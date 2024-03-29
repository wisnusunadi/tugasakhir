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

</style>
@stop

@section('content')

<section class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Draft Soal</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                <li class="breadcrumb-item active">Draft Soal</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
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
                    <strong>Hapus gagal</strong>, Soal sudah terpakai
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
          <div class="card-header">
           <div class="col-12">
                <span class="float-left filter">
                    <a href="{{route('draft_soal.create')}}"><button class="btn btn-info">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </a>
                </span>

                <span class="float-right filter">
                  <div class="form-inline">
                    <div class="input-group" >
                      <input class="form-control form-control-sidebar" type="search" placeholder="Cari" aria-label="Search" id="search">
                    </div>
                  </div>
                </span>
            </div>
          </div>
          <div class="card-body">
          <div class="row" id="showdata">
            @include('soal.draft.data')
          </div>
          <input class="d-none" name="hidden_page" id="hidden_page" value="1" />
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
                                <form method="post" action="{{route('draft_soal.delete')}}" id="form-hapus" >
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
    </div>
    </div>
  </div>
</div>
      </div>
</section>
@endsection

@section('script')
<script>

$(document).ready(function(){

    function fetch_data(page,query)
 {
  $.ajax({
   url:"/draft_soal/data?page="+page+"&query="+query,
   success:function(data)
   {
    $('#showdata').html(data);
   }
  });
 }

$(document).on('click', '.pagination a', function(event){
  event.preventDefault();
  var query = $('#search').val();
  var page = $(this).attr('href').split('page=')[1];
  $('#hidden_page').val(page);
  fetch_data(page,query);
 });

$(document).on('keyup', '#search', function(){
  var query = $(this).val();
    var page = $('#hidden_page').val();
    fetch_data(page,query);
    });


    $("#search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        dataType: 'json',
                        url: "/draft_soal/search",
                        data: {
                            term: request.term
                        },
                        success: function(data) {

                            var transformed = $.map(data, function(el) {
                                return {
                                    label: el.nama,
                                    id: el.id
                                };
                            });
                            response(transformed);
                        },
                        error: function() {
                            response([]);
                        }
                    });
                }
            });

     $(document).on('click', '.hapusmodal', function(event) {
            event.preventDefault();
            var id = $(this).data("id");
            var label = $(this).data("label");

            $('#id').val(id);
            $('#des_hapus').html("Apakah Anda yakin ingin menghapus soal <b>" +label+"</b> ? ");
            $('#hapusmodal').modal("show");

        });
    $('#search').on('autocompletechange change', function () {
        result = this.value;
        var query = $(this).val();
         var page = $('#hidden_page').val();
         fetch_data(page,query);
    }).change();

});
</script>
@endsection

