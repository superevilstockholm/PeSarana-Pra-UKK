@extends('layouts.dashboard')
@section('title', 'Detail Data Siswa - PeSarana')
@section('meta-description', 'Detail data siswa PeSarana')
@section('meta-keywords', 'master data, detail siswa, detail student, siswa, student, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Detail Siswa</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Informasi lengkap siswa: {{ $student->name ? ucwords(strtolower($student->name)) : 'N/A' }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.students.index') }}"
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
                    <h4 class="card-title fw-semibold mb-3">Data Siswa</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">NISN</div>
                        <div class="col-md-8 fw-medium">{{ $student->nisn ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Nama Siswa</div>
                        <div class="col-md-8 fw-medium">{{ $student->name ? ucwords(strtolower($student->name)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Lahir</div>
                        <div class="col-md-8 fw-medium">{{ $student->dob?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Kelas</div>
                        <div class="col-md-8 fw-medium">{{ $student->classroom?->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Memiliki User</div>
                        <div class="col-md-8 fw-medium">{{ $student->user ? 'Ya' : 'Tidak' }}</div>
                    </div>
                    <h4 class="card-title fw-semibold mt-4 mb-3">Informasi Sistem</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">ID Siswa</div>
                        <div class="col-md-8 fw-medium">{{ $student->id ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Dibuat</div>
                        <div class="col-md-8 fw-medium">{{ $student->created_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-muted">Terakhir Diperbarui</div>
                        <div class="col-md-8 fw-medium">{{ $student->updated_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-0">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Aksi Cepat</h4>
                    <a href="{{ route('dashboard.admin.master-data.students.edit', $student->id) }}" class="btn btn-warning w-100 mb-2">
                        <i class="ti ti-pencil me-1"></i> Edit Siswa
                    </a>
                    <form id="form-delete-{{ $student->id }}" action="{{ route('dashboard.admin.master-data.students.destroy', $student->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger w-100 btn-delete" data-id="{{ $student->id }}" data-name="{{ $student->title }}">
                            <i class="ti ti-trash me-1"></i> Hapus Siswa
                        </button>
                    </form>
                    <hr class="my-4">
                    <h4 class="card-title fw-semibold mb-3">Catatan</h4>
                    <p class="text-muted small">
                        Halaman ini hanya menampilkan detail data yang tersimpan. Untuk mengubah, klik tombol "Edit Siswa".
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
                        title: "Hapus Siswa?",
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
@endsection
