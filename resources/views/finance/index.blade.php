@extends('layouts.approval')

@section('title', 'Pusat Pembayaran')
@section('page_heading', 'Meja Kerja Keuangan')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card card-custom border-0 shadow-sm p-4 bg-white">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fa-solid fa-vault text-gold fs-5"></i>
                    <h6 class="fw-bold text-dark mb-0">Status Plafon Anggaran Kategori (Tahun {{ date('Y') }})</h6>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                    @forelse($budgets as $budget)
                        <div class="col">
                            <div class="p-3 border rounded-3 bg-light bg-opacity-50 shadow-sm-hover">
                                <small class="text-muted fw-bold text-uppercase d-block text-truncate"
                                    style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                    {{ $budget->category->name ?? 'Kategori Terhapus' }}
                                </small>
                                <span class="fw-bold text-dark fs-5 mt-1 d-block">
                                    Rp {{ number_format($budget->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning border-dashed rounded-3 small py-2 mb-0" role="alert">
                                <i class="fa-solid fa-circle-info me-2"></i> Belum ada alokasi plafon anggaran yang
                                diaktifkan oleh Administrator untuk tahun fiskal ini.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="card-header bg-white pt-4 pb-2 border-bottom-0 px-4">
            <h5 class="fw-bold text-dark mb-1">Daftar Transaksi Siap Dibayarkan</h5>
            <p class="small text-muted mb-0">Antrean pengajuan yang telah disetujui penuh oleh jajaran direksi dan siap
                dilakukan proses pencairan dana.</p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="py-3 ps-4">No. Pengajuan</th>
                            <th class="py-3">Karyawan / Pengaju</th>
                            <th class="py-3">Kategori & Deskripsi</th>
                            <th class="py-3">Nilai Pembayaran</th>
                            <th class="py-3">Lampiran</th>
                            <th class="py-3 pe-4 text-center" width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($submissions as $submission)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark d-block">{{ $submission->submission_number }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        {{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                            style="width: 28px; height: 28px; font-size: 0.7rem;">
                                            {{ substr($submission->user->name, 0, 2) }}
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $submission->user->name }}</span>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-1 mb-1 fw-medium"
                                        style="font-size: 0.7rem;">
                                        {{ $submission->category->name }}
                                    </span>
                                    <p class="text-muted mb-0 text-truncate" style="max-width: 220px; font-size: 0.8rem;"
                                        title="{{ $submission->description }}">
                                        {{ $submission->description }}
                                    </p>
                                </td>

                                <td>
                                    <span class="text-success fw-bold">
                                        Rp {{ number_format($submission->amount, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    @if ($submission->attachment)
                                        <a href="{{ asset('storage/' . $submission->attachment) }}" target="_blank"
                                            class="btn btn-sm btn-light border rounded-2 px-2 py-1 text-secondary shadow-none"
                                            style="font-size: 0.75rem;">
                                            <i class="fa-regular fa-file-pdf text-danger me-1"></i> Berkas
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="pe-4 py-3 text-center">
                                    <form action="{{ route('finance.pay', $submission->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-success w-100 rounded-2 fw-semibold shadow-sm py-1.5"
                                            style="font-size: 0.75rem;">
                                            <i class="fa-solid fa-money-bill-wave me-1"></i> Proses Bayar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2 fs-3 opacity-50"><i class="fa-solid fa-receipt text-muted"></i></div>
                                    <p class="mb-0 small fw-medium">Tidak ada antrean pencairan dana / pembayaran saat ini.
                                    </p>
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
