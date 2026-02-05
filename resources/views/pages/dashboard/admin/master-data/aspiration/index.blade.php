@extends('layouts.dashboard')
@section('title', 'Data Aspirasi - PeSarana')
@section('meta-description', 'Daftar data aspirasi PeSarana')
@section('meta-keywords', 'master data, data aspirasi, data aspirations, aspirasi, aspirations, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    @php
        use Illuminate\Contracts\Pagination\LengthAwarePaginator;
        use Illuminate\Support\Str;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Data Aspirasi</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Manajemen data aspirasi siswa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card my-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.admin.master-data.aspirations.index') }}" id="filterForm">
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
                                @if ($aspirations instanceof LengthAwarePaginator)
                                    Menampilkan {{ $aspirations->firstItem() }} hingga {{ $aspirations->lastItem() }} dari
                                    {{ $aspirations->total() }} total entri
                                @else
                                    Menampilkan {{ $aspirations->count() }} total entri
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive @if (!($aspirations instanceof LengthAwarePaginator && $aspirations->hasPages())) mb-0 @else mb-3 @endif">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Gambar Cover</th>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Status</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Dibuat Pada</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aspirations as $index => $aspiration)
                                    <tr>
                                        <td class="text-center">
                                            @if ($aspirations instanceof LengthAwarePaginator)
                                                {{ $aspirations->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>
                                            <img class="object-fit-cover rounded" style="width: 100px; height: 100px; object-position: center;" src="{{ $aspiration->cover_image_path_url }}" alt="{{ $aspiration->title ?? '-' }}">
                                        </td>
                                        <td>{{ $aspiration->title ?? '-' }}</td>
                                        <td>{{ $aspiration->content ? Str::limit($aspiration->content, 60, '...') : '-' }}</td>
                                        <td>{{ $aspiration->status?->value ? ucwords(strtolower($aspiration->status->value)) : '-' }}</td>
                                        <td>{{ $aspiration->student?->name ? ucwords(strtolower($aspiration->student->name)) : '-' }}</td>
                                        <td>{{ $aspiration->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn border-0 p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('dashboard.admin.master-data.aspirations.show', $aspiration->id) }}">
                                                        <i class="ti ti-eye me-1"></i> Lihat
                                                    </a>
                                                    <form id="form-delete-{{ $aspiration->id }}"
                                                        action="{{ route('dashboard.admin.master-data.aspirations.destroy', $aspiration->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger btn-delete"
                                                            data-id="{{ $aspiration->id }}" data-name="{{ $aspiration->title }}">
                                                            <i class="ti ti-trash me-1 text-danger"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-warning my-2" role="alert">
                                                Tidak ada data aspirasi yang ditemukan dengan kriteria tersebut.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($aspirations instanceof LengthAwarePaginator && $aspirations->hasPages())
                        <div class="overflow-x-auto mt-0 py-1">
                            <div class="d-flex justify-content-center d-md-block w-100 px-3">
                                {{ $aspirations->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
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
                    const aspirationId = this.getAttribute('data-id');
                    const aspirationTitle = this.getAttribute('data-name');
                    Swal.fire({
                        title: "Hapus Aspirasi?",
                        text: "Apakah Anda yakin ingin menghapus aspirasi \"" + aspirationTitle + "\"? Aksi ini tidak dapat dibatalkan.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + aspirationId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
