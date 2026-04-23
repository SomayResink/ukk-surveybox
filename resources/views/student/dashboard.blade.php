@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="welcome-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="mb-0 opacity-90">Platform pengaduan dan aspirasi siswa. Sampaikan aspirasimu dengan mudah dan cepat.</p>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addAspirasiModal">
                <i class="fas fa-plus-circle"></i> Buat Aspirasi
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h6 class="text-muted mb-2">Total Aspirasi</h6>
                <h2 class="mb-0">{{ $stats['total'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h6 class="text-muted mb-2">Menunggu</h6>
                <h2 class="mb-0 text-warning">{{ $stats['pending'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <h6 class="text-muted mb-2">Diproses</h6>
                <h2 class="mb-0 text-info">{{ $stats['processed'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h6 class="text-muted mb-2">Selesai</h6>
                <h2 class="mb-0 text-success">{{ $stats['resolved'] }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card chart-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Status Aspirasi</h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="card chart-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Aspirasi per Kategori</h6>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Complaints -->
<div class="card chart-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-history"></i> Aspirasi Terbaru</h6>
        <a href="{{ route('student.history') }}" class="btn btn-sm btn-outline-gradient">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="card-body">
        @forelse($recentComplaints as $complaint)
            <div class="complaint-item" style="border-left-color:
                @if($complaint->status == 'pending') #f6c23e
                @elseif($complaint->status == 'processed') #36b9cc
                @elseif($complaint->status == 'resolved') #1cc88a
                @else #e74a3b @endif">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">{{ $complaint->title }}</h6>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-tag"></i> {{ ucfirst($complaint->category->name) }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-calendar"></i> {{ $complaint->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <span class="status-badge
                        @if($complaint->status == 'pending') bg-warning text-dark
                        @elseif($complaint->status == 'processed') bg-info text-white
                        @elseif($complaint->status == 'resolved') bg-success text-white
                        @else bg-danger text-white @endif">
                        {{ ucfirst($complaint->status) }}
                    </span>
                </div>
                <p class="mt-2 mb-2">{{ Str::limit($complaint->content, 100) }}</p>
                @if($complaint->feedback)
                    <div class="mt-2 p-2 bg-light rounded">
                        <small class="text-primary"><i class="fas fa-reply"></i> Feedback: </small>
                        <small>{{ Str::limit($complaint->feedback->message, 100) }}</small>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted"></i>
                <p class="text-muted mt-2">Belum ada aspirasi. Buat aspirasi pertama Anda!</p>
                <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#addAspirasiModal">
                    <i class="fas fa-plus"></i> Buat Aspirasi
                </button>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
        datasets: [{
            data: [{{ $stats['pending'] }}, {{ $stats['processed'] }}, {{ $stats['resolved'] }}, {{ $stats['rejected'] }}],
            backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a', '#e74a3b'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryLabels = {!! json_encode($categoryCounts->pluck('category.name')->map(function($name) { return ucfirst($name); })) !!};
const categoryData = {!! json_encode($categoryCounts->pluck('total')) !!};

new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: categoryLabels,
        datasets: [{
            label: 'Jumlah Aspirasi',
            data: categoryData,
            backgroundColor: '#667eea',
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});
</script>
@endpush
