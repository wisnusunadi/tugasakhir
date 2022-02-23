@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-proses_kirim-tab" data-toggle="pill" href="#pills-proses_kirim" role="tab" aria-controls="pills-proses_kirim" aria-selected="true">Pilih Jadwal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-selesai_kirim-tab" data-toggle="pill" href="#pills-selesai_kirim" role="tab" aria-controls="pills-selesai_kirim" aria-selected="false">Register</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-proses_kirim" role="tabpanel" aria-labelledby="pills-proses_kirim-tab">
                            
                           
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
                                                <tr>
                                                    <td>1</td>
                                                    <td>12 Juni 2022</td>
                                                    <td>13 Juni 2022</td>
                                                    <td>Open Recruitmen IT programmer
                                                        <small class="invalid-feedback d-block"> Junior Staff</small>
                                                    </td>
                                                    <td>2</td>
                                                    <td><div class="form-check">
                                                        <input class=" form-check-input yet nosericheck" type="checkbox"  />
                                                        </div></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>10 Juni 2022</td>
                                                    <td>15 Juni 2022</td>
                                                    <td>Open Recruitment Accounting 
                                                        <small class="invalid-feedback d-block"> Staff</small>
                                                    </td>
                                                    <td>1</td>
                                                    <td><div class="form-check">
                                                        <input class=" form-check-input yet nosericheck" type="checkbox"  />
                                                        </div></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>15 Juni 2022</td>
                                                    <td>18 Juni 2022</td>
                                                    <td>Open Recruitment HRD
                                                        <small class="invalid-feedback d-block"> Manager</small>
                                                    </td>
                                                    <td>3</td>
                                                    <td><div class="form-check">
                                                        <input class=" form-check-input yet nosericheck" type="checkbox"  />
                                                        </div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                             
                        </div>
                        <div class="tab-pane fade show" id="pills-selesai_kirim" role="tabpanel" aria-labelledby="pills-selesai_kirim-tab">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
        
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
                                        <button type="submit" class="btn btn-primary">
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
    </div>
</div>
@endsection
