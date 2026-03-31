@extends('layouts.dashboard')
@section('title', 'Kelola Aspirasi')
@section('page-title', 'Kelola Aspirasi')

@section('content')
{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4 rounded-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.aspirasi.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="form-control form-control-sm rounded-3" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1">Nama Siswa</label>
                <input type="text" name="nama" class="form-control form-control-sm rounded-3" placeholder="Cari nama..." value="{{ request('nama') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1">Kategori</label>
                <select name="id_kategori" class="form-select form-select-sm rounded-3">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->ket_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill rounded-3">
                    <i class="bi bi-filter me-1"></i>Filter
                </button>
                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-light border btn-sm rounded-3">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold mb-0 d-flex align-items-center">
            <i class="bi bi-chat-left-text me-2 text-primary"></i>
            Daftar Aspirasi
            <span class="badge bg-light text-dark border ms-2 fw-medium">{{ $aspirasis->total() }}</span>
        </h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small">
                <tr>
                    <th class="px-4 py-3 border-0">#</th>
                    <th class="border-0">Siswa / Kelas</th>
                    <th class="border-0">Kategori</th>
                    <th class="border-0">Keterangan</th>
                    <th class="border-0">Lokasi</th>
                    <th class="border-0">Tanggal</th>
                    <th class="border-0 text-center">Status</th>
                    <th class="border-0 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="small text-dark">
            @forelse($aspirasis as $i => $item)
            <tr>
                <td class="px-4 text-muted">{{ $aspirasis->firstItem() + $i }}</td>
                <td>
                    <div class="fw-bold">{{ $item->siswa->username ?? '-' }}</div>
                    <div class="text-muted" style="font-size: 11px">{{ $item->siswa->kelas ?? '' }}</div>
                </td>
                <td>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-medium px-2 py-1">
                        {{ $item->kategori->ket_kategori }}
                    </span>
                </td>
                <td title="{{ $item->keterangan }}">{{ Str::limit($item->keterangan, 30) }}</td>
                <td class="text-muted">{{ $item->lokasi }}</td>
                
                {{-- PERBAIKAN ERROR DI SINI --}}
                <td class="text-muted">
                    {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/y') : '-' }}
                </td>

                <td class="text-center">
                    @php
                        $status = strtolower($item->aspirasi->status ?? 'menunggu');
                        $color = match($status) {
                            'selesai' => 'success',
                            'proses', 'diproses' => 'warning',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-pill px-3 py-1 fw-bold">
                        {{ ucfirst($status) }}
                    </span>
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.aspirasi.show', $item->id_pelaporan) }}" class="btn btn-sm btn-light border rounded-3 p-1 px-2 shadow-sm text-primary">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="opacity-25 mb-3">
                    <p class="text-muted mb-0">Belum ada aspirasi masuk.</p>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if($aspirasis->hasPages())
    <div class="card-footer bg-white border-top py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="small text-muted">Menampilkan {{ $aspirasis->firstItem() }} - {{ $aspirasis->lastItem() }} data</span>
            {{ $aspirasis->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsectiona