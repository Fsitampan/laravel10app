@extends('layouts.dashboard')
@section('title', 'Histori Aspirasi')
@section('page-title', 'Histori Aspirasi')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        <div class="px-4 py-3 border-bottom">
            <h6 class="fw-bold mb-0"><i class="bi bi-journal-check me-2 text-success"></i>Aspirasi Selesai</h6>
        </div>

        @forelse($historis as $item)
        <div class="px-4 py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <span class="badge bg-secondary rounded-pill mb-1">{{ $item->kategori->ket_kategori }}</span>
                    <div class="small fw-semibold">{{ $item->keterangan }}</div>
                    <div class="text-muted" style="font-size:.78rem">
                        <i class="bi bi-geo-alt me-1"></i>{{ $item->lokasi }}
                        &nbsp;·&nbsp;{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                    </div>
                </div>
                <span class="badge badge-selesai rounded-pill px-3 py-2">Selesai</span>
            </div>

            @if($item->aspirasi && $item->aspirasi->feedback)
            <div class="mt-2 p-2 rounded" style="background:#f0fdf4;border-left:3px solid #198754">
                <div class="small text-muted mb-1"><i class="bi bi-chat-left-text me-1"></i><strong>Tanggapan Admin:</strong></div>
                <div class="small">{{ $item->aspirasi->feedback }}</div>
                @if($item->aspirasi->rating)
                <div class="mt-1">
                    @for($i=1;$i<=5;$i++)
                        <i class="bi bi-star{{ $i <= $item->aspirasi->rating ? '-fill text-warning' : '' }}" style="font-size:.8rem"></i>
                    @endfor
                </div>
                @endif
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-journal-x display-6 d-block mb-2"></i>
            <small>Belum ada aspirasi yang selesai.</small>
        </div>
        @endforelse
    </div>
</div>
@endsection