@extends('layouts.app')

@section('title')
Dashboard Admin
@endsection


@section('menu')

<li class="nav-item">
<a href="#" class="nav-link text-white">Dashboard</a>
</li>

<li class="nav-item">
<a href="#" class="nav-link text-white">Data Siswa</a>
</li>

<li class="nav-item">
<a href="#" class="nav-link text-white">Aspirasi</a>
</li>

<li class="nav-item">
<a href="#" class="nav-link text-white">Kategori</a>
</li>

@endsection


@section('content')

<h3 class="fw-bold mb-4">
Dashboard Admin
</h3>

<div class="row g-4">

<div class="col-md-4">
<div class="card shadow-sm border-0">
<div class="card-body">
<h6 class="text-muted">Total Siswa</h6>
<h3 class="fw-bold">120</h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card shadow-sm border-0">
<div class="card-body">
<h6 class="text-muted">Total Aspirasi</h6>
<h3 class="fw-bold">45</h3>
</div>
</div>
</div>

</div>

@endsection