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
                <li class="breadcrumb-item active">Ubah Pendaftaran</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{route('pendaftaran.update', ['id' => $id])}}">
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
                            <label for="jabatan" class="col-lg-4 col-md-12 col-form-label labelket">Jabatan</label>
                            <div class="col-lg-8 col-md-12">
                                <select class="form-control jabatan" name="jabatan" id="jabatan" style="width: 100%">
                                    <option value="{{$p->jabatan_id}}" selected>{{$p->Jabatan->nama}}</option>
                                </select>
                                <small id="msg_jabatan" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="divisi" class="col-lg-4 col-md-12 col-form-label labelket">Divisi</label>
                            <div class="col-lg-8 col-md-12">
                                <select class="form-control divisi" name="divisi" id="divisi" style="width: 100%">
                                    <option value="{{$p->divisi_id}}" selected>{{$p->Divisi->nama}}</option>
                                </select>
                                <small id="msg_divisi" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="divisi" class="col-lg-4 col-md-12 col-form-label labelket">Kuota</label>
                            <div class="col-lg-4 col-md-6">
                                <input type="number" class="form-control col-form-label" id="kuota" name="kuota" value="{{$p->kuota}}">
                                <small id="msg_kuota" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kriteria" class="col-lg-4 col-md-12 col-form-label labelket">Kriteria</label>
                            <div class="col-lg-8 col-md-12">
                                <div class="form-check form-check-inline col-form-label">
                                    <input class="form-check-input kriteria" type="checkbox" name="kriteria[]" id="kriteria0" value="usia" @if(count($p->KriteriaStatus('usia')) > 0) checked="true" @endif>
                                    <label class="form-check-label kriterialabel" for="kriteria0">Usia</label>
                                </div>
                                <div class="form-check form-check-inline col-form-label">
                                    <input class="form-check-input kriteria" type="checkbox" name="kriteria[]" id="kriteria1" value="pendidikan" @if(count($p->KriteriaStatus('pendidikan')) > 0) checked="true" @endif>
                                    <label class="form-check-label kriterialabel" for="kriteria1">Pendidikan</label>
                                </div>
                                <div class="form-check form-check-inline col-form-label">
                                    <input class="form-check-input kriteria" type="checkbox" name="kriteria[]" id="kriteria2" value="jarak" @if(count($p->KriteriaStatus('jarak')) > 0) checked="true" @endif>
                                    <label class="form-check-label kriterialabel" for="kriteria2">Jarak Rumah</label>
                                </div>
                                <div class="form-check form-check-inline col-form-label">
                                    <input class="form-check-input kriteria" type="checkbox" name="kriteria[]" id="kriteria3" value="soal" @if(count($p->KriteriaStatus('soal')) > 0)  checked="true" @endif>
                                    <label class="form-check-label kriterialabel" for="kriteria3">Soal</label>
                                </div>
                                <small id="msg_kriteria" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="flex-container">
                            <div id="usiaform" class="@if(count($p->KriteriaStatus('usia')) <= 0) hide @endif usiaform">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Usia</label>
                                            <div class="col-lg-5">

                                                <input type="number" class="form-control col-form-label master_usia" name="master_usia" step="0.01" min="0" @if(count($p->KriteriaStatus('usia')) > 0) value="{{$p->KriteriaStatus('usia')->first()->Kriteria->bobot}}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="table-responsive">
                                                <table class="table table-hover usiatable" id="usiatable">
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
                                                            <td><input type="number" class="form-control usia_min" name="usia_min[{{$loop->iteration - 1}}]" id="usia_min{{$loop->iteration - 1}}" min="0" value="{{$ku->range_min}}"></td>
                                                            <td><input type="number" class="form-control usia_max" name="usia_max[{{$loop->iteration - 1}}]" id="usia_max{{$loop->iteration - 1}}" min="0" value="{{$ku->range_max}}"></td>
                                                            <td><input type="number" class="form-control bobot_usia" name="bobot_usia[{{$loop->iteration - 1}}]" id="bobot_usia{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$ku->nilai}}"></td>
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
                                                            <td><input type="number" class="form-control usia_min" name="usia_min[0]" id="usia_min0" min="0"></td>
                                                            <td><input type="number" class="form-control usia_max" name="usia_max[0]" id="usia_max0" min="0"></td>
                                                            <td><input type="number" class="form-control bobot_usia" name="bobot_usia[0]" id="bobot_usia0" step="0.01" min="0"></td>
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
                            <div id="pendidikanform" class="@if(count($p->KriteriaStatus('pendidikan')) <= 0) hide @endif pendidikanform">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Pendidikan</label>
                                            <div class="col-lg-5">
                                                <input type="number" class="form-control col-form-label master_pendidikan" name="master_pendidikan" step="0.01" min="0" @if(count($p->KriteriaStatus('pendidikan')) > 0) value="{{$p->KriteriaStatus('pendidikan')->first()->Kriteria->bobot}}" @endif>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover pendidikantable" id="pendidikantable">
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
                                                        <td><select class="form-control ketentuan_pendidikan" name="ketentuan_pendidikan[{{$loop->iteration - 1}}]" id="ketentuan_pendidikan{{$loop->iteration - 1}}" style="width: 100%">
                                                                    <option value=""></option>
                                                                    <option value="smak" @if($kp->pendidikan == "smak") selected @endif>SMA / SMK</option>
                                                                    <option value="d3" @if($kp->pendidikan == "d3") selected @endif>D3</option>
                                                                    <option value="s1d4" @if($kp->pendidikan == "s1d4") selected @endif>D4 / S1</option>
                                                                </select>
                                                        </td>
                                                        <td><select class="form-control peringkat" name="peringkat[{{$loop->iteration - 1}}]" id="peringkat{{$loop->iteration - 1}}" style="width: 100%">
                                                                    <option value="NULL" @if($kp->peringkat == NULL) selected @endif>Tidak Terakreditasi</option>
                                                                    <option value="A" @if($kp->peringkat == "A") selected @endif>A</option>
                                                                    <option value="B" @if($kp->peringkat == "B") selected @endif>B</option>
                                                                    <option value="C" @if($kp->peringkat == "C") selected @endif>C</option>
                                                                </select>
                                                        </td>
                                                        <td><input type="number" class="form-control bobot_pendidikan" name="bobot_pendidikan[{{$loop->iteration - 1}}]" id="bobot_pendidikan{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$kp->nilai}}"></td>
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
                                                        <td><select class="form-control ketentuan_pendidikan" name="ketentuan_pendidikan[0]" id="ketentuan_pendidikan0" style="width: 100%">
                                                                    <option value=""></option>
                                                                    <option value="smak">SMA / SMK</option>
                                                                    <option value="d3">D3</option>
                                                                    <option value="s1d4">D4 / S1</option>
                                                                </select>
                                                        </td>
                                                        <td><select class="form-control peringkat" name="peringkat[0]" id="peringkat0" style="width: 100%">
                                                                    <option value="NULL">Tidak Terakreditasi</option>
                                                                    <option value="A">A</option>
                                                                    <option value="B">B</option>
                                                                    <option value="C">C</option>
                                                                </select>
                                                        </td>
                                                        <td><input type="number" class="form-control bobot_pendidikan" name="bobot_pendidikan[0]" id="bobot_pendidikan0" step="0.01" min="0"></td>
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
                            <div id="jarakform" class="@if(count($p->KriteriaStatus('jarak')) <= 0) hide @endif jarakform">
                                <div class="card">
                                        <div class="card-body">
                                        <div class="form-group row">
                                                <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Jarak</label>
                                                <div class="col-lg-5">
                                                    <input type="number" class="form-control col-form-label master_jarak" name="master_jarak" step="0.01" min="0" @if(count($p->KriteriaStatus('jarak')) > 0) value="{{$p->KriteriaStatus('jarak')->first()->Kriteria->bobot}}" @endif>
                                                </div>
                                            </div>
                                        <div class="form-group row">
                                            <div class="table-responsive">
                                                <table class="table table-hover jaraktable" id="jaraktable">
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
                                                            <td><input type="number" class="form-control jarak_min" name="jarak_min[{{$loop->iteration - 1}}]" id="jarak_min{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$kj->range_min}}"></td>
                                                            <td><input type="number" class="form-control jarak_max" name="jarak_max[{{$loop->iteration - 1}}]" id="jarak_max{{$loop->iteration - 1}}" step="0.01" min="0" value="{{$kj->range_max}}"></td>
                                                            <td><input type="number" class="form-control bobot_jarak" name="bobot_jarak[{{$loop->iteration - 1}}]" id="bobot_jarak{{$loop->iteration - 1}}"  step="0.01" min="0" value="{{$kj->nilai}}"></td>
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
                                                            <td><input type="number" class="form-control jarak_min" name="jarak_min[0]" id="jarak_min0" step="0.01" min="0"></td>
                                                            <td><input type="number" class="form-control jarak_max" name="jarak_max[0]" id="jarak_max0" step="0.01" min="0"></td>
                                                            <td><input type="number" class="form-control bobot_jarak" name="bobot_jarak[0]" id="bobot_jarak0"  step="0.01" min="0"></td>
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
                            <div id="soalform" class="@if(count($p->KriteriaStatus('soal')) <= 0) hide @endif soalform">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="" class="col-lg-5 col-form-label">Bobot Penilaian Soal</label>
                                            <div class="col-lg-5">
                                                <input type="number" class="form-control col-form-label master_soal" name="master_soal"  step="0.01" min="0" @if(count($p->KriteriaStatus('soal')) > 0) value="{{$p->KriteriaStatus('soal')->first()->Kriteria->bobot}}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="table-responsive">
                                                <table class="table table-hover soaltable" id="soaltable">
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
                                                                <select class="form-control soal_id" id="soal_id{{$loop->iteration - 1}}" name="soal_id[{{$loop->iteration - 1}}]">
                                                                    @if(count($p->DaftarSoal()) > 0)
                                                                    @foreach ($p->DaftarSoal() as $ps)
                                                                        <option value="{{$ps->id}}" @if($ks->soal_id == $ps->id) selected @endif>{{$ps->nama}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td><input type="number" class="form-control bobot_soal" name="bobot_soal[{{$loop->iteration - 1}}]" id="bobot_soal{{$loop->iteration - 1}}"  step="0.01" min="0" value="{{$ks->nilai}}"></td>
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
                                                            <td><select class="form-control soal_id" id="soal_id0" name="soal_id[0]">
                                                                @if(count($p->DaftarSoal()) > 0)
                                                                @foreach ($p->DaftarSoal() as $ps)
                                                                    <option value="{{$ps->id}}">{{$ps->nama}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select></td>
                                                            <td><input type="number" class="form-control bobot_soal" name="bobot_soal[0]" id="bobot_soal0"  step="0.01" min="0"></td>
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
                    </div>
                    <div class="card-footer">
                        <span class="float-left"><a href="{{route('jadwal.show')}}" type="button" class="btn btn-danger">
                            Batal
                        </a></span>
                        <span class="float-right"><button type="submit" id="btnsubmit" class="btn btn-warning">Simpan</button></span>
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

        function soal_select(jab_id, div_id){
            if(jab_id && div_id){
                $('.soal_id').select2({
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

        function numberRowsUsia() {
            var c = 0 - 1;
            $('#usiatable').find("tr").each(function(ind, el) {
                var j = c;
                $(el).find('.usia_min').attr('name', 'usia_min['+ j +']');
                $(el).find('.usia_min').attr('id', 'usia_min'+ j);
                $(el).find('.usia_max').attr('name', 'usia_max['+ j +']');
                $(el).find('.usia_max').attr('id', 'usia_max'+ j);
                $(el).find('.bobot_usia').attr('name', 'bobot_usia['+ j +']');
                $(el).find('.bobot_usia').attr('id', 'bobot_usia'+ j);
                c++;
            });
        }

        $(document).on('click', '.usiatable #addusiarow', function(){
            var ids = $(this).closest('.usiatable').attr('id');
            $('#'+ids+' tr:last').after(addusiarow());
            numberRowsUsia();
        });

        $(document).on('click', '.usiatable #removeusiarow', function(e) {
            var ids = $(this).closest('.usiatable').attr('id');
            $(this).closest('tr').remove();
            numberRowsUsia();
        });

        function numberRowsPendidikan() {
            var c = 0 - 1;
            $('#pendidikantable').find("tr").each(function(ind, el1) {
                var j = c;
                $(el1).find('.ketentuan_pendidikan').attr('name', 'ketentuan_pendidikan['+ j +']');
                $(el1).find('.ketentuan_pendidikan').attr('id', 'ketentuan_pendidikan'+ j);
                $(el1).find('.peringkat').attr('name', 'peringkat['+ j +']');
                $(el1).find('.peringkat').attr('id', 'peringkat'+ j);
                $(el1).find('.bobot_pendidikan').attr('name', 'bobot_pendidikan['+ j +']');
                $(el1).find('.bobot_pendidikan').attr('id', 'bobot_pendidikan'+ j);
                select_pend();
                c++;
            });
        }

        $(document).on('click', '.pendidikantable #addpendidikanrow', function(){
            var ids = $(this).closest('.pendidikantable').attr('id');
            $('#'+ids+' tr:last').after(addpendidikanrow());
            numberRowsPendidikan();
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
            $(this).closest('tr').remove();
            numberRowsPendidikan();
        });

        function numberRowsJarak() {
            var c = 0 - 1;
            $('#jaraktable').find("tr").each(function(ind, el1) {
                var j = c;
                $(el1).find('.jarak_min').attr('name', 'jarak_min['+ j +']');
                $(el1).find('.jarak_min').attr('id', 'jarak_min'+ j);
                $(el1).find('.jarak_max').attr('name', 'jarak_max['+ j +']');
                $(el1).find('.jarak_max').attr('id', 'jarak_max'+ j);
                $(el1).find('.bobot_jarak').attr('name', 'bobot_jarak['+ j +']');
                $(el1).find('.bobot_jarak').attr('id', 'bobot_jarak'+ j);
                c++;
            });
        }

        $(document).on('click', '.jaraktable #addjarakrow', function(){
            var ids = $(this).closest('.jaraktable').attr('id');
            $('#'+ids+' tr:last').after(addjarakrow());
            numberRowsJarak();
        });

        $(document).on('click', '.jaraktable #removejarakrow', function(e) {
            var ids = $(this).closest('.jaraktable').attr('id');
            $(this).closest('tr').remove();
            numberRowsJarak();
        });

        function numberRowsSoal() {
            var jab_id = $('.jabatan').val();
            var div_id = $('.divisi').val();
            var c = 0 - 1;
            $('#soaltable').find("tr").each(function(ind, el1) {
                var j = c;
                $(el1).find('.soal_id').attr('name', 'soal_id['+ j +']');
                $(el1).find('.soal_id').attr('id', 'soal_id'+ j);
                $(el1).find('.bobot_soal').attr('name', 'bobot_soal['+ j +']');
                $(el1).find('.bobot_soal').attr('id', 'bobot_soal'+ j);
                soal_select(jab_id, div_id);
                c++;
            });
        }

        $(document).on('click', '.soaltable #addsoalrow', function(){
            var ids = $(this).closest('.soaltable').attr('id');
            $('#'+ids+' tr:last').after(addsoalrow());
            numberRowsSoal();
        });

        $(document).on('click', '.soaltable #removesoalrow', function(e) {
            var ids = $(this).closest('.soaltable').attr('id');
            $(this).closest('tr').remove();
            numberRowsSoal();
        });

        $(document).on('change', '.kriteria', function(e){
            var kriteria = [];
            var valchecked = $(this).val();
            var numberOfChecked =  $('.kriteria:checked').length;
            $('.kriteria:checked').each(function(){
                    kriteria.push($(this).val());
            });


            if(numberOfChecked == 0){
                $('.kriteria[value='+valchecked+']').prop('checked', true);
                $('.kriteria:checked').each(function(){
                    kriteria.push(valchecked);
                });
            }

            if(kriteria.indexOf("usia") != -1){
                $('.usiaform').removeClass('hide');
            }
            else if(kriteria.indexOf("usia") == -1){
                $('.usiaform').addClass('hide');
            }

            if(kriteria.indexOf("pendidikan") != -1){
                $('.pendidikanform').removeClass('hide');
            }
            else if(kriteria.indexOf("pendidikan") == -1){
                $('.pendidikanform').addClass('hide');
            }

            if(kriteria.indexOf("jarak") != -1){
                $('.jarakform').removeClass('hide');
            }
            else if(kriteria.indexOf("jarak") == -1){
                $('.jarakform').addClass('hide');
            }

            if(kriteria.indexOf("soal") != -1){
                $('.soalform').removeClass('hide');
            }
            else if(kriteria.indexOf("soal") == -1){
                $('.soalform').addClass('hide');
            }
        });

        $(document).on('change', '.jabatan', function(e){
            var val = $('.jabatan').val();
            var val_divisi = $('.divisi').val();
            if(val){
                if(val_divisi){
                    soal_select(val, val_divisi);
                }
            }
        });

        $(document).on('change', '.divisi', function(e){
            var val = $('.divisi').val();
            var val_jabatan = $('.jabatan').val();
            if(val){
                if(val_jabatan){
                    soal_select(val_jabatan, val);
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
    })
</script>
@endsection
