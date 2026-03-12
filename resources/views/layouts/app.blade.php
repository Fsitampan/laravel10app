<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
<div class="container">

<a class="navbar-brand fw-bold" href="#">
Sistem Aspirasi
</a>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="btn btn-light btn-sm">Logout</button>
</form>

</div>
</nav>


<div class="d-flex">

<!-- SIDEBAR -->

<div class="bg-dark text-white p-3 vh-100" style="width:240px">

<h5 class="fw-bold mb-4">
Menu
</h5>

<ul class="nav flex-column">

@yield('menu')

</ul>

</div>


<!-- CONTENT -->

<div class="flex-grow-1 p-4">

@yield('content')

</div>

</div>

</body>
</html>