@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-0">Selamat Datang, {{ Auth::guard('admin')->user()->username }} 👋</h5>
    <small class="text-muted">Panel Manajemen Aspirasi Sekolah</small>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
        $stats = [
            ['label'=>'Total Aspirasi', 'val'=>$total,    'color'=>'#1a3c5e','bg'=>'#e8f0fe','icon'=>'bi-megaphone'],
            ['label'=>'Menunggu',       'val'=>$menunggu, 'color'=>'#856404','bg'=>'#fff3cd','icon'=>'bi-hourglass-split'],
            ['label'=>'Diproses',       'val'=>$diproses, 'color'=>'#084298','bg'=>'#cfe2ff','icon'=>'bi-arrow-repeat'],
            ['label'=>'Selesai',        'val'=>$selesai,  'color'=>'#0a3622','bg'=>'#d1e7dd','icon'=>'bi-check2-circle'],
        ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm stat-card h-100">
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

<div class="row g-3">
    {{-- Aspirasi Terbaru --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-0">
                <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0"><i class="bi bi-list-task me-2 text-primary"></i>Aspirasi Terbaru</h6>
                    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light"><tr>
                            <th class="px-4">Siswa</th><th>Kategori</th><th>Keterangan</th><th>Status</th>
                        </tr></thead>
                        <tbody>
                        @forelse($terbaru as $item)
                        <tr>
                            <td class="px-4">{{ $item->siswa->username ?? '-' }}<br>
                                <span class="text-muted" style="font-size:.72rem">{{ $item->siswa->kelas ?? '' }}</span></td>
                            <td><span class="badge bg-secondary">{{ $item->kategori->ket_kategori }}</span></td>
                            <td>{{ Str::limit($item->keterangan,35) }}</td>
                            <td>
                                <span class="badge badge-{{ $item->aspirasi->status ?? 'menunggu' }} rounded-pill">
                                    {{ ucfirst($item->aspirasi->status ?? 'menunggu') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada aspirasi.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Ringkasan per Kategori --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-0">
                <div class="px-4 py-3 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-secondary"></i>Per Kategori</h6>
                </div>
                @forelse($perKategori as $kat)
                <div class="px-4 py-2 border-bottom d-flex justify-content-between align-items-center">
                    <span class="small">{{ $kat->ket_kategori }}</span>
                    <span class="badge bg-primary rounded-pill">{{ $kat->inputaspirasi_count }}</span>
                </div>
                @empty
                <div class="px-4 py-3 text-muted small">Belum ada data.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection