<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SISCOM - Sistem Pengaduan Sekolah</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            transition: all 0.3s;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white !important;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s;
            margin: 0 10px;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .btn-login {
            background: white;
            color: #667eea !important;
            border-radius: 25px;
            padding: 8px 25px;
            font-weight: 600;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-register {
            background: transparent;
            border: 2px solid white;
            color: white !important;
            border-radius: 25px;
            padding: 8px 25px;
            font-weight: 600;
        }

        .btn-register:hover {
            background: white;
            color: #667eea !important;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 85vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .btn-hero {
            background: white;
            color: #667eea;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            margin-right: 15px;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: #667eea;
        }

        .btn-outline-hero {
            background: transparent;
            border: 2px solid white;
            color: white;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-outline-hero:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        .btn-create-complaint {
            background: #ffd700;
            color: #667eea;
            border: none;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            margin-left: 15px;
        }

        .btn-create-complaint:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            background: #ffed4a;
            color: #667eea;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fc;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .feature-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .feature-card h4 {
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* How It Works */
        .how-it-works {
            padding: 80px 0;
            background: white;
        }

        .step-card {
            text-align: center;
            padding: 20px;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-cta {
            background: white;
            color: #667eea;
            border-radius: 50px;
            padding: 12px 40px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* Modal Warning */
        .warning-modal .modal-content {
            border-radius: 20px;
            border: none;
        }

        .warning-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px;
            text-align: center;
        }

        .warning-icon {
            font-size: 4rem;
            color: #ffd700;
            margin-bottom: 10px;
        }

        .btn-warning-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 30px;
            margin: 0 5px;
        }

        .btn-warning-register {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 30px;
            margin: 0 5px;
        }

        /* Footer */
        footer {
            background: #2d2d3a;
            color: rgba(255,255,255,0.7);
            padding: 50px 0 20px;
        }

        footer h5 {
            color: white;
            margin-bottom: 20px;
        }

        footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
        }

        footer a:hover {
            color: white;
        }

        .social-icons a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 35px;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: #667eea;
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
            .btn-hero, .btn-outline-hero, .btn-create-complaint {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-school"></i> SISCOM
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#how-it-works">Cara Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Kontak</a>
                </li>
                @auth
                    @if(Auth::user()->role == 'student')
                        <li class="nav-item">
                            <a class="nav-link btn-login" href="{{ route('student.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link btn-login" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'super_admin')
                        <li class="nav-item">
                            <a class="nav-link btn-login" href="{{ route('superadmin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link btn-register" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn-login" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-register" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="row">
            <div class="text-center col-12" data-aos="fade-up">
                <h1>Sistem Pengaduan <br>Sekolah <span style="color: #ffd700;">Online</span></h1>
                <p class="mx-auto" style="max-width: 700px;">SISCOM adalah platform pengaduan dan aspirasi siswa yang memudahkan komunikasi antara siswa dan pihak sekolah. Sampaikan keluhan, saran, atau aspirasimu dengan mudah dan cepat.</p>
                <div class="mt-4">
                    @auth
                        @if(Auth::user()->role == 'student')
                            <a href="{{ route('student.dashboard') }}" class="btn btn-hero">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <button class="btn-create-complaint" data-bs-toggle="modal" data-bs-target="#createComplaintModal">
                                <i class="fas fa-plus-circle"></i> Buat Aspirasi
                            </button>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-hero">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-hero">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </a>
                        <button class="btn-create-complaint" id="btnCreateComplaintWarning">
                            <i class="fas fa-plus-circle"></i> Buat Aspirasi
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features" id="features">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Fitur Unggulan</h2>
            <p>Kami menyediakan berbagai fitur untuk memudahkan proses pengaduan</p>
        </div>
        <div class="row">
            <div class="mb-4 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h4>Kirim Aspirasi</h4>
                    <p>Sampaikan keluhan, saran, atau aspirasi dengan mudah melalui platform online.</p>
                </div>
            </div>
            <div class="mb-4 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-reply-all"></i>
                    </div>
                    <h4>Feedback Langsung</h4>
                    <p>Dapatkan tanggapan dan solusi dari pihak sekolah secara cepat dan transparan.</p>
                </div>
            </div>
            <div class="mb-4 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Pantau Status</h4>
                    <p>Lihat perkembangan aspirasimu dari status pending hingga selesai diproses.</p>
                </div>
            </div>
            <div class="mb-4 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h4>Kategori Tepat</h4>
                    <p>Pilih kategori yang sesuai agar aspirasimu sampai ke admin yang tepat.</p>
                </div>
            </div>
            <div class="mb-4 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h4>Dashboard Statistik</h4>
                    <p>Lihat statistik aspirasimu dalam bentuk grafik yang mudah dipahami.</p>
                </div>
            </div>
            <div class="mb-4 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Aman & Terpercaya</h4>
                    <p>Data Anda aman dengan sistem keamanan yang terjamin.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works" id="how-it-works">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Cara Kerja</h2>
            <p>Mudah! Hanya 3 langkah sederhana</p>
        </div>
        <div class="row">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h4>Daftar Akun</h4>
                    <p>Registrasi menggunakan NIS dan email kamu.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h4>Buat Aspirasi</h4>
                    <p>Tulis keluhan atau aspirasi dengan jelas.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h4>Dapatkan Feedback</h4>
                    <p>Tunggu tanggapan dari admin sekolah.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container" data-aos="zoom-in">
        <h2>Siap Menyampaikan Aspirasi?</h2>
        <p>Bergabunglah sekarang dan sampaikan aspirasimu dengan mudah!</p>
        <div>
            <a href="{{ route('register') }}" class="btn btn-cta">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        </div>
    </div>
</section>

<!-- Modal Warning Login -->
<div class="modal fade" id="warningLoginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content warning-modal">
            <div class="warning-header">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h4>Perhatian!</h4>
                <p class="mb-0">Kamu harus login terlebih dahulu</p>
            </div>
            <div class="py-4 text-center modal-body">
                <p>Untuk membuat aspirasi, kamu harus login sebagai siswa.</p>
                <p class="text-muted small">Belum punya akun? Daftar dulu yuk!</p>
            </div>
            <div class="pb-4 border-0 modal-footer justify-content-center">
                <a href="{{ route('login') }}" class="btn btn-warning-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-warning-register">
                    <i class="fas fa-user-plus"></i> Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Aspirasi (untuk user yang sudah login) -->
@auth
@if(Auth::user()->role == 'student')
<div class="modal fade" id="createComplaintModal" tabindex="-1">
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
                        <label class="form-label">Kategori Aspirasi <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="Masukkan judul aspirasi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi <span class="text-muted">(opsional)</span></label>
                        <input type="text" name="location" class="form-control" placeholder="Contoh: Kelas 10 A, Laboratorium Komputer, Lapangan, dll">
                        <small class="text-muted">Isi lokasi kejadian (jika perlu)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="content" rows="5" class="form-control" required placeholder="Jelaskan aspirasi Anda secara detail"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">Kirim Aspirasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

<!-- Footer -->
<footer id="contact">
    <div class="container">
        <div class="row">
            <div class="mb-4 col-md-4">
                <h5><i class="fas fa-school"></i> SISCOM</h5>
                <p>Sistem Pengaduan Sekolah yang memudahkan siswa menyampaikan aspirasi kepada pihak sekolah.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="mb-4 col-md-4">
                <h5>Link Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#how-it-works">Cara Kerja</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Daftar</a></li>
                </ul>
            </div>
            <div class="mb-4 col-md-4">
                <h5>Kontak</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-envelope"></i> info@siscom.sch.id</li>
                    <li><i class="fas fa-phone"></i> (021) 1234-5678</li>
                    <li><i class="fas fa-map-marker-alt"></i> JL. Pendidikan No. 123, Depok</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 SISCOM - Sistem Komplain Sekolah. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.style.padding = '0.5rem 0';
            navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        } else {
            navbar.style.padding = '1rem 0';
            navbar.style.boxShadow = 'none';
        }
    });

    // Tombol Buat Aspirasi untuk user belum login
    const btnWarning = document.getElementById('btnCreateComplaintWarning');
    if (btnWarning) {
        btnWarning.addEventListener('click', function() {
            const warningModal = new bootstrap.Modal(document.getElementById('warningLoginModal'));
            warningModal.show();
        });
    }
</script>
</body>
</html>
