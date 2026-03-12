<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary bg-gradient d-flex align-items-center justify-content-center" style="min-height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                
                <div class="card-header bg-white border-0 pt-5 pb-3 text-center">
                    <h3 class="fw-bold text-dark">Selamat Datang</h3>
                    <p class="text-muted small">Silakan pilih peran dan login</p>
                </div>
                
                <div class="card-body px-4 pb-5">
                    <ul class="nav nav-pills nav-justified mb-4 bg-light p-1 rounded-pill" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill fw-semibold" id="siswa-tab" data-bs-toggle="pill" type="button" role="tab" onclick="setRole('siswa')">Siswa</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill fw-semibold" id="admin-tab" data-bs-toggle="pill" type="button" role="tab" onclick="setRole('admin')">Admin</button>
                        </li>
                    </ul>

                    @if($errors->any())
                        <div class="alert alert-danger py-2 px-3 rounded-3 mb-3" role="alert">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="identifier" id="label-identifier" class="form-label small fw-bold text-secondary">Nomor Induk Siswa (NIS)</label>
                            <input type="text" class="form-control form-control-lg fs-6 rounded-3" id="identifier" name="identifier" value="{{ old('identifier') }}" placeholder="Contoh: 12345" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                            <input type="password" class="form-control form-control-lg fs-6 rounded-3" id="password" name="password" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fs-6 fw-bold shadow-sm">
                                Masuk ke Dashboard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center mt-4 text-white-50 small">
                &copy; {{ date('Y') }} Sistem Informasi Sekolah
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Logika ganti label tetap dibutuhkan agar user tidak bingung
    function setRole(role) {
        const label = document.getElementById('label-identifier');
        const input = document.getElementById('identifier');
        
        if(role === 'siswa') {
            label.innerText = 'Nomor Induk Siswa (NIS)';
            input.placeholder = 'Contoh: 12345';
        } else {
            label.innerText = 'Username Admin';
            input.placeholder = 'Contoh: admin_pusat';
        }
    }

    // Auto-switch tab jika ada error input admin sebelumnya
    document.addEventListener("DOMContentLoaded", function() {
        let oldInput = "{{ old('identifier') }}";
        if (oldInput && isNaN(oldInput)) {
            let adminTab = new bootstrap.Tab(document.getElementById('admin-tab'));
            adminTab.show();
            setRole('admin');
        }
    });
</script>
</body>
</html>