@extends('layouts.dashboard')
@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')

@section('content')
{{-- Greeting --}}
<div class="mb-4">
    <h5 class="fw-bold mb-0">Halo, {{ Auth::guard('siswa')->user()->username }} 👋</h5>
    <small class="text-muted">Kelas {{ Auth::guard('siswa')->user()->kelas }}</small>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
        $stats = [
            ['label'=>'Total Aspirasi',  'val'=>$total,    'color'=>'#1a3c5e', 'bg'=>'#e8f0fe', 'icon'=>'bi-megaphone'],
            ['label'=>'Menunggu',        'val'=>$menunggu, 'color'=>'#856404', 'bg'=>'#fff3cd', 'icon'=>'bi-hourglass-split'],
            ['label'=>'Diproses',        'val'=>$diproses, 'color'=>'#084298', 'bg'=>'#cfe2ff', 'icon'=>'bi-arrow-repeat'],
            ['label'=>'Selesai',         'val'=>$selesai,  'color'=>'#0a3622', 'bg'=>'#d1e7dd', 'icon'=>'bi-check2-circle'],
        ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:{{ $s['bg'] }};color:{{ $s['color'] }}">
                    <i class="bi {{ $s['icon'] }}"></i>
                </div>
                <div>
                    <div class="fw-bold fs-4 lh-1" style="color:{{ $s['color'] }}">{{ $s['val'] }}</div>
                    <div class="text-muted small">{{ $s['label'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Quick Action --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm" style="border-radius:12px">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2 text-primary"></i>Input Aspirasi Baru</h6>
                <p class="text-muted small mb-3">Sampaikan aspirasimu agar dapat segera ditindaklanjuti.</p>
                <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm px-4">
                    <i class="bi bi-send me-1"></i> Buat Aspirasi
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm" style="border-radius:12px">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-warning"></i>Aspirasi Aktif</h6>
                @forelse($aktif as $item)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="small fw-semibold">{{ $item->kategori->ket_kategori }}</div>
                        <div class="text-muted" style="font-size:.78rem">{{ Str::limit($item->keterangan, 40) }}</div>
                    </div>
                    <span class="badge badge-{{ $item->aspirasi->status ?? 'menunggu' }} rounded-pill px-2">
                        {{ ucfirst($item->aspirasi->status ?? 'menunggu') }}
                    </span>
                </div>
                @empty
                <p class="text-muted small mb-0">Tidak ada aspirasi aktif.</p>
                @endforelse
                @if($aktif->count())
                    <a href="{{ route('siswa.status') }}" class="btn btn-outline-secondary btn-sm mt-3">Lihat Semua</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection