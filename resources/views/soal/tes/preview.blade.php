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
.vera{
    vertical-align: text-top;
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
            @if(Session::has('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Selesai</strong>, Tes berhasil dikirim
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        <div class="card">
          <div class="card-header">
          </div>
          <div class="card-body">
          <div class="row">
            @foreach ($soal_belum as $s)
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
                      <p class="text-muted text-sm"><b>Waktu Pengerjaan: </b> {{ $s->waktu }} Menit</p>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Launch static backdrop modal
                      </button> --}}
                    <button  class="btn btn-sm btn-primary mulai"  data-waktu="{{ $s->waktu }}" data-id="{{ $s->id }}"><i class="fa fa-pencil" aria-hidden="true"></i>
                    Mulai Tes
                    </button>
                  </div>
                </div>
              </div>
            </div>
            @endforeach

            @foreach ($soal_sudah as $s)
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
                      <p class="text-muted text-sm"><b>Waktu Pengerjaan: </b> {{ $s->waktu }} Menit</p>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="btn btn-sm btn-success" type="button" disabled><i class="fa fa-check" aria-hidden="true" disabled></i> Selesai</button>
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

<!-- Modal -->
<div class="modal fade" id="rule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Tes akan segera dimulai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <img src="{{url('assets/image/attention.png')}}" class="rounded float-start" style=" width: 150px;">
          Mohon Dibaca Kembali :
          <table>
              <tr>
              <td class="vera">1. </td>
              <td class="vera">Tes akan berlangsung selama <b id="waktu"></b> menit</td>
              </tr>
              <tr>
              <td class="vera">2. </td>
              <td class="vera">Jika waktu habis maka akan otomatis tersubmit</td>
              </tr>
              <tr>
              <td class="vera">3. </td>
              <td class="vera">Segala bentuk kecurangan akan menyebakan anda terdiskualifikasi</td>
              </tr>
          </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <a href="" id="accept" class="btn btn-sm btn-primary" >
            Baik, saya paham
          </a>

        </div>
      </div>
        </div>
  </div>

</section>
@endsection

@section('script')
<script>
$(document).on('click', '.mulai', function(event) {
    event.preventDefault();
    var id = $(this).data("id");
    var waktu = $(this).data("waktu");
    console.log(waktu);
    $('#waktu').text(waktu);

    var link = '/soal_tes/show/'+ id;
    $('#accept').attr({
    href: link
    });

    $('#rule').modal("show");

});
</script>
@endsection
