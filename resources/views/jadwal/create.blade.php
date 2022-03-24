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

.imgoprec{
    object-fit: contain;
    width: 100%;
}
.aligncenter{
    text-align: center;
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
                <form method="POST" action="{{route('jadwal.store')}}">
                @csrf
                @if(Session::has('error') || count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{Session::get('error')}}</strong> Periksa
                    kembali data yang diinput
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{Session::get('success')}}</strong>,
                    Terima kasih
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header bg-success">
                        <h6 class="card-title">Tambah Jadwal</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="tanggal_mulai" class="col-lg-4 col-md-12 col-form-label labelket">Tanggal Mulai</label>
                            <div class="col-lg-8 col-md-12">
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_akhir" class="col-lg-4 col-md-12 col-form-label labelket">Tanggal Akhir</label>
                            <div class="col-lg-8 col-md-12">
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-lg-4 col-md-12 col-form-label labelket">Keterangan</label>
                            <div class="col-lg-8 col-md-12">
                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <table class="table table-hover aligncenter" id="showtable">
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
                                        <tr class="kolom0">
                                            <td>1</td>
                                            <td><select class="form-control jabatan" name="jabatan[]" id="jabatan" style="width: 100%">

                                            </select></td>
                                            <td><select class="form-control divisi" name="divisi[]" id="divisi" style="width: 100%">

                                            </select></td>
                                            <td><input type="number" class="form-control kuota" name="kuota[]" id="kuota"></td>
                                            <td><a id="removerow"><i class="fas fa-minus" style="color:red;"></i></a></td>
                                        </tr>
                                        <tr class="kolom0">
                                            <td colspan="5">
                                                <div class="form-group row">
                                                    <label for="tanggal_mulai" class="col-lg-4 col-md-12 col-form-label labelket">Tanggal Mulai</label>
                                                    <div class="col-lg-8 col-md-12 d-flex justify-content-around">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="usia">
                                                            <label class="form-check-label" for="inlineCheckbox1">Usia</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="pendidikan">
                                                            <label class="form-check-label" for="inlineCheckbox2">Pendidikan</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="jarak">
                                                            <label class="form-check-label" for="inlineCheckbox3">Jarak Rumah</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="soal">
                                                            <label class="form-check-label" for="inlineCheckbox3">Soal</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="usia">
                                                    <h6>Usia</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover" id="usiatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ketentuan</th>
                                                                    <th>Usia</th>
                                                                    <th>Bobot</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><select class="form-control ketentuan_usia" name="ketentuan_usia[][]" id="ketentuan_usia" style="width: 100%">
                                                                            <option value="">Minimum</option>
                                                                            <option value="">Maksimum</option>
                                                                            <option value="">Lainnya</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="number" class="form-control" name="usia[][]" id="usia"></td>
                                                                    <td><input type="number" class="form-control" name="bobot_usia[][]" id="bobot_usia"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="pendidikan">
                                                    <h6>Pendidikan</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover" id="pendidikantable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Pendidikan Terakhir</th>
                                                                    <th>Bobot</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="jarak">
                                                    <h6>Jarak</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover" id="jaraktable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ketentuan</th>
                                                                    <th>Jarak</th>
                                                                    <th>Bobot</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="soal">
                                                    <h6>Soal</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover" id="soaltable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Soal</th>
                                                                    <th>Bobot</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="float-left"><a href="{{route('jadwal.show')}}" type="button" class="btn btn-danger">
                            Batal
                        </a></span>
                        <span class="float-right"><button type="submit" class="btn btn-success">Tambah</button></span>
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
        select();
        // $('.jabatan').select2();
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        console.log(today);
        $("#tanggal_mulai").attr("min", today);
        $("#tanggal_akhir").attr("min", today);


        $('#tanggal_mulai').on('keyup change', function() {
            $("#tanggal_akhir").val("");
            $("#btncetak").removeAttr('disabled');
            if ($(this).val() != "") {
                $('#tanggal_akhir').removeAttr('readonly');
                $("#tanggal_akhir").attr("min", $(this).val());
            } else {
                $("#tanggal_akhir").val("");
                $("#btncetak").attr('disabled', true);
            }
        });

        function numberRows($t) {
            var c = 0 - 2;
            $t.find("tr").each(function(ind, el) {
                $(el).find("td:eq(0)").html(++c);
                var j = c - 1;
                $(el).find('.jabatan').attr('name', 'jabatan[' + j + ']');
                $(el).find('.jabatan').attr('id', 'jabatan' + j);
                $(el).find('.divisi').attr('name', 'divisi[' + j + ']');
                $(el).find('.divisi').attr('id', 'divisi' + j);
                $(el).find('.kuota').attr('name', 'kuota[' + j + ']');
                $(el).find('.kuota').attr('id', 'kuota' + j);
                select();
            });
        }

        $('#showtable').on('click', '#tambahrow', function(){
            $('#showtable tr:last').after(`<tr>
                                            <td></td>
                                            <td><select class="form-control jabatan" name="jabatan[]" id="jabatan" style="width: 100%">
                                                </select></td>
                                            <td><select class="form-control divisi" name="divisi[]" id="divisi" style="width: 100%">
                                                </select></td>
                                            <td><input type="number" class="form-control kuota" name="kuota[]" id="kuota"></td>
                                            <td><a id="removerow"><i class="fas fa-minus" style="color:red;"></i></a></td>
                                        </tr>`);
            numberRows($("#showtable"));
        });

        $('#showtable').on('click', '#removerow', function(e) {
            $(this).closest('tr').remove();
            numberRows($("#showtable"));
        });

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
        }
    })
</script>
@endsection
