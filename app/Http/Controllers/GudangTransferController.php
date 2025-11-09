<?php

namespace App\Http\Controllers;

use App\Models\GudangTransfer;
use App\Models\GudangTransferItem;
use App\Models\MasterGudang;
use App\Models\MasterInventori;
use App\Models\MasterInventoriGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GudangTransferController extends Controller
{
    public function index()
    {
        $transfers = GudangTransfer::with(['gudangAsal', 'gudangTujuan', 'creator'])
            ->latest()
            ->paginate(10);

        return view('gudang_transfer.index', compact('transfers'));
    }

    public function create()
    {
        $gudangs = MasterGudang::all();
        $barangs = MasterInventori::all();
        return view('gudang_transfer.create', compact('gudangs', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gudang_asal_id' => 'required|different:gudang_tujuan_id',
            'gudang_tujuan_id' => 'required',
            'tanggal_transfer' => 'required|date',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        DB::transaction(function() use ($request) {
            $transfer = GudangTransfer::create([
                'kode_transfer' => 'TRF-' . strtoupper(Str::random(6)),
                'gudang_asal_id' => $request->gudang_asal_id,
                'gudang_tujuan_id' => $request->gudang_tujuan_id,
                'tanggal_transfer' => $request->tanggal_transfer,
                'keterangan' => $request->keterangan,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->barang_id as $index => $barangId) {
                $jumlah = $request->jumlah[$index];

                GudangTransferItem::create([
                    'gudang_transfer_id' => $transfer->id,
                    'barang_id' => $barangId,
                    'jumlah' => $jumlah,
                ]);

                // Kurangi stok dari gudang asal
                $stokAsal = MasterInventoriGudang::firstOrNew([
                    'gudang_id' => $request->gudang_asal_id,
                    'barang_id' => $barangId,
                ]);
                $stokAsal->stok_aktual = max(0, ($stokAsal->stok_aktual ?? 0) - $jumlah);
                $stokAsal->save();

                // Tambah stok ke gudang tujuan
                $stokTujuan = MasterInventoriGudang::firstOrNew([
                    'gudang_id' => $request->gudang_tujuan_id,
                    'barang_id' => $barangId,
                ]);
                $stokTujuan->stok_aktual = ($stokTujuan->stok_aktual ?? 0) + $jumlah;
                $stokTujuan->save();
            }
        });

        return redirect()->route('gudang_transfer.index')->with('success', 'Transaksi transfer berhasil disimpan.');
    }

    public function edit(GudangTransfer $gudang_transfer)
    {
        $gudangs = MasterGudang::all();
        $barangs = MasterInventori::all();
        $transfer = $gudang_transfer->load('items.barang');

        return view('gudang_transfer.edit', compact('transfer', 'gudangs', 'barangs'));
    }

    public function update(Request $request, GudangTransfer $gudang_transfer)
    {
        $request->validate([
            'tanggal_transfer' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $gudang_transfer->update([
            'tanggal_transfer' => $request->tanggal_transfer,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('gudang_transfer.index')->with('success', 'Data transfer berhasil diperbarui.');
    }

    public function destroy(GudangTransfer $gudang_transfer)
    {
        $gudang_transfer->delete();
        return redirect()->route('gudang_transfer.index')->with('success', 'Data transfer berhasil dihapus.');
    }
}
