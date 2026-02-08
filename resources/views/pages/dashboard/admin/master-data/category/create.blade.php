@extends('layouts.dashboard')
@section('title', 'Tambah Data Kategori - PeSarana')
@section('meta-description', 'Tambah data kategori PeSarana')
@section('meta-keywords', 'master data, tambah kategori, tambah category, kategori, category, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Tambah Kategori</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Formulir untuk memasukkan data kategori baru.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.categories.index') }}"
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
                    <form action="{{ route('dashboard.admin.master-data.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="floatingInputName" placeholder="Nama Kategori" value="{{ old('name') }}" required>
                            <label for="floatingInputName">Nama Kategori</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi" id="floatingTextareaDescription" style="height: 120px">{{ old('description') }}</textarea>
                            <label for="floatingTextareaDescription">Deskripsi</label>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
