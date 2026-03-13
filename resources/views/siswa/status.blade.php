@extends('layouts.dashboard')
@section('title', 'Status Aspirasi')
@section('page-title', 'Status Aspirasi')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-warning"></i>Aspirasi Aktif</h6>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-1"></i>Baru
            </a>
        </div>

        @forelse($aspirasis as $item)
        @php $asp = $item->aspirasi; $status = $asp->status ?? 'menunggu'; @endphp
        <div class="px-4 py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <span class="badge bg-secondary rounded-pill mb-1">{{ $item->kategori->ket_kategori ?? '-' }}</span>
                    <div class="small fw-semibold">{{ $item->keterangan }}</div>
                    <div class="text-muted" style="font-size:.78rem">
                        <i class="bi bi-geo-alt me-1"></i>{{ $item->lokasi }}
                    </div>
                </div>
                <span class="badge badge-{{ $status }} rounded-pill px-3 py-2">
                    {{ ucfirst($status) }}
                </span>
            </div>

            {{-- Tanggapan Admin — hanya tampil jika ada feedback --}}
            @if($asp && $asp->feedback)
            <div class="mt-2 p-2 rounded" style="background:#f8fafc;border-left:3px solid var(--accent)">
                <div class="small text-muted mb-1">
                    <i class="bi bi-chat-left-text me-1"></i><strong>Tanggapan Admin:</strong>
                </div>
                <div class="small">{{ $asp->feedback }}</div>
                @if($asp->rating)
                <div class="mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= $asp->rating ? '-fill text-warning' : '' }}" style="font-size:.8rem"></i>
                    @endfor
                </div>
                @endif
            </div>
            @else
            <div class="mt-2 small text-muted fst-italic">
                <i class="bi bi-hourglass me-1"></i>Belum ada tanggapan dari admin.
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox display-6 d-block mb-2"></i>
            <small>Belum ada aspirasi aktif.</small>
            <div class="mt-3">
                <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">Buat Aspirasi</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection