@extends('layouts.app')

@section('title')
Dashboard Siswa
@endsection


@section('menu')

<li class="nav-item">
<a href="#" class="nav-link text-white">Dashboard</a>
</li>

<li class="nav-item">
<a href="#" class="nav-link text-white">Buat Aspirasi</a>
</li>

<li class="nav-item">
<a href="#" class="nav-link text-white">Riwayat Aspirasi</a>
</li>

@endsection


@section('content')

<h3 class="fw-bold mb-4">
Dashboard Siswa
</h3>

<div class="card shadow-sm border-0">

<div class="card-body">

<h5 class="fw-bold">
Selamat Datang
</h5>

<p class="text-muted">
Silakan buat aspirasi atau melihat status laporan anda.
</p>

</div>

</div>

@endsection