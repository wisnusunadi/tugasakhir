@extends('layouts.app')

@section('custom_css')
<style>
    .container{
        display:flex;
        justify-content:center;
        align-items:center;
        height: 100vh;
        width: 100%;
    }

    body{
        background: rgb(70,130,180);
        background: radial-gradient(circle, rgba(70,130,180,1) 0%, rgba(129,161,187,1) 35%, rgba(243,243,243,1) 100%);
    }

    .aligncenter{
        text-align: center;
    }

    #thecontent{
        width:60%;
    }

    .hide{
      display:none;
    }

</style>
@stop
@section('content')
<div class="container">
    <div class="row" id="thecontent">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pilih Jadwal</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-bio" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Biodata</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="pills-akun-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Akun</button>
                        </li>
                    </ul>
                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-responsive">
                                <table class="table" style="text-align:center;" id="showtable">
                                    <thead>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Kuota</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if(count($jadwal) > 0)
                                              @foreach($jadwal as $index => $j)
                                        <tr>

                                            <td rowspan="{{$j->Pendaftaran->count()}}">{{$j->ket}}
                                                <div><small  class="invalid-feedback d-block">{{date('d M', strtotime($j->waktu_mulai))}} - {{date('d M Y', strtotime($j->waktu_selesai))}}</small></div>
                                            </td>

                                            <td >{{$j->Pendaftaran[0]->jabatan->nama}} {{$j->Pendaftaran[0]->divisi->nama}}</td>
                                            <td >{{$j->Pendaftaran[0]->kuota}}</td>
                                            <td >
                                                <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pendaftaran_id" id="pendaftaran_id1" value="{{$j->Pendaftaran[0]->id}}"/>
                                                </div>
                                            </td>
                                        </tr>
                                        @for($i=1;$i<$j->pendaftaran->count();$i++)
                                        <tr>
                                            <td >{{$j->Pendaftaran[$i]->jabatan->nama}} {{$j->Pendaftaran[$i]->divisi->nama}}</td>
                                            <td >{{$j->Pendaftaran[$i]->kuota}}</td>
                                            <td >
                                                <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pendaftaran_id" id="pendaftaran_id{{$i}}" value="{{$j->Pendaftaran[$i]->id}}"/>
                                                </div>
                                            </td>
                                        </tr>
                                      @endfor
                                        @endforeach
                                            @else
                                            <td colspan="6">Maaf, info lowongan belum tersedia untuk saat ini</td>
                                            @endif


                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-bio" role="tabpanel" aria-labelledby="pills-bio-tab">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="tgl_lahir" class="col-md-4 col-form-label text-md-end">{{ __('Tgl Lahir') }}</label>
                                    <div class="col-md-6">
                                        <input id="tgl_lahir" type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required autocomplete="tgl_lahir">

                                        @error('tgl_lahir')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Jenis Kelamin</label>
                                    <div class="col-md-6 col-form-label">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="laki" value="l" name="jenis_kelamin" >
                                            <label class="form-check-label" for="inlineCheckbox1">Laki - laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="perempuan"  value="p" name="jenis_kelamin" >
                                            <label class="form-check-label" for="inlineCheckbox1">Perempuan</label>
                                        </div>

                                        @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Pend Terakhir</label>
                                    <div class="col-md-8 col-form-label">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="pend1" value="smak" name="pend" >
                                            <label class="form-check-label" for="inlineCheckbox1">SMA / SMK</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="pend2"  value="d3" name="pend" >
                                            <label class="form-check-label" for="inlineCheckbox1">D3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="pend2"  value="s1d4" name="pend" >
                                            <label class="form-check-label" for="inlineCheckbox1">S1 / D4</label>
                                        </div>

                                        @error('pendidikan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-3 univ hide">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Universitas</label>
                                    <div class="col-md-8 col-form-label">
                                      <select class="universitas" data-placeholder="Pilih universitas" style="width: 100%;" name="universitas" id="universitas">
                                      </select>
                                    </div>
                                </div>


                                {{-- <div class="row mb-3 univ hide">
                                    <label for="tgl_lahir" class="col-md-4 col-form-label text-md-end"></label>
                                    <div class="col-md-6">
                                        <select class="universitas" data-placeholder="Pilih universitas"  name="universitas" id="universitas">
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Alamat</label>

                                    <div class="col-md-6">
                                        <div id="map" style="width: 100%;height: 30vh;"></div>
                                        <div id="instructions"></div>
                                            </div>
                                            <input id="jarak_user" type="text" name="jarak" class="d-none">
                                </div>


                                <div class="row mb-0">
                                    <div class="col-md-9 offset-md-2">
                                        <a type="button" class="btn btn-danger" href="{{route('login')}}">Batal</a>
                                        <button type="submit" class="btn btn-primary float-right" id="tambah" disabled>
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Konfirmasi Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>



                        </div>
                    </div>

                    </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css">
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<script>
	// TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
	mapboxgl.accessToken = 'pk.eyJ1IjoiY29iYWFqYSIsImEiOiJjbDB1YmF2MW0wbTc5M2lwN29naXNvZmNhIn0.0NSEJTzK2A0B20TS5GNLYA';
const map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/streets-v11',
  center: [112.60510145893522, -7.24034151386617], // starting position
  zoom: 13
});

// set the bounds of the map
// const bounds = [
//   [-123.069003, 45.395273],
//   [-122.303707, 45.612333]
// ];
// map.setMaxBounds(bounds);

// an arbitrary start will always be the same
// only the end or destination will change
const start = [112.60254505477201, -7.238722373177026];

// this is where the code for the next step will go

// create a function to make a directions request
async function getRoute(end) {
  // make a directions request using cycling profile
  // an arbitrary start will always be the same
  // only the end or destination will change
  const query = await fetch(
    `https://api.mapbox.com/directions/v5/mapbox/cycling/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken}`,
    { method: 'GET' }
  );
  const json = await query.json();
  const data = json.routes[0];
  const route = data.geometry.coordinates;
  const geojson = {
    type: 'Feature',
    properties: {},
    geometry: {
      type: 'LineString',
      coordinates: route
    }
  };
  // if the route already exists on the map, we'll reset it using setData
  if (map.getSource('route')) {
    map.getSource('route').setData(geojson);
  }
  // otherwise, we'll make a new request
  else {
    map.addLayer({
      id: 'route',
      type: 'line',
      source: {
        type: 'geojson',
        data: geojson
      },
      layout: {
        'line-join': 'round',
        'line-cap': 'round'
      },
      paint: {
        'line-color': '#3887be',
        'line-width': 5,
        'line-opacity': 0.75
      }
    });
  }
  // add turn instructions here at the end


// get the sidebar and add the instructions
const instructions = document.getElementById('instructions');
console.log(data);



if (data.distance < 1000){
    var label = ' Meter'
    var h =  data.distance / 1000
}else{
    var label = ' Kilometer'
    var h =  data.distance / 1000
}

$('#jarak_user').val(h.toFixed(1));
let tripInstructions = '';
instructions.innerHTML = `<p><strong>Jarak: `+h.toFixed(1)+``+label+`  🚴 </strong></p>`;
}

map.on('load', () => {
  // make an initial directions request that
  // starts and ends at the same location
  getRoute(start);

  // Add starting point to the map
  map.addLayer({
    id: 'point',
    type: 'circle',
    source: {
      type: 'geojson',
      data: {
        type: 'FeatureCollection',
        features: [
          {
            type: 'Feature',
            properties: {},
            geometry: {
              type: 'Point',
              coordinates: start
            }
          }
        ]
      }
    },
    paint: {
      'circle-radius': 10,
      'circle-color': '#3887be'
    },
  });
  // this is where the code from the next step will go
});

map.on('click', (event) => {
  const coords = Object.keys(event.lngLat).map((key) => event.lngLat[key]);
  const end = {
    type: 'FeatureCollection',
    features: [
      {
        type: 'Feature',
        properties: {},
        geometry: {
          type: 'Point',
          coordinates: coords
        }
      }
    ]
  };
  if (map.getLayer('end')) {
    map.getSource('end').setData(end);
  } else {
    map.addLayer({
      id: 'end',
      type: 'circle',
      source: {
        type: 'geojson',
        data: {
          type: 'FeatureCollection',
          features: [
            {
              type: 'Feature',
              properties: {},
              geometry: {
                type: 'Point',
                coordinates: coords
              }
            }
          ]
        }
      },
      paint: {
        'circle-radius': 10,
        'circle-color': '#f30'
      }
    });
  }
  getRoute(coords);



});




var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            marker:false,
            placeholder: 'Lokasi anda tinggal',
            zoom:20
        });


        map.addControl(
            geocoder
        );

        var today = new Date();
        var yyyy = today.getFullYear() - 17;

        today = yyyy + '-' + 12 + '-' + 31;

        $("#tgl_lahir").attr("max", today);




