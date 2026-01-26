@extends('layouts.app.base')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="profile-cover" style="background-image: url('{{ asset('assets/images/profile-bg.jpg') }}'); background-position: bottom; background-repeat: no-repeat; object-fit: cover;"></div>
        <div class="profile-header">
            <div class="profile-img">
                <img src="{{ asset('assets/images/blank-profile.png') }}" alt="">
            </div>
            <div class="profile-name">
                <h3>{{ auth()->user()->name }}</h3>
            </div>
            <div class="profile-header-menu d-none d-xl-block">
                <ul class="list-unstyled">
                    <li><a href="{{ route('invoices.list') }}">Tagihan</a></li>
                    <li><a href="#">Data Pribadi</a></li>
                    <li><a href="#">Cetak Formulir</a></li>
                    <li><a href="#">Cetak Kartu</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-4 order-2 order-lg-1">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informasi Pendaftaran</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Nomor Pendaftaran
                        <span class="badge bg-light text-dark rounded-pill">{{ $onboarding->registration_number ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Jalur Pendaftaran
                        <span class="badge bg-light text-dark rounded-pill">{{ $onboarding->initialPath->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tanggal Pendaftaran
                        <span class="badge bg-light text-dark rounded-pill">{{ $onboarding->created_at->translatedFormat('d F Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Nomor Ujian
                        <span class="badge bg-light text-dark rounded-pill">A-001</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Status Pendaftaran</h5>
                <div class="transactions-list">
                    <div class="tr-item">
                        <div class="tr-company-name">
                            <div class="tr-icon tr-card-icon tr-card-bg-success text-dark">
                                <i data-feather="check"></i>
                            </div>
                            <div class="tr-text">
                                <h4>Pembayaran Pendaftaran</h4>
                                <span class="badge bg-success">Lunas</span>
                                <span class="badge border border-success text-dark">QRIS</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transactions-list">
                    <div class="tr-item">
                        <div class="tr-company-name">
                            <div class="tr-icon tr-card-icon tr-card-bg-success text-dark">
                                <i data-feather="check"></i>
                            </div>
                            <div class="tr-text">
                                <h4>Data Pribadi</h4>
                                <span class="badge bg-success">Disetujui</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transactions-list">
                    <div class="tr-item">
                        <div class="tr-company-name">
                            <div class="tr-icon tr-card-icon tr-card-bg-warning text-dark">
                                <i data-feather="clock"></i>
                            </div>
                            <div class="tr-text">
                                <h4>Data Orang Tua</h4>
                                <span class="badge bg-warning">Menunggu</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transactions-list">
                    <div class="tr-item">
                        <div class="tr-company-name">
                            <div class="tr-icon tr-card-icon tr-card-bg-danger text-dark">
                                <i data-feather="x-square"></i>
                            </div>
                            <div class="tr-text">
                                <h4>Data Asal Sekolah</h4>
                                <span class="badge bg-danger">Butuh Perbaikan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transactions-list">
                    <div class="tr-item">
                        <div class="tr-company-name">
                            <div class="tr-icon tr-card-icon tr-card-bg-danger text-dark">
                                <i data-feather="x-square"></i>
                            </div>
                            <div class="tr-text">
                                <h4>Upload Berkas & Dokumen</h4>
                                <span class="badge bg-danger">Butuh Perbaikan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transactions-list">
                    <div class="tr-item">
                        <div class="tr-company-name">
                            <div class="tr-icon tr-card-icon tr-card-bg-info text-dark">
                                <i data-feather="award"></i>
                            </div>
                            <div class="tr-text">
                                <h4>Prestasi</h4>
                                <span class="badge bg-info">0 Prestasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Contact Info</h5>
                <ul class="list-unstyled profile-about-list">
                    <li><i class="far fa-envelope m-r-xxs"></i><span>psb@ruhulislam.com</span></li>
                    <li><i class="far fa-compass m-r-xxs"></i><span>Jalan Pintu Air, Desa Gue Gajah, Aceh Besar</span>
                    </li>
                    <li><i class="far fa-address-book m-r-xxs"></i><span>+62 812-3456-7890</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-8 order-1 order-lg-2">
        {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Butuh Perbaikan!</strong> Segera lengkapi dan perbaiki data pendaftaran Anda agar dapat melanjutkan ke tahap berikutnya.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Timeline Pendaftaran</h5>
                <ul class="timeline">
                @foreach ($timeline as $item)
                    <li class="status-{{ $item['status'] }}">
                        <div class="fw-semibold fs-5">
                            {{ $item['label'] }}
                        </div>
                        <div class="float-right text-muted">
                            {{ \Carbon\Carbon::parse($item['start_at'])->translatedFormat('d M Y') }}
                            –
                            {{ \Carbon\Carbon::parse($item['end_at'])->translatedFormat('d M Y') }}
                        </div>
                        <p class="mb-0 text-muted">
                            <code>{{ $item['description'] }}</code>
                        </p>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection