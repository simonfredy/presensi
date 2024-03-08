@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Halaman
          </div>
          <h2 class="page-title">
            Laporan Personel
          </h2>
        </div>
      </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card card-body">
                    <form action="/presensi/cetaklaporan" id="frmLaporan" target="_blank" method="post">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="bulan" id="bulan" class="form-select">
                                        <option value="">Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ date("m") == $i ? 'selected' : '' }}>{{ $namabulan[$i] }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="tahun" id="tahun" class="form-select">
                                        <option value="">Tahun</option>
                                        @php
                                            $tahunmulai = 2022;
                                            $tahunsekarang = date("Y");
                                        @endphp
                                        @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                                            <option value="{{ $tahun }}" {{ date("Y") == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="nik" id="nik" class="form-select">
                                        <option value="">Pilih Personel</option>
                                        @foreach ($karyawan as $d)
                                            <option value="{{ $d->nik }}">{{ $d->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                                        Cetak
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" name="exportexcel" class="btn btn-success w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg>
                                        Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@push('myscript')
<script>
    $(function({
        $("#frmLaporan").submit(function(e){
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();
            var nik = $("#nik").val();
            if(bulan== "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Bulan Harus Dipilih',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya paham'
                }).then((result) => {
                    $("#bulan").focus();
                });
                return false;
            } else if(tahun == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Tahun Harus Dipilih',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya paham'
                }).then((result) => {
                    $("#tahun").focus();
                });
                return false;
            } else if(nik == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Personel Belum Dipilih',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya paham'
                }).then((result) => {
                    $("#nik").focus();
                });
                return false;
            }
        });
    }));
</script>
@endpush
