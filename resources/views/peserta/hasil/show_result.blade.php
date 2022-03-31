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

.row{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.imgoprec{
    object-fit: contain;
    width: 100%;
}
.aligncenter{
    text-align: center;
}
</style>
@stop

@section('content')

<section class="content">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Jadwal Open Recruitment</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item active">Jadwal Open Recruitment</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover aligncenter" id="showtable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pendaftaran</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Nama Peserta</th>
                                    <th>Usia</th>
                                    <th>Pendidikan</th>
                                    <th>Jarak</th>
                                    <th>Soal</th>
                                    <th>Rata Rata</th>
                                    <th>Keputusan</th>
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
</section>
@endsection

@section('script')
<script>
    $(function(){
        var groupColumn = 1;
        $('#showtable').DataTable({
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "order": [[ groupColumn, 'asc'], ['9', 'desc']],
            "displayLength": 25,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="9">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                });
            },
            processing: true,
            serverSide: true,
            ajax: {
                'url': '/api/peserta/hasil',
                'method': 'GET',
                'headers': {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin"></i> Tunggu Sebentar'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    className: 'nowrap-text align-center',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'pendaftaran',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'tanggal_daftar',
                }, {
                    data: 'nama',
                }, {
                    data: 'usia',
                }, {
                    data: 'pendidikan',
                }, {
                    data: 'jarak',
                }, {
                    data: 'soal',
                }, {
                    data: 'rerata',
                }, {
                    data: 'keputusan',
                },
            ]
        });
    })
</script>
@endsection
