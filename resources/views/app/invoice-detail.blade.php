@extends('layouts.app.base')

@section('title', 'Invoice Detail')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/pages.css') }}">
    <style>
    /* existing print rules kept */
    @media print {
        #printTable, #printTable * {
            visibility: visible;
        }
        #btnPrint {
            display: none;
        }
        #printTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        @page { margin: 0; }

        .label {
            font-weight: 600;
            font-size: 14pt;
            color: #000 !important;
        }

        .paymentMethodSection {
            display: none;
            visibility: hidden;
        }

        /* ensure watermark sits behind text by forcing lower stacking for printed content */
        #printTable > * {
            position: relative;
            z-index: 10000;
        }
    }

    /* hide watermark on screen */
    .wm-print { display: none; }
    </style>
@endpush
@section('content')
<div class="row">
    <div class="col">
        <div class="card" id="printTable">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h2>Invoice</h2>
                    </div>
                    <div class="col-4">
                        <h4 class="float-end">{{ $invoice->code }}</h4>
                    </div>
                </div>
                <div class="invoice-details">
                    <div class="row">
                        <div class="col">
                            <p class="info">Invoice Date:</p>
                            <p>{{ $invoice->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col">
                            <p class="info">Due Date:</p>
                            <p>{{ $invoice->due_date}}</p>
                        </div>
                        <div class="col">
                            <p class="info">Invoice to:</p>
                            <p>{{ auth()->user()->name }}</p>
                            <p>{{ auth()->user()->phone_number }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table invoice-table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Batas Pembayaran</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($invoice->items as $index => $item)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{ $item->label }}</td>
                                    <td>{{ $item->due_date }}</td>
                                    <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Tidak ada item pada invoice ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row invoice-last">
                    <div class="col-8">
                        <p>Terms and Condition :</p>
                        <ol>
                            <li>Biaya yang telah di bayarkan, tidak dapat di kembalikan dengan alasan apapun.</li>
                            <li>Harap simpan bukti pembayaran dengan baik.</li>
                            <li>Segala bentuk penipuan yang mengatasnamakan pihak sekolah, bukan tanggung jawab sekolah.</li>
                            <li>Apabila ada pertanyaan, silahkan hubungi bagian administrasi sekolah.</li>
                        </ol>
                    </div>
                    <div class="col-4">
                        <div class="invoice-info">
                            <p>Subtotal <span>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span></p>
                            <p>Discount <span>Rp {{ number_format($invoice->discount ?? 0, 0, ',', '.') }}</span></p>
                            <p>Tax <span>Rp {{ number_format($invoice->tax ?? 0, 0, ',', '.') }}</span></p>
                            <p class="bold">Total <span>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span></p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-danger m-t-xs" type="button" id="btnPrint">Print Invoice</button>

                                @if($invoice->status == 'UNPAID' || $invoice->status == 'PARTIAL')
                                <button type="button" class="btn btn-primary m-t-xs" id="modalConfirmButton">Konfirmasi Pembayaran</button>
                                @endif
                                
                                @if($invoice->status == 'PAID')
                                <p>Kami sudah menerima bukti transfer anda, namun berikan kami waktu untuk melakukan verifikasi</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($invoice->status == 'UNPAID' || $invoice->status == 'PARTIAL')
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembayaran</h5>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data" onsubmit="return processDataWithLoading(this)">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="manual_bank_from" class="form-label">Transfer Via Bank</label>
                        <input type="text" class="form-control" name="manual_bank_from" placeholder="Bank BSI / Bank Aceh" required>
                    </div>
                    <div class="mb-3">
                        <label for="evidence" class="form-label">Bukti Transfer</label>
                        <input type="file" class="form-control" name="evidence" required accept="image/*">
                        <small class="text-muted">Max 1MB | JPG, JPEG, PNG</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Metode Pembayaran --}}
<div class="modal fade" id="modalPaymentMethod" tabindex="-1" role="dialog" aria-labelledby="modalPaymentMethodLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPaymentMethodLabel">Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionPaymentMethod">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            <img src="{{ asset('assets/images/transfer.png') }}" alt="" width="20px" class="mx-2"> Transfer Bank (Verifikasi Manual)
                        </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <p>Silahkan melakukan pembayaran ke rekening berikut:</p>
                            <ul>
                                <li>Bank : </li>
                                <li>Atas Nama : </li>
                                <li>No. Rekening : </li>
                            </ul>
                            <p>Setelah melakukan pembayaran, silahkan konfirmasi pembayaran dengan mengunggah bukti transfer pada tombol "Konfirmasi Pembayaran" di halaman invoice.</p>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <img src="{{ asset('assets/images/qr-code.png') }}" alt="" width="20px" class="mx-2"> QRIS
                        </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                            </center>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <img src="{{ asset('assets/images/virtual-card.png') }}" alt="" width="20px" class="mx-2"> Virtual Account
                        </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                            </center>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            <img src="{{ asset('assets/images/outlet.png') }}" alt="" width="20px" class="mx-2"> Outlet
                        </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                                <img src="{{ asset('assets/images/indomaret.png') }}" alt="" width="100px" class="mx-2">
                                <img src="{{ asset('assets/images/alfa.png') }}" alt="" width="100px" class="mx-2">
                            </center>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            <img src="{{ asset('assets/images/digital-wallet.png') }}" alt="" width="20px" class="mx-2"> E-Wallet
                        </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionPaymentMethod">
                        <div class="accordion-body">
                            <center>
                                <h5 class="text-danger">Fitur ini Sedang dalam pengembangan</h5>
                                <img src="{{ asset('assets/images/e-wallet.png') }}" alt="" width="100%" class="mx-2">
                            </center>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            $('#modalConfirmButton').on('click', function() {
                $('#modalConfirm').modal('show');
            });
            $('#modalPaymentMethodButton').on('click', function () {
                $('#modalPaymentMethod').modal('show');
            });
        });
        // Print area
        $('#btnPrint').on('click', function() {
            var printContents = document.getElementById('printTable').innerHTML;
            var originalContents = document.body.innerHTML;

            // Tulis ulang hanya bagian yang mau di-print
            document.body.innerHTML = printContents;

            // Jalankan print
            window.print();

            // Kembalikan konten asli setelah print
            document.body.innerHTML = originalContents;

            // Reload script agar tombol dll tetap berfungsi
            location.reload();
        });
    </script>
@endpush