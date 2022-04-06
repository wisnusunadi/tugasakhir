   @foreach ($data as $s )
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                  {{ $s->nama }}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>{{ $s->kode_soal }}</b></h2>
                      <p class="text-muted text-sm"><b>Jumlah: </b> {{ $s->getJumlahSoal() }} Soal </p>
                      <p class="text-muted text-sm"><b>Jabatan: </b>
                        @foreach($s->Jabatan as $j)
                        {{$j->nama}}
                        @if(!$loop->last)
                        ,
                        @endif
                        @endforeach
                      </p>
                      <p class="text-muted text-sm"><b>Divisi: </b>
                        @foreach($s->Divisi as $d)
                        {{$d->nama}}
                        @if(!$loop->last)
                        ,
                        @endif
                        @endforeach
                      </p>
                      <p class="text-muted text-sm"><b>Waktu Pengerjaan: </b> {{ $s->waktu }} Menit</p>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a href="{{ route('draft_soal.edit',['id' => $s->id]) }}" class="btn btn-sm bg-teal">
                    Edit
                    </a>
                    <a href="{{ route('draft_soal.preview',['id' => $s->id]) }}" class="btn btn-sm btn-primary">
                   Lihat Soal
                    </a>
                    <a data-toggle="modal" class="hapusmodal" data-id="{{$s->id}}" data-label="{{$s->kode_soal}} : {{ $s->nama }}">
                        <button class="btn btn-sm btn-danger" type="button" >
                            Hapus
                        </button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            {!! $data->links() !!}
