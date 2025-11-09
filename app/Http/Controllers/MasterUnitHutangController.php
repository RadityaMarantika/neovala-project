<?php

namespace App\Http\Controllers;

use App\Models\MasterUnitHutang;
use Illuminate\Http\Request;

class MasterUnitHutangController extends Controller
{
    public function index()
    {
        $hutangs = MasterUnitHutang::with('sewa.unit')->latest()->get();
        return view('master_unit_hutangs.index', compact('hutangs'));
    }

    public function edit(MasterUnitHutang $masterUnitHutang)
    {
        return view('master_unit_hutangs.edit', compact('masterUnitHutang'));
    }

    public function update(Request $r, MasterUnitHutang $masterUnitHutang)
    {
        $data = $r->validate([
            'pembayaran_unit' => 'nullable|numeric',
            'pembayaran_utl' => 'nullable|numeric',
            'pembayaran_ipl' => 'nullable|numeric',
            'pembayaran_wifi' => 'nullable|numeric',
        ]);

        // Update status Paid jika ada pembayaran
        if ($r->pembayaran_unit) $data['pay_unit'] = 'Paid';
        if ($r->pembayaran_utl)  $data['pay_utl']  = 'Paid';
        if ($r->pembayaran_ipl)  $data['pay_ipl']  = 'Paid';
        if ($r->pembayaran_wifi) $data['pay_wifi'] = 'Paid';

        $masterUnitHutang->update($data);

        return redirect()->route('master_unit_hutangs.index')
            ->with('success', 'Pembayaran hutang telah diperbarui.');
    }

    public function destroy(MasterUnitHutang $masterUnitHutang)
    {
        $masterUnitHutang->delete();
        return redirect()->back()->with('success', 'Data hutang berhasil dihapus.');
    }
}
