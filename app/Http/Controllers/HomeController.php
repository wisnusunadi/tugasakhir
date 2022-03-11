<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use PhpParser\Node\Expr\Cast\Array_;


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
        $divisi_id = Auth::user()->Pendaftaran->Divisi->id;
        $jabatan_id = Auth::user()->Pendaftaran->Jabatan->id;
        $soal = Soal::whereHas('Divisi', function ($q) use ($divisi_id) {
            $q->where('id', $divisi_id);
        })->whereHas('Jabatan', function ($q) use ($jabatan_id) {
            $q->where('id', $jabatan_id);
        })->get();
        return view('soal.tes.preview', ['soal' => $soal]);
    }

    public function soal_tes_show($id)
    {
        if (!Auth::user()) {
        } else {
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


    public function draft_soal_preview($id)
    {
        $soal = Soal::find($id);
        return view('soal.draft.preview', ['soal' => $soal]);
    }
    public function draft_soal_show()
    {
        $soal = Soal::paginate(6);
        return view('soal.draft.show', ['soal' => $soal]);
    }
    public function draft_soal_data(Request $request)
    {
        if ($request->ajax()) {
            // $output ='';
            //  $query = $request->get('query');
            //  if($query != '')
            //  {
            //     $data = Soal::where('id',1)->get();
            //  }
            //  else
            //  {
            //   $data = Soal::all();
            //  }
            //  $total = $data->count();

            //  if ($total > 0){
            //    foreach($data as $s){
            //     $output .= '<input class="form-check-input" type="radio" name="x" checked><br>';
            //    }
            //    $output = '<br>';
            //  }else{
            //      'Data Kosong';
            //  }

            $output = '';

            $query = $request->get('query');
            if ($query != '') {
                $data = Soal::where('nama', 'like', '%' . $query . '%')
                    ->orwhere('kode_soal', 'like', '%' . $query . '%')->paginate(6);
            } else {
                $data = Soal::paginate(6);
            }
            $total = $data->count();

            if ($total > 0) {
                foreach ($data as $s) {
                    $output .= '   <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                     <div class="card-header text-muted border-bottom-0">
                     ' . $s->nama . '
                     </div>
                     <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b>' . $s->kode_soal . '</b></h2>
                          <p class="text-muted text-sm"><b>Jumlah: </b> ' . $s->getJumlahSoal() . ' Soal </p>
                          <p class="text-muted text-sm"><b>Jabatan: </b>';
                    foreach ($s->Jabatan as $j) {
                        $output .= ' ' . $j->nama;
                        if ($s->Jabatan->last() == $j) {
                            $output .= '';
                        } else {
                            $output .= ',';
                        }
                    }
                    $output .= ' </p>
                          <p class="text-muted text-sm"><b>Divisi: </b>';
                    foreach ($s->Divisi as $d) {
                        $output .= ' ' . $d->nama;
                        if ($s->Divisi->last() == $d) {
                            $output .= '';
                        } else {
                            $output .= ',';
                        }
                    }

                    $output .= '</p>
                        </div>
                      </div>
                       </div>
                      <div class="card-footer">
                       <div class="text-right">
                         <a href="#" class="btn btn-sm bg-teal">
                         Edit
                        </a>
                         <a href="' . route('draft_soal.preview', ['id' => $s->id]) . '" class="btn btn-sm btn-primary">
                        Lihat Soal
                          </a>
                         </div>
                        </div>
                     </div>
                     </div>


                     ';
                }
            } else {
                $output .= '<div class="callout callout-danger">
                <h5>Data tidak ditemukan</h5>
                <p>Data belum pernah di input atau adanya kesalahan kata kunci pencarian</p>
              </div>';
            }


            $output .= ' <div class="card-footer" id="paging">
            ' . $data->render() . '
            </div>';

            $data = array(
                'show' => $output,
            );

            return response($data);
        }
    }

    public function draft_soal_create()
    {
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        return view('soal.draft.create', ['divisi' => $divisi, 'jabatan' => $jabatan]);
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
}
