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
        <h1 class="content-title">Jadwal Open Recruitment</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover" id="showtable">
                            <thead class="aligncenter">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jabatan</th>
                                    <th>Kuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--   --}}
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
      var groupColumn = 0;
        $('#showtable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'url': '/api/jadwal/data',
                    "dataType": "json",
                  
                    'headers': {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                },
                "columns": [{
                        data: 'tanggal',
                    },
                    {
                        data: 'jabatan',
                    },
                    {
                        data: 'kuota',
                    }
                ],
                "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
                "drawCallback": function ( settings ) {
    var api = this.api();
    var rows = api.rows( {page:'current'} ).nodes();
    var last=null;

    api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
            $(rows).eq( i ).before(
                '<tr class="aligncenter group"><td colspan="3">'+group+'</td></tr>'
            );

            last = group;
        }
    });
}
                
                
        });
    })
</script>
@endsection