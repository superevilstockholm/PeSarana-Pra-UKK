@extends('layouts.dashboard')
@section('title', 'Data Kategori - PeSarana')
@section('meta-description', 'Daftar data kategori PeSarana')
@section('meta-keywords', 'master data, data kategori, data categories, kategori, categories, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    @php
        use Illuminate\Support\Str;
        use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Data Kategori</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Manajemen data kategori siswa.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.categories.create') }}"
                            class="btn btn-sm btn-primary px-4 rounded-pill m-0">
                            <i class="ti ti-plus me-1"></i> Tambah Kategori
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
                    <form method="GET" action="{{ route('dashboard.admin.master-data.categories.index') }}" id="filterForm">
                        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-3 gap-2 gap-md-0">
                            <div class="d-flex align-items-center">
                                @php
                                    $limits = [5, 10, 25, 50, 'all'];
                                    $currentLimit = request('limit', 10);
                                @endphp
                                <label for="limitSelect" class="form-label mb-0 me-2">Limit</label>
                                <select class="form-select form-select-sm" id="limitSelect" name="limit"
                                    onchange="document.getElementById('filterForm').submit()">
                                    @foreach ($limits as $limit)
                                        <option value="{{ $limit }}"
                                            {{ (string) $currentLimit === (string) $limit ? 'selected' : '' }}>
                                            {{ $limit === 'all' ? 'All' : $limit }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ms-2">entries</span>
                            </div>
                            <div class="text-muted small">
                                @if ($categories instanceof LengthAwarePaginator)
                                    Menampilkan {{ $categories->firstItem() }} hingga {{ $categories->lastItem() }} dari
                                    {{ $categories->total() }} total entri
                                @else
                                    Menampilkan {{ $categories->count() }} total entri
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive @if (!($categories instanceof LengthAwarePaginator && $categories->hasPages())) mb-0 @else mb-3 @endif">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Dipakai Aspirasi</th>
                                    <th>Dibuat Pada</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr>
                                        <td class="text-center">
                                            @if ($categories instanceof LengthAwarePaginator)
                                                {{ $categories->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{ $category->name ?? '-' }}</td>
                                        <td>{{ $category->description ? Str::limit($category->description, 60, '...') : '-' }}</td>
                                        <td>{{ $category->aspirations_count ?? '-' }}</td>
                                        <td>{{ $category->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn border-0 p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('dashboard.admin.master-data.categories.edit', $category->id) }}">
                                                        <i class="ti ti-pencil me-1"></i> Edit
                                                    </a>
                                                    <form id="form-delete-{{ $category->id }}"
                                                        action="{{ route('dashboard.admin.master-data.categories.destroy', $category->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger btn-delete"
                                                            data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                            <i class="ti ti-trash me-1 text-danger"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="alert alert-warning my-2" role="alert">
                                                Tidak ada data kategori yang ditemukan dengan kriteria tersebut.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($categories instanceof LengthAwarePaginator && $categories->hasPages())
                        <div class="overflow-x-auto mt-0 py-1">
                            <div class="d-flex justify-content-center d-md-block w-100 px-3">
                                {{ $categories->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-id');
                    const categoryName = this.getAttribute('data-name');
                    Swal.fire({
                        title: "Hapus Kategori?",
                        text: "Apakah Anda yakin ingin menghapus Kategori \"" + categoryName + "\"? Aksi ini tidak dapat dibatalkan.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + categoryId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
