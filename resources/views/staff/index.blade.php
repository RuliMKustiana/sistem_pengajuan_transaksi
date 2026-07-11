@extends('layouts.staff')

@section('title', 'Riwayat Pengajuan Staf')
@section('page_heading', 'Panel Transaksi Staf')

@section('content')
    <!-- Header Aksi & Informasi Status Kontrol -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-1">Riwayat Pengajuan Transaksi</h5>
            <p class="small text-muted mb-0">Daftar seluruh permohonan dana operasional yang Anda ajukan.</p>
        </div>
        <a href="{{ route('staff.create') }}"
            class="btn btn-dark rounded-3 shadow-sm px-3 py-2 fw-semibold d-flex align-items-center gap-2"
            style="background-color: #111;">
            <i class="fa-solid fa-plus text-gold"></i> Buat Pengajuan Baru
        </a>
    </div>

    <!-- Notifikasi Flash Sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Riwayat Data Bergaya Clean Grid -->
    <div class="card card-custom border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive rounded-3">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="py-3 ps-4">No. Pengajuan</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Nilai Pengajuan</th>
                            <th class="py-3">Status Persetujuan</th>
                            <th class="py-3 text-center pe-4">Lampiran</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($submissions as $submission)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-2 d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-file-invoice" style="font-size: 0.85rem;"></i>
                                        </div>
                                        <strong class="text-dark">{{ $submission->submission_number }}</strong>
                                    </div>
                                </td>
                                <td class="text-muted">
                                    <i class="fa-regular fa-calendar me-1" style="font-size: 0.8rem;"></i>
                                    {{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $submission->category->name }}</span>
                                </td>
                                <td class="fw-bold text-dark">
                                    Rp {{ number_format($submission->amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($submission->status == 'Paid')
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 fw-bold"
                                            style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-circle-check me-1"></i> Paid
                                        </span>
                                    @elseif($submission->status == 'Rejected')
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1.5 fw-bold"
                                            style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                        </span>
                                    @elseif(str_contains($submission->status, 'Waiting'))
                                        <span
                                            class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1.5 fw-bold"
                                            style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-spinner fa-spin me-1"></i> {{ $submission->status }}
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1.5 fw-bold"
                                            style="font-size: 0.7rem;">
                                            {{ $submission->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    @if ($submission->attachment)
                                        <a href="{{ asset('storage/' . $submission->attachment) }}" target="_blank"
                                            class="btn btn-sm btn-light border rounded-2 px-2.5 py-1 text-secondary font-semibold shadow-none"
                                            style="font-size: 0.75rem;">
                                            <i class="fa-regular fa-file-pdf me-1 text-danger"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2 fs-3 text-muted opacity-50"><i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    <p class="mb-0 small fw-medium">Belum ada riwayat pengajuan transaksi operasional.</p>
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
