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
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pilih Jadwal</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Isi Akun</button>
                        </li>
                    </ul>
                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-responsive">
                                <table class="table" style="text-align:center;" id="showtable">
                                    <thead>
                                        <th>No</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Keterangan</th>
                                        <th>Kuota</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach($p as $i)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{date('d-m-Y', strtotime($i->Jadwal->waktu_mulai))}} </td>
                                            <td>{{date('d-m-Y', strtotime($i->Jadwal->waktu_selesai))}}</td>
                                            <td>{{$i->Jabatan->nama}} {{$i->Divisi->nama}}
                                                <small class="invalid-feedback d-block">{{$i->Jadwal->ket}}</small>
                                            </td>
                                            <td>{{$i->kuota}}</td>
                                            <td><div class="form-check">
                                                <input class="form-check-input" type="radio" name="pendaftaran_id" id="pendaftaran_id{{$loop->iteration}}" value="{{$i->id}}"/>
                                                </div></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Jenis Kelamin</label>
                                    <div class="col-md-6 colcol-form-label">
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
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
        
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary float-right">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                        </div>
<<<<<<< HEAD
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
=======
                    </div>
>>>>>>> 424ba3e12919f50cab10a7e49e7b90a4774852bc
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
