<form action="/cabang/update" method="POST" id="frmCabangEdit">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
                </span>
                <input type="text" value="{{ $cabang->kode_cabang }}" readonly class="form-control" id="kode_cabang" name="kode_cabang" placeholder="Kode Lokasi Presensi">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </span>
                <input type="text" value="{{ $cabang->nama_cabang }}" class="form-control" id="nama_cabang" name="nama_cabang" placeholder="Nama Lokasi Presensi">
              </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 -3l6 3l6 -3v13l-6 3l-6 -3l-6 3v-13" /><path d="M9 4v13" /><path d="M15 7v13" /></svg>
                </span>
                <input type="text" value="{{ $cabang->lokasi_cabang }}" class="form-control" id="lokasi_cabang" name="lokasi_cabang" placeholder="Koordinat Lokasi Presensi">
              </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-radar-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15.51 15.56a5 5 0 1 0 -3.51 1.44" /><path d="M18.832 17.86a9 9 0 1 0 -6.832 3.14" /><path d="M12 12v9" /></svg>
                </span>
                <input type="text" value="{{ $cabang->radius_cabang }}" class="form-control" id="radius_cabang" name="radius_cabang" placeholder="Radius(Meter)">
              </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $("#frmCabangEdit").submit(function() {
            var kode_cabang = $("#frmCabangEdit").find("#kode_cabang").val();
            var nama_cabang = $("#frmCabangEdit").find("#nama_cabang").val();
            var lokasi_cabang = $("#frmCabangEdit").find("#lokasi_cabang").val();
            var radius_cabang = $("#frmCabangEdit").find("#radius_cabang").val();

            if(kode_cabang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Kode Lokasi Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya paham'
                }).then((result) => {
                    $("#nik").focus();
                });
                return false;
            } else if(nama_cabang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Lokasi Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya paham'
                }).then((result) => {
                    $("#nama_cabang").focus();
                });
                return false;
            } else if(lokasi_cabang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Koordinat Lokasi Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya paham'
                }).then((result) => {
                    $("#lokasi_cabang").focus();
                });
                return false;
            } else if(radius_cabang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Radius Lokasi Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya paham'
                }).then((result) => {
                    $("#radius_cabang").focus();
                });
                return false;
            }
        });
    })
</script>
