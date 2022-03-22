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
.benar{
    background-color: rgb(168, 255, 118);
    color: white;
}

.row{
    height: 100%;
}

.imgoprec{
    object-fit: contain;
    width: 100%;
}
.aligncenter{
    text-align: center;
}
.alignleft{
    text-align: left;
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


</style>
@stop

@section('content')

<section class="content">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Draft Soal</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{route('draft_soal')}}">Draft Soal</a></li>
                <li class="breadcrumb-item active">Lihat Soal</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Preview {{ $soal->kode_soal }} - <strong>{{ $soal->nama }}</strong></h3>
                      </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-2">

                            </div>
                            <div class="col-12 col-sm-2">
                              <div class="info-box bg-light">
                                <div class="info-box-content">
                                  <span class="info-box-text text-center text-muted">Jabatan</span>
                                  <span class="info-box-number text-center text-muted mb-0">
                                    @foreach($soal->Jabatan as $j)
                                  {{$j->nama}}
                                @if(!$loop->last)
                                  ,
                                 @endif
                                 @endforeach
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-sm-2">
                              <div class="info-box bg-light">
                                <div class="info-box-content">
                                  <span class="info-box-text text-center text-muted">Divisi</span>
                                  <span class="info-box-number text-center text-muted mb-0">
                                    @foreach($soal->Divisi as $j)
                                    {{$j->nama}}
                                  @if(!$loop->last)
                                    ,
                                   @endif
                                   @endforeach
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-sm-2">
                              <div class="info-box bg-light">
                                <div class="info-box-content">
                                  <span class="info-box-text text-center text-muted">Jumlah</span>
                                  <span class="info-box-number text-center text-muted mb-0">{{ $soal->getJumlahSoal() }} Soal</span>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                  <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Waktu</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{$soal->waktu}} menit</span>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="table-responsive">
                        <table class="table  aligncenter" id="showtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Soal</th>
                                    <th class="alignleft">Jawaban</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
  var showtable = $('#showtable').DataTable({
    destroy: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [[1,"asc"]],
columnDefs: [
    { orderable: false, target: '_all' }
  ],
            ajax: {
                'url': '/draft_soal/preview/data/{{ $soal->id }}',
                'dataType': 'json',
                'headers': {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin"></i> Tunggu Sebentar'
            },
            columns: [{
                data: 'DT_RowIndex',
                className: 'aligncenter',
                orderable: false,
                searchable: false
            },{
                data: 'deskripsi',
                className: 'alignleft',
                orderable: false,
                searchable: false
            },{
                data: 'jawaban',
                className: 'alignleft',
                orderable: false,
                searchable: false
            },{
                data: 'bobot',
                orderable: false,
                searchable: false
            }]
        });
</script>
@endsection
