@extends('layouts.dashboard')
@section('title', 'Detail Aspirasi')
@section('page-title', 'Detail & Tanggapan Aspirasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Detail Aspirasi --}}
        <div class="card border-0 shadow-sm mb-3" style="border-radius:14px">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Detail Aspirasi</h6>
                <div class="row g-2 small">
                    <div class="col-5 text-muted">Siswa</div>
                    <div class="col-7 fw-semibold">{{ $input->siswa->username ?? '-' }}
                        <span class="text-muted fw-normal">({{ $input->siswa->kelas ?? '' }})</span>
                    </div>
                    <div class="col-5 text-muted">Kategori</div>
                    <div class="col-7"><span class="badge bg-secondary">{{ $input->kategori->ket_kategori }}</span></div>
                    <div class="col-5 text-muted">Lokasi</div>
                    <div class="col-7">{{ $input->lokasi }}</div>
                    <div class="col-5 text-muted">Keterangan</div>
                    <div class="col-7">{{ $input->keterangan }}</div>
                    <div class="col-5 text-muted">Tanggal Masuk</div>
                    <div class="col-7">{{ $input->created_at ? $input->created_at->format('d M Y, H:i') : '-' }}</div>
                    <div class="col-5 text-muted">Status Saat Ini</div>
                    <div class="col-7">
                        <span class="badge badge-{{ $input->aspirasi->status ?? 'menunggu' }} rounded-pill px-3 py-2">
                            {{ ucfirst($input->aspirasi->status ?? 'menunggu') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Tanggapan --}}
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-chat-left-dots me-2 text-success"></i>Beri Tanggapan</h6>

                <form action="{{ route('admin.aspirasi.update', $input->id_pelaporan) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm @error('status') is-invalid @enderror">
                            @foreach(['menunggu','diproses','selesai'] as $s)
                            <option value="{{ $s }}" {{ ($input->aspirasi->status ?? 'menunggu') == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Feedback / Tanggapan</label>
                        <textarea name="feedback" rows="3" maxlength="50"
                            class="form-control form-control-sm @error('feedback') is-invalid @enderror"
                            placeholder="Tulis tanggapan...">{{ old('feedback', $input->aspirasi->feedback ?? '') }}</textarea>
                        @error('feedback')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Rating</label>
                        <div class="d-flex gap-3" id="star-group">
                            @for($i=1;$i<=5;$i++)
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input visually-hidden" type="radio" name="rating"
                                    id="star{{ $i }}" value="{{ $i }}"
                                    {{ old('rating', $input->aspirasi->rating ?? '') == $i ? 'checked' : '' }}>
                                <label class="form-check-label fs-4 star-label" for="star{{ $i }}"
                                    style="cursor:pointer;color:#dee2e6">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-sm px-4">
                            <i class="bi bi-save me-1"></i> Simpan Tanggapan
                        </button>
                        <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const stars = document.querySelectorAll('.star-label');
    const inputs = document.querySelectorAll('input[name="rating"]');

    function paintStars(n) {
        stars.forEach((s, i) => s.style.color = i < n ? '#ffc107' : '#dee2e6');
    }

    // Init
    inputs.forEach((inp, i) => { if (inp.checked) paintStars(i + 1); });

    stars.forEach((star, i) => {
        star.addEventListener('mouseover', () => paintStars(i + 1));
        star.addEventListener('mouseout',  () => {
            const checked = [...inputs].findIndex(r => r.checked);
            paintStars(checked >= 0 ? checked + 1 : 0);
        });
        star.addEventListener('click', () => paintStars(i + 1));
    });
</script>
@endpush