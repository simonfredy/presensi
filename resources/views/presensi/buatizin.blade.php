@extends('layouts.presensi');
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 430px !important;
    }
    .datepicker-date-display{
        background-color: #1E74FD !important;
    }
    .datepicker-done, .datepicker-cancel{
        color: #1E74FD !important;
    }
</style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Pengajuan Izin</div>
    <div class="right"></div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top:50px">
    <div class="col">
        <form action="/presensi/storeizin" method="post" id="frmIzin">
            @csrf
            <div class="form-group">
                <input type="text" name="tgl_izin" id="tgl_izin" class="form-control datepicker" placeholder="Tanggal">
            </div>
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value="">Status Izin/Sakit</option>
                    <option value="i">Izin</option>
                    <option value="s">Sakit</option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="5" placeholder="Keterangan/Alasan Izin"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();
    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"
        });
        $("#frmIzin").submit(function(){
            var tgl_izin = $("#tgl_izin").val();
            var status = $("#status").val();
            var keterangan = $("#keterangan").val();
            if(tgl_izin == "") {
                Swal.fire({
                    title: 'Peringatan',
                    text: "Tanggal harus diisi",
                    icon: 'warning'
                })
                return false;
            }else if(status == "") {
                Swal.fire({
                    title: 'Peringatan',
                    text: "Status harus dipilih",
                    icon: 'warning'
                })
                return false;
            }else if(keterangan == "") {
                Swal.fire({
                    title: 'Peringatan',
                    text: "Keterangan harus diisi",
                    icon: 'warning'
                })
                return false;
            }
        });
    });
</script>
@endpush
