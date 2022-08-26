@extends('layouts.adminlte.main')

@section('title', 'Sistem Penerimaan Karyawan')

@section('custom_css')
<style>
section{
    height: 100vh;
    display: flex;
    justify-content:center;
    align-items:center;
    margin-left: 250px;
    background: rgb(70,130,180);
    background: radial-gradient(circle, rgba(70,130,180,1) 0%, rgba(129,161,187,1) 35%, rgba(243,243,243,1) 100%);
}

.row{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.card{
    width: 400px;
    box-shadow: none;
    margin:auto;
}
.imgoprec{
    object-fit: contain;
    width: 100%;
}
.aligncenter{
    text-align: center;
}
</style>
@stop

@section('content')
<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card aligncenter d-flex flex-wrap align-items-center justify-content-center">
                    <div class="card-img-top">
                        <img class="imgoprec" src="{{url('assets/image/oprec.jpg')}}" alt="">
                    </div>
                    <div class="card-body">
                        <div class=""><h4>Selamat Datang</h4></div>
                        <div><h6>Sistem Penerimaan Karyawan</h6></div>
                        <a href="/login" type="button" class="btn btn-outline-info">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
