@extends('layouts.dashboard')
@section('title', 'Detail Data Aspirasi - PeSarana')
@section('meta-description', 'Detail data aspirasi PeSarana')
@section('meta-keywords', 'master data, detail aspirasi, detail aspiration, aspirasi, aspiration, PeSarana')
@section('content')
    <x-alerts :errors="$errors" />
    @php
        use Illuminate\Support\Str;
        use App\Enums\AspirationStatusEnum;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Detail Aspirasi</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Informasi lengkap aspirasi: {{ $aspiration->title ?? 'N/A' }}</p>
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
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-4">Data Aspirasi</h4>
                    <div class="row mb-4">
                        <div class="col d-flex align-items-center gap-2">
                            @foreach ($aspiration->aspiration_images as $image)
                            <img class="object-fit-cover rounded me-2 mb-2 img-preview"
                                style="height: 150px; width: 150px; cursor: zoom-in;"
                                src="{{ $image->image_path_url }}"
                                alt="{{ $aspiration->title ?? '-' }}"
                                data-full="{{ $image->image_path_url }}">
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Judul Aspirasi</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->title ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Lokasi</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->location ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Status</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->status?->value ? ucwords(strtolower($aspiration->status->value)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Kategori</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->category?->name ? ucwords(strtolower($aspiration->category->name)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Dibuat Oleh</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->student?->name ? ucwords(strtolower($aspiration->student->name)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-muted mb-3">Konten</div>
                        <div class="col-md-12 fw-normal fs-6">{!! $aspiration->content ? Str::markdown($aspiration->content) : '-' !!}</div>
                    </div>
                    <h4 class="card-title fw-semibold mt-4 mb-3">Informasi Sistem</h4>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">ID Aspirasi</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->id ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Dibuat</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->created_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Terakhir Diperbarui</div>
                        <div class="col-md-8 fw-medium">{{ $aspiration->updated_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mt-4 mb-3">Feedback Admin</h4>
                    @if ($aspiration->aspiration_feedbacks->isEmpty())
                        <div class="row mb-3">
                            <div class="col-md-8 fw-medium">Belum ada feedback.</div>
                        </div>
                    @else
                        @foreach ($aspiration->aspiration_feedbacks as $feedback)
                            <div class="row mb-3">
                                <div class="col-md-4 text-muted">Status</div>
                                <div class="col-md-8 fw-medium">{{ $feedback->status->label() ?? '-' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 text-muted mb-3">Konten</div>
                                <div class="col-md-12 fw-normal fs-6">{!! $feedback->content ? Str::markdown($feedback->content) : '-' !!}</div>
                            </div>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-0">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Aksi Cepat</h4>
                    @if (!in_array($aspiration->status, [AspirationStatusEnum::COMPLETED, AspirationStatusEnum::REJECTED]))
                        <a href="{{ route('dashboard.student.aspirations.edit', $aspiration->id) }}"
                            class="btn btn-warning w-100 mb-2">
                            <i class="ti ti-pencil me-1"></i> Edit Aspirasi
                        </a>
                    @endif
                    <form id="form-delete-{{ $aspiration->id }}" action="{{ route('dashboard.student.aspirations.destroy', $aspiration->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger w-100 btn-delete" data-id="{{ $aspiration->id }}" data-name="{{ $aspiration->title }}">
                            <i class="ti ti-trash me-1"></i> Hapus Aspirasi
                        </button>
                    </form>
                    <hr class="my-4">
                    <h4 class="card-title fw-semibold mb-3">Catatan</h4>
                    <p class="text-muted small">
                        Halaman ini hanya menampilkan detail data yang tersimpan. Untuk mengubah, klik tombol "Edit Aspirasi".
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Preview Image -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body p-0 text-center">
                    <img id="previewImage" src="" class="img-fluid rounded shadow" alt="Preview">
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const aspirationId = this.getAttribute('data-id');
                    const aspirationTitle = this.getAttribute('data-name');
                    Swal.fire({
                        title: "Hapus Aspirasi?",
                        text: "Apakah Anda yakin ingin menghapus \"" + aspirationTitle + "\"? Aksi ini tidak dapat dibatalkan.",
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.img-preview').forEach(img => {
                img.addEventListener('click', function () {
                    const fullImageUrl = this.getAttribute('data-full');
                    document.getElementById('previewImage').src = fullImageUrl;
                    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                    modal.show();
                });
            });
        });
    </script>
@endsection
