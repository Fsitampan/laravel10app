@extends('layouts.dashboard')
@section('title', 'Input Aspirasi')
@section('page-title', 'Input Aspirasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4"><i class="bi bi-megaphone me-2 text-primary"></i>Sampaikan Aspirasi</h6>

                <form action="{{ route('siswa.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kategori</label>
                        <select name="id_kategori" class="form-select form-select-sm @error('id_kategori') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->ket_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control form-control-sm @error('lokasi') is-invalid @enderror"
                            placeholder="Contoh: Ruang Kelas XII-A" value="{{ old('lokasi') }}" maxlength="50">
                        @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Keterangan</label>
                        <textarea name="keterangan" rows="4" maxlength="50"
                            class="form-control form-control-sm @error('keterangan') is-invalid @enderror"
                            placeholder="Jelaskan aspirasi kamu...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-send me-1"></i> Kirim Aspirasi
                        </button>
                        <a href="{{ route('siswa.dashboard_siswa') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection