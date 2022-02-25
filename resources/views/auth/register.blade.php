@extends('layouts.app')

@section('custom_css')
<style>
    .container{
        display:flex;
        justify-content:center;
        align-items:center;
        height: 100vh;
        width: 100%;
    }

    body{
        background: rgb(70,130,180);
        background: radial-gradient(circle, rgba(70,130,180,1) 0%, rgba(129,161,187,1) 35%, rgba(243,243,243,1) 100%);
    }

    .aligncenter{
        text-align: center;
    }

    #thecontent{
        width:60%;
    }
</style>
@stop
@section('content')
<div class="container">
    <div class="row" id="thecontent">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <h4>Register</h4>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-lg-4 col-md-12 col-form-label text-lg-end">Nama</label>

                            <div class="col-lg-7 col-md-12">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-lg-4 col-md-12 col-form-label text-lg-end">Alamat Email</label>

                            <div class="col-lg-7 col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password" class="col-lg-4 col-md-12 col-form-label text-lg-end">Jenis Kelamin</label>
                            <div class="col-lg-7 col-md-12 col-form-label">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="laki" value="l" name="jenis_kelamin" >
                                    <label class="form-check-label" for="inlineCheckbox1">Laki - laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="perempuan"  value="p" name="jenis_kelamin" >
                                    <label class="form-check-label" for="inlineCheckbox1">Perempuan</label>
                                </div>

                                @error('jenis_kelamin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-lg-4 col-md-12 col-form-label text-lg-end">{{ __('Password') }}</label>

                            <div class="col-lg-7 col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-lg-4 col-md-12 col-form-label text-lg-end">Konfirmasi Password</label>

                            <div class="col-lg-7 col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-lg-4 col-md-12 col-form-label text-lg-end">Pendaftaran</label>

                            <div class="col-lg-7 col-md-12">
                                <select class="form-control select2" name="pendaftaran_id" id="pendaftaran_id">
                                    @foreach($p as $i)
                                    <option value="{{$i->id}}">{{$i->Jabatan->nama}} {{$i->Divisi->nama}}</option>
                                    @endforeach
                                </select>

                                @error('pendaftaraan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-lg-12 col-md-12">
                                <a type="button" class="btn btn-danger" href="{{route('login')}}">Batal</a>
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function(){
        $('#pendaftaran_id').select2();
    })
</script>
@endsection
