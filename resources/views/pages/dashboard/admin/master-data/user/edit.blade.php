@extends('layouts.dashboard')
@section('title', 'Ubah Data Pengguna - PeSarana')
@section('meta-description', 'Ubah data pengguna PeSarana')
@section('meta-keywords', 'master data, ubah pengguna, edit user, pengguna, user, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Ubah Pengguna</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Formulir untuk memasukkan data pengguna baru.</p>
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
        <div class="col">
            <div class="card my-0">
                <div class="card-body">
                    <form action="{{ route('dashboard.admin.master-data.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="floatingInputEmail"
                                placeholder="Email"
                                value="{{ old('email', $user->email) }}"
                                required>
                            <label for="floatingInputEmail">Email</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="floatingInputPassword"
                                placeholder="Password baru (opsional)">
                            <label for="floatingInputPassword">Password (kosongkan jika tidak diubah)</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="role"
                                class="form-select @error('role') is-invalid @enderror"
                                id="floatingSelectRole"
                                required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role', $user->role->value) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="student" {{ old('role', $user->role->value) === 'student' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            <label for="floatingSelectRole">Role</label>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3" id="name-wrapper">
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                id="floatingInputName"
                                placeholder="Nama"
                                value="{{ old('name', $user->name) }}">
                            <label for="floatingInputName">Nama</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3 d-none" id="student-wrapper">
                            <select name="student_id"
                                class="form-select @error('student_id') is-invalid @enderror"
                                id="floatingSelectStudent">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ old('student_id', optional($user->student)->id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingSelectStudent">Siswa</label>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const roleSelect = document.getElementById('floatingSelectRole');
        const nameWrapper = document.getElementById('name-wrapper');
        const studentWrapper = document.getElementById('student-wrapper');
        function toggleFields() {
            if (roleSelect.value === 'student') {
                studentWrapper.classList.remove('d-none');
                nameWrapper.classList.add('d-none');
            } else if (roleSelect.value === 'admin') {
                nameWrapper.classList.remove('d-none');
                studentWrapper.classList.add('d-none');
            } else {
                nameWrapper.classList.add('d-none');
                studentWrapper.classList.add('d-none');
            }
        }
        roleSelect.addEventListener('change', toggleFields);
        toggleFields();
    </script>
@endsection
