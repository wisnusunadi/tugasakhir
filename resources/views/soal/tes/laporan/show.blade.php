@extends('layouts.adminlte.main')

@section('title', 'Sistem Penerimaan Karyawan')

@section('custom_css')
<style>

td.dt-control {
        background: url("/assets/image/plus.png") no-repeat center center;
        cursor: pointer;
        background-size: 15px 15px;
    }
    tr.shown td.dt-control {
        background: url("/assets/image/minus.png") no-repeat center center;
        background-size: 15px 15px;
    }

section{
    height: 100vh;
    margin-left: 250px;
}

.group{
    background-color: #8199AE;
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


.align-center {
        text-align: center;
    }

 .nowraptxt {
        white-space: nowrap;
    }

    .va-mid{
        vertical-align: middle !important;
    }

.modal-dialog{
            height:100%
}
.modal-content{
            height:90%
        }
        .modal-body{
            height:100%;
            overflow:auto
        }

</style>
@stop

@section('content')

<section class="content">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Hasil Tes</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item active">Hasil Tes</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body"> <div class="table-responsive">
                        <a id="exportbutton" href="{{route('laporan.hasil.export')}}"><button class="btn btn-success">
                            <i class="far fa-file-excel" id="load"></i> Export
                        </button>
                    </a>
                        <table class="table table-hover" id="showtable" style="width=100%">
                            <thead class="aligncenter">
                                <tr>
                                    <th></th>
                                    <th>Tanggal</th>
                                    <th>Jabatan</th>
                                    <th>Divisi</th>
                                    <th>Kuota</th>
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

    <div class="modal fade" id="detailmodal" tabindex="-1" role="dialog" aria-labelledby="detailmodal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin: 10px">
                <div class="modal-header">
                    <h4 id="modal-title">Detail</h4>
                </div>
                <div class="modal-body" id="detail">
                    <div class="table-responsive">
                        <table class="table  aligncenter" id="detailjawaban" style="width:100%">
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

</section>
@endsection

@section('script')
<script>
    $(function(){
        var groupColumn = 1;
        var showtable  =   $('#showtable').DataTable({
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "order": [[ groupColumn, 'asc' ]],
            "displayLength": 25,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="aligncenter group"><td colspan="4">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                });
            },
            lengthChange: false,
            processing: true,
            serverSide: true,
            ajax: {
                'url': '/api/laporan/hasil/data',
                'method': 'GET',
                'headers': {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin"></i> Tunggu Sebentar'
            },
            columns: [
                {
                    "className": 'dt-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },{
                data: 'jadwal',
                orderable: false,
                searchable: false,
                className: 'nowraptxt align-right borderright tabnum va-mid',
            },

            {
                data: 'jabatan',
                className: 'nowraptxt align-right borderright tabnum va-mid',
            }, {
                data: 'divisi',
                className: 'nowraptxt align-right borderright tabnum va-mid',
            }, {
                data: 'kuota',
                className: 'nowraptxt align-right borderright tabnum va-mid',
            }]
        });

        $('#showtable tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = showtable.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                detailtable(row.data().id);
                tr.addClass('shown');

            }
        });

        function format ( data ) {
            return `
            <div class="row">
                <div class="col-7">
                    <div class="card ">
                        <div class="card-header"><h6 class="card-title">Detail</h6></div>
                        <div class="card-body">
                            <div class="table-responsive">
                     <table class="table table-hover" id="detailtable`+data.id+`" style="width:100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kode Soal</th>
                                <th>Waktu</th>
                                <th>Soal</th>
                                <th>Benar</th>
                                <th>Salah</th>
                                <th>Kosong</th>
                                <th>Nilai</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                    </div>
                </div>
                </div>
            </div>`;
        }

        $(document).on('click', '.detailmodal', function(event) {
            var user = $(this).data("id");
            var soal = $(this).data("soal");
            detailjawaban(soal,user);
            $('#detailmodal').modal("show");
        });

        function detailjawaban(soal,user){
        $('#detailjawaban').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [[1,"asc"]],
            columnDefs: [
                { orderable: false, target: '_all' }
            ],
            ajax: {
                'url': '/soal_tes/result/'+soal+'/'+user,
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

    }


        function detailtable(id){
            $('#detailtable'+id).DataTable({
                destroy: true,
                processing: true,
                serverSide: false,
                paging: false,
                info:false,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin"></i> Tunggu Sebentar'
                },
                ajax: {
                    'url': '/api/laporan/hasil/data/'+id,
                    'dataType': 'json',

                    'headers': {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    className: 'nowrap-text align-center',
                    orderable: true,
                    searchable: false
                },{
                    data: 'nama',
                    className: 'nowrap-text align-center',

                },{
                    data: 'kode_soal',
                    className: 'nowrap-text align-center',

                 }
                ,{    data: 'waktu',
                    className: 'nowrap-text align-center',
                    orderable: true,
                    searchable: false

                },
                {
                    data: 'j_soal',
                    className: 'nowrap-text align-center',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'j_benar',
                    className: 'nowrap-text align-center',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'j_salah',
                    className: 'nowrap-text align-center',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'j_kosong',
                    className: 'nowrap-text align-center',
                    orderable: true,
                    searchable: false
                }
                ,{
                    data: 'nilai',
                    className: 'nowrap-text align-center',}
                ,{
                    data: 'button',
                    className: 'nowrap-text align-center',}

                 ],
            });
        }

    })
</script>
@endsection
