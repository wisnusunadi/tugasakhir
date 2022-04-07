<table style="border:1px solid #000">
    <thead>
        <tr>
            <th colspan="24" style="text-align:center">
                Laporan Hasil Keputusan
            </th>
        </tr>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Jadwal</th>
            <th rowspan="2">Jabatan</th>
            <th rowspan="2">Divisi</th>
            <th rowspan="2">Tanggal Daftar</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Jenis Kelamin</th>
            <th colspan="3">Usia</th>
            <th colspan="5">Pendidikan</th>
            <th colspan="3">Jarak</th>
            <th colspan="4">Hasil Tes</th>
            <th rowspan="2">Rata-rata</th>
            <th rowspan="2">Keputusan</th>
        </tr>
        <tr>
            <th>Usia</th>
            <th>Bobot</th>
            <th>Rerata</th>
            <th>Pendidikan</th>
            <th>Universitas</th>
            <th>Akreditasi</th>
            <th>Bobot</th>
            <th>Rerata</th>
            <th>Jarak</th>
            <th>Bobot</th>
            <th>Rerata</th>
            <th>Soal</th>
            <th>Nilai</th>
            <th>Bobot</th>
            <th>Rerata</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i)
        <?php
        $usercount = $i->User->count();
        $soalcount = $i->KriteriaStatus('soal')->count();
        if($soalcount <= 0){
            $soalcount = 1;
        }
        $rowspan = $usercount * $soalcount;
        ?>
        <tr>
            <td rowspan="{{$rowspan}}">{{$loop->iteration}}</td>
            <td rowspan="{{$rowspan}}">{{$i->Jadwal->ket}}</td>
            <td rowspan="{{$rowspan}}">{{$i->Jabatan->nama}}</td>
            <td rowspan="{{$rowspan}}">{{$i->Divisi->nama}}</td>
            <?php $cuser = 0; ?>
            @foreach ($i->User as $j)
            @if($cuser <= 0)
                <td rowspan="{{$soalcount}}">{{date('d-m-Y', strtotime($j->created_at))}}</td>
                <td rowspan="{{$soalcount}}">{{$j->nama}}</td>
                <td rowspan="{{$soalcount}}">{{ ucfirst($j->jenis_kelamin) }}</td>
                <td rowspan="{{$soalcount}}">{{ \Carbon\Carbon::parse($j->tgl_lahir)->age }}</td>
                <td rowspan="{{$soalcount}}">
                @if(count($i->KriteriaStatus('usia')) > 0)
                @php
                    echo App\Http\Controllers\GetController::bobot_usia_peserta($j->id);
                @endphp
                @endif
                </td>
                <td rowspan="{{$soalcount}}">
                @if(count($i->KriteriaStatus('usia')) > 0)
                @php
                    echo App\Http\Controllers\GetController::count_usia_peserta($j->id);
                @endphp
                @endif
                </td>
                <td rowspan="{{$soalcount}}">
                @if($j->pend == "smak")
                SMA / SMK
                @elseif($j->pend == "d3")
                D3
                @else
                D4 / S1
                @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if($j->univ_id)
                    {{$j->Universitas->nama}}
                    @else
                    -
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if($j->univ_id)
                    {{$j->Universitas->peringkat}}
                    @else
                    -
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                @if(count($i->KriteriaStatus('pendidikan')) > 0)
                @php
                    echo App\Http\Controllers\GetController::bobot_pend_peserta($j->id);
                @endphp
                @endif
                </td>
                <td rowspan="{{$soalcount}}">
                @if(count($i->KriteriaStatus('pendidikan')) > 0)
                @php
                    echo App\Http\Controllers\GetController::count_pend_peserta($j->id);
                @endphp
                @endif
                </td>
                <td rowspan="{{$soalcount}}">{{$j->jarak}}</td>
                <td rowspan="{{$soalcount}}">
                @if(count($i->KriteriaStatus('jarak')) > 0)
                @php
                    echo App\Http\Controllers\GetController::bobot_jarak_peserta($j->id);
                @endphp
                @endif
                </td>
                <td rowspan="{{$soalcount}}">
                @if(count($i->KriteriaStatus('jarak')) > 0)
                @php
                    echo App\Http\Controllers\GetController::count_jarak_peserta($j->id);
                @endphp
                @endif
                </td>
                <?php $csoal = 0; ?>
                @foreach ($i->KriteriaStatus('soal') as $k)
                    @if($csoal <= 0)
                    <td>{{$k->Soal->nama}}</td>
                    <td>
                        @if(count($i->KriteriaStatus('soal')) > 0)
                            @php
                                echo App\Http\Controllers\GetController::nilai_jawaban($j->id, $k->Soal->id);
                            @endphp
                        @endif
                    </td>
                    <td rowspan="{{$soalcount}}">
                        @if(count($i->KriteriaStatus('soal')) > 0)
                            @php
                                echo App\Http\Controllers\GetController::sum_soal_peserta($j->id);
                            @endphp
                        @endif
                    </td>
                    <td rowspan="{{$soalcount}}">
                        @if(count($i->KriteriaStatus('soal')) > 0)
                            @php
                                echo App\Http\Controllers\GetController::count_soal_peserta($j->id);
                            @endphp
                        @endif
                    </td>
                    <td rowspan="{{$soalcount}}">
                        @if(count($i->Kriteria) > 0)
                            @php
                                echo App\Http\Controllers\GetController::count_all_bobot($j->id);
                            @endphp
                        @endif
                    </td>
                    <td rowspan="{{$soalcount}}" @if(App\Http\Controllers\GetController::get_keputusan_rekruitmen($j->id) == true) style="color: #28a745; font-weight:600;" @elseif(App\Http\Controllers\GetController::get_keputusan_rekruitmen($j->id) == false) style="color: #dc3545; font-weight:600;" @endif>
                        @if(count($i->Kriteria) > 0)
                            @php
                                if(App\Http\Controllers\GetController::get_keputusan_rekruitmen($j->id) == true){
                                    echo "Diterima";
                                } else{
                                    echo "Tidak Diterima";
                                }
                            @endphp
                        @endif
                    </td>
                    @else
                    <tr>
                    <td>{{$k->Soal->nama}}</td>
                    <td>
                        @if(count($i->KriteriaStatus('soal')) > 0)
                            @php
                                echo App\Http\Controllers\GetController::nilai_jawaban($j->id, $k->Soal->id);
                            @endphp
                        @endif
                    </td>
                    @endif
                    </tr>
                <?php $csoal++; ?>
                @endforeach
            @else
                <tr>
                <td rowspan="{{$soalcount}}">{{date('d-m-Y', strtotime($j->created_at))}}</td>
                <td rowspan="{{$soalcount}}">{{$j->nama}}</td>
                <td rowspan="{{$soalcount}}">{{ ucfirst($j->jenis_kelamin) }}</td>
                <td rowspan="{{$soalcount}}">{{ \Carbon\Carbon::parse($j->tgl_lahir)->age }}</td>
                <td rowspan="{{$soalcount}}">
                    @if(count($i->KriteriaStatus('usia')) > 0)
                    @php
                        echo App\Http\Controllers\GetController::bobot_usia_peserta($j->id);
                    @endphp
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if(count($i->KriteriaStatus('usia')) > 0)
                    @php
                        echo App\Http\Controllers\GetController::count_usia_peserta($j->id);
                    @endphp
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                @if($j->pend == "smak")
                SMA / SMK
                @elseif($j->pend == "d3")
                D3
                @else
                D4 / S1
                @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if($j->univ_id)
                    {{$j->Universitas->nama}}
                    @else
                    -
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if($j->univ_id)
                    {{$j->Universitas->peringkat}}
                    @else
                    -
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if(count($i->KriteriaStatus('pendidikan')) > 0)
                    @php
                        echo App\Http\Controllers\GetController::bobot_pend_peserta($j->id);
                    @endphp
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if(count($i->KriteriaStatus('pendidikan')) > 0)
                    @php
                        echo App\Http\Controllers\GetController::count_pend_peserta($j->id);
                    @endphp
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">{{$j->jarak}}</td>
                <td rowspan="{{$soalcount}}">
                    @if(count($i->KriteriaStatus('jarak')) > 0)
                    @php
                        echo App\Http\Controllers\GetController::bobot_jarak_peserta($j->id);
                    @endphp
                    @endif
                </td>
                <td rowspan="{{$soalcount}}">
                    @if(count($i->KriteriaStatus('jarak')) > 0)
                    @php
                        echo App\Http\Controllers\GetController::count_jarak_peserta($j->id);
                    @endphp
                    @endif
                </td>
                <?php $csoal = 0; ?>
                @foreach ($i->KriteriaStatus('soal') as $k)
                    @if($csoal <= 0)
                    <td>{{$k->Soal->nama}}</td>
                    <td>
                    @if(count($i->KriteriaStatus('soal')) > 0)
                        @php
                            echo App\Http\Controllers\GetController::nilai_jawaban($j->id, $k->Soal->id);
                        @endphp
                    @endif
                    </td>
                    <td rowspan="{{$soalcount}}">
                        @if(count($i->KriteriaStatus('soal')) > 0)
                            @php
                                echo App\Http\Controllers\GetController::sum_soal_peserta($j->id);
                            @endphp
                        @endif
                    </td>
                    <td rowspan="{{$soalcount}}">
                    @if(count($i->KriteriaStatus('soal')) > 0)
                        @php
                            echo App\Http\Controllers\GetController::count_soal_peserta($j->id);
                        @endphp
                    @endif
                    </td>
                    <td rowspan="{{$soalcount}}">
                    @if(count($i->Kriteria) > 0)
                        @php
                            echo App\Http\Controllers\GetController::count_all_bobot($j->id);
                        @endphp
                    @endif
                    </td>
                    <td rowspan="{{$soalcount}}" @if(App\Http\Controllers\GetController::get_keputusan_rekruitmen($j->id) == true) style="color: #28a745; font-weight:600;" @elseif(App\Http\Controllers\GetController::get_keputusan_rekruitmen($j->id) == false) style="color: #dc3545; font-weight:600;" @endif>
                    @if(count($i->Kriteria) > 0)
                        @php
                            if(App\Http\Controllers\GetController::get_keputusan_rekruitmen($j->id) == true){
                                echo "Diterima";
                            } else{
                                echo "Tidak Diterima";
                            }
                        @endphp
                    @endif
                    </td>
                    @else
                    <tr>
                    <td>{{$k->Soal->nama}}</td>
                    <td>
                    @if(count($i->KriteriaStatus('soal')) > 0)
                        @php
                            echo App\Http\Controllers\GetController::nilai_jawaban($j->id, $k->Soal->id);
                        @endphp
                    @endif
                    </td>
                    @endif
                    </tr>
                <?php $csoal++; ?>
                @endforeach
            @endif
            <?php $cuser++;?>
            @endforeach
        @endforeach
    </tbody>
</table>
