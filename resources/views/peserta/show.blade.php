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

.align-center {
        text-align: center;
    }

.nowraptxt {
        white-space: nowrap;
    }

.va-mid{
        vertical-align: middle !important;
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

    <div class="modal fade" id="detailmodal" role="dialog" aria-labelledby="detailmodal" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin: 10px">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="title"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="hapus">
                    <div class="row">
                        <div class="col-12">

                                <input id="id" name="id" class="d-none" hidden>

                                    <div class="card-body">
                                        <strong><i class="fas fa-book mr-1"></i> Pendidikan Terakhir</strong>

                                        <p class="text-muted" id="pendidikan">
                                        </p>

                                        <hr>

                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Jarak lokasi ke pabrik</strong>

                                        <p class="text-muted" id="jarak"></p>

                                        <hr>

                                        <strong><i class="fas fa-pencil-alt mr-1"></i> Username</strong>

                                        <p class="text-muted" id="username">
                                        </p>

                                        <hr>

                                       </div>
                                      <!-- /.card-body -->


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
                className: 'nowrap-text align-center',
            }, {
                data: 'tanggal_daftar',
                className: 'nowrap-text align-center',
            }, {
                data: 'nama',
                className: 'nowrap-text align-center',
            }, {
                data: 'email',
                className: 'nowrap-text align-center',
            }, {
                data: 'jenis_kelamin',
                className: 'nowrap-text align-center',
            }, {
                data: 'aksi',
                className: 'nowrap-text align-center',
            }],
        });

        $(document).on('click', '.detail', function(event) {
            event.preventDefault();
            var id = $(this).data("id");
            $('#detailmodal').modal("show");
            console.log(id);
            detail_profile(id);
        });

        function detail_profile(id){
            $.ajax({
                        url: "/api/peserta/detail/" + id,
                        data : {id:id},
                        success: function(data) {
                            $('#title').text(data.data[0].nama);
                            if(data.data[0].pend != 'smak'){
                                if(data.data[0].pend != 's1d4'){
                                    $('#pendidikan').text("Strata (S1) / Diploma (D4) : "+ data.data[0].universitas.nama);
                                }
                                else{
                                    $('#pendidikan').text("Diploma (D3) : "+ data.data[0].universitas.nama);
                                }

                            }else{
                                $('#pendidikan').text("SMA / SMK");
                            }

                            $('#jarak').text( data.data[0].jarak + " Km");
                            $('#username').text(data.data[0].username);
                        },
                        error: function() {
                            response([]);
                        }
                    });
                }

         $('.modal-dialog').draggable({
        handle: ".modal-header"
        });

    })
</script>
@endsection
