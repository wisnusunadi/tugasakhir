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

.card{
    box-shadow:none;
}

.row{
    height: 100%;
    display:flex;
    justify-content:center;
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

.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
}

td{
    border-color: white !important;
}

#navigation li a {
    width:60px;
    max-width:60px;
    text-align: center;
}

#navigation li.answer a {
    background: rgb(104, 145, 38);
  color: #fff;
}

#navigation li.active a {
    background: rgba(23, 23, 24, 0.844);
  color: #fff;
}

</style>
@stop

@section('content')

<section class="content">
    <div class="content-header">
        <h1 class="content-title">Soal Tes</h1>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
        <div class="card">
          <div class="card-header">
          </div>
          <div class="card-body">
          <div class="row">
            @foreach ($soal as $s)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                  {{ $s->nama }}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>{{ $s->kode_soal }}</b></h2>
                      <p class="text-muted text-sm"><b>Jumlah: </b> {{ $s->getJumlahSoal() }} Soal </p>
                      <p class="text-muted text-sm"><b>Jabatan: </b>
                        @foreach($s->Jabatan as $j)
                        {{$j->nama}}
                        @if(!$loop->last)
                        ,
                        @endif
                        @endforeach
                      </p>
                      <p class="text-muted text-sm"><b>Divisi: </b>
                        @foreach($s->Divisi as $d)
                        {{$d->nama}}
                        @if(!$loop->last)
                        ,
                        @endif
                        @endforeach
                      </p>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a href="{{ route('soal_tes.show',['id' => $s->id])}}" class="btn btn-sm btn-primary">
                    Mulai Tes
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer -->
      </div>
</section>
@endsection

@section('script')

@endsection
