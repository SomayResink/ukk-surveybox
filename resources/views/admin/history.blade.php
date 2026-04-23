@extends('layouts.app')

@section('title', 'History Feedback Admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px;">
                <div class="card-body">
                    <h3 class="mb-2"><i class="fas fa-history"></i> History Feedback</h3>
                    <p class="mb-0">Riwayat feedback yang sudah Anda berikan kepada siswa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon">
                        <i class="fas fa-reply-all"></i>
                    </div>
                    <h6 class="text-muted mb-2">Total Feedback</h6>
                    <h2 class="mb-0">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <h6 class="text-muted mb-2">Minggu Ini</h6>
                    <h2 class="mb-0 text-info">{{ $stats['this_week'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h6 class="text-muted mb-2">Bulan Ini</h6>
                    <h2 class="mb-0 text-success">{{ $stats['this_month'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row align-items-end">
                <div class="col-md-3 mb-2">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari judul atau nama siswa..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Filter Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Diproses</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
                <div class="col-md-1 mb-2">
                    <a href="{{ route('admin.history') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-sync"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar History Feedback -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Riwayat Feedback</h5>
        </div>
        <div class="card-body">
            @forelse($feedbacks as $feedback)
                <div class="mb-3 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-0">{{ $feedback->complaint->title }}</h5>
                                <span class="status-badge
                                    @if($feedback->complaint->status == 'pending') bg-warning text-dark
                                    @elseif($feedback->complaint->status == 'processed') bg-info text-white
                                    @elseif($feedback->complaint->status == 'resolved') bg-success text-white
                                    @else bg-danger text-white @endif">
                                    {{ ucfirst($feedback->complaint->status) }}
                                </span>
                            </div>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user"></i> {{ $feedback->complaint->student->name }}
                                (NIS: {{ $feedback->complaint->student->nis }})
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar"></i> {{ $feedback->complaint->created_at->format('d F Y H:i') }}
                            </p>
                            <p class="mb-2"><strong>Aspirasi:</strong> {{ Str::limit($feedback->complaint->content, 100) }}</p>

                            <div class="alert alert-info mt-2 mb-0">
                                <i class="fas fa-reply"></i> <strong>Feedback Anda:</strong>
                                <p class="mb-0 mt-1">{{ $feedback->message }}</p>
                                <small class="text-muted">Diberikan: {{ $feedback->created_at->format('d F Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    data-complaint-title="{{ $feedback->complaint->title }}"
                                    data-complaint-content="{{ $feedback->complaint->content }}"
                                    data-student-name="{{ $feedback->complaint->student->name }}"
                                    data-student-nis="{{ $feedback->complaint->student->nis }}"
                                    data-created-at="{{ $feedback->complaint->created_at->format('d F Y H:i') }}"
                                    data-status="{{ $feedback->complaint->status }}"
                                    data-feedback="{{ $feedback->message }}">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted"></i>
                    <p class="text-muted mt-2">Belum ada history feedback</p>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $feedbacks->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title"><i class="fas fa-file-alt"></i> Detail Aspirasi & Feedback</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul</label>
                    <p id="modal-title" class="p-2 bg-light rounded"></p>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Dari</label>
                        <p id="modal-student" class="p-2 bg-light rounded"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal</label>
                        <p id="modal-date" class="p-2 bg-light rounded"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Aspirasi</label>
                    <p id="modal-content" class="p-2 bg-light rounded"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-info"><i class="fas fa-reply"></i> Feedback yang Diberikan</label>
                    <p id="modal-feedback" class="p-2 bg-info bg-opacity-10 rounded"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Status Akhir</label>
                    <p id="modal-status" class="p-2 rounded"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const detailModal = document.getElementById('detailModal');
if (detailModal) {
    detailModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('modal-title').innerText = button.getAttribute('data-complaint-title');
        document.getElementById('modal-content').innerText = button.getAttribute('data-complaint-content');
        document.getElementById('modal-student').innerHTML = `<strong>${button.getAttribute('data-student-name')}</strong> (NIS: ${button.getAttribute('data-student-nis')})`;
        document.getElementById('modal-date').innerText = button.getAttribute('data-created-at');
        document.getElementById('modal-feedback').innerText = button.getAttribute('data-feedback');

        const status = button.getAttribute('data-status');
        const statusEl = document.getElementById('modal-status');
        let statusClass = '', statusText = '';
        switch(status) {
            case 'pending': statusClass = 'bg-warning text-dark'; statusText = 'Pending - Menunggu'; break;
            case 'processed': statusClass = 'bg-info text-white'; statusText = 'Diproses'; break;
            case 'resolved': statusClass = 'bg-success text-white'; statusText = 'Selesai'; break;
            case 'rejected': statusClass = 'bg-danger text-white'; statusText = 'Ditolak'; break;
            default: statusClass = 'bg-secondary text-white'; statusText = status;
        }
        statusEl.className = `p-2 rounded ${statusClass}`;
        statusEl.innerText = statusText;
    });
}
</script>
@endsection
