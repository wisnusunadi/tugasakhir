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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body aligncenter">
                        <span class="countdown"></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <form action="" id="soalform">
                @csrf
                <div class="card">
                    <div class="card-body">
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
        {{$selesai}}
    </div>
</section>
@endsection

@section('script')
<script>
  var timer2 = "60:01";
  var interval = setInterval(function() {


  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $('.countdown').html(minutes + ':' + seconds);
  if (minutes < 0) clearInterval(interval);
  //check if both minutes and seconds are 0
  if ((seconds <= 0) && (minutes <= 0)) clearInterval(interval);
  timer2 = minutes + ':' + seconds;
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
            // document.getElementById("nextBtn").type = "submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Berikutnya";
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
            // ... the form gets submitted:
            document.getElementById("soalform").submit();
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
            document.getElementById("soalform").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }
</script>
@endsection
