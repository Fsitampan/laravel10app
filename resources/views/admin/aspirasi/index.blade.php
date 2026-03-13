@extends('layouts.dashboard')
@section('title', 'Kelola Aspirasi')
@section('page-title', 'Kelola Aspirasi')

@section('content')
{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3" style="border-radius:14px">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.aspirasi.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Nama Siswa</label>
                <input type="text" name="nama" class="form-control form-control-sm" placeholder="Cari nama..." value="{{ request('nama') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Kategori</label>
                <select name="id_kategori" class="form-select form-select-sm">
                    <option value="">-- Semua --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->ket_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill"><i class="bi bi-search me-1"></i>Filter</button>
                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        <div class="px-4 py-3 border-bottom">
            <h6 class="fw-bold mb-0"><i class="bi bi-list-task me-2 text-primary"></i>
                Daftar Aspirasi
                <span class="badge bg-secondary ms-1">{{ $aspirasis->total() }}</span>
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">#</th>
                        <th>Siswa / Kelas</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($aspirasis as $i => $item)
                <tr>
                    <td class="px-4 text-muted">{{ $aspirasis->firstItem() + $i }}</td>
                    <td>
                        <div class="fw-semibold">{{ $item->siswa->username ?? '-' }}</div>
                        <small class="text-muted">{{ $item->siswa->kelas ?? '' }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ $item->kategori->ket_kategori }}</span></td>
                    <td>{{ Str::limit($item->keterangan, 40) }}</td>
                    <td class="text-muted">{{ $item->lokasi }}</td>
                    <td class="text-muted">{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $item->aspirasi->status ?? 'menunggu' }} rounded-pill">
                            {{ ucfirst($item->aspirasi->status ?? 'menunggu') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.aspirasi.show', $item->id_pelaporan) }}" class="btn btn-sm btn-outline-primary py-0 px-2">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-5">Tidak ada data aspirasi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($aspirasis->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-end">
            {{ $aspirasis->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection