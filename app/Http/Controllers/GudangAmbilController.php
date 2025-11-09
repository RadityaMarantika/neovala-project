<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterGudang;
use App\Models\MasterInventori;
use App\Models\MasterInventoriGudang;
use App\Models\GudangAmbil;
use App\Models\GudangAmbilItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GudangAmbilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $transfers = GudangAmbil::with('items.barang', 'gudangTujuan')
            ->orderByDesc('id')
            ->get();

        return view('gudang_ambils.index', compact('transfers'));
    }

    public function create()
    {
        $gudangs = MasterGudang::where('id', '!=', 1)->get(); // selain gudang pusat
        $barangs = MasterInventori::orderBy('nama_barang')->get();

        return view('gudang_ambils.create', compact('gudangs', 'barangs'));
    }

   public function store(Request $request)
{
    $request->validate([
        'gudang_tujuan' => 'required|integer',
        'barang_id'     => 'required|array',
        'qty_transfer'  => 'required|array',
    ]);

    DB::beginTransaction();
    try {

        // ✅ 1. Simpan header transfer
        $transfer = GudangAmbil::create([
            'gudang_tujuan' => $request->gudang_tujuan,
            'user_id' => Auth::id(),  // ✅ Tambahkan ini
        ]);

        // ✅ 2. Loop setiap item
        foreach ($request->barang_id as $index => $barangId) {

            $qty = (int) $request->qty_transfer[$index];

            if ($qty < 1) {
                throw new \Exception("Qty tidak boleh kosong.");
            }

            // ✅ Simpan detail item
            GudangAmbilItem::create([
                'transfer_id' => $transfer->id,
                'barang_id' => $barangId,
                'qty_transfer' => $qty,
            ]);

            // ✅ Ambil stok gudang pusat (1)
            $gudangPusat = MasterInventoriGudang::where('barang_id', $barangId)
                ->where('gudang_id', 1)
                ->first();

            if (!$gudangPusat || $gudangPusat->stok_aktual < $qty) {
                throw new \Exception("Stok gudang pusat tidak cukup untuk barang ID $barangId.");
            }

            // ✅ Kurangi stok gudang pusat
            $gudangPusat->decrement('stok_aktual', $qty);

            // ✅ Update status gudang pusat
            $min = $gudangPusat->stok_minimum ?? 0;
            $gudangPusat->update([
                'status_stok' => $gudangPusat->stok_aktual <= $min ? 'Perlu Purchase' : 'Tersedia Cukup'
            ]);

            // ✅ Tambahkan stok ke gudang tujuan
            $gudangTujuan = MasterInventoriGudang::firstOrCreate(
                [
                    'barang_id' => $barangId,
                    'gudang_id' => $request->gudang_tujuan,
                ],
                [
                    'stok_aktual' => 0,
                    'stok_minimum' => 0,
                    'status_stok' => 'Normal',
                ]
            );

            $gudangTujuan->increment('stok_aktual', $qty);

            // ✅ Update status gudang tujuan
            $min2 = $gudangTujuan->stok_minimum ?? 0;
            $gudangTujuan->update([
                'status_stok' => $gudangTujuan->stok_aktual <= $min2 ? 'Perlu Purchase' : 'Tersedia Cukup'
            ]);
        }

        DB::commit();
        return redirect()->route('gudang-ambils.index')
            ->with('success', 'Barang berhasil di-transfer ke gudang tujuan.');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal transfer: ' . $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    $transfer = GudangAmbil::with('items')->findOrFail($id);
    $gudangs = MasterGudang::where('id', '!=', 1)->get();
    $barangs = MasterInventori::all();

    return view('gudang_ambils.edit', compact('transfer', 'gudangs', 'barangs'));
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $request->validate([
        'gudang_tujuan' => 'required',
    ]);

    $transfer =  GudangAmbil::findOrFail($id);

    $transfer->update([
        'gudang_tujuan' => $request->gudang_tujuan
    ]);

    return redirect()->route('gudang_ambils.index')->with('success', 'Transfer berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
     GudangAmbil::findOrFail($id)->delete();
    return back()->with('success', 'Data transfer berhasil dihapus.');
}
}
