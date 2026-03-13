@extends('layouts.dashboard')
@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="row g-3 align-items-start">

    {{-- Form Tambah --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Kategori</h6>
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Kategori</label>
                        <input type="text" name="ket_kategori" maxlength="50"
                            class="form-control form-control-sm @error('ket_kategori') is-invalid @enderror"
                            placeholder="Contoh: Fasilitas Sekolah" value="{{ old('ket_kategori') }}">
                        @error('ket_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Kategori --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-0">
                <div class="px-4 py-3 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-secondary"></i>
                        Daftar Kategori <span class="badge bg-secondary ms-1">{{ $kategoris->count() }}</span>
                    </h6>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($kategoris as $k)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4">
                        <span class="small fw-semibold">{{ $k->ket_kategori }}</span>
                        <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST"
                            onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-5 small">Belum ada kategori.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection