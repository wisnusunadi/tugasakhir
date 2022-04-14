@extends('layouts.app')

@section('custom_css')
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<style>
  body{
    background: rgb(70,130,180);
    background: radial-gradient(circle, rgba(70,130,180,1) 0%, rgba(129,161,187,1) 35%, rgba(243,243,243,1) 100%);
  }

  .aligncenter{
    text-align: center;
  }

  @font-face
  {
    font-family: 'Poppins';
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
        <p class="login-box-msg">Silahkan mengupdate password anda</p>
      <form method="POST" action="{{ route('reset.password.post') }}">
        @csrf
        <small class="text-danger" id="email_error"></small>
        <div class="input-group mb-3">
            {{-- <input type="text"class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} has-feedback" placeholder="Username atau Email" name="email" id="email" value="{{ old('email') }}" required autocomplete="off">
          --}}
         <input class="form-control" type="username" name="email" id="email" value=""  placeholder="Email"/>

         <input type="form-control d-none" name="token" value="{{ $token }}" hidden>
         <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>

        </div>

        @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif

        <div class="input-group mb-3">
         <input class="form-control" type="password" name="password" id="pass" placeholder="Password baru"/>
         <span class="input-group-text"><i toggle="#password-toggle" class="fa fa-fw fa-eye  toggle-password"></i></span></span>
        </div>
        @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif

        <div class="input-group mb-3">
         <input class="form-control" type="password" name="password_confirmation" id="pass" placeholder="Konfirmasi password baru"/>
         <span class="input-group-text"><i toggle="#password-toggle" class="fa fa-fw fa-eye  toggle-password"></i></span></span>
        </div>
        @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
        <div class="row d-flex justify-content-center align-items-center">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" disabled id="submit">Ganti Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
@section('script')
<script>
    $(function(){
            $('#email').on('keyup change', function() {
            if ($(this).val() != "") {
                $('#email').removeClass('is-invalid');
                $('#email_error').html('');
                $('#submit').attr("disabled", false);
            } else {
                $('#submit').attr("disabled", true);
                $('#nama').addClass('is-invalid');
                $('#email_error').html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email Harus diisi");
            }
        });
    });

    </script>
@endsection
