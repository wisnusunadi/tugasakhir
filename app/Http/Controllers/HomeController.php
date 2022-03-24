<?php

namespace App\Http\Controllers;

use App\Exports\LaporanHasilTes;
use App\Models\DetailUserJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Soal;
use App\Models\SoalDetail;
use App\Models\Jawaban;
use App\Models\User;
use App\Models\UserJawaban;
use DateTime;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Cast\Array_;
use Barryvdh\DomPDF\PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == "admin") {
            return view('home');
        } else {
            return view('beranda');
        }
    }

    public function beranda()
    {
        return view('beranda');
    }

    public function draft_soal_preview_data($id)
    {
        $data = SoalDetail::where('soal_id', $id);
        return DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('jawaban', function ($data) {
                $g = array();
                $return = "";
                $return .= ' <div class="form-group">';
                foreach ($data->Jawaban as $s) {
                    if ($s->status == 1) {
                        $g[] =   '<div class="form-check">
            <input class="form-check-input" type="radio" name="' . $s->id . '" checked>
            <label class="form-check-label"> ' . $s->jawaban . '</label>
          </div>';
                    } else {
                        $g[] =   '<div class="form-check">
            <input class="form-check-input" type="radio" disabled>
            <label class="form-check-label"> ' . $s->jawaban . '</label>
          </div>';
                    }
                }
                $return .= implode('', $g);
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['jawaban'])
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


    public function soal_tes_preview()
    {
        if (Auth::user()->role != "admin") {
            $divisi_id = Auth::user()->Pendaftaran->Divisi->id;
            $jabatan_id = Auth::user()->Pendaftaran->Jabatan->id;
            $soal = Soal::whereHas('Divisi', function ($q) use ($divisi_id) {
                $q->where('id', $divisi_id);
            })->whereHas('Jabatan', function ($q) use ($jabatan_id) {
                $q->where('id', $jabatan_id);
            })->get();
            return view('soal.tes.preview', ['soal' => $soal]);
        } else {
            return view('home');
        }
    }



    public function soal_tes_show(Request $request, $id)
    {
        if (!Auth::user()) {
        } else {

            $now = Carbon::now();
            $timer = Soal::find($id);


            $time = Carbon::parse($now)->addMinutes($timer->waktu)->toTimeString();
            $mulai = Carbon::parse($now)->toTimeString();


            if ($request->session()->has('waktu')) {
            } else {
                $request->session()->put('waktu', $time);
                $request->session()->put('mulai', $mulai);
            }

            $soal = SoalDetail::where('soal_id', $id)->inRandomOrder()->get();


            return view('soal.tes.show', ['id' => $id, 'soals' => $soal]);
        }
    }

    public function peserta_show()
    {
        return view('peserta.show');
    }

    public function hasil_show()
    {
        return view('peserta.hasil.show');
    }

    public function laporan_hasil_show()
    {
        return view('soal.tes.laporan.show');
    }
    public function draft_soal_preview($id)
    {
        $soal = Soal::find($id);
        return view('soal.draft.preview', ['soal' => $soal]);
    }
    public function draft_soal_show()
    {
        $data = Soal::paginate(6);
        return view('soal.draft.show', ['data' => $data]);
    }
    public function draft_soal_data(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $query = str_replace("", "%", $query);
            $data = Soal::where('nama', 'like', '%' . $query . '%')
                ->paginate(6);
            return view('soal.draft.data', compact('data'))->render();
        }
    }

    public function draft_soal_search(Request $request)
    {
        $data = Soal::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')->groupby('nama')->get();
        echo json_encode($data);
    }

    public function draft_soal_create()
    {
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        return view('soal.draft.create', ['divisi' => $divisi, 'jabatan' => $jabatan]);
    }
    public function draft_soal_edit($id)
    {
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        $soal = Soal::find($id);
        return view('soal.draft.edit', ['divisi' => $divisi, 'jabatan' => $jabatan, 'soal' => $soal]);
    }

    public function draft_soal_update(Request $request, $id)
    {
        $bool = true;
        $soal = Soal::find($id);
        $soal->nama = $request->nama;
        $soal->kode_soal = $request->kode_soal;
        $soal->waktu = $request->waktu;
        $soal = $soal->save();

        if ($request->jabatan != '') {
            $jabatan_array = [];
            for ($i = 0; $i < count($request->jabatan); $i++) {
                $jabatan_array[] = $request->jabatan[$i];
            }
            $soals = Soal::find($id);
            $p = $soals->Jabatan()->sync($jabatan_array);
        }

        if ($request->divisi != '') {
            $divisi_array = [];
            for ($i = 0; $i < count($request->divisi); $i++) {
                $divisi_array[] = $request->divisi[$i];
            }
            $soals = Soal::find($id);
            $p = $soals->divisi()->sync($divisi_array);
        }

        $jawaban =  Jawaban::whereHas('SoalDetail', function ($q) use ($id) {
            $q->where('soal_id', $id);
        })->get();

        if (count($jawaban) > 0) {
            $del_jawaban = Jawaban::whereHas('SoalDetail', function ($q) use ($id) {
                $q->where('soal_id', $id);
            })->delete();
        }

        $detjawaban = SoalDetail::where('soal_id', $id)->get();
        if (count($detjawaban) > 0) {
            SoalDetail::where('soal_id', $id)->delete();
        }


        for ($i = 0; $i < count($request->soal); $i++) {
            $sdc = SoalDetail::create([
                'soal_id' => $id,
                'deskripsi' => $request->soal[$i],
                'bobot' => $request->poin[$i]
            ]);

            if ($sdc) {
                for ($j = 0; $j < count($request->jawaban[$i]); $j++) {
                    $status = NULL;
                    if (isset($request->get('kunci_jawaban')[$i][$j])) {
                        $status = '1';
                    } else {
                        $status = NULL;
                    }
                    $jc = Jawaban::create([
                        'soal_detail_id' => $sdc->id,
                        'jawaban' => $request->jawaban[$i][$j],
                        'status' => $status
                    ]);
                    if (!$jc) {
                        $bool = false;
                    }
                }
            } else if (!$sdc) {
                $bool = false;
            }
        }


        if ($bool == true) {
            return redirect()->back()->with('success', 'Berhasil mengubah Soal');
        } else if ($bool == false) {
            return redirect()->back()->with('error', 'Gagal mengubah Soal');
        }
    }



    public function soal_tes_store(Request $request)
    {

        $now = Carbon::now();
        $end_time = Carbon::parse($now)->toTimeString();


        $time1 = new DateTime($request->session()->get('mulai'));
        $time2 = new DateTime($end_time);
        $interval = $time1->diff($time2);

        $hasil = $interval->format('%h:%i:%s');


        $u = UserJawaban::create([
            'user_id' => $request->user,
            'waktu' => $hasil,
            'tanggal' => $now
        ]);

        for ($d = 0; $d < count($request->jawaban_id); $d++) {
            $du = DetailUserJawaban::create([
                'user_jawaban_id' => $u->id,
                'jawaban_id' => $request->jawaban_id[$d]
            ]);
        }

        $request->session()->forget('waktu');
        $request->session()->forget('mulai');
        Auth::logout();
        return redirect('/');
    }

    public function draft_soal_store(Request $request)
    {

        $bool = true;
        $c = Soal::create([
            'nama' => $request->nama,
            'kode_soal' => $request->kode_soal,
            'waktu' => $request->waktu
        ]);

        if ($c) {
            $soal = Soal::find($c->id);
            $soal->Divisi()->attach($request->divisi);
            $soal->Jabatan()->attach($request->jabatan);

            for ($i = 0; $i < count($request->soal); $i++) {
                $sdc = SoalDetail::create([
                    'soal_id' => $c->id,
                    'deskripsi' => $request->soal[$i],
                    'bobot' => $request->poin[$i]
                ]);

                if ($sdc) {
                    for ($j = 0; $j < count($request->jawaban[$i]); $j++) {
                        $status = NULL;
                        if (isset($request->get('kunci_jawaban')[$i][$j])) {
                            $status = '1';
                        } else {
                            $status = NULL;
                        }
                        $jc = Jawaban::create([
                            'soal_detail_id' => $sdc->id,
                            'jawaban' => $request->jawaban[$i][$j],
                            'status' => $status
                        ]);
                        if (!$jc) {
                            $bool = false;
                        }
                    }
                } else if (!$sdc) {
                    $bool = false;
                }
            }
        } else {
            $bool = false;
        }

        if ($bool == true) {
            return redirect()->back()->with('success', 'Berhasil menambahkan Soal');
        } else if ($bool == false) {
            return redirect()->back()->with('error', 'Gagal menambahkan Soal');
        }
    }

    public function laporan_hasil_export()
    {
        $waktu = Carbon::now();
        return Excel::download(new LaporanHasilTes(), 'Laporan Hasil Tes ' . $waktu->toDateTimeString() . '.xls');
    }

    public function select_jabatan(Request $request)
    {
        $data = Jabatan::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')
            ->get();
        return response()->json($data);
    }
    public function select_jabatan_get($id)
    {
        $x = explode(',', $id);
        $data = Jabatan::whereHas('Soal', function ($q) use ($x) {
            $q->whereIN('id', $x);
        })->get();
        return response()->json($data);
    }

    public function select_divisi(Request $request)
    {
        $data = Divisi::where('nama', 'LIKE', '%' . $request->input('term', '') . '%')
            ->orderby('nama', 'ASC')
            ->get();
        return response()->json($data);
    }

    public function select_divisi_get($id)
    {
        $x = explode(',', $id);
        $data = Divisi::whereHas('Soal', function ($q) use ($x) {
            $q->whereIN('id', $x);
        })->get();
        return response()->json($data);
    }
}
