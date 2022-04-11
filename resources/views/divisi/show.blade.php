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

.edit-link
{
   color: white;
   text-decoration: none;
   background-color: none;
}

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
              <h1 class="m-0">Divisi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item active">Divisi</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Hapus berhasil</strong>, Terima kasih
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Hapus gagal</strong>, Divisi sudah terpakai
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover aligncenter" id="showtable"  style="width:100%">
                            <thead>
                                    <tr>
                                        <th colspan="5">
                                        <a href="{{route('divisi.create')}}" type="button" class="btn btn-info btn-sm float-right"><i class="fa-solid fa-plus"></i> Tambah</a>
                                        </th>
                                    </tr>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                    <th></th>
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

    <div class="modal fade" id="hapusmodal" role="dialog" aria-labelledby="hapusmodal" aria-hidden="true" data-bs-backdrop="static" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin: 10px">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Hapus</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="hapus">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{route('divisi.delete')}}" id="form-hapus" >
                                @method('delete')
                                @csrf
                                <input id="id" name="id" class="d-none" hidden>
                                <div class="card">
                                    <div class="card-body" id="des_hapus"></div>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </div>
                </form>
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
                'url': '/api/divisi/data',
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
                data: 'nama',

            }, {
                data: 'button',
                orderable: false,
                searchable: false
            } ]
        });

        $(document).on('click', '.hapusmodal', function(event) {
            event.preventDefault();
            var id = $(this).data("id");
            var label = $(this).data("label");

            $('#id').val(id);
            $('#des_hapus').html("Apakah Anda yakin ingin menghapus divisi <b>" +label+"</b> ? ");
            $('#hapusmodal').modal("show");

        });
    })
</script>
@endsection
