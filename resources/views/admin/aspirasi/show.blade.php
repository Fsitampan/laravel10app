@extends('layouts.dashboard')
@section('title', 'Detail Aspirasi')
@section('page-title', 'Detail & Tanggapan Aspirasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        {{-- Tombol Kembali --}}
        <div class="mb-3">
            <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-link text-decoration-none text-muted p-0 small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>

        {{-- Detail Aspirasi --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-primary">
                    <i class="bi bi-info-circle me-2"></i>Informasi Aspirasi
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-4 small">
                    <div class="col-sm-6">
                        <label class="text-muted d-block mb-1">Pengirim</label>
                        <div class="fw-bold text-dark fs-6">{{ $input->siswa->username ?? '-' }}</div>
                        <span class="badge bg-light text-muted border fw-normal">{{ $input->siswa->kelas ?? '' }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted d-block mb-1">Kategori & Lokasi</label>
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium me-1">
                                {{ $input->kategori->ket_kategori }}
                            </span>
                            <span class="text-dark fw-medium"><i class="bi bi-geo-alt me-1"></i>{{ $input->lokasi }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="text-muted d-block mb-1">Isi Aspirasi</label>
                        <div class="p-3 bg-light rounded-3 border-start border-primary border-4 text-dark italic">
                            "{{ $input->keterangan }}"
                        </div>
                    </div>
                    <div class="col-sm-6 text-muted">
                        <i class="bi bi-calendar3 me-1"></i> 
                        {{ $input->created_at ? \Carbon\Carbon::parse($input->created_at)->format('d F Y, H:i') : '-' }}
                    </div>
                    <div class="col-sm-6 text-end">
                        @php
                            $status = strtolower($input->aspirasi->status ?? 'menunggu');
                            $color = match($status) {
                                'selesai' => 'success',
                                'proses', 'diproses' => 'warning',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-pill px-4 py-2 fw-bold border border-{{ $color }} border-opacity-25">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Tanggapan --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4 text-success">
                    <i class="bi bi-chat-left-dots me-2"></i>Beri Tanggapan
                </h6>

                <form action="{{ route('admin.aspirasi.update', $input->id_pelaporan) }}" method="POST">
                    @csrf 
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Ubah Status</label>
                            <select name="status" class="form-select rounded-3 @error('status') is-invalid @enderror">
                                @foreach(['menunggu','diproses','selesai'] as $s)
                                <option value="{{ $s }}" {{ ($input->aspirasi->status ?? 'menunggu') == $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Beri Rating</label>
                            <div class="d-flex gap-2" id="star-group">
                                @for($i=1;$i<=5;$i++)
                                <div class="form-check p-0 m-0">
                                    <input class="form-check-input d-none" type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ old('rating', $input->aspirasi->rating ?? '') == $i ? 'checked' : '' }}>
                                    <label class="star-label fs-3" for="star{{ $i }}" style="cursor:pointer; color:#dee2e6 transition: 0.2s">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                </div>
                                @endfor
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Feedback / Tanggapan <span class="text-muted fw-normal">(Maks. 50 Karakter)</span></label>
                            <textarea name="feedback" rows="3" maxlength="50" class="form-control rounded-3 @error('feedback') is-invalid @enderror" placeholder="Tuliskan tindakan atau pesan singkat...">{{ old('feedback', $input->aspirasi->feedback ?? '') }}</textarea>
                            @error('feedback')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-success rounded-3 px-4 fw-bold">
                                <i class="bi bi-check-circle me-1"></i> Simpan Tanggapan
                            </button>
                        </div>
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
        stars.forEach((s, i) => {
            s.style.color = i < n ? '#ffc107' : '#dee2e6';
            s.style.transform = i < n ? 'scale(1.1)' : 'scale(1)';
        });
    }

    // Init state
    inputs.forEach((inp, i) => { if (inp.checked) paintStars(i + 1); });

    stars.forEach((star, i) => {
        star.addEventListener('mouseover', () => paintStars(i + 1));
        star.addEventListener('mouseout', () => {
            const checkedIndex = [...inputs].findIndex(r => r.checked);
            paintStars(checkedIndex >= 0 ? checkedIndex + 1 : 0);
        });
        star.addEventListener('click', () => {
            paintStars(i + 1);
            inputs[i].checked = true;
        });
    });
</script>
@endpusha