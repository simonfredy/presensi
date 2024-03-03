@if ($histori->isEmpty())
    <div class="alert alert-warning alert-outline">
        <p>Data tidak ada</p>
    </div>
@endif

@foreach ($histori as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('upload/absensi/'.$d->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image">
                <div class="in">
                    <div>
                        <strong>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</strong><br>
                        {{-- <small class="text-muted">{{ $d->jabatan }}</small> --}}
                    </div>
                    <span class="badge {{ $d->jam_in < "07:00" ? "bg-success" : "bg-danger" }}">
                        {{ $d->jam_in }}
                    </span>
                    <span class="badge btn-primary">{{ $d->jam_out }}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach
