@extends('layouts.app')

@section('custom_css')
<style>
  body{
    background: rgb(70,130,180);
    background: radial-gradient(circle, rgba(70,130,180,1) 0%, rgba(129,161,187,1) 35%, rgba(243,243,243,1) 100%);
  }

  .aligncenter{
    text-align: center;
  }
</style>
@endsection

@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="/"> Reset Password</a>
  </div>
  @if(Session::has('error')  )
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ Session::get('error') }}
    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
  <div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Silahkan masukkan dan verifikasi email anda</p>
      <form method="POST" action="{{ route('forget.password.post') }}">
        @csrf
        <div class="input-group mb-3">
            {{-- <input type="text"class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} has-feedback" placeholder="Username atau Email" name="email" id="email" value="{{ old('email') }}" required autocomplete="off">
          --}}
         <input class="form-control" type="email" name="email" id="email" value=""  placeholder="Email"/>
          <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
        </div>
        @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
        <div class="row d-flex justify-content-center align-items-center">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Verifikasi Email</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-0 aligncenter">
        Belum Punya Akun?
        <a href="{{ route('register') }}" class="text-center">Daftar</a>
      </p>
      <p class="mb-0 aligncenter">
        <a href="{{ route('login') }}" class="text-center">Sudah punya akun</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
