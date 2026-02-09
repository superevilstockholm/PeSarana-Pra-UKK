@extends('layouts.dashboard')
@section('title', 'Detail Data Kelas - PeSarana')
@section('meta-description', 'Detail data kelas PeSarana')
@section('meta-keywords', 'master data, detail kelas, detail classroom, kelas, classroom, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Detail Kelas</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Informasi lengkap kelas: {{ $classroom->name ? ucwords(strtolower($classroom->name)) : 'N/A' }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.classrooms.index') }}"
                            class="btn btn-sm btn-primary px-4 rounded-pill m-0">
                            <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Data Kelas</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Nama Kelas</div>
                        <div class="col-md-8 fw-medium">{{ $classroom->name ? ucwords(strtolower($classroom->name)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-muted mb-3">Deskripsi</div>
                        <div class="col-md-12 fw-normal fs-6 markdown-content">{!! $classroom->description ? Str::markdown($classroom->description) : '-' !!}</div>
                    </div>
                    <h4 class="card-title fw-semibold mt-4 mb-3">Informasi Sistem</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">ID Kelas</div>
                        <div class="col-md-8 fw-medium">{{ $classroom->id ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Dibuat</div>
                        <div class="col-md-8 fw-medium">{{ $classroom->created_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-muted">Terakhir Diperbarui</div>
                        <div class="col-md-8 fw-medium">{{ $classroom->updated_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-0">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Aksi Cepat</h4>
                    <a href="{{ route('dashboard.admin.master-data.classrooms.edit', $classroom->id) }}" class="btn btn-warning w-100 mb-2">
                        <i class="ti ti-pencil me-1"></i> Edit Kelas
                    </a>
                    <form id="form-delete-{{ $classroom->id }}" action="{{ route('dashboard.admin.master-data.classrooms.destroy', $classroom->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger w-100 btn-delete" data-id="{{ $classroom->id }}" data-name="{{ $classroom->title }}">
                            <i class="ti ti-trash me-1"></i> Hapus Kelas
                        </button>
                    </form>
                    <hr class="my-4">
                    <h4 class="card-title fw-semibold mb-3">Catatan</h4>
                    <p class="text-muted small">
                        Halaman ini hanya menampilkan detail data yang tersimpan. Untuk mengubah, klik tombol "Edit Kelas".
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const studentId = this.getAttribute('data-id');
                    const studentTitle = this.getAttribute('data-name');
                    Swal.fire({
                        title: "Hapus Kelas?",
                        text: "Apakah Anda yakin ingin menghapus \"" + studentTitle + "\"? Aksi ini tidak dapat dibatalkan.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + studentId).submit();
                        }
                    });
                });
            });
        });
    </script>
    <style>
        .markdown-content p, .markdown-content ul {
            margin-bottom: 0 !important;
        }
    </style>
@endsection
