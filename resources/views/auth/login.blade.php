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
    <a href="/"> Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silahkan isi untuk Masuk</p>
 
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
          <input type="email" aria-label="Masukkan Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} has-feedback" placeholder="Masukkan Email" name="email" id="email" value="{{ old('email') }}" required>
          <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
        </div>
        @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif

        <div class="input-group mb-3">
          <input type="password" aria-label="Masukkan Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} has-feedback" placeholder="Masukkan Password" name="password" id="password" required>
          <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
        </div>
        @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif

        <div class="row d-flex justify-content-center align-items-center">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-0 aligncenter">
        Belum Punya Akun? 
        <a href="{{ route('register') }}" class="text-center">Daftar</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->