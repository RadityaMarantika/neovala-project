<?php

namespace App\Http\Controllers;

use App\Models\MasterInventoriGudang;
use App\Models\InventoriGudangHistory;
use App\Models\MasterGudang;
use App\Models\MasterInventori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterInventoriGudangController extends Controller
{
    public function index(Request $request)
    {
        $gudangId = $request->get('gudang_id');

        $gudangs = MasterGudang::all();

        $inventoriGudangs = MasterInventoriGudang::with(['gudang', 'barang'])
            ->when($gudangId, fn($q) => $q->where('gudang_id', $gudangId))
            ->paginate(10);

        // Data gudang unik yang punya inventori (untuk tombol edit)
        $gudangInventories = MasterInventoriGudang::select('gudang_id')
            ->with('gudang')
            ->groupBy('gudang_id')
            ->get();

        return view('master_inventori_gudang.index', compact(
            'inventoriGudangs',
            'gudangs',
            'gudangId',
            'gudangInventories'
        ));
    }



   public function create()
    {
        $gudangs = MasterGudang::all();
        return view('master_inventori_gudang.create', compact('gudangs'));
    }

    // AJAX endpoint untuk ambil barang yang belum dimiliki gudang tertentu
    public function getBarangBelumDimiliki(Request $request)
    {
        $gudangId = $request->input('gudang_id');

        // ambil id barang yang sudah dimiliki gudang tsb
        $barangDimiliki = MasterInventoriGudang::where('gudang_id', $gudangId)->pluck('barang_id');

        // ambil barang yang belum dimiliki
        $barangs = MasterInventori::whereNotIn('id', $barangDimiliki)->get();

        return response()->json($barangs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gudang_id' => 'required|exists:master_gudangs,id',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:master_inventoris,id',
            'stok_aktual' => 'required|array',
            'minimum_stok' => 'required|array',
            'kode_rak' => 'required|array',
            'penanggung_jawab' => 'required|array',
        ]);

        foreach ($validated['barang_id'] as $barangId) {
            $stokAktual = $validated['stok_aktual'][$barangId] ?? 0;
            $minimumStok = $validated['minimum_stok'][$barangId] ?? 0;
            $kodeRak = $validated['kode_rak'][$barangId] ?? '-';
            $penanggungJawab = $validated['penanggung_jawab'][$barangId] ?? '-';

            MasterInventoriGudang::create([
                'gudang_id' => $validated['gudang_id'],
                'barang_id' => $barangId,
                'stok_aktual' => $stokAktual,
                'minimum_stok' => $minimumStok,
                'kode_rak' => $kodeRak,
                'penanggung_jawab' => $penanggungJawab,
                'status_stok' => $stokAktual <= 0 
                    ? 'Habis' 
                    : ($stokAktual <= $minimumStok 
                        ? 'Perlu Purchase' 
                        : 'Tersedia Cukup'),
            ]);
        }

        return redirect()->route('master_inventori_gudang.index')->with('success', 'Inventori gudang berhasil ditambahkan.');
    }


    public function edit($gudangId)
    {
        $gudang = MasterGudang::findOrFail($gudangId);

        // Ambil semua item yang SUDAH ADA di gudang ini
        $inventoriGudang = MasterInventoriGudang::where('gudang_id', $gudangId)
            ->with('barang')
            ->get();

        return view('master_inventori_gudang.edit', compact('gudang', 'inventoriGudang'));
    }


    public function update(Request $request, $id)
{
    $gudang = MasterGudang::findOrFail($id);

    // Ambil semua ID barang dari key array stok_aktual
    $barangDipilih = array_keys($request->stok_aktual ?? []);

    foreach ($barangDipilih as $barangId) {
        $stokAktual = $request->stok_aktual[$barangId] ?? 0;
        $minStok = $request->minimum_stok[$barangId] ?? 0;

        $inventori = MasterInventoriGudang::where('gudang_id', $id)
            ->where('barang_id', $barangId)
            ->first();

        if ($inventori) {
            if ($inventori->stok_aktual != $stokAktual) {
                InventoriGudangHistory::create([
                    'inventori_gudang_id' => $inventori->id,
                    'stok_lama' => $inventori->stok_aktual,
                    'stok_baru' => $stokAktual,
                    'keterangan' => 'Update stok dari halaman edit gudang',
                    'updated_by' => Auth::id(),
                ]);
            }

            $inventori->update([
                'stok_aktual' => $stokAktual,
                'minimum_stok' => $minStok,
            ]);
        } else {
            $inventoriBaru = MasterInventoriGudang::create([
                'gudang_id' => $id,
                'barang_id' => $barangId,
                'stok_aktual' => $stokAktual,
                'minimum_stok' => $minStok,
            ]);

            InventoriGudangHistory::create([
                'inventori_gudang_id' => $inventoriBaru->id,
                'stok_lama' => 0,
                'stok_baru' => $stokAktual,
                'keterangan' => 'Penambahan stok baru ke gudang',
                'updated_by' => Auth::id(),
            ]);
        }
    }

    return redirect()->route('master_inventori_gudang.index')
        ->with('success', 'Stok barang berhasil diperbarui dan histori tercatat.');
}





    public function destroy($id)
    {
        MasterInventoriGudang::findOrFail($id)->delete();
        return redirect()->route('master_inventori_gudang.index')->with('success', 'Data berhasil dihapus.');
    }
}
