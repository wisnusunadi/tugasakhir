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
.benar{
    background-color: rgb(168, 255, 118);
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

<section class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Draft Soal</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{route('draft_soal')}}">Draft Soal</a></li>
                <li class="breadcrumb-item active">Edit</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{route('draft_soal.update',['id' => $soal->id])}}">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
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
                @elseif(Session::has('used'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{Session::get('used')}}</strong>,
                    Soal sudah terpakai
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @endif
                <div class="card">
                    <div class="card-header bg-success">
                        <h6 class="card-title">Edit Soal</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nama" class="col-lg-4 col-md-12 col-form-label labelket">Nama</label>
                            <div class="col-lg-8 col-md-12">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Tes Potensi Akademik , Tes Logika" value="{{$soal->nama}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode_soal" class="col-lg-4 col-md-12 col-form-label labelket">Kode Soal</label>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" class="form-control" id="kode_soal" name="kode_soal" placeholder="Mohon Isi Kode Soal" value="{{$soal->kode_soal}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode_soal" class="col-lg-4 col-md-12 col-form-label labelket">Waktu Pengerjaan</label>
                            <div class="col-lg-3 col-md-4">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="Isi Waktu Pengerjaan" min="1" name="waktu" id="waktu" aria-label="waktu pengerjaan" aria-describedby="waktus" value="{{$soal->waktu}}">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="waktus">menit</span>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_akhir" class="col-lg-4 col-md-12 col-form-label labelket">Jabatan</label>
                            <div class="col-lg-8 col-md-12">
                                    <select class="jabatan" data-placeholder="Pilih Jabatan" style="width: 100%;" name="jabatan[]" id="jabatan">

                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_akhir" class="col-lg-4 col-md-12 col-form-label labelket">Divisi</label>
                            <div class="col-lg-8 col-md-12">
                                    <select class="divisi" data-placeholder="Pilih Divisi" style="width: 100%;" name="divisi[]" id="divisi">
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <table class="table aligncenter" id="showtable">
                                    <thead>
                                        <tr>
                                            <th colspan="6">
                                                <span class="float-right"><button type="button" class="btn btn-sm btn-primary" id="tambahrow"><i class="fas fa-plus"></i> Tambah Soal</button></span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Soal</th>
                                            <th colspan="2">Jawaban (Centang untuk kunci jawaban)</th>
                                            <th  width="10%">Poin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($soal->soaldetail as $index => $soal_detail )
                                        <tr class="kolom" id="kolom{{$index}}">
                                            <td rowspan="{{$soal_detail->jawaban->count()}}" class="nomor">{{$index+1}}</td>
                                            <td rowspan="{{$soal_detail->jawaban->count()}}" class="soal"><textarea class="form-control soal" name="soal[{{$index}}]" id="soal{{$index}}">{{$soal_detail->deskripsi}}</textarea></td>
                                            <td>
                                                <div class="form-group">
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text"><input type="radio" id="0" class="kunci_jawaban" data-name="radiokunci{{$index}}" name="kunci_jawaban[{{$index}}][0]" value="1" {{ ($soal_detail->jawaban[0]->status=="1")? "checked" : "" }} ></span>
                                                </div>
                                                <textarea name="jawaban[{{$index}}][0]" id="jawaban{{$index}}" class="form-control jawaban">{{$soal_detail->jawaban[0]->jawaban}}</textarea>
                                              </div>
                                            </div>
                                            </td>
                                            <td>
                                                <a type ="button" id="tambahopsi"><i class="fas fa-plus" style="color:green;"></i></a>
                                            </td>
                                            <td  rowspan="{{$soal_detail->jawaban->count()}}" class="poin"><input  type ="number" class="form-control poin" name="poin[{{$index}}]" id="poin{{$index}}" value="{{$soal_detail->bobot}}"></td>
                                            <td  rowspan="{{$soal_detail->jawaban->count()}}" class="hapus_baris"><a id="removerow"><i class="fas fa-minus" style="color:red;"></i></a></td>
                                        </tr>
                                        @for($i=1;$i<$soal_detail->jawaban->count();$i++)
                                        <tr id="kolom{{$index}}">
                                            <td>
                                                <div class="form-group">
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text"><input type="radio" id="{{$i}}" class="kunci_jawaban" data-name="radiokunci{{$index}}" name="kunci_jawaban[{{$index}}][{{$i}}]" value="1" {{ ($soal_detail->jawaban[$i]->status=="1")? "checked" : "" }}></span>
                                                </div>
                                                <textarea name="jawaban[{{$index}}][{{$i}}]" id="jawaban{{$index}}" class="form-control jawaban">{{$soal_detail->jawaban[$i]->jawaban}}</textarea>
                                              </div>
                                            </div>
                                            </td>
                                            <td>
                                            @if($i == 0)
                                                <a type ="button" id="tambahopsi"><i class="fas fa-plus" style="color:green;"></i></a>
                                            @else
                                                <a id="hapusopsi"><i class="fas fa-minus" style="color:red;"></i></a>
                                            @endif
                                            </td>
                                        </tr>
                                        @endfor
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="float-left"><a href="{{route('draft_soal')}}" type="button" class="btn btn-danger">
                            Batal
                        </a></span>
                        <span class="float-right"><button type="submit" class="btn btn-success" id="ubah">Ubah</button></span>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <?php
// $jabatan_array = array();
 $genre = array();
// foreach ($soal->Jabatan as $i=>$s) {
//    array_push($jabatan_array , $s->id);
// }
// print_r($jabatan_array);

?>

    </div>
</section>


@endsection

@section('script')
<script>
    var rowCount = {{$soal->SoalDetail->count()}};
    console.log(rowCount);
    $(function(){

        function validasi(){
            var counttr = $('#showtable > tbody > tr').find('#removerow').length;
            // var fieldsoal = $('.soal').parent().children('.soal');
            var countsoal = 0;
            var countpoin = 0;
            var countjawaban = 0;
            var countfieldjawaban = $('#showtable > tbody > tr').find('.jawaban').length;
            var countkuncijawaban = $('.kunci_jawaban:checked').length;

            $('.soal').each(function() {
                if ($(this).val() != "") {
                    countsoal++;
                }
            });

            $('.poin').each(function() {
                if ($(this).val() != "") {
                    countpoin++;
                }
            });

            $('.jawaban').each(function() {
                if ($(this).val() != "") {
                    countjawaban++;
                }
            });


            if ($('#nama').val() != "" && $('#kode_soal').val() != "" && $('#waktu').val() != "" &&  $('#jabatan').val() != ""  &&  $('#divisi').val() != "" && countsoal >= counttr && countkuncijawaban >= counttr && countpoin >= counttr && countjawaban >= countfieldjawaban) {
                $('#ubah').attr("disabled", false);
            } else {
                $('#ubah').attr("disabled", true);
            }
        }
    $('.divisi').select2({
                    theme: 'bootstrap4',
                    multiple: true,

                 ajax: {
                    minimumResultsForSearch: 20,
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    url: '/select/divisi',
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function(data) {
                       // console.log(data);
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

    $('.jabatan').select2({
                    theme: 'bootstrap4',
                    multiple: true,
                 ajax: {
                    minimumResultsForSearch: 20,
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    url: '/select/jabatan',
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function(data) {
                     //   console.log(data);
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

        set_jabatan({{$soal->id}});
        set_divisi({{$soal->id}});



        function set_jabatan(soal_id){
            $.ajax({
                type: "GET",
                dataType : 'json',
                url: '/select/jabatan/get/'+soal_id,
                success: function(data) {
                    $.each(data,function(i,j){
                    var option = new Option(''+data[i].nama+'',''+data[i].id+'',true, true);
                    $('.jabatan').append(option);

                    });
                    $('.jabatan').trigger('change');

                },
            });
        }

        function set_divisi(soal_id){
            $.ajax({
                type: "GET",
                dataType : 'json',
                url: '/select/divisi/get/'+soal_id,
                success: function(data) {
                  //  console.log(data);

                    $.each(data,function(i,j){
                    var option = new Option(''+data[i].nama+'',''+data[i].id+'',true, true);
                    $('.divisi').append(option);
               //     console.log(option);
                    });
                    $('.divisi').trigger('change');

                },
            });
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
       // console.log(today);
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
            validasi();
        });

        function numberJawaban(id){
            // var id = $('tr[id="kolom' + id + '"]').closest('tr').attr('id');
            var count_jawaban = 0;
            $('tr[id="kolom' + id + '"]').find('.jawaban').each(function(ind1, el1){
                $(el1).attr('name', 'jawaban[' + id + ']['+ count_jawaban +']');
                count_jawaban++;
            });
            var count_kunci = 0;
            $('tr[id="kolom' + id + '"]').find('.kunci_jawaban').each(function(ind1, el1){
                $(el1).attr('data-name', 'radiokunci' + id);
                $(el1).attr('name', 'kunci_jawaban[' + id + ']['+ count_kunci +']');
                count_kunci++;
            });
          //  console.log(id);
        }

        function numberRows($t) {
            var c = 0;
            $t.find("tr.kolom").each(function(ind, el) {
                $(el).find("td:eq(0)").html(++c);
                var j = c - 1;
                var id = $(el).attr('id');
                $('tr[id="' + id + '"]').find('.soal').attr('name', 'soal[' + j + ']');
                console.log(id);
                // $('tr[id="' + id + '"]').find('.kunci_jawaban').attr('name', 'kunci_jawaban[' + j + '][]');
                // $('tr[id="' + id + '"]').find('.jawaban').attr('name', 'jawaban[' + j + '][]');
                var count_jawaban = 0;
                $('tr[id="' + id + '"]').find('.jawaban').each(function(ind1, el1){
                    $(el1).attr('name', 'jawaban[' + j + ']['+ count_jawaban +']');
                    count_jawaban++;
                });
                var count_kunci = 0;
                $('tr[id="' + id + '"]').find('.kunci_jawaban').each(function(ind1, el1){
                    $(el1).attr('data-name', 'radiokunci' + j);
                    $(el1).attr('name', 'kunci_jawaban[' + j + ']['+count_kunci+']');
                    count_kunci++;
                });
                $('tr[id="' + id + '"]').find('.jawaban').attr('id', 'jawaban'+j);
                $('tr[id="' + id + '"]').attr('id', 'kolom' + j);
                $(el).attr('id', 'kolom' + j);
                $(el).find('.soal').attr('name', 'soal[' + j + ']');
                $(el).find('.soal').attr('id', 'soal' + j);
                // $(el).find('.jawaban').attr('name', 'jawaban[' + j + '][]');

                $(el).find('.jawaban').attr('id', 'jawaban' + j);

                // $(el).find('.kunci_jawaban').attr('name', 'kunci_jawaban[' + j + '][]' );
                $(el).find('.poin').attr('name', 'poin[' + j + ']');
                $(el).find('.poin').attr('id', 'poin' + j);


                // select();
            });
        }

        $('#showtable').on('click', '#tambahrow', function(){

            $('#showtable tr:last').after(`<tr class="kolom" id="kolom`+rowCount+`">
                <td rowspan="1" class="nomor"></td>
                                            <td rowspan="1" class="soal"><textarea class="form-control soal" name="soal[`+rowCount+`]" id="soal`+rowCount+`"></textarea></td>
                                            <td>
                                                <div class="form-group">
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text"><input type="radio" class="kunci_jawaban" data-name="radiokunci` + rowCount +`" id="`+rowCount+`" name="kunci_jawaban[`+rowCount+`][0]" value="1"></span>
                                                </div>
                                                <textarea name="jawaban[`+rowCount+`][0]" id="jawaban" class="form-control jawaban"></textarea>
                                              </div>
                                            </div>
                                            </td>
                                            <td>
                                                <a type ="button" id="tambahopsi"><i class="fas fa-plus" style="color:green;"></i></a>
                                            </td>
                                            <td  rowspan="1" class="poin"><input  type ="number" class="form-control poin" name="poin[`+rowCount+`]" id="poin"></td>
                                            <td  rowspan="1" class="hapus_baris"><a id="removerow"><i class="fas fa-minus" style="color:red;"></i></a></td>
                                           </tr>`);
            rowCount++;
            validasi();
            numberRows($("#showtable"));
            // console.log(rowCount);
        });

        $('#showtable').on('click', '#removerow', function(e) {
            var id = $(this).closest('tr').attr('id');
            $('tr[id="'+id+'"]').remove();
            rowCount--;
            validasi();
            numberRows($("#showtable"));
        });

        $('#showtable').on('click', '.kolom #tambahopsi', function() {
            var id = $(this).closest('tr').attr('id');
            var x = $('tr[id="' + id + '"]').find('.nomor').attr('rowspan');
             arry = [];

            $('.kunci_jawaban').each(function() {
                arry.push($(this).closest('tr[id="' + id + '"]').find('.kunci_jawaban').attr('id'));
            });

            console.log(id);
            console.log((parseInt(x) + 1));
            columnCount = (arry.length - 1) + 1;

            $('tr[id="' + id + '"]').find('.nomor').attr('rowspan', (parseInt(x) + 1));
            $('tr[id="' + id + '"]').find('.soal').attr('rowspan', (parseInt(x) + 1));
            $('tr[id="' + id + '"]').find('.poin').attr('rowspan', (parseInt(x) + 1));
            $('tr[id="' + id + '"]').find('.hapus_baris').attr('rowspan', (parseInt(x) + 1));


            $(this).closest('tr.kolom').after(`<tr id="` + id + `">
            <td>
                <div class="form-group">
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text"><input type="radio" class="kunci_jawaban" data-name="radiokunci` + id.substring(5)+`" id="`+columnCount+`" name="kunci_jawaban[` + id.substring(5) + `][`+columnCount+`]" value="1"></span>
                                                </div>
                                                <textarea name="jawaban[` + id.substring(5) + `][`+columnCount+`]" id="jawaban` + id.substring(5) + `" class="form-control jawaban"></textarea>
                                              </div>
                                            </div>
            </td>
            <td>
                <a type="button" id="hapusopsi"><i class="fas fa-times" style="color:red;"></i></button>
            </td>
            </tr>`);
            validasi();
            numberJawaban(id.substring(5));
        });

        $('#showtable').on('click', '#hapusopsi', function() {
            var id = $(this).closest('tr').attr('id');
            var x = $('tr[id="' + id + '"]').find('.nomor').attr('rowspan');
            $('tr[id="' + id + '"]').find('.nomor').attr('rowspan', (parseInt(x) - 1));
            $('tr[id="' + id + '"]').find('.soal').attr('rowspan', (parseInt(x) - 1));
            $('tr[id="' + id + '"]').find('.poin').attr('rowspan', (parseInt(x) - 1));
            $('tr[id="' + id + '"]').find('.hapus_baris').attr('rowspan', (parseInt(x) - 1));
          //  $(this).closest('tr[id="' + id + '"]').find('.nomor').attr('rowspan', (parseInt(x) - 1));
            // $(this).closest('tr[id="' + id + '"]').find('.soal').attr('rowspan', (parseInt(x) - 1));
            // $(this).closest('tr[id="' + id + '"]').find('.poin').attr('rowspan', (parseInt(x) - 1));
            // $(this).closest('tr[id="' + id + '"]').find('.hapus_baris').attr('rowspan', (parseInt(x) - 1));
            $(this).closest('tr').remove();
            // console.log(x);
            // console.log(parseInt(x)-1)
            validasi();
            numberJawaban(id.substring(5));
        });

        $("#showtable").on('change', '.kunci_jawaban', function(){
            var dataattr = $(this).closest('tr').find('.kunci_jawaban').attr('data-name');
            $('input[type="radio"][data-name="'+dataattr+'"]').prop('checked', false);
            $(this).prop('checked', true);
            validasi();
        });

        $('#nama').on('keyup change', function() {
            validasi();
        });
        $('#kode_soal').on('keyup change', function() {
            validasi();
        });
        $('#waktu').on('keyup change', function() {
            validasi();
        });
        $('#jabatan').on('keyup change', function() {
            validasi();
        });
        $('#divisi').on('keyup change', function() {
            validasi();
        });

        $(document).on('keyup change', '.soal', function(){
            validasi();
        });

        $(document).on('change', '.kunci_jawaban', function(){
            validasi();
        });

        $(document).on('keyup change', '.jawaban', function(){
            validasi();
        });

        $(document).on('keyup change', '.poin', function(){
            validasi();
        });
    })
</script>
@endsection
