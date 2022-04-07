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
              <h1 class="m-0">Divisi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{route('divisi.show')}}">Divisi</a></li>
                <li class="breadcrumb-item active">Tambah</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-7">
                <form method="POST" action="{{route('divisi.store')}}">
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
                    <div class="card-header bg-success">
                        <h6 class="card-title">Tambah Divisi</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nama" class="col-lg-4 col-md-12 col-form-label labelket">Nama</label>
                            <div class="col-lg-8 col-md-12">
                                <input class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Divisi">
                                <small id="msg_nama" class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="float-left"><a href="{{route('divisi.show')}}" type="button" class="btn btn-danger">
                            Batal
                        </a></span>
                        <span class="float-right"><button type="submit" id="btnsubmit" class="btn btn-success" >Tambah</button></span>
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
        $('#nama').on('keyup change', function() {
            if ($(this).val() != "") {
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/api/divisi/check/' + $(this).val(),
                    success: function(data) {
                        console.log(data);
                        if (data.jumlah >= 1) {
                        $("#msg_nama").html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama divisi sudah terpakai");
                        $('#btnsubmit').attr("disabled", true);
                        $('#nama').addClass("is-invalid");
                         } else {
                            $('#msg_nama').text("");
                            $('#nama').removeClass("is-invalid");
                            $('#btnsubmit').attr("disabled", false);
                        }
                    }
                });
            } else if ($(this).val() == "") {
                $("#msg_nama").html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama divisi harus di isi");
                $('#nama').addClass("is-invalid");
                $("#btnsubmit").attr('disabled', true);
            }
        });
    })
</script>
@endsection
