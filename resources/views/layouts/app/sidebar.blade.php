<div class="page-sidebar">
    <ul class="list-unstyled accordion-menu">
        <li class="sidebar-title">
            Menu Utama
        </li>
        <li class="{{ request()->routeIs('dashboard*') ? 'active-page' : '' }}">
            <a href="{{ route('dashboard') }}"><i data-feather="home"></i>Dashboard</a>
        </li>
        <li class="{{ request()->routeIs('billing*') ? 'active-page' : '' }}">
            <a href="#"><i data-feather="dollar-sign"></i>Tagihan saya</a>
        </li>

        <li class="{{ request()->routeIs('data/*') ? 'active-page' : '' }}">
            <a href="#">
                <i data-feather="star"></i>Kelengkapan Data<i class="fas fa-chevron-right dropdown-icon"></i>
            </a>
            <ul class="">
                <li><a href="#"><i class="far fa-circle"></i>Data Pribadi</a></li>
                <li><a href="#"><i class="far fa-circle"></i>Data Orang Tua</a></li>
                <li><a href="#"><i class="far fa-circle"></i>Asal Sekolah</a></li>
                <li><a href="#"><i class="far fa-circle"></i>Berkas & Dokumen</a></li>
                <li><a href="#"><i class="far fa-circle"></i>Prestasi</a></li>
            </ul>
        </li>

        <li class="sidebar-title">
            Cetak Berkas
        </li>
        <li>
            <a href="#"><i data-feather="printer"></i>Cetak Formulir</a>
        </li>
        <li>
            <a href="#"><i data-feather="printer"></i>Cetak Kartu</a>
        </li>
        <li class="sidebar-title">
            Pengumuman
        </li>
        <li>
            <a href="#"><i data-feather="book-open"></i>Pengumuman</a>
        </li>
    </ul>
</div>