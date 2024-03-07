<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Presensi {{ $karyawan->nama_lengkap }}</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    @page {
        size: A4
    }
    h3 {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0px;
    }
    .tabeldatakaryawan {
        margin-top: 40px
    }
    .tabeldatakaryawan td {
        padding: 5px
    }
    .fotoprofil {
        width: 150px;
        height: 150px;
    }
    .tabelpresensi {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px
    }
    .tabelpresensi tr th{
        border: 1px solid #000000;
        padding: 8px;
        background: #DBDBDB;
    }
    .tabelpresensi tr td{
        border: 1px solid #000000;
        padding: 5px;
        font-size: 14px;
    }
    .fotopresensi {
        width: 80px;
        height: 80px;
    }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        list($h, $m, $s) = explode(":", $jam_masuk);
        $dtAwal = mktime($h, $m, $s, "1", "1", "1");
        list($h, $m, $s) = explode(":", $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode(".", $totalmenit / 60);
        $sisamenit = ($totalmenit / 60) - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ":" . round($sisamenit2);
    }
    ?>

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%">
        <tr>
            <td style="width: 30px">
                <img src="{{ asset("assets/img/logorsbm.png") }}" width="70" height="70" alt="Logo RSBM">
            </td>
            <td>
                <h3 style="margin-left: 13px">RS. BHAYANGKARA MEDAN</h3>
                <span style="margin-left: 13px">Jl. K.H. Wahid Hasyim No.1 Medan</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <h3 style="text-align: center">LAPORAN PRESENSI PERIODE {{ Str::upper($namabulan[$bulan]) }} {{ $tahun }}</h3>
            </td>
        </tr>
    </table>
    <table class="tabeldatakaryawan">
        <tr>
            <td rowspan="6">
                @php
                    $path = Storage::url('upload/karyawan/' . $karyawan->foto);
                @endphp
                <img src="{{ url($path) }}" class="fotoprofil" alt="Foto Profil">
            </td>
        </tr>
        <tr>
            <td>NIP/NRP</td>
            <td>:</td>
            <td>{{ $karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Nama Karyawan</td>
            <td>:</td>
            <td>{{ $karyawan->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $karyawan->jabatan }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>:</td>
            <td>{{ $karyawan->nama_dept }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>:</td>
            <td>{{ $karyawan->no_hp }}</td>
        </tr>
    </table>
    <table class="tabelpresensi">
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Foto Masuk</th>
            <th>Jam Pulang</th>
            <th>Foto Pulang</th>
            <th>Keterangan</th>
            <th>Total Jam</th>
        </tr>
        @foreach ($presensi as $d)
        @php
            $path_in = Storage::url('upload/absensi/' . $d->foto_in);
            $path_out = Storage::url('upload/absensi/' . $d->foto_out);
            $jamterlambat = selisih('07:30:00', $d->jam_in);
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
            <td>{{ $d->jam_in }}</td>
            <td><img src="{{ url($path_in) }}" alt="Foto Masuk" class="fotopresensi"></td>
            <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Presensi' }}</td>
            <td>
                @if ($d->jam_out != null)
                    <img src="{{ url($path_out) }}" alt="Foto Keluar" class="fotopresensi">
                @else
                    Belum Foto Pulang
                @endif

            </td>
            <td>
                @if ($d->jam_in > '07:30')
                    Terlambat {{ $jamterlambat }}
                @else
                    Tepat Waktu
                @endif
            </td>
            <td>
                @if ($d->jam_out != null)
                    @php
                        $jmljamkerja = selisih($d->jam_in, $d->jam_out);
                    @endphp
                @else
                    @php
                        $jmljamkerja = 0;
                    @endphp
                @endif
                {{ $jmljamkerja }}
            </td>
        </tr>
        @endforeach
    </table>
    <table width="100%" style="margin-top: 100px">
        <tr>
            <td colspan="2" style="text-align: right">Medan, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: bottom" height="100px">
                <u><strong>RONNIDA NABABAN</strong></u><br>
                KAURMIN
            </td>
            <td style="text-align: center; vertical-align: bottom">
                <u><strong>dr. S.N. IMANTA TARIGAN, Sp.PK</strong></u><br>
                KEPALA RUMAH SAKIT
            </td>
        </tr>
    </table>
  </section>

</body>

</html>