</script>

<script>
    $(function(){
        // $('#pendaftaran_id').select2();
        $('input[type="radio"][name="pend"]').change(function(){
          if($(this).val() == "s1d4" || $(this).val() == "d3"){
            $('.univ').removeClass('hide');
          }else{
            $('.univ').addClass('hide');
          }
        })

        $('.universitas').select2({
            theme: 'bootstrap4',
            ajax: {
              minimumResultsForSearch: 20,
              dataType: 'json',
              delay: 250,
              type: 'GET',
              url: '/select/universitas',
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
                          }
                      })
                  }
              },
            }
        });



        $('#name').on('keyup change', function() {
            if ($(this).val() != "") {
                if ($('#tgl_lahir').val() != "" &&  $('input[name=jenis_kelamin]:checked').length > 0  &&  $('input[name=pend]:checked').val() == 'smak' && $('#jarak_user').val() > 0 ) {
                    $('#tambah').attr("disabled", false);
                } else {
                    $('#tambah').attr("disabled", true);
                }
            } else {
                $('#tambah').attr("disabled", true);
            }
        });

        $('#tgl_lahir').on('keyup change', function() {
            if ($(this).val() != "") {
                if ($('#name').val() != "" && $('input[name=jenis_kelamin]:checked').length > 0  &&  $('input[name=pend]:checked').val() == 'smak'  && $('#jarak_user').val() > 0 ) {
                    $('#tambah').attr("disabled", false);
                } else {
                    $('#tambah').attr("disabled", true);
                }
            } else {
                $('#tambah').attr("disabled", true);
            }
        });

        $('input[type="radio"][name="jenis_kelamin"]').on('change', function() {
            if ($(this).val() != "") {
                if ($('#name').val() != "" && $('#tgl_lahir').val() != ""  &&  $('input[name=pend]:checked').val() == 'smak'  && $('#jarak_user').val() > 0 ) {
                    $('#tambah').attr("disabled", false);
                } else {
                    $('#tambah').attr("disabled", true);
                }
            } else {
                $('#tambah').attr("disabled", true);
            }
        });

        $('input[type="radio"][name="pend"]').on('change', function() {
            $("#universitas").empty().trigger('change')
            if ($(this).val() == "smak" && $('#name').val() != "" && $('#tgl_lahir').val() != ""  && $('input[name=jenis_kelamin]:checked').length > 0   && $('#jarak_user').val() > 0 ) {
                $('#tambah').attr("disabled", false);
            } else {

                $('#tambah').attr("disabled", true);
            }
        });

        $('#universitas').change(function() {
            if ($(this).val() != "" && $('#name').val() != "" && $('#tgl_lahir').val() != ""  && $('input[name=jenis_kelamin]:checked').length > 0 &&  ($('input[name=pend]:checked').val() == 'd3'|| $('input[name=pend]:checked').val() == 's1d4')  ) {
                $('#tambah').attr("disabled", false);
            } else {
                $('#tambah').attr("disabled", true);
            }
        });

        $('#jarak_user').change(function() {
            if ($(this).val() > "0" && $('#name').val() != "" && $('#tgl_lahir').val() != ""  && $('input[name=jenis_kelamin]:checked').length > 0   ) {
                $('#tambah').attr("disabled", false);
            } else {
                $('#tambah').attr("disabled", true);
            }
        });


    })
</script>

@endsection
