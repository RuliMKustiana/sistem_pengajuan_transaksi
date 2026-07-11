@extends('layouts.approval')

@section('title', 'Persetujuan Direktur')
@section('page_heading', 'Antrean Otorisasi Direktur')

@section('content')
    <!-- Notifikasi Status Transaksi -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Kotak Konten Utama (Clean Card Donezo Style) -->
    <div class="card card-custom border-0 shadow-sm">
        <div class="card-header bg-white pt-4 pb-2 border-bottom-0 px-4">
            <h5 class="fw-bold text-dark mb-1">Daftar Pengajuan Menunggu Approval Direktur</h5>
            <p class="small text-muted mb-0">Otorisasi final keuangan perusahaan Lavanaya Madinah Travel. Periksa validitas
                seluruh dokumen dengan saksama.</p>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="py-3 ps-4">No. Pengajuan</th>
                            <th class="py-3">Karyawan / Pengaju</th>
                            <th class="py-3">Kategori & Deskripsi</th>
                            <th class="py-3">Nilai Transaksi</th>
                            <th class="py-3">Lampiran</th>
                            <th class="py-3 pe-4" width="280">Tindakan Otorisasi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($submissions as $submission)
                            <tr>
                                <!-- 1. Nomor Invoice & Tanggal -->
                                <td class="ps-4">
                                    <span class="fw-bold text-dark d-block">{{ $submission->submission_number }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        {{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y') }}
                                    </small>
                                </td>

                                <!-- 2. Informasi Nama Staf + Avatar Bulat -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                            style="width: 28px; height: 28px; font-size: 0.7rem;">
                                            {{ substr($submission->user->name, 0, 2) }}
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $submission->user->name }}</span>
                                    </div>
                                </td>

                                <!-- 3. Kategori & Rincian Deskripsi -->
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

                                <!-- 4. Nilai Anggaran -->
                                <td class="fw-bold text-dark">
                                    Rp {{ number_format($submission->amount, 0, ',', '.') }}
                                </td>

                                <!-- 5. Berkas Lampiran Dokumen -->
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

                                <!-- 6. Form Eksekusi Proses Approval -->
                                <td class="pe-4 py-3">
                                    <form action="{{ route('direktur.process', $submission->id) }}" method="POST">
                                        @csrf
                                        <!-- Input Catatan Review Ringkas -->
                                        <div class="mb-2">
                                            <input type="text" name="notes"
                                                class="form-control form-control-sm form-control-notes rounded-2"
                                                style="font-size: 0.75rem;" placeholder="Tulis catatan peninjauan...">
                                        </div>
                                        <!-- Tombol Pilihan Opsi Setuju / Tolak -->
                                        <div class="d-flex gap-2">
                                            <button type="submit" name="action" value="approve"
                                                class="btn btn-sm btn-success flex-grow-1 rounded-2 fw-semibold shadow-sm py-1">
                                                <i class="fa-solid fa-check small me-1"></i> Setuju
                                            </button>
                                            <button type="submit" name="action" value="reject"
                                                class="btn btn-sm btn-danger flex-grow-1 rounded-2 fw-semibold shadow-sm py-1">
                                                <i class="fa-solid fa-xmark small me-1"></i> Tolak
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2 fs-3 opacity-50"><i
                                            class="fa-solid fa-envelope-open-text text-muted"></i></div>
                                    <p class="mb-0 small fw-medium">Tidak ada antrean dokumen transaksi yang memerlukan
                                        persetujuan Direktur.</p>
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
