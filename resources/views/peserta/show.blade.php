@extends('layouts.adminlte.main')

@section('title', 'Sistem Penerimaan Karyawan')

@section('custom_css')
<style>
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
</style>
@stop

@section('content')

<section class="content">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Peserta</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item active">Peserta</li>
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
                        <table class="table table-hover" id="showtable">
                            <thead class="aligncenter">
                                <tr>
                                    <th>No</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                    <td>1</td>
                                    <td>13 Feb 2021</td>
                                    <td>Mahlagha Kaylana</td>
                                    <td>Staff Admin Gudang</td>
                                    <td>mahlaghakay@gmail.com</td>
                                    <td><span class="badge badge-success">Diterima</span></td>
                                    <td><i class="fas fa-eye"></i></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>13 Feb 2021</td>
                                    <td>Salsa Fachrunisa</td>
                                    <td>Staff Admin Gudang</td>
                                    <td>salfachnisa@gmail.com</td>
                                    <td><span class="badge badge-danger">Ditolak</span></td>
                                    <td><i class="fas fa-eye"></i></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>12 Feb 2021</td>
                                    <td>Ebelle Rukhi</td>
                                    <td>Staff Admin Gudang</td>
                                    <td>ebellerukhi@gmail.com</td>
                                    <td><span class="badge badge-success">Diterima</span></td>
                                    <td><i class="fas fa-eye"></i></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>12 Feb 2021</td>
                                    <td>Myrna Myura</td>
                                    <td>Staff PPIC</td>
                                    <td>myrnamyura@gmail.com</td>
                                    <td><span class="badge badge-danger">Ditolak</span></td>
                                    <td><i class="fas fa-eye"></i></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>13 Feb 2021</td>
                                    <td>Deva Narendra</td>
                                    <td>Staff PPIC</td>
                                    <td>devanar0101@gmail.com</td>
                                    <td><span class="badge badge-danger">Ditolak</span></td>
                                    <td><i class="fas fa-eye"></i></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>12 Feb 2021</td>
                                    <td>Isamu Ariyya</td>
                                    <td>Staff PPIC</td>
                                    <td>isamuariyya@gmail.com</td>
                                    <td><span class="badge badge-success">Diterima</span></td>
                                    <td><i class="fas fa-eye"></i></td>
                                </tr> -->
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
            processing: true,
            serverSide: true,
            ajax: {
                'url': '/api/peserta/table',
                'method': 'GET',
                'headers': {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            },
            language: {
                processing: '<i class="fa fa-spinner fa-spin"></i> Tunggu Sebentar'
            },
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
                            '<tr class="group"><td colspan="6">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                });
            },
            columns: [{
                data: 'DT_RowIndex',
                className: 'nowrap-text align-center',
                orderable: false,
                searchable: false
            }, {
                data: 'pendaftaran',
            }, {
                data: 'tanggal_daftar',
            }, {
                data: 'nama',
            }, {
                data: 'email',
            }, {
                data: 'jenis_kelamin',
            }, {
                data: 'aksi',
            }],
        });
    })
</script>
@endsection
