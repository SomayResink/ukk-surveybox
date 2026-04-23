@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px;">
                <div class="card-body">
                    <h3 class="mb-2"><i class="fas fa-crown"></i> Dashboard Super Admin</h3>
                    <p class="mb-0">Kelola seluruh sistem pengaduan sekolah</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6 class="text-muted mb-2">Total Siswa</h6>
                    <h2 class="mb-0">{{ $stats['total_students'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h6 class="text-muted mb-2">Total Admin</h6>
                    <h2 class="mb-0 text-success">{{ $stats['total_admins'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h6 class="text-muted mb-2">Total Kategori</h6>
                    <h2 class="mb-0 text-info">{{ $stats['total_categories'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h6 class="text-muted mb-2">Total Aspirasi</h6>
                    <h2 class="mb-0 text-warning">{{ $stats['total_complaints'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-3">
            <div class="card chart-card">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-user-plus"></i> Tambah Admin Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.create-admin') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama Admin</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukkan nama admin" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="admin@sekolah.com" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="********" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient w-100">
                            <i class="fas fa-save"></i> Buat Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card chart-card">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Kategori Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.create-category') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: UKS, Perpustakaan, dll" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi kategori ini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-gradient w-100">
                            <i class="fas fa-save"></i> Tambah Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Admin -->
    <div class="card chart-card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-users"></i> Daftar Admin</h6>
            <span class="badge bg-primary">{{ $admins->count() }} Admin</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kategori</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($admin->category->name ?? '-') }}</span>
                            </td>
                            <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form action="{{ route('superadmin.delete-admin', $admin) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin {{ $admin->name }}?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-user-slash fa-2x text-muted"></i>
                                <p class="mt-2 mb-0">Belum ada admin</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Aspirasi Terbaru -->
    <div class="card chart-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-clock"></i> Aspirasi Terbaru</h6>
            <a href="{{ route('superadmin.complaints') }}" class="btn btn-sm btn-gradient">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Siswa</th>
                            <th>NIS</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComplaints as $complaint)
                        <tr>
                            <td>{{ $complaint->student->name }}</td>
                            <td>{{ $complaint->student->nis }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($complaint->category->name) }}</span>
                            </td>
                            <td>{{ Str::limit($complaint->title, 40) }}</td>
                            <td>
                                <span class="status-badge
                                    @if($complaint->status == 'pending') bg-warning text-dark
                                    @elseif($complaint->status == 'processed') bg-info text-white
                                    @elseif($complaint->status == 'resolved') bg-success text-white
                                    @else bg-danger text-white @endif">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </td>
                            <td>{{ $complaint->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted"></i>
                                <p class="mt-2 mb-0">Belum ada aspirasi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
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

.chart-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.chart-card .card-header {
    background: white;
    border-bottom: 1px solid #e3e6f0;
    padding: 1rem 1.5rem;
    border-radius: 15px 15px 0 0;
}

.btn-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    transition: all 0.3s;
}

.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-block;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #e0e0e0;
    padding: 10px 15px;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.table th {
    border-bottom: 2px solid #e3e6f0;
    font-weight: 600;
}
</style>
@endsection
