<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Rekap Presensi</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    @page {
        size: legal
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
        font-size: 10px;
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
<body class="legal landscape">
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
                <h3 style="text-align: center;">REKAP PRESENSI PERIODE {{ Str::upper($namabulan[$bulan]) }} {{ $tahun }}</h3>
            </td>
        </tr>
    </table>

    <table class="tabelpresensi">
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">Nama</th>
            <th colspan="31">Tanggal</th>
            <th rowspan="2">Total <br>Hadir</th>
            <th rowspan="2">Total <br>Telat</th>
        </tr>
        <tr>
            <?php
            for($i = 1; $i <= 31; $i++)
            {
            ?>
                <th>{{ $i }}</th>
            <?php
            }
            ?>
        </tr>
        @foreach ($rekap as $d)
        <tr>
            <td style="text-align:center">{{ $loop->iteration }}</td>
            <td>{{ $d->nama_lengkap }}</td>

            <?php
            $totalhadir = 0;
            $totalterlambat = 0;
            for($i = 1; $i <= 31; $i++)
            {
                $tgl = "tgl_" . $i;
                if(empty($d->$tgl))
                {
                    $hadir = ['',''];
                    $totalhadir += 0;
                }
                else
                {
                    $hadir = explode("-",$d->$tgl);
                    $totalhadir += 1;
                    if($hadir[0] > "07:30:00")
                    {
                        $totalterlambat += 1;
                    }
                }
            ?>

                <td>
                    <span style="color:{{ $hadir[0] > "07:30:00" ? "red" : "" }}">{{ $hadir[0] }} </span><br>
                    <span style="color:{{ $hadir[1] < "15:00:00" ? "red" : "" }}">{{ $hadir[0] }} </span><br>

                </td>
            <?php
            }
            ?>
            <td style="text-align:center">{{ $totalhadir }}</td>
            <td style="text-align:center">{{ $totalterlambat }}</td>
        </tr>
        @endforeach
    </table>

    <table width="100%" style="margin-top: 100px">
        <tr>
            <td></td>
            <td style="text-align: center">Medan, {{ date('d-m-Y') }}</td>
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
