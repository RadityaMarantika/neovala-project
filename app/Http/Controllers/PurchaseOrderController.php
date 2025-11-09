<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\MasterInventori;
use App\Models\MasterInventoriGudang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['items.inventory'])->latest()->get();
        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $inventories = MasterInventori::orderBy('nama_barang')->get();
        return view('purchase_orders.create', compact('inventories'));
    }

   public function store(Request $request)
{
    $request->validate([
        'inventory_id'   => 'required|array|min:1',
        'qty_request'    => 'required|array|min:1',
        'inventory_id.*' => 'required|exists:master_inventoris,id',
        'qty_request.*'  => 'required|integer|min:1',
    ]);

    $kode_po = 'PO' . date('ymdHis');

    $po = PurchaseOrder::create([
        'kode_po'     => $kode_po,
        'user_id'     => Auth::id(),
        'gudang_id'   => 1,
        'tanggal_po'  => now(),
        'status'      => 'Pending',
    ]);

    // Loop sesuai struktur form
    foreach ($request->inventory_id as $index => $invId) {
        PurchaseOrderItem::create([
            'purchase_order_id' => $po->id,
            'inventory_id'      => $invId,
            'qty_request'       => $request->qty_request[$index],
        ]);
    }

    return redirect()->route('purchase-orders.index')->with('success', 'PO berhasil dibuat.');
}

    public function approve($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->update(['status' => 'Approved']);
        return back()->with('success', 'PO berhasil disetujui.');
    }

    public function pembelian(Request $request, $id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'bukti_pembelian' => 'nullable|file|max:2048'
        ]);

        $bukti = $request->hasFile('bukti_pembelian')
            ? $request->file('bukti_pembelian')->store('bukti_pembelian', 'public')
            : null;

        $po->update([
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'bukti_pembelian' => $bukti,
            'status' => 'Ongoing'
        ]);

        return back()->with('success', 'Data pembelian berhasil disimpan.');
    }

public function terimaBarang(Request $request, $id)
{
    $po = PurchaseOrder::with('items')->findOrFail($id);

    $request->validate([
        'tanggal_diterima' => 'required|date',
        'bukti_sampai' => 'nullable|file|max:2048',
        'qty_received' => 'required|array',
    ]);

    $bukti = $request->hasFile('bukti_sampai')
        ? $request->file('bukti_sampai')->store('bukti_sampai', 'public')
        : null;

    DB::beginTransaction();
    try {

        foreach ($po->items as $item) {

            $received = (int) $request->input("qty_received.{$item->id}", 0);

            if ($received < 0) {
                throw new \Exception("Qty diterima untuk item {$item->inventory->nama_barang} tidak boleh negatif.");
            }

            // update qty_received di purchase_order_items
            $item->update(['qty_received' => $received]);

            // ambil stok gudang pusat (gudang_id = 1)
            $gudangItem = \App\Models\MasterInventoriGudang::where('barang_id', $item->inventory_id)
                ->where('gudang_id', 1)
                ->first();

            if ($gudangItem) {

                // ✅ Tambahkan stok ke stok_aktual
                $gudangItem->increment('stok_aktual', $received);

            } else {

                // ✅ Jika belum ada entry → buat baru
                \App\Models\MasterInventoriGudang::create([
                    'gudang_id'     => 1,
                    'barang_id'     => $item->inventory_id,
                    'stok_aktual'   => $received,   // langsung isi stok awal
                    'minimum_stok'  => 0,           // default tidak mengubah apa-apa
                    'status_stok'   => 'Normal',    // atau kosong kalau kamu mau
                ]);
            }
        }

        // update data PO
        $po->update([
            'tanggal_diterima' => $request->tanggal_diterima,
            'bukti_sampai'     => $bukti,
            'status'           => 'Receive',
        ]);

        DB::commit();
        return redirect()->route('purchase-orders.index')
            ->with('success', 'Barang diterima dan stok gudang pusat berhasil ditambahkan.');

    } catch (\Throwable $e) {

        DB::rollBack();
        return back()->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
    }
}


}
