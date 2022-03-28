<style>
    .va {
      vertical-align: bottom;
    }
    .vat {
      vertical-align: top;
    }
    </style>
    <table border="1">
        <thead>
            <tr>
                <th colspan="9" style="text-align:center">
                Laporan Hasil Tes
                </th>
            </tr>
            <tr>

                <th colspan="3" ></th>
                <th colspan="6"  style="text-align:center" >Total</th>
            </tr>
            <tr>
                <th class="vat">No</th>
                <th>Nama</th>
                <th>Tanggal Pengerjaan</th>
                <th>Waktu Pengerjaan</th>
                <th>Jumlah</th>
                <th>Benar</th>
                <th>Salah</th>
                <th>Kosong</th>
                <th>Nilai</th>

            </tr>
                @foreach($data as $d )
                <tr>
                    <td></td>
                   <td><b>{{$d->Jadwal->ket}} - ({{date('d M', strtotime($d->Jadwal->waktu_mulai))}} - {{date('d M Y', strtotime($d->Jadwal->waktu_selesai))}})</b></td>
                </tr>
                @for($i=0;$i<$d->User->count();$i++)
                <tr>
                    <td  style="text-align:center">{{$i + 1}}</td>
                    <td >{{$d->User[$i]->nama}}</td>
                    <td >
                        @if(count($d->User[$i]->UserJawaban) > 0)
                       @foreach ( $d->User[$i]->UserJawaban as $uj )
                       {{date('d M Y', strtotime($uj->tanggal))}}
                       @endforeach
                        @endif
                     </td>
                    <td  style="text-align:center">
                       @if(count($d->User[$i]->UserJawaban) > 0)
                      @foreach ( $d->User[$i]->UserJawaban as $uj )
                      {{$uj->waktu}}
                      @endforeach
                       @endif
                    </td>
                    <td  style="text-align:center">
                       @if(count($d->User[$i]->UserJawaban) > 0)
                      @foreach ( $d->User[$i]->UserJawaban as $uj )
                      {{$uj->DetailUserJawaban->first()->Jawaban->SoalDetail->Soal->getJumlahSoal()}}
                      @endforeach
                       @endif
                    </td>
                    <td  style="text-align:center">
                      @php $q = 0 @endphp
                       @if(count($d->User[$i]->UserJawaban) > 0)
                            @foreach ( $d->User[$i]->UserJawaban as $uj )
                                    @foreach ($uj->DetailUserJawaban as $j)
                                        @if ($j->Jawaban->status == 1)
                                            @php $q++ @endphp
                                        @endif
                                    @endforeach
                                    {{$q}}
                            @endforeach

                       @endif
                    </td>
                    <td  style="text-align:center">
                      @php $q = 0 @endphp
                       @if(count($d->User[$i]->UserJawaban) > 0)
                            @foreach ( $d->User[$i]->UserJawaban as $uj )
                                    @foreach ($uj->DetailUserJawaban as $j)
                                        @if ($j->Jawaban->status == 0)
                                            @php $q++ @endphp
                                        @endif
                                    @endforeach
                                    {{$q}}
                            @endforeach

                       @endif
                    </td>
                    <td  style="text-align:center">
                      @php $q = 0  @endphp
                      @php $p = 0  @endphp
                       @if(count($d->User[$i]->UserJawaban) > 0)
                            @foreach ( $d->User[$i]->UserJawaban as $uj )
                                    @foreach ($uj->DetailUserJawaban as $j)
                                        @if ($j->Jawaban->status == 0)
                                            @php $q++ @endphp
                                        @elseif ($j->Jawaban->status == 1)
                                            @php $p++ @endphp
                                        @endif
                                    @endforeach
                                    {{$uj->DetailUserJawaban->first()->Jawaban->SoalDetail->Soal->getJumlahSoal() - ($p + $q)}}
                            @endforeach

                       @endif
                    </td>
                    <td  style="text-align:center">
                        @php $q = 0 @endphp
                         @if(count($d->User[$i]->UserJawaban) > 0)
                              @foreach ( $d->User[$i]->UserJawaban as $uj )
                                      @foreach ($uj->DetailUserJawaban as $j)
                                          @if ($j->Jawaban->status == 1)
                                              @php $q+= $j->jawaban->soaldetail->bobot @endphp
                                          @endif
                                      @endforeach
                                      {{$q}}
                              @endforeach

                         @endif
                      </td>
                 </tr>
                @endfor
            @endforeach
         </thead>
        <tbody>
        </tbody>
    </table>



