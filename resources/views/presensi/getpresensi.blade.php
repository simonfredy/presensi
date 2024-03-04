@foreach ($presensi as $d)
@php
    $foto_in = Storage::url('upload/absensi/' . $d->foto_in);
    $foto_out = Storage::url('upload/absensi/' . $d->foto_out);
@endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nik }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->nama_dept }}</td>
        <td>{{ $d->jam_in }}</td>
        <td>
            <img src="{{ url($foto_in) }}" class="avatar" alt="Foto Masuk">
        </td>
        <td>{!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger">Belum Presensi Pulang</span>' !!}</td>
        <td>
            @if ($d->jam_out != null)
                <img src="{{ url($foto_out) }}" class="avatar" alt="Foto Masuk">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hourglass" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.5 7h11" /><path d="M6.5 17h11" /><path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" /><path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" /></svg>
            @endif
        </td>
        <td>
            @if ($d->jam_in >= '07:00')
                <span class="badge bg-danger">Terlambat</span>
            @else
                <span class="badge bg-success">Tepat Waktu</span>
            @endif
        </td>
    </tr>
@endforeach
