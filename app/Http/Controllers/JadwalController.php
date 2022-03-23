<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Jadwal;
use App\Models\User;

class JadwalController extends Controller
{
    public function jadwal_show()
    {
        return view('jadwal.show');
    }

    public function get_data_jadwal()
    {
        $data = Pendaftaran::all();
        return DataTables()->of($data)
            ->addColumn('tanggal', function ($data) {
                $mulai = Carbon::parse($data->Jadwal->waktu_mulai)->isoFormat('D MMMM Y');
                $selesai = Carbon::parse($data->Jadwal->waktu_selesai)->isoFormat('D MMMM Y');
                return  $data->Jadwal->ket . ' (' . $mulai . ' - ' . $selesai . ')';
            })
            ->addColumn('jabatan', function ($data) {
                return $data->Jabatan->nama . ' ' . $data->Divisi->nama;
            })

            ->make(true);
    }
    public function laporan_hasil_data()
    {
        $data = Pendaftaran::all();
        return DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('jadwal', function ($data) {
                return 'Tanggal ' . Carbon::parse($data->Jadwal->waktu_mulai)->format('d-m-Y') . " - " . Carbon::parse($data->Jadwal->waktu_selesai)->format('d-m-Y');
            })
            ->addColumn('divisi', function ($data) {
                return $data->Divisi->nama;
            })
            ->addColumn('jabatan', function ($data) {
                return $data->Jabatan->nama;
            })
            ->addColumn('kuota', function ($data) {
                return $data->kuota;
            })
            ->addColumn('detail', function ($data) {
                return '<a data-toggle="modal" class="realmodal" data-id="' . $data->id . '" data-target="#realmodal"><button type="button" class="btn btn-info btn-circle" alt="Detail">
                <i class="far fa-plus-square"></i>
                </button> </a>';
            })

            ->rawColumns(['detail'])
            ->make(true);
    }
    public function laporan_hasil_data_detail($id)
    {
        $data = User::Has('Jawaban')->where('pendaftaran_id', $id)->get();

        return DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('kode_soal', function ($data) {
                return $data->Jawaban->first()->SoalDetail->Soal->kode_soal;
            })
            ->addColumn('waktu', function ($data) {
                return $data->Jawaban->first()->SoalDetail->Soal->waktu;
            })
            ->addColumn('nilai', function ($data) {
                $q = 0;
                foreach ($data->Jawaban as $j) {
                    if ($j->status == 1) {
                        $q += $j->soaldetail->bobot;
                    }
                }
                return $q;
            })
            ->make(true);
    }

    public function jadwal_table()
    {
        $today = Carbon::now();
        $data = Pendaftaran::whereHas('Jadwal', function ($q) use ($today) {
            $q->where('waktu_selesai', '>=', $today);
        })->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('jadwal', function ($data) {
                return 'Tanggal ' . Carbon::parse($data->Jadwal->waktu_mulai)->format('d-m-Y') . " - " . Carbon::parse($data->Jadwal->waktu_selesai)->format('d-m-Y');
            })
            ->addColumn('divisi', function ($data) {
                return $data->Divisi->nama;
            })
            ->addColumn('jabatan', function ($data) {
                return $data->Jabatan->nama;
            })
            ->addColumn('kuota', function ($data) {
                return $data->kuota;
            })
            ->make(true);
    }

    public function jadwal_create()
    {
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        return view('jadwal.create', ['d' => $divisi, 'j' => $jabatan]);
    }

    public function jadwal_store(Request $r)
    {
        $bool = true;
        $j = Jadwal::create([
            'waktu_mulai' => $r->tanggal_mulai,
            'waktu_selesai' => $r->tanggal_akhir,
            'ket' => $r->keterangan
        ]);

        if ($j) {
            for ($i = 0; $i < count($r->divisi); $i++) {
                $p = Pendaftaran::create([
                    'divisi_id' => $r->divisi[$i],
                    'jabatan_id' => $r->jabatan[$i],
                    'jadwal_id' => $j->id,
                    'kuota' => $r->kuota[$i]
                ]);
                if (!$p) {
                    $bool = false;
                }
            }
        }

        if ($bool == true) {
            return redirect()->back()->with('success', 'Berhasil menambahkan Jadwal');
        } else if ($bool == false) {
            return redirect()->back()->with('error', 'Gagal menambahkan Jadwal');
        }
    }
}
