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

/* .edit-link
{
   color: white;
   text-decoration: none;
   background-color: none;
} */

.edit-link:hover
{
   color: #ffc107;
   text-decoration: none;
   background-color: none;
}
</style>
@stop

@section('content')

<section class="content-wrapper">
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
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover aligncenter" id="showtable"  style="width:100%">
                            <thead>
                                @if(Auth::user())
                                    @if(Auth::user()->role == "admin")
                                    <tr>
                                        <th colspan="6">
                                        <a href="{{route('jadwal.create')}}" type="button" class="btn btn-info btn-sm float-right"><i class="fa-solid fa-plus"></i> Tambah</a>
                                        </th>
                                    </tr>
                                    @endif
                                @endif
                                <tr>
                                    <th style="min-width:8%">No</th>
                                    <th>Keterangan</th>
                                    <th style="min-width:20%">Tanggal Mulai</th>
                                    <th style="min-width:20%">Tanggal Selesai</th>
                                    <th style="min-width:8%">Aksi</th>
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
    $(function(){
        function detailtable(id){
            $('#detailtable'+id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'url': '/pendaftaran/table/'+id,
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
                    className: 'aligncenter',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'jabatan',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'divisi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kuota',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'pendaftar',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'aksi',
                    visible: auth == 'admin' ? true : false,
                }, ]
            });
        }
        var auth = <?php if(Auth::user()){ echo '"'.Auth::user()->role.'"'; } else { echo "0"; } ?>;
        var groupColumn = 1;
        $('#showtable').on('click', '.hapusmodal', function(){
            var id = $(this).attr('data-id');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Hapus Pendaftaran',
                text: "Apakah anda yakin untuk menghapus Data Pendaftaran ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/api/pendaftaran/delete/'+id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#showtable').DataTable().ajax.reload();
                            swalWithBootstrapButtons.fire(
                                'Berhasil',
                                'Data Pendaftaran Berhasil dihapus',
                                'success'
                            )
                        },
                        error: function(xhr, status, error) {
                            swalWithBootstrapButtons.fire(
                                'Error',
                                'Data telah digunakan',
                                'warning'
                            );
                            // console.log(action);
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Batal',
                    'Data Pendaftaran Batal dihapus',
                    'error'
                    )
                }
            })
        });

        function format ( data ) {
            return `
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="table-responsive">
                     <table class="table table-hover" id="detailtable`+data.id+`" style="width:100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="min-width:8%">No</th>
                                <th>Jabatan</th>
                                <th>Divisi</th>
                                <th style="min-width:8%">Kuota</th>
                                <th style="min-width:15%">Jumlah Pendaftar</th>
                                <th style="min-width:20%">Aksi</th>
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

        var showtable = $('#showtable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': '/jadwal/table',
                'method': 'GET',
                'headers': {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin"></i> Tunggu Sebentar'
            },
            columns: [{
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": '',
            },
            {
                data: 'jadwal',
                orderable: false,
                searchable: false
            },
            {
                data: 'tanggal_mulai',
                orderable: false,
                searchable: false
            },
            {
                data: 'tanggal_selesai',
                orderable: false,
                searchable: false
            },{
                data: 'aksi',
                visible: auth == 'admin' ? true : false,
            }, ]
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


    })
</script>
@endsection
