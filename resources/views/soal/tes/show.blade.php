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
    background: rgb(40, 167, 69);
  color: #fff;
}

#navigation li.active a {
    background: rgba(23, 23, 24, 0.844);
  color: #fff;
}
.thankyou-page ._header {
    background: rgb(40, 167, 69);
    padding: 30px 30px;
    text-align: center;
    background:rgb(40, 167, 69); url(https://codexcourier.com/images/main_page.jpg) center/cover no-repeat;
}
.thankyou-page ._header .logo {
    max-width: 100px;
    margin: 0 auto 50px;
}
.thankyou-page ._header .logo img {
    width: 100%;
}
.thankyou-page ._header h4 {
    font-size: 20px;
    font-weight: 800;
    color: black;
    margin: 0;
}
.thankyou-page ._body {
    margin: -70px 0 30px;
}
.thankyou-page ._body ._box {
    margin: auto;
    max-width: 80%;
    padding: 50px;
    background: white;
    border-radius: 3px;
    box-shadow: 0 0 35px rgba(10, 10, 10,0.12);
    -moz-box-shadow: 0 0 35px rgba(10, 10, 10,0.12);
    -webkit-box-shadow: 0 0 35px rgba(10, 10, 10,0.12);
}
.thankyou-page ._body ._box h2 {
    font-size: 32px;
    font-weight: 600;
    color: #4ab74a;
}
.thankyou-page ._footer {
    text-align: center;
    padding: 10px 30px;
}


</style>
@stop

@section('content')

<section class="content-wrapper">
    <div class="content-header">
        <h1 class="content-title">Soal Tes</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <button type="button" class="btn btn-lg btn-primary" disabled> <i class="fa-solid fa-stopwatch"></i>
                    <div align="center" id="timer" class="form-inline "></div>
                </button>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="progress d-none" id="last" >
                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="80"></div>
                    <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="20"></div>
                </div>

                <div class="progress" id="blips">
                    <div class="progress-bar bg-success " role="progressbar" >
                      <span class="sr-only"></span>
                    </div>
                  </div>
                  {{-- action="{{route('soal_tes.store')}}"  --}}
                <form id="soalform" method="POST" action="{{route('soal_tes.store')}}">
                    {{csrf_field()}}
                <div class="card">
                    <div class="card-body">
                       <input type="hidden" name="user" value="{{Auth::user()->id}}">
                    <?php $soal = 0; ?>
                    @foreach($soals as $s)
                    <div class="tab">
                        <table class="table" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td>{{$loop->iteration}}. {{$s->deskripsi}}</td>
                                </tr>
                                <tr hidden>
                                    <td><input type="hidden" name="soal[{{$soal}}]" value="{{$s->id}}"></td>
                                </tr>
                                <?php $jawaban = 0; ?>
                                @foreach($s->Jawaban->shuffle() as $j)
                                <tr>
                                <td><div class="form-check">
                                            <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[{{$soal}}]" id="jawaban_id{{$soal}}{{$jawaban}}" value="{{$j->id}}">
                                            <label class="form-check-label" for="jawaban_id{{$soal}}{{$jawaban}}">
                                                {{$j->jawaban}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php $jawaban++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <?php $soal++; ?>
                    @endforeach
                    <div class="tab">
                        <div class="thankyou-page">
                            <div class="_header">
                                <div class="logo">
                                    <img src="https://codexcourier.com/images/banner-logo.png" alt="">
                                </div>
                                <h4><i class="fa fa-check-circle" aria-hidden="true"></i>
                                    Tes selesai</h4>
                            </div>
                            <div class="_body">
                                <div class="_box">
                                    <h4>
                                        <strong>Perhatian ! </strong>
                                    </h4>
                                    <p>
                                      Periksa kembali jawaban anda, jawaban akan sangat mempengaruhi penilaian anda. Pilih  <strong>Kirim </strong> untuk mengirim jawaban dan  <strong>Batal </strong> untuk memeriksa jawaban anda
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- <div class="tab">
                        <table class="table" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td>1. Antonim dari kata Indah Adalah</td>
                                </tr>
                                <tr hidden>
                                    <td><input type="hidden" name="soal[0]" value=""></td>
                                </tr>
                                <tr>
                                <td><div class="form-check">
                                            <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[0]" id="jawaban_id00" value="baik">
                                            <label class="form-check-label" for="jawaban_id00">
                                                Baik
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check">
                                            <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[0]" id="jawaban_id01" value="bagus">
                                            <label class="form-check-label" for="jawaban_id01">
                                                Bagus
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div class="form-check">
                                        <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[0]" id="jawaban_id02" value="baik">
                                        <label class="form-check-label" for="jawaban_id02">
                                            Jelek
                                        </label>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div class="form-check">
                                        <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[0]" id="jawaban_id03" value="baik">
                                        <label class="form-check-label" for="jawaban_id03">
                                            Buruk
                                        </label>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                    <!-- <div class="tab">
                        <table class="table" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td>2. Sinonim dari kata Dermawan Adalah</td>
                                </tr>
                                <tr hidden>
                                    <td><input type="hidden" name="soal[1]" value=""></td>
                                </tr>
                                <tr>
                                <td><div class="form-check">
                                            <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[1]" id="jawaban_id10" value="baik">
                                            <label class="form-check-label" for="jawaban_id10">
                                                Ringan Tangan
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check">
                                            <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[1]" id="jawaban_id11" value="penolong">
                                            <label class="form-check-label" for="jawaban_id11">
                                                Penolong
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div class="form-check">
                                        <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[1]" id="jawaban_id12" value="kikir">
                                        <label class="form-check-label" for="jawaban_id12">
                                            Kikir
                                        </label>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div class="form-check">
                                        <input class="form-check-input jawaban_id" type="radio" name="jawaban_id[1]" id="jawaban_id13" value="serakah">
                                        <label class="form-check-label" for="jawaban_id13">
                                            Serakah
                                        </label>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                    <div style="overflow:auto;">
                        <div>
                        <button type="button" style="float:left;" class="btn btn-warning" id="prevBtn" onclick="nextPrev(-1)">Kembali</button>
                        <button type="button" style="float:right;" class="btn btn-info" id="nextBtn" onclick="nextPrev(1)">Berikutnya</button>
                        </div>
                    </div>
                    <!-- Circles which indicates the steps of the form: -->
                    <!-- <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div> -->
                    </div>
                </div>
                @if (session()->has('waktu'))
                <input value="{{session()->get('waktu')}}" type="text" id="session_time" class="d-none" >
                @else
                <input value="00:00:00" type="text" id="session_time" class="d-none">
                 @endif
                </form>
                <div class="card">
                    <div class="card-body">
                        <h4 class="content-title">Navigasi</h4>
                        <nav aria-label="...">
                            <ul class="pagination flex-wrap" id="navigation">
                                <?php for($i=0;$i<count($soals);$i++) {?>
                                    @if ($i == 0)
                                        <li class="page-item active" id="page{{ $i }}"><a class="page-link" onclick="navigate({{ $i }})">{{ $i+1 }}</a></li>
                                    @else
                                        <li class="page-item " id="page{{ $i }}"><a class="page-link" onclick="navigate({{ $i }})">{{ $i+1 }}</a></li>
                                    @endif
                              <?php }?>
                            </ul>
                          </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Modal -->
    <div class="modal fade" id="rule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{url('assets/image/attention.png')}}" class="rounded float-start" style=" width: 150px;">
              Perhatian :
              <table>
                  <tr>
                  <td class="vera">1. </td>
                  <td class="vera">Harap cek jawaban anda kembali</td>
                  </tr>
                  <tr>
                  <td class="vera">2. </td>
                  <td class="vera">Tes tidak bisa di ulangi</td>
                  </tr>
              </table>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cek kembali</button>
              <button id="accept" class="btn btn-sm btn-primary" >
                Baik, kirim jawaban
              </button>

            </div>
          </div>
            </div>
      </div>
@endsection

@section('script')
<script>


let text = document.getElementById("session_time").value;
const myArray = text.split(":");
let jam = myArray[0];
let menit = myArray[1];
let detik = myArray[2];

var end = new Date();
end.setHours(jam);
end.setMinutes(menit);
end.setSeconds(detik);



function timePart(val,text,color="black"){
 return `${val}${text}`
}

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = end - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
 var seconds = Math.floor((distance % (1000 * 60)) / 1000);

 // Display the result in the element with id="demo"


 let res = timePart(hours,':') + timePart(minutes,':')  + timePart(seconds,'','red');
document.getElementById("timer").innerHTML = res

  // If the count down is finished, write some text
 if (distance < 0) {
    clearInterval(x);
    $('#soalform').submit();
document.getElementById("timer").innerHTML = "Tes Selesai";
  }
}, 1000);
</script>

