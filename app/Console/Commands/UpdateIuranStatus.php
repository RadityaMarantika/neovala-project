<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Iuran;
use Carbon\Carbon;


class UpdateIuranStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-iuran-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();

        Iuran::where('status', '!=', 'Sudah Bayar')->get()->each(function ($iuran) use ($today) {
            $due = Carbon::parse($iuran->tanggal_jatuh_tempo);
            $diff = $due->diffInDays($today, false);

            if ($diff <= 7 && $diff >= 0) {
                $iuran->status = 'Belum Bayar';
            } elseif ($diff < 0 && abs($diff) <= 14) {
                $iuran->status = 'Terlambat';
            } elseif ($diff < -14) {
                $iuran->status = 'Tidak Bayar';
            }
            $iuran->save();
        });
    }
}
