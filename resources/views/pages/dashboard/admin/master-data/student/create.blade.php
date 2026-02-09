@extends('layouts.dashboard')
@section('title', 'Tambah Data Siswa - PeSarana')
@section('meta-description', 'Tambah data Siswa PeSarana')
@section('meta-keywords', 'master data, tambah Siswa, tambah student, Siswa, student, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Tambah Siswa</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Formulir untuk memasukkan data Siswa baru.</p>
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
        <div class="col">
            <div class="card my-0">
                <div class="card-body">
                    <form action="{{ route('dashboard.admin.master-data.students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" id="floatingInputNISN" placeholder="NISN" value="{{ old('nisn') }}" inputmode="numeric" maxlength="10" required>
                            <label for="floatingInputNISN">NISN</label>
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="floatingInputName" placeholder="Nama Siswa" value="{{ old('name') }}" required>
                            <label for="floatingInputName">Nama Siswa</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" id="floatingInputDOB" placeholder="Tanggal Lahir" value="{{ old('dob') }}" required>
                            <label for="floatingInputDOB">Tanggal Lahir</label>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="classroom_id" id="floatingInputClassroom" class="form-select @error('classroom_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                        {{ $classroom->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputClassroom">Kelas</label>
                            @error('classroom_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
