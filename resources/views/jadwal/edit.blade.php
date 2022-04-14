@extends('layouts.adminlte.main')

@section('title', 'Sistem Penerimaan Karyawan')

@section('custom_css')
<style>
section{
    height: 100vh;
    margin-left: 250px;
}

.group{
    background-color: steelblue;
    color: white;
}

.row{
    height: 100%;
}

.flex-container {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    justify-content: center;
}

.flex-container > div{
    margin: 10px;
}

.imgoprec{
    object-fit: contain;
    width: 100%;
}
.aligncenter{
    text-align: center;
}
.hide{
    display: none;
}

.usiaform{
    width: 45%;
}

.pendidikanform{
    width: 45%;
}

.jarakform{
    width: 45%;
}

.soalform{
    width: 50%;
}

@media only screen and (min-width: 992px){
    .labelket{
        text-align: right !important;
    }
}

@media only screen and (max-width: 991px){
    .labelket{
        text-align: left !important;
    }
}
</style>
@stop

@section('content')

<section class="content">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Jadwal Open Recruitment</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{route('jadwal.show')}}">Jadwal Open Recruitment</a></li>
                <li class="breadcrumb-item active">Tambah</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{route('jadwal.update', ['id' => $id])}}" id="jadwalform">
                @method('PUT')
                @csrf
                @if(Session::has('error') || count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{Session::get('error')}}</strong> Periksa
                    kembali data yang diinput
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{Session::get('success')}}</strong>,
                    Terima kasih
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header bg-warning">
                        <h6 class="card-title">Ubah Jadwal</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="tanggal_mulai" class="col-lg-4 col-md-12 col-form-label labelket">Tanggal Mulai</label>
                            <div class="col-lg-8 col-md-12">
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ date('Y-m-d', strtotime($j->waktu_mulai)) }}">
                                <small id="msg_tanggal_mulai" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_akhir" class="col-lg-4 col-md-12 col-form-label labelket">Tanggal Akhir</label>
                            <div class="col-lg-8 col-md-12">
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ date('Y-m-d', strtotime($j->waktu_selesai)) }}" min="{{ date('Y-m-d', strtotime($j->waktu_mulai)) }}">
                                <small id="msg_tanggal_akhir" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-lg-4 col-md-12 col-form-label labelket">Keterangan</label>
                            <div class="col-lg-8 col-md-12">
                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">{{$j->ket}}</textarea>
                                <small id="msg_keterangan" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <table class="table table-hover aligncenter showtables" id="showtable">
                                    <thead>
                                        <tr>
                                            <th colspan="5">
                                                <span class="float-right"><button type="button" class="btn btn-sm btn-primary" id="tambahrow"><i class="fas fa-plus"></i> Tambah Jabatan</button></span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Jabatan</th>
                                            <th>Divisi</th>
                                            <th>Kuota</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 0; ?>
                                        @foreach ($j->Pendaftaran as $p)
                                        <tr class="kolom" id="kolom{{$x}}">
                                            <td rowspan="2">1</td>
                                            <td><select class="form-control jabatan" name="jabatan[{{$x}}]" id="jabatan{{$x}}" style="width: 100%">
                                                <option value="{{$p->jabatan_id}}" selected>{{$p->Jabatan->nama}}</option>
                                            </select></td>
                                            <td><select class="form-control divisi" name="divisi[{{$x}}]" id="divisi{{$x}}" style="width: 100%">
                                                <option value="{{$p->divisi_id}}" selected>{{$p->Divisi->nama}}</option>
                                            </select></td>
                                            <td><input type="number" class="form-control kuota" name="kuota[{{$x}}]" id="kuota{{$x}}" value="{{$p->kuota}}"></td>
                                            <td rowspan="2"><a id="removerow"><i class="fas fa-minus" style="color:red;"></i></a></td>
                                        </tr>
                                        <tr id="kolom{{$x}}">
                                            <td colspan="3">
                                                <div class="form-group row">
                                                    <label for="kriteria" class="col-lg-4 col-md-12 col-form-label labelket">Kriteria</label>
                                                    <div class="col-lg-7 col-md-12 d-flex justify-content-around">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[{{$x}}][0]" id="kriteria{{$x}}0" value="usia" @if(count($p->KriteriaStatus('usia')) > 0) checked="true" @endif>
                                                            <label class="form-check-label kriterialabel" for="kriteria{{$x}}0">Usia</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[{{$x}}][1]" id="kriteria{{$x}}1" value="pendidikan" @if(count($p->KriteriaStatus('pendidikan')) > 0) checked="true" @endif>
                                                            <label class="form-check-label kriterialabel" for="kriteria{{$x}}1">Pendidikan</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[{{$x}}][2]" id="kriteria{{$x}}2" value="jarak" @if(count($p->KriteriaStatus('jarak')) > 0) checked="true" @endif>
                                                            <label class="form-check-label kriterialabel" for="kriteria{{$x}}2">Jarak Rumah</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[{{$x}}][3]" id="kriteria{{$x}}3" value="soal" @if(count($p->KriteriaStatus('soal')) > 0)  checked="true" @endif>
                                                            <label class="form-check-label kriterialabel" for="kriteria{{$x}}3">Soal</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-container">
                                                    <div id="usiaform{{$x}}" class="@if(count($p->KriteriaStatus('usia')) <= 0) hide @endif usiaform">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="form-group row">
                                                                    <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Usia</label>
                                                                    <div class="col-lg-5">

                                                                        <input type="number" class="form-control col-form-label master_usia" name="master_usia[{{$x}}]" step="0.01" min="0" @if(count($p->KriteriaStatus('usia')) > 0) value="{{$p->KriteriaStatus('usia')->first()->Kriteria->bobot}}" @endif>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover usiatable" id="usiatable{{$x}}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Range Min ( <i class="fas fa-greater-than"></i> )</th>
                                                                                    <th>Range Max ( <i class="fas fa-less-than-equal"></i> )</th>
                                                                                    <th>Bobot</th>
                                                                                    <th>Aksi</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if(count($p->KriteriaStatus('usia')) > 0)
                                                                                @foreach ($p->KriteriaStatus('usia') as $ku)
                                                                                <tr>
                                                                                    <td><input type="number" class="form-control usia_min" name="usia_min[{{$x}}][{{$loop->iteration - 1}}]" id="usia_min{{$x}}{{$loop->iteration - 1}}" min="0" value="{{$ku->range_min}}"></td>
                                                                                    <td><input type="number" class="form-control usia_max" name="usia_max[{{$x}}][{{$loop->iteration - 1}}]" id="usia_max{{$x}}{{$loop->iteration - 1}}" min="0" value="{{$ku->range_max}}"></td>
                                                                                    <td><input type="number" class="form-control bobot_usia" name="bobot_usia[{{$x}}][{{$loop->iteration - 1}}]" id="bobot_usia{{$x}}{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$ku->nilai}}"></td>
                                                                                    <td>
                                                                                        @if($loop->iteration <= 1)
                                                                                            <a id="addusiarow"><i class="fas fa-plus text-success"></i></a>
                                                                                        @else
                                                                                            <a id="removeusiarow"><i class="fas fa-minus text-danger"></i></a>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                @endforeach
                                                                                @else
                                                                                <tr>
                                                                                    <td><input type="number" class="form-control usia_min" name="usia_min[{{$x}}][0]" id="usia_min{{$x}}0" min="0"></td>
                                                                                    <td><input type="number" class="form-control usia_max" name="usia_max[{{$x}}][0]" id="usia_max{{$x}}0" min="0"></td>
                                                                                    <td><input type="number" class="form-control bobot_usia" name="bobot_usia[{{$x}}][0]" id="bobot_usia{{$x}}0" step="0.01" min="0"></td>
                                                                                    <td><a class="addusiarow"><i class="fas fa-plus text-success"></i></a></td>
                                                                                </tr>
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="pendidikanform{{$x}}" class="@if(count($p->KriteriaStatus('pendidikan')) <= 0) hide @endif pendidikanform">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="form-group row">
                                                                    <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Pendidikan</label>
                                                                    <div class="col-lg-5">
                                                                        <input type="number" class="form-control col-form-label master_pendidikan" name="master_pendidikan[{{$x}}]" step="0.01" min="0" @if(count($p->KriteriaStatus('pendidikan')) > 0) value="{{$p->KriteriaStatus('pendidikan')->first()->Kriteria->bobot}}" @endif>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover pendidikantable" id="pendidikantable{{$x}}">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Pendidikan Terakhir</th>
                                                                                <th>Akreditasi</th>
                                                                                <th>Bobot</th>
                                                                                <th>Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if(count($p->KriteriaStatus('pendidikan')) > 0)
                                                                            @foreach ($p->KriteriaStatus('pendidikan') as $kp)
                                                                            <tr>
                                                                                <td><select class="form-control ketentuan_pendidikan" name="ketentuan_pendidikan[{{$x}}][{{$loop->iteration - 1}}]" id="ketentuan_pendidikan{{$x}}{{$loop->iteration - 1}}" style="width: 100%">
                                                                                            <option value=""></option>
                                                                                            <option value="smak" @if($kp->pendidikan == "smak") selected @endif>SMA / SMK</option>
                                                                                            <option value="d3" @if($kp->pendidikan == "d3") selected @endif>D3</option>
                                                                                            <option value="s1d4" @if($kp->pendidikan == "s1d4") selected @endif>D4 / S1</option>
                                                                                        </select>
                                                                                </td>
                                                                                <td><select class="form-control peringkat" name="peringkat[{{$x}}][{{$loop->iteration - 1}}]" id="peringkat{{$x}}{{$loop->iteration - 1}}" style="width: 100%">
                                                                                            <option value="NULL" @if($kp->peringkat == NULL) selected @endif>Tidak Terakreditasi</option>
                                                                                            <option value="A" @if($kp->peringkat == "A") selected @endif>A</option>
                                                                                            <option value="B" @if($kp->peringkat == "B") selected @endif>B</option>
                                                                                            <option value="C" @if($kp->peringkat == "C") selected @endif>C</option>
                                                                                        </select>
                                                                                </td>
                                                                                <td><input type="number" class="form-control bobot_pendidikan" name="bobot_pendidikan[{{$x}}][{{$loop->iteration - 1}}]" id="bobot_pendidikan{{$x}}{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$kp->nilai}}"></td>
                                                                                <td>
                                                                                    @if($loop->iteration <= 1)
                                                                                        <a id="addpendidikanrow"><i class="fas fa-plus text-success"></i></a>
                                                                                    @else
                                                                                        <a id="removependidikanrow"><i class="fas fa-minus text-danger"></i></a>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                            @else
                                                                            <tr>
                                                                                <td><select class="form-control ketentuan_pendidikan" name="ketentuan_pendidikan[{{$x}}][0]" id="ketentuan_pendidikan{{$x}}0" style="width: 100%">
                                                                                            <option value=""></option>
                                                                                            <option value="smak">SMA / SMK</option>
                                                                                            <option value="d3">D3</option>
                                                                                            <option value="s1d4">D4 / S1</option>
                                                                                        </select>
                                                                                </td>
                                                                                <td><select class="form-control peringkat" name="peringkat[{{$x}}][0]" id="peringkat{{$x}}0" style="width: 100%">
                                                                                            <option value="NULL">Tidak Terakreditasi</option>
                                                                                            <option value="A">A</option>
                                                                                            <option value="B">B</option>
                                                                                            <option value="C">C</option>
                                                                                        </select>
                                                                                </td>
                                                                                <td><input type="number" class="form-control bobot_pendidikan" name="bobot_pendidikan[{{$x}}][0]" id="bobot_pendidikan{{$x}}0" step="0.01" min="0"></td>
                                                                                <td>
                                                                                    <a id="addpendidikanrow"><i class="fas fa-plus text-success"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="jarakform{{$x}}" class="@if(count($p->KriteriaStatus('jarak')) <= 0) hide @endif jarakform">
                                                        <div class="card">
                                                                <div class="card-body">
                                                                <div class="form-group row">
                                                                        <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Jarak</label>
                                                                        <div class="col-lg-5">
                                                                            <input type="number" class="form-control col-form-label master_jarak" name="master_jarak[{{$x}}]" step="0.01" min="0" @if(count($p->KriteriaStatus('jarak')) > 0) value="{{$p->KriteriaStatus('jarak')->first()->Kriteria->bobot}}" @endif>
                                                                        </div>
                                                                    </div>
                                                                <div class="form-group row">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover jaraktable" id="jaraktable{{$x}}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>( <i class="fas fa-greater-than"></i> ) Range Min (KM)</th>
                                                                                    <th>( <i class="fas fa-less-than-equal"></i> ) Range Max (KM)</th>
                                                                                    <th>Bobot</th>
                                                                                    <th>Aksi</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if(count($p->KriteriaStatus('jarak')) > 0)
                                                                                @foreach ($p->KriteriaStatus('jarak') as $kj)
                                                                                <tr>
                                                                                    <td><input type="number" class="form-control jarak_min" name="jarak_min[{{$x}}][{{$loop->iteration - 1}}]" id="jarak_min{{$x}}{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$kj->range_min}}"></td>
                                                                                    <td><input type="number" class="form-control jarak_max" name="jarak_max[{{$x}}][{{$loop->iteration - 1}}]" id="jarak_max{{$x}}{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$kj->range_max}}"></td>
                                                                                    <td><input type="number" class="form-control bobot_jarak" name="bobot_jarak[{{$x}}][{{$loop->iteration - 1}}]" id="bobot_jarak{{$x}}{{$loop->iteration - 1}}"  step="0.01" min="0" value="{{$kj->nilai}}"></td>
                                                                                    <td>
                                                                                        @if($loop->iteration <= 1)
                                                                                            <a id="addjarakrow"><i class="fas fa-plus text-success"></i></a>
                                                                                        @else
                                                                                            <a id="removejarakrow"><i class="fas fa-minus text-danger"></i></a>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                @endforeach
                                                                                @else
                                                                                <tr>
                                                                                    <td><input type="number" class="form-control jarak_min" name="jarak_min[{{$x}}][0]" id="jarak_min{{$x}}0" step="0.01" min="0"></td>
                                                                                    <td><input type="number" class="form-control jarak_max" name="jarak_max[{{$x}}][0]" id="jarak_max{{$x}}0" step="0.01" min="0"></td>
                                                                                    <td><input type="number" class="form-control bobot_jarak" name="bobot_jarak[{{$x}}][0]" id="bobot_jarak{{$x}}0"  step="0.01" min="0"></td>
                                                                                    <td><a id="addjarakrow"><i class="fas fa-plus text-success"></i></a></td>
                                                                                </tr>
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="soalform{{$x}}" class="@if(count($p->KriteriaStatus('soal')) <= 0) hide @endif soalform">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="form-group row">
                                                                    <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Soal</label>
                                                                    <div class="col-lg-5">
                                                                        <input type="number" class="form-control col-form-label master_soal" name="master_soal[{{$x}}]"  step="0.01" min="0" @if(count($p->KriteriaStatus('soal')) > 0) value="{{$p->KriteriaStatus('soal')->first()->Kriteria->bobot}}" @endif>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover soaltable" id="soaltable{{$x}}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Soal</th>
                                                                                    <th>Bobot</th>
                                                                                    <th>Aksi</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if(count($p->KriteriaStatus('soal')) > 0)
                                                                                @foreach ($p->KriteriaStatus('soal') as $ks)
                                                                                <tr>
                                                                                    <td>
                                                                                        <select class="form-control soal_id" id="soal_id{{$x}}{{$loop->iteration - 1}}" name="soal_id[{{$x}}][{{$loop->iteration - 1}}]">
                                                                                            @if(count($p->DaftarSoal()) > 0)
                                                                                            @foreach ($p->DaftarSoal() as $ps)
                                                                                                <option value="{{$ps->id}}" @if($ks->soal_id == $ps->id) selected @endif>{{$ps->nama}}</option>
                                                                                            @endforeach
                                                                                            @endif
                                                                                        </select>
                                                                                    </td>
                                                                                    <td><input type="number" class="form-control bobot_soal" name="bobot_soal[{{$x}}][{{$loop->iteration - 1}}]" id="bobot_soal{{$x}}{{$loop->iteration - 1}}"  step="0.01" min="0" value="{{$ks->nilai}}"></td>
                                                                                    <td>
                                                                                        @if($loop->iteration <= 1)
                                                                                        <a id="addsoalrow"><i class="fas fa-plus text-success"></i></a>
                                                                                        @else
                                                                                        <a id="removesoalrow"><i class="fas fa-minus text-danger"></i></a>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                @endforeach
                                                                                @else
                                                                                <tr>
                                                                                    <td><select class="form-control soal_id" id="soal_id{{$x}}{{$loop->iteration - 1}}" name="soal_id[{{$x}}][{{$loop->iteration - 1}}]">
                                                                                        @if(count($p->DaftarSoal()) > 0)
                                                                                        @foreach ($p->DaftarSoal() as $ps)
                                                                                            <option value="{{$ps->id}}">{{$ps->nama}}</option>
                                                                                        @endforeach
                                                                                        @endif
                                                                                    </select></td>
                                                                                    <td><input type="number" class="form-control bobot_soal" name="bobot_soal[{{$x}}][{{$loop->iteration - 1}}]" id="bobot_soal{{$x}}{{$loop->iteration - 1}}"  step="0.01" min="0"></td>
                                                                                    <td><a id="addsoalrow"><i class="fas fa-plus text-success"></i></a></td>
                                                                                </tr>
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $x++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="float-left"><a href="{{route('jadwal.show')}}" type="button" class="btn btn-danger">
                            Batal
                        </a></span>
                        <span class="float-right"><button type="button" id="btnsubmit" class="btn btn-warning">Simpan</button></span>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(function(){
        var countable = 1;
        select();
        select_pend();
        // $('.jabatan').select2();
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        console.log(today);
        // $("#tanggal_mulai").attr("min", today);
        // $("#tanggal_akhir").attr("min", today);


        $('#tanggal_mulai').on('keyup change', function() {
            $("#tanggal_akhir").val("");
            $("#btncetak").removeAttr('disabled');
            if ($(this).val() != "") {
                $('#tanggal_mulai').removeClass('is-invalid');
                $('#msg_tanggal_mulai').html("");
                $('#tanggal_akhir').removeAttr('readonly');
                $("#tanggal_akhir").attr("min", $(this).val());
            } else {
                $('#tanggal_mulai').addClass('is-invalid');
                $('#msg_tanggal_mulai').html("Tanggal Mulai Pendaftaran harus diisi");
                $("#tanggal_akhir").val("");
                $("#btncetak").attr('disabled', true);
            }

            validasi();
        });

        $('#tanggal_akhir').on('keyup change', function() {

            $("#btncetak").removeAttr('disabled');
            if ($(this).val() != "") {
                $('#tanggal_akhir').removeClass('is-invalid');
                $('#msg_tanggal_mulai').html("");
            } else {
                $('#tanggal_akhir').addClass('is-invalid');
                $('#msg_tanggal_akhir').html("Tanggal Akhir Pendaftaran harus diisi");
                $("#btncetak").attr('disabled', true);
            }

            validasi();
        });

        $('#keterangan').on('keyup change', function() {
            $("#btncetak").removeAttr('disabled');
            if ($(this).val() != "") {
                $('#keterangan').removeClass('is-invalid');
                $('#msg_keterangan').html("");
            } else {
                $('#keterangan').addClass('is-invalid');
                $('#msg_keterangan').html("Keterangan harus diisi");
                $("#btncetak").attr('disabled', true);
            }

            validasi();
        });

        function validasi(){
            var tgl_mulai = $("#tanggal_mulai").val();
            var tgl_akhir = $("#tanggal_akhir").val();
            var ket = $('#keterangan').val();
            if(tgl_mulai != "" && tgl_akhir != "" && ket != ""){
                $('#btnsubmit').removeAttr('disabled');
            }
            else{
                $('#btnsubmit').attr('disabled', true);
            }
        }

        function soal_select(ids, jab_id, div_id){
            if(jab_id && div_id){
                ids.select2({
                        placeholder: "Pilih Soal",
                        ajax: {
                            minimumResultsForSearch: 20,
                            dataType: 'json',
                            theme: "bootstrap",
                            delay: 250,
                            type: 'POST',
                            url: '/api/soal/get_select/'+jab_id+'/'+div_id,
                            data: function(params) {
                                return {
                                    term: params.term
                                }
                            },
                            processResults: function(data) {
                                console.log(data);
                                return {
                                    results: $.map(data, function(obj) {
                                        return {
                                            id: obj.id,
                                            text: obj.nama
                                        };
                                    })
                                };
                            },
                        }
                    });
            }else{
                ids.select2({
                    placeholder: 'Pilih Soal',
                });
            }
        }

        function numberRows($t) {
            var c = 0;
            $t.find("tr.kolom").each(function(ind, el) {
                $(el).find("td:eq(0)").html(++c);
                var j = c - 1;
                var id = $(el).attr('id');
                $('tr[id="' + id + '"]').find('.jabatan').attr('name', 'jabatan[' + j + ']');
                $('tr[id="' + id + '"]').find('.jabatan').attr('id', 'jabatan' + j);
                $('tr[id="' + id + '"]').find('.divisi').attr('name', 'divisi[' + j + ']');
                $('tr[id="' + id + '"]').find('.divisi').attr('id', 'divisi' + j);
                $('tr[id="' + id + '"]').find('.kuota').attr('name', 'kuota[' + j + ']');
                $('tr[id="' + id + '"]').find('.kuota').attr('id', 'kuota' + j);
                $('tr[id="' + id + '"]').find('.usiatable').attr('id', 'usiatable' + j);
                $('tr[id="' + id + '"]').find('.usiaform').attr('id', 'usiaform' + j);
                $('tr[id="' + id + '"]').find('.pendidikantabe').attr('id', 'pendidikantable' + j);
                $('tr[id="' + id + '"]').find('.pendidikanform').attr('id', 'pendidikanform' + j);
                $('tr[id="' + id + '"]').find('.jaraktable').attr('id', 'jaraktable' + j);
                $('tr[id="' + id + '"]').find('.jarakform').attr('id', 'jarakform' + j);
                $('tr[id="' + id + '"]').find('.soaltable').attr('id', 'soaltable' + j);
                $('tr[id="' + id + '"]').find('.soalform').attr('id', 'soalform' + j);

                var jab_id = $('tr[id="' + id + '"]').find('.jabatan').val();
                var div_id = $('tr[id="' + id + '"]').find('.divisi').val();

                var count_kriteria = 0;
                $('tr[id="' + id + '"]').find('.kriteria').each(function(ind1, el1){
                    $(el1).attr('id', 'kriteria' + j+''+count_kriteria);
                    $(el1).attr('name', 'kriteria[' + j + ']['+ count_kriteria +']');
                    count_kriteria++;
                });

                var count_kriteria_label = 0;
                $('tr[id="' + id + '"]').find('.kriterialabel').each(function(ind1, el1){
                    $(el1).attr('for', 'kriteria' + j+''+count_kriteria_label);
                    count_kriteria_label++;
                });

                $('tr[id="' + id + '"]').find('.master_usia').attr('name', 'master_usia[' + j +']');
                var count_usia = 0 - 1;
                $('tr[id="' + id + '"] .usiatable').find('tr').each(function(ind1, el1){
                    $(el1).find('.usia_min').attr('name', 'usia_min[' + j + ']['+ count_usia +']');
                    $(el1).find('.usia_min').attr('id', 'usia_min'+ count_usia);
                    $(el1).find('.usia_max').attr('name', 'usia_max[' + j + ']['+ count_usia +']');
                    $(el1).find('.usia_max').attr('id', 'usia_max'+ count_usia);
                    $(el1).find('.bobot_usia').attr('name', 'bobot_usia[' + j + ']['+ count_usia +']');
                    $(el1).find('.bobot_usia').attr('id', 'bobot_usia'+ count_usia);
                    count_usia++;
                });

                $('tr[id="' + id + '"]').find('.master_pendidikan').attr('name', 'master_pendidikan[' + j +']');
                var count_pendidikan = 0 - 1;
                $('tr[id="' + id + '"] .pendidikantable').find('tr').each(function(ind1, el1){
                    $(el1).find('.ketentuan_pendidikan').attr('name', 'ketentuan_pendidikan[' + j + ']['+ count_pendidikan +']');
                    $(el1).find('.ketentuan_pendidikan').attr('id', 'ketentuan_pendidikan'+j+''+ count_pendidikan);
                    $(el1).find('.peringkat').attr('name', 'peringkat[' + j + ']['+ count_pendidikan +']');
                    $(el1).find('.peringkat').attr('id', 'peringkat'+j+''+ count_pendidikan);
                    $(el1).find('.bobot_pendidikan').attr('name', 'bobot_pendidikan[' + j + ']['+ count_pendidikan +']');
                    $(el1).find('.bobot_pendidikan').attr('id', 'bobot_pendidikan'+ count_pendidikan);
                    // $('.ketentuan_pendidikan').select2();
                    // $('.peringkat').select2();
                    count_pendidikan++;
                });

                $('tr[id="' + id + '"]').find('.master_jarak').attr('name', 'master_jarak[' + j +']');
                var count_jarak = 0 - 1;
                $('tr[id="' + id + '"] .jaraktable').find('tr').each(function(ind1, el1){
                    $(el1).find('.jarak_min').attr('name', 'jarak_min[' + j + ']['+ count_jarak +']');
                    $(el1).find('.jarak_min').attr('id', 'jarak_min'+ count_jarak);
                    $(el1).find('.jarak_max').attr('name', 'jarak_max[' + j + ']['+ count_jarak +']');
                    $(el1).find('.jarak_max').attr('id', 'jarak_max'+ count_jarak);
                    $(el1).find('.bobot_jarak').attr('name', 'bobot_jarak[' + j + ']['+ count_jarak +']');
                    $(el1).find('.bobot_jarak').attr('id', 'bobot_jarak'+ count_jarak);
                    count_jarak++;
                });

                soal_select($('tr[id="' + id + '"] .soaltable .soal_id'), jab_id, div_id);

                $('tr[id="' + id + '"]').find('.master_soal').attr('name', 'master_soal[' + j +']');
                var count_soal = 0 - 1;
                $('tr[id="' + id + '"] .soaltable').find('tr').each(function(ind1, el1){
                    $(el1).find('.soal_id').attr('name', 'soal_id[' + j + ']['+ count_soal +']');
                    $(el1).find('.soal_id').attr('id', 'soal_id'+j+''+ count_soal);
                    $(el1).find('.bobot_soal').attr('name', 'bobot_soal[' + j + ']['+ count_soal +']');
                    $(el1).find('.bobot_soal').attr('id', 'bobot_soal'+ count_soal);
                    $('.soal_id').select2();
                    count_soal++;
                });
                $('tr[id="' + id + '"]').attr('id', 'kolom' + j);



                select();
                select_pend();
                // var count_kunci = 0;
                // $('tr[id="' + id + '"]').find('.kunci_jawaban').each(function(ind1, el1){
                //     $(el1).attr('data-name', 'radiokunci' + j);
                //     $(el1).attr('name', 'kunci_jawaban[' + j + ']['+ count_kunci +']');
                //     count_kunci++;
                // });
                // $('tr[id="' + id + '"]').find('.jawaban').attr('id', 'jawaban'+j);

                // $(el).attr('id', 'kolom' + j);
                // $(el).find('.soal').attr('name', 'soal[' + j + ']');
                // $(el).find('.soal').attr('id', 'soal' + j);

                // $(el).find('.jawaban').attr('id', 'jawaban' + j);
                // $(el).find('.poin').attr('name', 'poin[' + j + ']');
                // $(el).find('.poin').attr('id', 'poin' + j);


            });
        }

        // function numberRows($t) {
        //     var c = 0 - 2;
        //     $t.find("tr").each(function(ind, el) {
        //         $(el).find("td:eq(0)").html(++c);
        //         var j = c - 1;
        //         $(el).find('.jabatan').attr('name', 'jabatan[' + j + ']');
        //         $(el).find('.jabatan').attr('id', 'jabatan' + j);
        //         $(el).find('.divisi').attr('name', 'divisi[' + j + ']');
        //         $(el).find('.divisi').attr('id', 'divisi' + j);
        //         $(el).find('.kuota').attr('name', 'kuota[' + j + ']');
        //         $(el).find('.kuota').attr('id', 'kuota' + j);
        //         select();
        //     });
        // }

        $('#showtable').on('click', '#tambahrow', function(){
            $('#showtable tr[id="kolom'+(countable - 1)+'"]:last').after(`<tr class="kolom" id="kolom`+countable+`">
                                            <td rowspan="2">1</td>
                                            <td><select class="form-control jabatan" name="jabatan[`+countable+`]" id="jabatan`+countable+`" style="width: 100%">

                                            </select></td>
                                            <td><select class="form-control divisi" name="divisi[`+countable+`]" id="divisi`+countable+`" style="width: 100%">

                                            </select></td>
                                            <td><input type="number" class="form-control kuota" name="kuota[`+countable+`]" id="kuota`+countable+`"></td>
                                            <td rowspan="2"><a id="removerow"><i class="fas fa-minus" style="color:red;"></i></a></td>
                                        </tr>
                                        <tr id="kolom`+countable+`">
                                            <td colspan="3">
                                                <div class="form-group row">
                                                    <label for="kriteria" class="col-lg-4 col-md-12 col-form-label labelket">Kriteria</label>
                                                    <div class="col-lg-7 col-md-12 d-flex justify-content-around">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[`+countable+`][0]" id="kriteria01" value="usia">
                                                            <label class="form-check-label kriterialabel" for="kriteria01">Usia</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[`+countable+`][1]" id="kriteria02" value="pendidikan">
                                                            <label class="form-check-label kriterialabel" for="kriteria02">Pendidikan</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[`+countable+`][2]" id="kriteria03" value="jarak">
                                                            <label class="form-check-label kriterialabel" for="kriteria03">Jarak Rumah</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input kriteria" type="checkbox" name="kriteria[`+countable+`][3]" id="kriteria04" value="soal">
                                                            <label class="form-check-label kriterialabel" for="kriteria04">Soal</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-container">
                                                <div id="usiaform`+countable+`" class="hide usiaform">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-group row">
                                                                <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Usia</label>
                                                                <div class="col-lg-5">
                                                                    <input type="number" class="form-control col-form-label master_usia" name="master_usia[`+countable+`]" step="0.01" min="0">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover usiatable" id="usiatable`+countable+`">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>( <i class="fas fa-greater-than"></i> ) Range Min (KM)</th>
                                                                                <th>( <i class="fas fa-less-than-equal"></i> ) Range Max (KM)</th>
                                                                                <th>Bobot</th>
                                                                                <th>Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><input type="number" class="form-control usia_min" name="usia_min[`+countable+`][]" id="usia_min`+countable+`" min="0"></td>
                                                                                <td><input type="number" class="form-control usia_max" name="usia_max[`+countable+`][]" id="usia_max`+countable+`" min="0"></td>
                                                                                <td><input type="number" class="form-control bobot_usia" name="bobot_usia[`+countable+`][]" id="bobot_usia`+countable+`" step="0.01" min="0"></td>
                                                                                <td><a class="addusiarow"><i class="fas fa-plus text-success"></i></a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="pendidikanform`+countable+`" class="hide pendidikanform">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-group row">
                                                                <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Pendidikan</label>
                                                                <div class="col-lg-5">
                                                                    <input type="number" class="form-control col-form-label master_pendidikan" name="master_pendikan[`+countable+`]" step="0.01" min="0">
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table table-hover pendidikantable" id="pendidikantable`+countable+`">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Pendidikan Terakhir</th>
                                                                            <th>Akreditasi</th>
                                                                            <th>Bobot</th>
                                                                            <th>Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><select class="form-control ketentuan_pendidikan" name="ketentuan_pendidikan[`+countable+`][]" id="ketentuan_pendidikan`+countable+`" style="width: 100%">
                                                                                        <option value=""></option>
                                                                                        <option value="smak">SMA / SMK</option>
                                                                                        <option value="d3">D3</option>
                                                                                        <option value="s1d4">D4 / S1</option>
                                                                                    </select>
                                                                            </td>
                                                                            <td><select class="form-control peringkat" name="peringkat[`+countable+`][]" id="peringkat`+countable+`" style="width: 100%">
                                                                                        <option value="NULL">Tidak Terakreditasi</option>
                                                                                        <option value="A">A</option>
                                                                                        <option value="B">B</option>
                                                                                        <option value="C">C</option>
                                                                                    </select>
                                                                            </td>
                                                                            <td><input type="number" class="form-control bobot_pendidikan" name="bobot_pendidikan[`+countable+`][]" id="bobot_pendidikan`+countable+`" step="0.01" min="0"></td>
                                                                            <td><a id="addpendidikanrow"><i class="fas fa-plus text-success"></i></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="jarakform`+countable+`" class="hide jarakform">
                                                    <div class="card">
                                                            <div class="card-body">
                                                            <div class="form-group row">
                                                                    <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Jarak</label>
                                                                    <div class="col-lg-5">
                                                                        <input type="number" class="form-control col-form-label master_jarak" name="master_jarak[`+countable+`]" step="0.01" min="0">
                                                                    </div>
                                                                </div>
                                                            <div class="form-group row">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover jaraktable" id="jaraktable`+countable+`">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Range Min ( <i class="fas fa-greater-than"></i> ) Km</th>
                                                                                <th>Range Max ( <i class="fas fa-less-than-equal"></i> ) Km</th>
                                                                                <th>Bobot</th>
                                                                                <th>Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><input type="number" class="form-control jarak_min" name="jarak_min[`+countable+`][]" id="jarak_min`+countable+`" step="0.01" min="0"></td>
                                                                                <td><input type="number" class="form-control jarak_max" name="jarak_max[`+countable+`][]" id="jarak_max`+countable+`" step="0.01" min="0"></td>
                                                                                <td><input type="number" class="form-control bobot_jarak" name="bobot_jarak[`+countable+`][]" id="bobot_jarak`+countable+`" step="0.01" min="0"></td>
                                                                                <td><a id="addjarakrow"><i class="fas fa-plus text-success"></i></a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="soalform`+countable+`" class="hide soalform">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-group row">
                                                                <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Soal</label>
                                                                <div class="col-lg-5">
                                                                    <input type="number" class="form-control col-form-label master_soal" name="master_soal[`+countable+`]" step="0.01" min="0">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover soaltable" id="soaltable`+countable+`">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Soal</th>
                                                                                <th>Bobot</th>
                                                                                <th>Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><select class="form-control soal_id" id="soal_id`+countable+`" name="soal_id[`+countable+`][]"></select></td>
                                                                                <td><input type="number" class="form-control bobot_soal" name="bobot_soal[`+countable+`][]" id="bobot_soal`+countable+`" step="0.01" min="0"></td>
                                                                                <td><a id="addsoalrow"><i class="fas fa-plus text-success"></i></a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </td>
                                        </tr>`);
            countable++;
            numberRows($("#showtable"));
        });

        $('#showtable').on('click', '#removerow', function(e) {
            var idtable = $(this).closest('tr.kolom').attr('id');
            $('tr[id="'+idtable+'"]').remove();
            countable--;
            numberRows($("#showtable"));

        });

        function numberRowsUsia(id) {
            var c = 0 - 1;
            $('#usiatable'+id).find("tr").each(function(ind, el) {
                var j = c;
                $(el).find('.usia_min').attr('name', 'usia_min[' + id + ']['+ j +']');
                $(el).find('.usia_min').attr('id', 'usia_min'+ j);
                $(el).find('.usia_max').attr('name', 'usia_max[' + id + ']['+ j +']');
                $(el).find('.usia_max').attr('id', 'usia_max'+ j);
                $(el).find('.bobot_usia').attr('name', 'bobot_usia[' + id + ']['+ j +']');
                $(el).find('.bobot_usia').attr('id', 'bobot_usia'+ j);
                c++;
            });
        }

        $(document).on('click', '.usiatable .addusiarow', function(){
            var ids = $(this).closest('.usiatable').attr('id');
            var idt = ids.substring(9);
            $('#'+ids+' tr:last').after(addusiarow());
            console.log(ids);
            numberRowsUsia(idt);
        });

        $(document).on('click', '.usiatable #removeusiarow', function(e) {
            var ids = $(this).closest('.usiatable').attr('id');
            var idt = ids.substring(9);
            $(this).closest('tr').remove();
            console.log(ids);
            numberRowsUsia(idt);
        });

        function numberRowsPendidikan(id) {
            var c = 0 - 1;
            $('#pendidikantable'+id).find("tr").each(function(ind, el1) {
                var j = c;
                $(el1).find('.ketentuan_pendidikan').attr('name', 'ketentuan_pendidikan[' + id + ']['+ j +']');
                $(el1).find('.ketentuan_pendidikan').attr('id', 'ketentuan_pendidikan'+id+''+ j);
                $(el1).find('.peringkat').attr('name', 'peringkat[' + id + ']['+ j +']');
                $(el1).find('.peringkat').attr('id', 'peringkat'+id+''+ j);
                $(el1).find('.bobot_pendidikan').attr('name', 'bobot_pendidikan[' + id + ']['+ j +']');
                $(el1).find('.bobot_pendidikan').attr('id', 'bobot_pendidikan'+ j);
                select_pend();
                c++;
            });
        }

        $(document).on('click', '.pendidikantable #addpendidikanrow', function(){
            var ids = $(this).closest('.pendidikantable').attr('id');
            var idt = ids.substring(15);
            $('#'+ids+' tr:last').after(addpendidikanrow());
            numberRowsPendidikan(idt);
        });

        $(document).on('change', '.pendidikantable .ketentuan_pendidikan', function(){
            var val = $(this).closest('tr').find('.ketentuan_pendidikan').val();
            var peringkat = $(this).closest('tr').find('.peringkat');
            if(val == "smak"){
                peringkat.prop('disabled', true);
            }
            else{
                peringkat.prop('disabled', false);
            }
        });

        $(document).on('click', '.pendidikantable #removependidikanrow', function(e) {
            var ids = $(this).closest('.pendidikantable').attr('id');
            var idt = ids.substring(9);
            $(this).closest('tr').remove();
            numberRowsPendidikan(idt);
        });

        function numberRowsJarak(id) {
            var c = 0 - 1;
            $('#jaraktable'+id).find("tr").each(function(ind, el1) {
                var j = c;
                $(el1).find('.jarak_min').attr('name', 'jarak_min[' + id + ']['+ j +']');
                $(el1).find('.jarak_min').attr('id', 'jarak_min'+ j);
                $(el1).find('.jarak_max').attr('name', 'jarak_max[' + id + ']['+ j +']');
                $(el1).find('.jarak_max').attr('id', 'jarak_max'+ j);
                $(el1).find('.bobot_jarak').attr('name', 'bobot_jarak[' + id + ']['+ j +']');
                $(el1).find('.bobot_jarak').attr('id', 'bobot_jarak'+ j);
                c++;
            });
        }

        $(document).on('click', '.jaraktable #addjarakrow', function(){
            var ids = $(this).closest('.jaraktable').attr('id');
            var idt = ids.substring(10);
            console.log(idt);
            $('#'+ids+' tr:last').after(addjarakrow());
            numberRowsJarak(idt);
        });

        $(document).on('click', '.jaraktable #removejarakrow', function(e) {
            var ids = $(this).closest('.jaraktable').attr('id');
            var idt = ids.substring(10);
            $(this).closest('tr').remove();
            numberRowsJarak(idt);
        });

        function numberRowsSoal(id, jab_id, div_id) {
            var c = 0 - 1;
            $('#soaltable'+id).find("tr").each(function(ind, el1) {
                var j = c;
                $(el1).find('.soal_id').attr('name', 'soal_id[' + id + ']['+ j +']');
                $(el1).find('.soal_id').attr('id', 'soal_id'+id+''+ j);
                soal_select($(el1).find('.soal_id'), jab_id, div_id);
                $(el1).find('.bobot_soal').attr('name', 'bobot_soal[' + id + ']['+ j +']');
                $(el1).find('.bobot_soal').attr('id', 'bobot_soal'+ j);
                c++;
            });
        }

        $(document).on('click', '.soaltable #addsoalrow', function(){
            var ids = $(this).closest('.soaltable').attr('id');
            var idt = ids.substring(9);
            var jab_id = $('tr[id="kolom'+idt+'"]').find('.jabatan').val();
            var div_id = $('tr[id="kolom'+idt+'"]').find('.divisi').val();
            console.log(jab_id+" "+div_id);
            $('#'+ids+' tr:last').after(addsoalrow());
            numberRowsSoal(idt, jab_id, div_id);
        });

        $(document).on('click', '.soaltable #removesoalrow', function(e) {
            var ids = $(this).closest('.soaltable').attr('id');
            var idt = ids.substring(9);
            $(this).closest('tr').remove();
            numberRowsSoal(idt);
        });

        $('#showtable').on('change', '.kriteria', function(e){
            var kriteria = [];
            var valchecked = $(this).val();
            // var idkriteria = $(this).closest('tr').find('.kriteria').attr('id');
            var numberOfChecked =  $(this).closest('tr').find('.kriteria:checked').length;
            $(this).closest('tr').find('.kriteria:checked').each(function(){
                    kriteria.push($(this).val());
            });


            if(numberOfChecked == 0){
                $(this).closest('tr').find('.kriteria[value='+valchecked+']').prop('checked', true);
                $(this).closest('tr').find('.kriteria:checked').each(function(){
                    kriteria.push(valchecked);
                });
            }

            if(kriteria.indexOf("usia") != -1){
                $(this).closest('tr').find('.usiaform').removeClass('hide');
            }
            else if(kriteria.indexOf("usia") == -1){
                $(this).closest('tr').find('.usiaform').addClass('hide');
            }

            if(kriteria.indexOf("pendidikan") != -1){
                $(this).closest('tr').find('.pendidikanform').removeClass('hide');
            }
            else if(kriteria.indexOf("pendidikan") == -1){
                $(this).closest('tr').find('.pendidikanform').addClass('hide');
            }

            if(kriteria.indexOf("jarak") != -1){
                $(this).closest('tr').find('.jarakform').removeClass('hide');
            }
            else if(kriteria.indexOf("jarak") == -1){
                $(this).closest('tr').find('.jarakform').addClass('hide');
            }

            if(kriteria.indexOf("soal") != -1){
                $(this).closest('tr').find('.soalform').removeClass('hide');
            }
            else if(kriteria.indexOf("soal") == -1){
                $(this).closest('tr').find('.soalform').addClass('hide');
            }
        });

        $('#showtable').on('change', '.jabatan', function(e){
            var id = $(this).closest('tr.kolom').attr('id');
            var val = $(this).closest('tr').find('.jabatan').val();
            var val_divisi = $(this).closest('tr').find('.divisi').val();
            if(val){
                if(val_divisi){
                    soal_select($('tr[id="'+id+'"] .soaltable .soal_id'), val, val_divisi);
                }
            }
        });

        $('#showtable').on('change', '.divisi', function(e){
            var id = $(this).closest('tr.kolom').attr('id');
            var val = $(this).closest('tr').find('.divisi').val();
            var val_jabatan = $(this).closest('tr').find('.jabatan').val();
            if(val){
                if(val_jabatan){
                    soal_select($('tr[id="'+id+'"] .soaltable .soal_id'), val_jabatan, val);
                }
            }
        });

        function addusiarow(){
            return `<tr>
                        <td><input type="number" class="form-control usia_min" name="usia_min[0][]" id="usia_min0" min="0"></td>
                        <td><input type="number" class="form-control usia_max" name="usia_max[0][]" id="usia_max0" min="0"></td>
                        <td><input type="number" class="form-control bobot_usia" name="bobot_usia[0][]" id="bobot_usia0" step="0.01" min="0"></td>
                        <td><a id="removeusiarow"><i class="fas fa-minus text-danger"></i></a></td>
                    </tr>`;
        }

        function addpendidikanrow(){
            return `<tr>
                    <td><select class="form-control ketentuan_pendidikan" name="ketentuan_pendidikan[0][]" id="ketentuan_pendidikan0" style="width: 100%">
                            <option value=""></option>
                            <option value="smak">SMA / SMK</option>
                            <option value="d3">D3</option>
                            <option value="s1d4">D4 / S1</option>
                        </select>
                    </td>
                    <td><select class="form-control peringkat" name="peringkat[0][]" id="peringkat0" style="width: 100%">
                            <option value="NULL">Tidak Terakreditasi</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td><input type="number" class="form-control bobot_pendidikan" name="bobot_pendidikan[0][]" id="bobot_pendidikan0" step="0.01" min="0"></td>
                    <td><a id="removependidikanrow"><i class="fas fa-minus text-danger"></i></a></td>
                </tr>`;
        }

        function addjarakrow(){
            return `<tr>
                        <td><input type="number" class="form-control jarak_min" name="jarak_min[0][]" id="jarak_min0" step="0.01" min="0"></td>
                        <td><input type="number" class="form-control jarak_max" name="jarak_max[0][]" id="jarak_max0" step="0.01" min="0"></td>
                        <td><input type="number" class="form-control bobot_jarak" name="bobot_jarak[0][]" id="bobot_jarak0" step="0.01" min="0"></td>
                        <td><a id="removejarakrow"><i class="fas fa-minus text-danger"></i></a></td>
                    </tr>`;
        }

        function addsoalrow(){
            return `<tr>
                    <td><select class="form-control soal_id" id="soal_id0" name="soal_id[0][]"></select></td>
                    <td><input type="number" class="form-control bobot_soal" name="bobot_soal[0][]" id="bobot_soal0" step="0.01" min="0"></td>
                    <td><a id="removesoalrow"><i class="fas fa-minus text-danger"></i></a></td>
                </tr>`
        }

        function select(){
            $('.jabatan').select2({
                placeholder: "Pilih Jabatan",
                ajax: {
                    minimumResultsForSearch: 20,
                    dataType: 'json',
                    theme: "bootstrap",
                    delay: 250,
                    type: 'GET',
                    url: '/api/jabatan/select',
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function(data) {
                        console.log(data);
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.id,
                                    text: obj.nama
                                };
                            })
                        };
                    },
                }
            })

            $('.divisi').select2({
                placeholder: "Pilih Divisi",
                ajax: {
                    minimumResultsForSearch: 20,
                    dataType: 'json',
                    theme: "bootstrap",
                    delay: 250,
                    type: 'GET',
                    url: '/api/divisi/select',
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function(data) {
                        console.log(data);
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.id,
                                    text: obj.nama
                                };
                            })
                        };
                    },
                }
            });
            $('.soal_id').select2({
                placeholder: 'Pilih Soal'
            });
        }

        function select_pend(){
            $('.ketentuan_pendidikan').select2({
                placeholder: 'Pilih Pendidikan'
            });
            $('.peringkat').select2({
                placeholder: 'Pilih Akreditasi'
            });
        }

        var unsaved = false;

        $(document).on('keyup change', ':input', function(){
            unsaved = true;
        });

        const unloadPage = () => {
            if (unsaved == true) {
                return "You have unsaved changes on this page.";
            }
        };

        window.onbeforeunload = unloadPage;

        $("#btnsubmit").on('click', function(){
            unsaved = false;
            $('#jadwalform').submit();
        });
    })
</script>
@endsection
