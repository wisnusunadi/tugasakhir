<?php

namespace App\Exports;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class LaporanHasilKeputusan implements FromView, ShouldAutoSize, WithStyles {
    /**
     * @return \Illuminate\Support\Collection
     */


    // public function columnFormats(): array
    // {
    //     return [
    //         'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
    //         'I' => NumberFormat::FORMAT_TEXT
    //     ];
    // }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:X2')->getFont()->setBold(true);
        $sheet->getStyle('A3:X3')->getFont()->setBold(true);
        $sheet->getStyle('A:X')->getAlignment()
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C:E')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G:K')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('M:R')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('T:X')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('a2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('8FBC8F');
        $sheet->getStyle('b2:d2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('ADD8E6');
        $sheet->getStyle('e2:g2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('66CDAA');
        $sheet->getStyle('h2:j2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('dae7f1');
        $sheet->getStyle('h3:j3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('dae7f1');
        $sheet->getStyle('k2:o2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('c8eaea');
        $sheet->getStyle('k3:o3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('c8eaea');
        $sheet->getStyle('p2:r2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('c8d0ea');
        $sheet->getStyle('p3:r3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('c8d0ea');
        $sheet->getStyle('s2:v2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('99c66c');
        $sheet->getStyle('s3:v3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('99c66c');
        $sheet->getStyle('w2:x2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('dbb1a3');
    //     $sheet->getStyle('g2:j2')->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setRGB('89d0b4');
    //     $sheet->getStyle('k2:n2')->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setRGB('00ff7f');
    //     $sheet->getStyle('o2')->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setRGB('89d0b4');
    //     $sheet->getStyle('A:C')->getAlignment()
    //         ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('G:I')->getAlignment()
    //         ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('O')->getAlignment()
    //         ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //     $sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(35);
    //     $sheet->getStyle('D')->getAlignment()->setWrapText(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(45);
    //     $sheet->getStyle('E')->getAlignment()->setWrapText(true);
    //     $sheet->getColumnDimension('K')->setAutoSize(false)->setWidth(38);
    //     $sheet->getStyle('K')->getAlignment()->setWrapText(true);
    //     $sheet->getColumnDimension('L')->setAutoSize(false)->setWidth(30);
    //     $sheet->getStyle('L')->getAlignment()->setWrapText(true);
    //     $sheet->getColumnDimension('N')->setAutoSize(false)->setWidth(45);
    //     $sheet->getStyle('N')->getAlignment()->setWrapText(true);
    }

    public function view(): View
    {
        $data = Pendaftaran::Has('User')->get();
        return view('peserta.hasil.laporan.LaporanKeputusan', ['data' => $data]);
    }
}
