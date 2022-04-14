@extends('layouts.adminlte.main')

@section('title', 'Dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Jumlah Seleksi </h3>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-2">
                        <input class="form-check-input" type="radio" name="filter" checked value="jabatan">
                        <label class="form-check-label">Jabatan</label>
                    </div>
                    <!-- /.col-lg-6 -->
                    <div class="col-lg-3">
                        <input class="form-check-input" type="radio" name="filter" value="divisi">
                        <label class="form-check-label">Divisi</label>
                    </div>
                    <!-- /.col-lg-6 -->
                  </div>

        </div>
        <div class="card-body" id="jabatan">
        <select class="jabatan" data-placeholder="Pilih Jabatan" style="width: 100%;" name="jabatan[]" id="jabatan">
        </select>
        </div>
        <div class="card-body d-none" id="divisi">
        <select class="divisi" data-placeholder="Pilih Divisi" style="width: 100%;" name="divisi[]" id="divisi">
        </select>
        </div>
              <div class="card-body">

                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{{$u}}</span>
                    <span>Total pendaftar</span>
                  </p>
                  {{-- <p class="d-flex flex-column">
                    <span class="text-bold text-lg">820</span>
                    <span>Total lolos </span>
                  </p>
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">820</span>
                    <span>Total tidak lolos</span>
                  </p> --}}
                </div>

                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="jabatan_chart" height="200" ></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')

<script>
$(function(){
get_jabatan();
get_divisi();

var lolos = [];
var n_lolos = [];

$('input[type="radio"][name="filter"]').on('change', function() {
            if ($(this).val() == "jabatan") {
                $("#divisi").addClass("d-none");
                $("#jabatan").removeClass("d-none");
            }else{
                $("#jabatan").addClass("d-none");
                $("#divisi").removeClass("d-none");
            }
});

var ctx = document.getElementById('jabatan_chart').getContext('2d');

var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Lolos',
            backgroundColor: 'rgb(54, 162, 235)',
            borderColor: 'rgb(54, 162, 235)',
            data: lolos
        },
        {
            label: 'Tidak Lolos',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: n_lolos
        }]
    },

    // Configuration options go here
    options: {}
});

$(document).on('change', '.jabatan', function(){
    var id = $(this).val();
    $.ajax({
        dataType: 'json',
        url: "/api/chart/jabatan/"+id,
        type: 'GET',
        success: function(data) {
            if(data){
                lolos = data.lolos;
                n_lolos = data.n_lolos;
                chart.data.datasets[0].data = lolos;
                chart.data.datasets[1].data = n_lolos;
                chart.update();
            }

        },
        error: function() {
            response([]);
        }
    });
});

$(document).on('change', '.divisi', function(){
    var id = $(this).val();
    console.log(id);
    $.ajax({
        dataType: 'json',
        url: "/api/chart/divisi/"+id,
        type: 'GET',
        success: function(data) {
            if(data){
                lolos = data.lolos;
                n_lolos = data.n_lolos;
                chart.data.datasets[0].data = lolos;
                chart.data.datasets[1].data = n_lolos;
                chart.update();
            }

        },
        error: function() {
            response([]);
        }
    });
});

function get_jabatan(){
$('.jabatan').select2({
                theme: 'bootstrap4',

                ajax: {
                    minimumResultsForSearch: 20,
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    url: '/select/jabatan',
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function(data) {
                     //   console.log(data);
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.id,
                                    text: obj.nama
                                };
                            })
                        };
                    },
                }
        });
}
function get_divisi(){
$('.divisi').select2({
                    theme: 'bootstrap4',

                 ajax: {
                    minimumResultsForSearch: 20,
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    url: '/select/divisi',
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function(data) {
                     //   console.log(data);
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.id,
                                    text: obj.nama
                                };
                            })
                        };
                    },
                }
        });
}

})
</script>

@endsection

