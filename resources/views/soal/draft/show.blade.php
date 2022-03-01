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

<section class="content">
    <div class="content-header">
        <h1 class="content-title">Soal Tes</h1>
    </div>
    
    <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">

            <div class="col-12">
                <span class="float-right filter">
                    <a href=""><button class="btn btn-outline-info">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </a>
                </span>

                <span class="float-right filter">
                    <button class="btn btn-outline-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <form id="filter_ekat">
                        <div class="dropdown-menu">
                            <div class="px-3 py-3">
                                <div class="form-group">
                                    <label for="jenis_penjualan">Status</label>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="sepakat" id="status1" name="status_ekatalog[]" />
                                        <label class="form-check-label" for="status1">
                                            Sepakat
                                        </label>
                                    </div>
                                </div>               
                                <div class="form-group">
                                    <span class="float-right">
                                        <button class="btn btn-primary" type="submit" id="filter_ekatalog">
                                            Cari
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </span>
            </div>

            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    Soal Tes Psikologi 
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>Soal 1</b></h2>
                        <p class="text-muted text-sm"><b>Jumlah: </b> 50 Soal </p>
                        <p class="text-muted text-sm"><b>Jabatan: </b> Staff , Manager </p>
                        <p class="text-muted text-sm"><b>Divisi: </b> Logistik , Gudang </p>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <a href="#" class="btn btn-sm bg-teal">
                      Edit
                      </a>
                      <a href="#" class="btn btn-sm btn-primary">
                     Lihat Soal
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                  Soal Tes Potensi Akademik
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>Soal 2</b></h2>
                      <p class="text-muted text-sm"><b>Jumlah: </b> 50 Soal </p>
                      <p class="text-muted text-sm"><b>Jabatan: </b> Staff </p>
                      <p class="text-muted text-sm"><b>Divisi: </b> IT , Akutansi </p>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a href="#" class="btn btn-sm bg-teal">
                    Edit
                    </a>
                    <a href="#" class="btn btn-sm btn-primary">
                   Lihat Soal
                    </a>
                  </div>
                </div>
              </div>
            </div>
           
           
            
            
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item"><a class="page-link" href="#">6</a></li>
              <li class="page-item"><a class="page-link" href="#">7</a></li>
              <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
</section>
@endsection

@section('script')

@endsection