<?php

namespace App\Http\Controllers;

use App\Models\MasterUnit;
use App\Models\MasterUnitSewa;
use App\Models\MasterUnitHutang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MasterUnitSewaController extends Controller
{
    public function index()
    {
        $sewas = MasterUnitSewa::with('unit')->latest()->get();
        return view('master_unit_sewas.index', compact('sewas'));
    }

   public function create()
    {
        $units = MasterUnit::where('status_kelola', 'Aktif')->get();
        return view('master_unit_sewas.create', compact('units'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'periode_sewa' => 'required|in:3 bulan,6 bulan,12 bulan',
            'jenis_tempo' => 'required|in:monthly,quarterly,semi-annually,annually',
            'unit_id' => 'required|exists:master_units,id',

            'jenis_ipl' => 'required|in:Include,Exclude',
            'jenis_utl' => 'required|in:Include,Exclude',
            'jenis_wifi' => 'required|in:Include,Exclude',

            'pengambilan_kunci' => 'nullable|date',

            // UNIT
            'bayar_unit' => 'required|in:Owner,Marketing',
            'biaya_unit' => 'required|numeric',
            'tanggal_unit' => 'required|integer|min:1|max:31',

            // UTL
            'bayar_utl' => 'required_if:jenis_utl,Exclude|nullable|in:Owner,Marketing',
            'biaya_utl' => 'required_if:jenis_utl,Exclude|nullable|numeric',
            'tanggal_utl' => 'required_if:jenis_utl,Exclude|nullable|integer|min:1|max:31',

            // IPL
            'bayar_ipl' => 'required_if:jenis_ipl,Exclude|nullable|in:Owner,Marketing',
            'biaya_ipl' => 'required_if:jenis_ipl,Exclude|nullable|numeric',
            'tanggal_ipl' => 'required_if:jenis_ipl,Exclude|nullable|integer|min:1|max:31',

            // WIFI
            'provider_wifi' => 'required|string',
            'bayar_wifi' => 'required_if:jenis_wifi,Exclude|nullable|in:Owner,Marketing',
            'biaya_wifi' => 'required_if:jenis_wifi,Exclude|nullable|numeric',
            'tanggal_wifi' => 'required_if:jenis_wifi,Exclude|nullable|integer|min:1|max:31',
        ]);

        $unit = MasterUnit::find($r->unit_id);

        // AUTO-SET bila Include
        if ($data['jenis_ipl'] === 'Include') {
            $data['bayar_ipl'] = $unit->jenis_koneksi;
            $data['biaya_ipl'] = null;
            $data['tanggal_ipl'] = null;
        }
        if ($data['jenis_utl'] === 'Include') {
            $data['bayar_utl'] = $unit->jenis_koneksi;
            $data['biaya_utl'] = null;
            $data['tanggal_utl'] = null;
        }
        if ($data['jenis_wifi'] === 'Include') {
            $data['bayar_wifi'] = $unit->jenis_koneksi;
            $data['biaya_wifi'] = null;
            $data['tanggal_wifi'] = null;
        }

        // Simpan SEWA
        $sewa = MasterUnitSewa::create($data);

        // ---------------------------------------------------------------------
        // ✅ HITUNG JUMLAH HUTANG YANG HARUS DIBUAT
        // ---------------------------------------------------------------------
        $periodeAngka = intval($r->periode_sewa); // 3 / 6 / 12

        $jumlahInvoice = match ($r->jenis_tempo) {
            'monthly'        => $periodeAngka,
            'quarterly'      => ceil($periodeAngka / 3),
            'semi-annually'  => ceil($periodeAngka / 6),
            'annually'       => ceil($periodeAngka / 12),
            default          => 1,
        };

        // ---------------------------------------------------------------------
        // ✅ GENERATE MULTI TAGIHAN
        // ---------------------------------------------------------------------
        for ($i = 0; $i < $jumlahInvoice; $i++) {

            $tempo_unit = $this->generateTempoPlusMonths($r->tanggal_unit, $i);
            $tempo_utl  = $r->jenis_utl === 'Include' ? now() :
                          $this->generateTempoPlusMonths($r->tanggal_utl, $i);
            $tempo_ipl  = $r->jenis_ipl === 'Include' ? now() :
                          $this->generateTempoPlusMonths($r->tanggal_ipl, $i);
            $tempo_wifi = $r->jenis_wifi === 'Include' ? now() :
                          $this->generateTempoPlusMonths($r->tanggal_wifi, $i);

            MasterUnitHutang::create([
                'sewa_id' => $sewa->id,

                'tempo_unit' => $tempo_unit,
                'pay_unit' => $r->biaya_unit ? 'Unpaid' : 'Paid',
                'pembayaran_unit' => null,

                'tempo_utl' => $tempo_utl,
                'pay_utl' => $r->jenis_utl === 'Include' ? 'Paid' : 'Unpaid',
                'pembayaran_utl' => null,

                'tempo_ipl' => $tempo_ipl,
                'pay_ipl' => $r->jenis_ipl === 'Include' ? 'Paid' : 'Unpaid',
                'pembayaran_ipl' => null,

                'tempo_wifi' => $tempo_wifi,
                'pay_wifi' => $r->jenis_wifi === 'Include' ? 'Paid' : 'Unpaid',
                'pembayaran_wifi' => null,
            ]);
        }

        return redirect()->route('master_unit_sewas.index')
            ->with('success', "Data sewa berhasil dibuat & $jumlahInvoice hutang berhasil digenerate.");
    }

    // ========================================================================
    // ✅ Generate Tanggal Tempo + Tambahan Bulan
    // ========================================================================
    private function generateTempoPlusMonths($tanggal, $plusMonths)
    {
        if (!$tanggal) return null;

        $day = str_pad($tanggal, 2, '0', STR_PAD_LEFT);

        return Carbon::now()
            ->startOfMonth()
            ->addMonths($plusMonths)
            ->format("Y-m-$day");
    }

    private function generateSpecificTempo($bulanCarbon, $tanggal)
{
    if (!$tanggal) return null;

    $day = str_pad($tanggal, 2, '0', STR_PAD_LEFT);

    return $bulanCarbon->format("Y-m-$day");
}



    public function show(MasterUnitSewa $master_unit_sewa)
    {
        return view('master_unit_sewas.show', ['masterUnitSewa' => $master_unit_sewa]);
    }

   public function update(Request $r, MasterUnitSewa $masterUnitSewa)
{
    $data = $r->validate([
        'periode_sewa' => 'required|in:3 bulan,6 bulan,12 bulan',
        'jenis_tempo' => 'required|in:monthly,quarterly,semi-annually,annually',
        'unit_id' => 'required|exists:master_units,id',

        'jenis_ipl' => 'required|in:Include,Exclude',
        'jenis_utl' => 'required|in:Include,Exclude',
        'jenis_wifi' => 'required|in:Include,Exclude',

        'pengambilan_kunci' => 'nullable|date',

        'bayar_unit' => 'required|in:Owner,Marketing',
        'biaya_unit' => 'required|numeric',
        'tanggal_unit' => 'required|integer|min:1|max:31',

        'bayar_utl' => 'required_if:jenis_utl,Exclude|nullable|in:Owner,Marketing',
        'biaya_utl' => 'required_if:jenis_utl,Exclude|nullable|numeric',
        'tanggal_utl' => 'required_if:jenis_utl,Exclude|nullable|integer|min:1|max:31',

        'bayar_ipl' => 'required_if:jenis_ipl,Exclude|nullable|in:Owner,Marketing',
        'biaya_ipl' => 'required_if:jenis_ipl,Exclude|nullable|numeric',
        'tanggal_ipl' => 'required_if:jenis_ipl,Exclude|nullable|integer|min:1|max:31',

        'provider_wifi' => 'required|string',
        'bayar_wifi' => 'required_if:jenis_wifi,Exclude|nullable|in:Owner,Marketing',
        'biaya_wifi' => 'required_if:jenis_wifi,Exclude|nullable|numeric',
        'tanggal_wifi' => 'required_if:jenis_wifi,Exclude|nullable|integer|min:1|max:31',
    ]);

    $unit = MasterUnit::find($r->unit_id);

    // AUTO-FILL include
    if ($data['jenis_ipl'] === 'Include') {
        $data['bayar_ipl'] = $unit->jenis_koneksi;
        $data['biaya_ipl'] = null;
        $data['tanggal_ipl'] = null;
    }
    if ($data['jenis_utl'] === 'Include') {
        $data['bayar_utl'] = $unit->jenis_koneksi;
        $data['biaya_utl'] = null;
        $data['tanggal_utl'] = null;
    }
    if ($data['jenis_wifi'] === 'Include') {
        $data['bayar_wifi'] = $unit->jenis_koneksi;
        $data['biaya_wifi'] = null;
        $data['tanggal_wifi'] = null;
    }

    // Update master sewa
    $masterUnitSewa->update($data);

    /*
    |--------------------------------------------------------------------------
    | DELETE ALL OLD HUTANG → REGENERATE NEW HUTANG
    |--------------------------------------------------------------------------
    */
    MasterUnitHutang::where('sewa_id', $masterUnitSewa->id)->delete();

    /*
    |--------------------------------------------------------------------------
    | DETERMINE NUMBER OF HUTANG BASED ON PERIODE & TEMPO
    |--------------------------------------------------------------------------
    */
    $periode = intval(explode(' ', $data['periode_sewa'])[0]); // 3, 6, 12
    $tempo = $data['jenis_tempo'];

    if ($tempo === 'monthly') {
        $totalHutang = $periode;
        $step = 1;
    } 
    elseif ($tempo === 'quarterly') {
        $totalHutang = 1;
        $step = $periode;
    } 
    elseif ($tempo === 'semi-annually') {
        $totalHutang = ceil($periode / 6);
        $step = 6;
    } 
    else { // annually
        $totalHutang = ceil($periode / 12);
        $step = 12;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE MULTIPLE HUTANG
    |--------------------------------------------------------------------------
    */
    $start = Carbon::now()->startOfMonth();

    for ($i = 0; $i < $totalHutang; $i++) {
        $bulan = $start->copy()->addMonths($i * $step);

        MasterUnitHutang::create([
            'sewa_id' => $masterUnitSewa->id,

            'tempo_unit' => $this->generateSpecificTempo($bulan, $data['tanggal_unit']),
            'pay_unit' => $data['biaya_unit'] ? 'Unpaid' : 'Paid',

            'tempo_utl' => $data['jenis_utl'] === 'Include'
                ? $bulan->toDateString()
                : $this->generateSpecificTempo($bulan, $data['tanggal_utl'] ?? null),
            'pay_utl' => $data['jenis_utl'] === 'Include' ? 'Paid' : 'Unpaid',

            'tempo_ipl' => $data['jenis_ipl'] === 'Include'
                ? $bulan->toDateString()
                : $this->generateSpecificTempo($bulan, $data['tanggal_ipl'] ?? null),
            'pay_ipl' => $data['jenis_ipl'] === 'Include' ? 'Paid' : 'Unpaid',

            'tempo_wifi' => $data['jenis_wifi'] === 'Include'
                ? $bulan->toDateString()
                : $this->generateSpecificTempo($bulan, $data['tanggal_wifi'] ?? null),
            'pay_wifi' => $data['jenis_wifi'] === 'Include' ? 'Paid' : 'Unpaid',
        ]);
    }

    return redirect()->route('master_unit_sewas.index')
        ->with('success', 'Data sewa & hutang berhasil diupdate.');
}


    public function destroy(MasterUnitSewa $masterUnitSewa)
    {
        $masterUnitSewa->delete();
        return redirect()->back()->with('success', 'Data sewa berhasil dihapus.');
    }
}
