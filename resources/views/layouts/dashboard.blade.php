<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aspirasi Sekolah')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 240px;
            --primary: #1a3c5e;
            --accent: #2e86de;
            --light-bg: #f0f4f8;
        }
        body { background: var(--light-bg); font-family: 'Segoe UI', sans-serif; }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-w); min-height: 100vh; position: fixed;
            background: var(--primary); top: 0; left: 0; z-index: 1000;
            transition: transform .25s ease;
        }
        #sidebar .brand { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        #sidebar .brand h6 { color: #fff; font-weight: 700; font-size: .95rem; margin: 0; }
        #sidebar .brand small { color: rgba(255,255,255,.5); font-size: .72rem; }
        #sidebar .nav-link {
            color: rgba(255,255,255,.7); padding: .55rem 1.5rem;
            font-size: .875rem; border-radius: 0; transition: all .2s;
            display: flex; align-items: center; gap: .6rem;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            color: #fff; background: rgba(255,255,255,.1);
            border-left: 3px solid var(--accent);
        }
        #sidebar .nav-label { color: rgba(255,255,255,.35); font-size: .68rem;
            letter-spacing: .08em; text-transform: uppercase; padding: 1rem 1.5rem .4rem; }

        /* Main */
        #main { margin-left: var(--sidebar-w); min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem; position: sticky; top: 0; z-index: 999; }
        .content-area { padding: 1.75rem 1.5rem; }

        /* Cards */
        .stat-card { border: none; border-radius: 12px; overflow: hidden; }
        .stat-card .icon-box { width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }

        /* Badge status */
        .badge-menunggu  { background: #fff3cd; color: #856404; }
        .badge-diproses  { background: #cfe2ff; color: #084298; }
        .badge-selesai   { background: #d1e7dd; color: #0a3622; }

        /* Responsive */
        @media(max-width:768px){
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<nav id="sidebar">
    <div class="brand">
        <h6><i class="bi bi-megaphone-fill me-2" style="color:var(--accent)"></i>Aspirasi Sekolah</h6>
        <small>
            @auth('siswa') Siswa &mdash; {{ Auth::guard('siswa')->user()->username }}
            @endauth
            @auth('admin') Admin &mdash; {{ Auth::guard('admin')->user()->username }}
            @endauth
        </small>
    </div>

    <nav class="mt-2">
        @auth('siswa')
            <div class="nav-label">Menu</div>
            <a href="{{ route('siswa.dashboard_siswa') }}" class="nav-link @active('siswa.dashboard_siswa')"><i class="bi bi-house"></i> Dashboard</a>
            <a href="{{ route('siswa.create') }}"          class="nav-link @active('siswa.create')"><i class="bi bi-plus-circle"></i> Input Aspirasi</a>
            <a href="{{ route('siswa.status') }}"          class="nav-link @active('siswa.status')"><i class="bi bi-clock-history"></i> Status Aspirasi</a>
            <a href="{{ route('siswa.histori') }}"         class="nav-link @active('siswa.histori')"><i class="bi bi-journal-check"></i> Histori</a>
        @endauth

        @auth('admin')
            <div class="nav-label">Menu</div>
            <a href="{{ route('admin.dashboard_admin') }}"   class="nav-link @active('admin.dashboard_admin')"><i class="bi bi-house"></i> Dashboard</a>
            <a href="{{ route('admin.aspirasi.index') }}"    class="nav-link @active('admin.aspirasi.index')"><i class="bi bi-list-task"></i> Kelola Aspirasi</a>
            <a href="{{ route('admin.kategori.index') }}"    class="nav-link @active('admin.kategori.index')"><i class="bi bi-tags"></i> Kategori</a>
        @endauth

        <div class="nav-label">Akun</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link w-100 text-start" style="border:none;background:none;">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</nav>

{{-- MAIN --}}
<div id="main">
    {{-- TOPBAR --}}
    <div class="topbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <span class="fw-semibold text-secondary small">@yield('page-title', 'Dashboard')</span>
        </div>
        <span class="text-muted small d-none d-md-block">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

    {{-- CONTENT --}}
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>a