@extends('layouts.dashboard')
@section('title', 'Detail Data Pengguna - PeSarana')
@section('meta-description', 'Detail data pengguna PeSarana')
@section('meta-keywords', 'master data, detail pengguna, detail user, pengguna, user, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    @php
        use Illuminate\Support\Str;
        use App\Enums\RoleEnum;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Detail Pengguna</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Informasi lengkap pengguna: {{ $user->name ? ucwords(strtolower($user->name)) : 'N/A' }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.users.index') }}"
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
                    <h4 class="card-title fw-semibold mb-3">Data Pengguna</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Nama Pengguna</div>
                        <div class="col-md-8 fw-medium">{{ $user->name ? ucwords(strtolower($user->name)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Email</div>
                        <div class="col-md-8 fw-medium">{{ $user->email ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Role</div>
                        <div class="col-md-8 fw-medium">{{ $user->role->label() ?? '-' }}</div>
                    </div>
                    @if ($user->role === RoleEnum::STUDENT)
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">ID Siswa</div>
                            <div class="col-md-8 fw-medium">{{ $user->student->id ?? '-' }}</div>
                        </div>
                    @endif
                    @if ($user->role === RoleEnum::ADMIN)
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Feedback Aspirasi Dibuat</div>
                            <div class="col-md-8 fw-medium">{{ $user->aspiration_feedbacks_count ?? '-' }}</div>
                        </div>
                    @endif
                    <h4 class="card-title fw-semibold mt-4 mb-3">Informasi Sistem</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">ID Pengguna</div>
                        <div class="col-md-8 fw-medium">{{ $user->id ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Dibuat</div>
                        <div class="col-md-8 fw-medium">{{ $user->created_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-muted">Terakhir Diperbarui</div>
                        <div class="col-md-8 fw-medium">{{ $user->updated_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-0">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Aksi Cepat</h4>
                    <a href="{{ route('dashboard.admin.master-data.users.edit', $user->id) }}" class="btn btn-warning w-100 mb-2">
                        <i class="ti ti-pencil me-1"></i> Edit Pengguna
                    </a>
                    <form id="form-delete-{{ $user->id }}" action="{{ route('dashboard.admin.master-data.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger w-100 btn-delete" data-id="{{ $user->id }}" data-name="{{ $user->title }}">
                            <i class="ti ti-trash me-1"></i> Hapus Pengguna
                        </button>
                    </form>
                    <hr class="my-4">
                    <h4 class="card-title fw-semibold mb-3">Catatan</h4>
                    <p class="text-muted small">
                        Halaman ini hanya menampilkan detail data yang tersimpan. Untuk mengubah, klik tombol "Edit Pengguna".
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
                        title: "Hapus Pengguna?",
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
