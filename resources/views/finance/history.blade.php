@extends('layouts.approval')

@section('title', 'Riwayat Pembukuan')
@section('page_heading', 'Arsip & Riwayat Transaksi')

@section('content')
    <div class="card card-custom border-0 shadow-sm">
        <div class="card-header bg-white pt-4 pb-3 border-bottom-0 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Seluruh Riwayat Pengeluaran lunas</h5>
                    <p class="small text-muted mb-0">Arsip data pembukuan Lavanaya Madinah Travel yang telah sukses dicairkan
                        oleh Finance.</p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('finance.history') }}" method="GET" class="d-flex align-items-center gap-2">
                        <select name="month" class="form-select form-select-sm rounded-2 text-muted"
                            style="font-size: 0.8rem; width: 130px;">
                            <option value="">-- Semua Bulan --</option>
                            @foreach (range(1, 12) as $m)
                                <option value="{{ sprintf('%02d', $m) }}"
                                    {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>

                        <select name="year" class="form-select form-select-sm rounded-2 text-muted"
                            style="font-size: 0.8rem; width: 100px;">
                            <option value="">-- Tahun --</option>
                            @foreach (range(date('Y'), date('Y') - 3) as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-sm btn-light border rounded-2 fw-semibold shadow-none"
                            style="font-size: 0.8rem;">
                            <i class="fa-solid fa-filter small"></i> Filter
                        </button>
                    </form>

                    <a href="{{ route('finance.export', request()->query()) }}"
                        class="btn btn-sm btn-outline-success rounded-2 fw-semibold d-flex align-items-center gap-1"
                        style="font-size: 0.8rem;">
                        <i class="fa-solid fa-file-csv"></i> Export CSV (Excel)
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="py-3 ps-4">No. Pengajuan</th>
                            <th class="py-3">Tanggal Lunas</th>
                            <th class="py-3">Pengaju</th>
                            <th class="py-3">Kategori & Deskripsi</th>
                            <th class="py-3">Nilai Transaksi</th>
                            <th class="py-3 pe-4 text-center">Status Pembukuan</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($historySubmissions as $submission)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $submission->submission_number }}</td>
                                <td>{{ $submission->updated_at->format('d M Y H:i') }} WIB</td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $submission->user->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-0.5 mb-1"
                                        style="font-size: 0.65rem;">
                                        {{ $submission->category->name }}
                                    </span>
                                    <p class="text-muted mb-0 text-truncate" style="max-width: 250px; font-size: 0.8rem;">
                                        {{ $submission->description }}
                                    </p>
                                </td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($submission->amount, 0, ',', '.') }}
                                </td>
                                <td class="pe-4 text-center">
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-1.5 rounded-2 fw-semibold"
                                        style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-circle-check me-1 small"></i> Dibayarkan & Dibukukan
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2 fs-3 opacity-50"><i class="fa-solid fa-folder-open text-muted"></i>
                                    </div>
                                    <p class="mb-0 small fw-medium">Tidak ada riwayat pembukuan pengeluaran untuk filter
                                        periode ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer bg-white border-top-0 px-4 py-3">
        <form method="GET" action="" id="formLimit" class="d-flex align-items-center gap-2">
            @if (request('month'))
                <input type="hidden" name="month" value="{{ request('month') }}">
            @endif
            @if (request('year'))
                <input type="hidden" name="year" value="{{ request('year') }}">
            @endif

            <span class="small text-muted text-nowrap">Tampilkan:</span>
            <select name="limit" onchange="document.getElementById('formLimit').submit()"
                class="form-select form-select-sm rounded-2" style="width: 80px; font-size: 0.8rem;">
                <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
                <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </form>

        @php
            $dataPaginator = isset($submissions) ? $submissions : $historySubmissions;
        @endphp

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-muted">
                Menampilkan {{ $dataPaginator->firstItem() ?? 0 }} sampai {{ $dataPaginator->lastItem() ?? 0 }} dari
                {{ $dataPaginator->total() }} data
            </small>
            <div>
                {{ $dataPaginator->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
