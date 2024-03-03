<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Beranda</strong>
        </div>
    </a>
    <a href="/presensi/histori" class="item {{ request()->is('presensi/histori') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline"></ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
    <a href="/presensi/create" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/presensi/izin" class="item {{ request()->is('presensi/izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="/editprofile" class="item {{ request()->is('editprofile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline"></ion-icon>
            <strong>Profil</strong>
        </div>
    </a>
</div>