<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab


    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        // document.getElementById("nextBtn").type = "button";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {

            document.getElementById("nextBtn").innerHTML = "Kirim";
            $('#nextBtn').attr("onclick","modal()");
            $("#last").removeClass("d-none");
            $("#blips").addClass("d-none");

            // document.getElementById("nextBtn").type = "submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Berikutnya";
           $('#nextBtn').attr("onclick","nextPrev(1)");
           $("#last").addClass("d-none");
            $("#blips").removeClass("d-none");

        }
        //... and run a function that will display the correct step indicator:
        // fixStepIndicator(n)

    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = $("input[name='jawaban_id["+currentTab+"]']:checked").val();

        // A loop that checks every input field in the current tab:
        if($("input[name='jawaban_id["+currentTab+"]']:checked").val() === "" || $("input[name='jawaban_id["+currentTab+"]']:checked").val() === undefined){
            $("input[name='jawaban_id["+currentTab+"]']").addClass('is-invalid');
            valid = false;
        }else{
            $("input[name='jawaban_id["+currentTab+"]']").removeClass('is-invalid');
            $('#page'+currentTab).removeClass("active");
            $('#page'+currentTab).addClass("answer");
        }
        // for (i = 0; i < y.length; i++) {
        //     // If a field is empty...
        //     if (y[i].value == "") {
        //     // add an "invalid" class to the field:
        //     y[i].className += " invalid";
        //     // and set the current valid status to false
        //     valid = false;
        //     }
        // }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            // document.getElementsByClassName("step")[currentTab].className += "finish";
        }
        return valid; // return the valid status
    }

    // function fixStepIndicator(n) {
    //     // This function removes the "active" class of all steps...
    //     var i, x = document.getElementsByClassName("step");
    //     for (i = 0; i < x.length; i++) {
    //         x[i].className = x[i].className.replace("active", "");
    //     }
    //     //... and adds the "active" class on the current step:
    //     x[n].className += " active";
    // }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        if(n == -1){
            $('#page'+currentTab).removeClass("active");
            if($("input[name='jawaban_id["+currentTab+"]']:checked").val() !== undefined){
                $('#page'+currentTab).addClass("answer");
            }
        }
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        $('#page'+currentTab).removeClass("answer");
        $('#page'+currentTab).addClass("active");
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            //alert('ok');
            // ... the form gets submitted:
          //  document.getElementById("soalform").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);


    }

    function navigate(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (!validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:


        currentTab = n;
        $('#page'+currentTab).removeClass("answer");
        $('#page'+currentTab).addClass("active");
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:

           // document.getElementById("soalform").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);





    }

</script>
<script>

function modal(){
    $('#rule').modal("show");

    $('#accept').click(function(){
    $('#soalform').submit();
});
}
var unsaved = false;
        // $("#soalform").addEventListener('input', function(e){
        //     if(somethingChanged)
        //         alert("You made some changes and it's not saved?");
        //     else
        //         e=null; // i.e; if form state change show warning box, else don't show it.
        // });

const beforeUnloadListener = (event) => {
  event.preventDefault();
  return event.returnValue = "Are you sure you want to exit?";
};
document.querySelector(".jawaban_id").addEventListener('input', (event) =>{
        if (event.target.value !== "") {
            // if(somethingChanged){
                addEventListener("beforeunload", beforeUnloadListener, {capture: true});
                alert("You made some changes and it's not saved?");
            // }
        } else {
                removeEventListener("beforeunload", beforeUnloadListener, {capture: true});
            } // i.e; if form state change show warning box, else don't show it.
    });
// const nameInput = document.querySelector("#soalform");

// nameInput.addEventListener("input", (event) => {
//   if (event.target.value !== "") {
//     addEventListener("beforeunload", beforeUnloadListener, {capture: true});
//   } else {
//     removeEventListener("beforeunload", beforeUnloadListener, {capture: true});
//   }
// });

 $(".jawaban_id").change(function(){
     unsaved = true;
     console.log(unsaved);
        countjawaban();
    });

function countjawaban(){
    var score = 0;
    var total= {{$parent->getJumlahSoal()}};
    $(".jawaban_id:checked").each(function(){
        $('#blips > .progress-bar').attr("style","width:" + (score+=1/total)*80 + "%");
    });
  console.log(score)
}





</script>
@endsection
