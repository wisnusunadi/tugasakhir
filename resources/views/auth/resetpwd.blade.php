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
        <div class="form-group row mb-3">
            <div class="input-group">
                    {{-- <input type="text"class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} has-feedback" placeholder="Username atau Email" name="email" id="email" value="{{ old('email') }}" required autocomplete="off">
                --}}
                <input class="form-control" type="username" name="email" id="email" value=""  placeholder="Email"/>
                <input type="form-control d-none" name="token" value="{{ $token }}" hidden>
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
            </div>
            <small class="text-danger" id="email_error"></small>
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>


        <div class="form-group row mb-3">
            <div class="input-group">
                <input class="form-control" type="password" name="password" id="pass" placeholder="Password baru"/>
                <span class="input-group-text"><i toggle="#pass-toggle" class="fa fa-fw fa-eye  toggle-pass"></i></span></span>
            </div>
            <small class="text-danger" id="pass_error"></small>
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group row mb-3">
          <div class="input-group">
            <input class="form-control" type="password" name="password_confirmation" id="konfpass" placeholder="Konfirmasi password baru"/>
            <span class="input-group-text"><i toggle="#konf-pass-toggle" class="fa fa-fw fa-eye toggle-konfpass"></i></span></span>
          </div>
          <small class="text-danger" id="konf_pass_error"></small>
          @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
          @endif
        </div>

        <div class="row d-flex justify-content-center align-items-center">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="submit" disabled>Ganti Password</button>
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
      function validasi(){
        if(($('#email').val() != "" && !$('#email').hasClass('is-invalid')) && ($('#pass').val() != "" && !$('#pass').hasClass('is-invalid')) && ($('#konfpass').val() != "" && !$('#konfpass').hasClass('is-invalid'))){
          $('#submit').attr("disabled", false);
        }else{
          $('#submit').attr("disabled", true);
        }
      }

      $(document).on('click', '.toggle-pass',function(){
            // $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#pass");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(document).on('click', '.toggle-konfpass',function(){
            // $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#konfpass");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $('#email').on('keyup change', function() {
            var emailreg = new RegExp("([!#-'*+/-9=?A-Z^-~-]+(\.[!#-'*+/-9=?A-Z^-~-]+)*|\"\(\[\]!#-[^-~ \t]|(\\[\t -~]))+\")@([!#-'*+/-9=?A-Z^-~-]+(\.[!#-'*+/-9=?A-Z^-~-]+)*|\[[\t -Z^-~]*])");
            if ($(this).val() != "") {
                if(emailreg.test($(this).val())){
                    $('#email_error').html("");
                    $('#email').removeClass("is-invalid");
                }
                else{
                    $("#email_error").html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Harus mengandung format email (contoh: test@example.com)");
                    $('#email').addClass("is-invalid");
                }
            } else if ($(this).val() == "") {
                $("#email_error").html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email harus di isi");
                $('#email').addClass("is-invalid");
                // $("#tambah").attr('disabled', true);
            }
            validasi();
        });

      $('#pass').on('keyup change', function() {
            var passwordreg = new RegExp("^(?=.*[a-z])(?=.*[0-9])(?=.{8,})");
            var value = $(this).val();
            console.log(passwordreg.test(value));
            if ($(this).val() != ""){
                if(passwordreg.test(value)){
                    $('#pass').removeClass('is-invalid');
                    $('#pass_error').html('');
                }else{
                    $('#pass').addClass('is-invalid');
                    $('#pass_error').html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Password harus mengandung Min 8 Karakter, Huruf & Angka");
                }
            }
            else{
                $('#pass').addClass('is-invalid');
                $('#pass_error').html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Password harus diisi");
            }
            validasi();
        });

        $('#konfpass').on('keyup change', function() {
            if ($(this).val() != "") {
                if($(this).val() !== $('#pass').val()) {
                    $('#konfpass').addClass('is-invalid');
                    $('#konf_pass_error').html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Konfirmasi Password harus sama dengan Password");
                }
                else {
                    $('#konfpass').removeClass('is-invalid');
                    $('#konf_pass_error').html('');
                }
            } else {
                $('#konfpass').addClass('is-invalid');
                $('#konf_pass_error').html("<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Konfirmasi Password harus diisi");
            }
            validasi();
        });
    });

    </script>
@endsection
