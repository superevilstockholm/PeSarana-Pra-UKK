@extends('layouts.dashboard')
@section('title', 'Tambah Data Aspirasi - PeSarana')
@section('meta-description', 'Tambah data aspirasi PeSarana')
@section('meta-keywords', 'master data, tambah aspirasi, tambah aspiration, aspirasi, aspiration, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Tambah Aspirasi</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Formulir untuk memasukkan data aspirasi baru.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.student.aspirations.index') }}"
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
                    <form action="{{ route('dashboard.student.aspirations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Foto Aspirasi</label>
                            <div id="image-card-wrapper" class="d-flex flex-wrap gap-3">
                                <div class="image-card border rounded position-relative d-flex flex-column justify-content-center align-items-center" style="width:150px;height:150px;">
                                    <input type="file" name="aspiration_images[]" class="d-none" onchange="previewImage(this)">
                                    <button type="button" class="btn d-flex align-items-center justify-content-center border-0 w-100 h-100 p-0 m-0" onclick="triggerFileInput(this)">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @error('aspiration_images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('aspiration_images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="floatingInputTitle" placeholder="Judul Aspirasi" value="{{ old('title') }}" required>
                            <label for="floatingInputTitle">Judul Aspirasi</label>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" placeholder="Isi Aspirasi" id="floatingTextareaContent" style="height: 120px" required>{{ old('content') }}</textarea>
                            <label for="floatingTextareaContent">Isi Aspirasi</label>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="floatingInputLocation" placeholder="Lokasi" value="{{ old('location') }}" required>
                            <label for="floatingInputLocation">Lokasi</label>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="category_id" id="floatingInputCategory" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingInputCategory">Hubungkan dengan Data Guru</label>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Aspirasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function triggerFileInput(button) {
            const card = button.closest('.image-card');
            const input = card.querySelector('input[type="file"]');
            input.click();
        }
        function previewImage(input) {
            const file = input.files[0];
            if (!file) return;
            input.dataset.hasFile = "true";
            const card = input.closest('.image-card');
            const addBtn = card.querySelector('button');
            if (addBtn) addBtn.classList.add('d-none');
            let img = card.querySelector('img');
            if (!img) {
                img = document.createElement('img');
                img.className = 'w-100 h-100 object-fit-cover rounded';
                card.appendChild(img);
            }
            img.src = URL.createObjectURL(file);
            let deleteBtn = card.querySelector('.delete-btn');
            if (!deleteBtn) {
                deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1 d-none delete-btn';
                deleteBtn.innerHTML = '<i class="ti ti-trash"></i>';
                deleteBtn.onclick = () => removeImageCard(card);
                card.appendChild(deleteBtn);
            }
            card.addEventListener('mouseenter', () => deleteBtn.classList.remove('d-none'));
            card.addEventListener('mouseleave', () => deleteBtn.classList.add('d-none'));
            addEmptyCardIfNeeded();
        }
        function addEmptyCardIfNeeded() {
            const wrapper = document.getElementById('image-card-wrapper');
            const hasEmpty = wrapper.querySelectorAll('.image-card input[type="file"]:not([data-has-file])').length > 0;
            if (!hasEmpty) {
                const card = document.createElement('div');
                card.className = 'image-card border rounded position-relative d-flex flex-column justify-content-center align-items-center';
                card.style.width = '150px';
                card.style.height = '150px';
                card.innerHTML = `
                    <input type="file" name="aspiration_images[]" class="d-none" onchange="previewImage(this)">
                    <button type="button" class="btn d-flex align-items-center justify-content-center border-0 w-100 h-100 p-0 m-0" onclick="triggerFileInput(this)">
                        <i class="ti ti-plus"></i>
                    </button>
                `;
                wrapper.appendChild(card);
            }
        }
        function removeImageCard(card) {
            card.remove();
            addEmptyCardIfNeeded();
        }
    </script>
@endsection
