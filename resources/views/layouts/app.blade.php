<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SISCOM - @yield('title', 'School Complaint System')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .nav-link-custom {
            color: rgba(255,255,255,0.9) !important;
            transition: all 0.3s;
            margin: 0 5px;
        }

        .nav-link-custom:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .nav-link-custom.active {
            color: white !important;
            font-weight: 600;
            border-bottom: 2px solid white;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 3rem;
            opacity: 0.15;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        footer {
            background: white;
            padding: 20px 0;
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #e3e6f0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-school"></i> SISCOM
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    {{-- MENU UNTUK STUDENT --}}
                    @if(Auth::user()->role == 'student')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
                               href="{{ route('student.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('student.history') ? 'active' : '' }}"
                               href="{{ route('student.history') }}">
                                <i class="fas fa-history"></i> History
                            </a>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link nav-link-custom btn btn-link" data-bs-toggle="modal" data-bs-target="#addAspirasiModal">
                                <i class="fas fa-plus-circle"></i> Buat Aspirasi
                            </button>
                        </li>
                    @endif

                    {{-- MENU UNTUK ADMIN --}}
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('admin.history') ? 'active' : '' }}"
                               href="{{ route('admin.history') }}">
                                <i class="fas fa-history"></i> History Feedback
                            </a>
                        </li>
                    @endif

                    {{-- MENU UNTUK SUPER ADMIN --}}
                    @if(Auth::user()->role == 'super_admin')
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}"
                               href="{{ route('superadmin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('superadmin.complaints') ? 'active' : '' }}"
                               href="{{ route('superadmin.complaints') }}">
                                <i class="fas fa-list"></i> Semua Aspirasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('superadmin.create-admin') ? 'active' : '' }}"
                               href="{{ route('superadmin.create-admin') }}">
                                <i class="fas fa-user-plus"></i> Tambah Admin
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- User Dropdown -->
            @auth
            <div class="dropdown ms-3">
                <button class="btn btn-link text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-lg"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i> Profile
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Main Content -->
<main style="min-height: calc(100vh - 150px);">
    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<!-- Footer -->
<footer>
    <div class="container">
        <p class="mb-0 text-muted">&copy; {{ date('Y') }} SISCOM - Sistem Komplain Sekolah. All rights reserved.</p>
    </div>
</footer>

<!-- Modal Add Aspirasi (hanya untuk student) -->
@auth
@if(Auth::user()->role == 'student')
<div class="modal fade" id="addAspirasiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-paper-plane"></i> Buat Aspirasi Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('student.complaint.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori Aspirasi</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" required placeholder="Masukkan judul aspirasi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="content" rows="5" class="form-control" required placeholder="Jelaskan aspirasi Anda secara detail"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient">Kirim Aspirasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
