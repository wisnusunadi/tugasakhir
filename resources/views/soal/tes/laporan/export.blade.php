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
                <th colspan="2" style="text-align:center">
                Laporan Hasil Tes
                </th>
            </tr>
            <tr>

                <th class="vat">No</th>
                <th>Nama</th>
                <th>Waktu Pengerjaan</th>

            </tr>
                @foreach($data as $d )
                <tr>
                   <td rowspan="{{$d->User->count() + 1}}" style="vertical-align: top;">{{$loop->iteration}}</td>
                   <td><b>{{$d->Jadwal->ket}} - ({{date('d M', strtotime($d->Jadwal->waktu_mulai))}} - {{date('d M Y', strtotime($d->Jadwal->waktu_selesai))}})</b></td>
                </tr>
                @for($i=0;$i<$d->User->count();$i++)
                <tr>
                    <td>{{$d->User[$i]->nama}}</td>
                    <td>
                       @if(($d->User[$i]->UserJawaban->waktu = ''))
                       {{$d->User[$i]->UserJawaban->waktu}}
                       @endif
                    </td>
                 </tr>
                @endfor
            @endforeach
         </thead>
        <tbody>
        </tbody>
    </table>



