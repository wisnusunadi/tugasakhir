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
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover aligncenter" id="showtable">
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
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jabatan</th>
                                    <th>Divisi</th>
                                    <th>Kuota</th>
                                    <th>Aksi</th>
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
        })
        $('#showtable').DataTable({
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
                            '<tr class=""><td colspan="5">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                });
            },
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
                data: 'DT_RowIndex',
                className: 'nowrap-text align-center',
                orderable: false,
                searchable: false
            }, {
                data: 'jadwal',
                orderable: false,
                searchable: false
            }, {
                data: 'jabatan',
            }, {
                data: 'divisi',
            }, {
                data: 'kuota',
            },{
                data: 'aksi',
                visible: auth == 'admin' ? true : false,
            }, ]
        });
    })
</script>
@endsection
