@extends('layouts.app.base')

@section('title', 'Invoice List')

@push('styles')
    <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">   
@endpush

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tagihan saya</h5>
                <div class="table-responsive">
                    <table id="dataTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Keterangan</th>
                                <th>Jumlah Tagihan</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.detail', ['invoice' => $invoice->id]) }}"
                                    class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                                <td>
                                    {{ $invoice->title }}
                                </td>
                                <td>
                                    Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ optional($invoice->due_date)->translatedFormat('d M Y') ?? '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $invoice->displayStatus() }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada tagihan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush