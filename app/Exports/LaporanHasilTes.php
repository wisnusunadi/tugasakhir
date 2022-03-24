<?php

namespace App\Exports;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanHasilTes implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }

    public function view(): View
    {
        $data = Pendaftaran::has('User')->get();
        return view('soal.tes.laporan.export', ['data' => $data]);
    }
}
