@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4 row">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px;">
                <div class="card-body">
                    <h3 class="mb-2"><i class="fas fa-tachometer-alt"></i> Dashboard Admin - {{ ucfirst(Auth::user()->category->name ?? '') }}</h3>
                    <p class="mb-0">Kelola aspirasi untuk kategori {{ ucfirst(Auth::user()->category->name ?? '') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="mb-4 row">
        <div class="mb-3 col-lg-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                    <h6 class="mb-2 text-muted">Total Aspirasi</h6>
                    <h2 class="mb-0">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="mb-3 col-lg-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <h6 class="mb-2 text-muted">Pending</h6>
                    <h2 class="mb-0 text-warning">{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="mb-3 col-lg-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                    <h6 class="mb-2 text-muted">Diproses</h6>
                    <h2 class="mb-0 text-info">{{ $stats['processed'] }}</h2>
                </div>
            </div>
        </div>
        <div class="mb-3 col-lg-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body position-relative">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <h6 class="mb-2 text-muted">Selesai</h6>
                    <h2 class="mb-0 text-success">{{ $stats['resolved'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER - PAKAI GET, BUKAN POST -->
    <div class="mb-4 card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="row align-items-end">
                <div class="mb-2 col-md-4">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari judul, isi, atau nama siswa..." value="{{ request('search') }}">
                </div>
                <div class="mb-2 col-md-3">
                    <label class="form-label">Filter Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Diproses</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="mb-2 col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
                <div class="mb-2 col-md-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100"><i class="fas fa-sync"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- DAFTAR ASPIRASI -->
    <div class="card">
        <div class="bg-white card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Aspirasi</h5>
        </div>
        <div class="card-body">
            @forelse($complaints as $complaint)
                <div class="p-3 mb-3 border rounded complaint-item">
                    <div class="row align-items-start">
                        <div class="col-md-8">
                            <div class="mb-2 d-flex justify-content-between align-items-start">
                                <h5 class="mb-0">{{ $complaint->title }}</h5>
                                <span class="status-badge
                                    @if($complaint->status == 'pending') bg-warning text-dark
                                    @elseif($complaint->status == 'processed') bg-info text-white
                                    @elseif($complaint->status == 'resolved') bg-success text-white
                                    @else bg-danger text-white @endif">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </div>
                            <p class="mb-2 text-muted small">
                                <i class="fas fa-user"></i> {{ $complaint->student->name }} (NIS: {{ $complaint->student->nis }})
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar"></i> {{ $complaint->created_at->format('d F Y H:i') }}
                            </p>
                            @if($complaint->location)
                                <p class="mb-2 text-muted small"><i class="fas fa-map-marker-alt"></i> Lokasi: {{ $complaint->location }}</p>
                            @endif
                            <p class="mb-2">{{ Str::limit($complaint->content, 150) }}</p>
                            @if($complaint->feedback)
                                <div class="py-2 mt-2 mb-0 alert alert-info">
                                    <small><i class="fas fa-reply"></i> <strong>Feedback:</strong> {{ Str::limit($complaint->feedback->message, 100) }}</small>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-complaint-id="{{ $complaint->id }}"
                                data-complaint-title="{{ $complaint->title }}"
                                data-complaint-content="{{ $complaint->content }}"
                                data-complaint-location="{{ $complaint->location ?? '-' }}"
                                data-student-name="{{ $complaint->student->name }}"
                                data-student-nis="{{ $complaint->student->nis }}"
                                data-created-at="{{ $complaint->created_at->format('d F Y H:i') }}"
                                data-status="{{ $complaint->status }}"
                                data-feedback="{{ $complaint->feedback ? $complaint->feedback->message : '' }}">
                                <i class="fas fa-eye"></i> Detail & Feedback
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-5 text-center">
                    <i class="fas fa-inbox fa-3x text-muted"></i>
                    <p class="mt-2 text-muted">Tidak ada aspirasi</p>
                </div>
            @endforelse
            <div class="mt-4 d-flex justify-content-center">
                {{ $complaints->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title"><i class="fas fa-file-alt"></i> Detail Aspirasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label fw-bold">Judul</label><p id="modal-title" class="p-2 rounded bg-light"></p></div>
                <div class="mb-3 row">
                    <div class="col-md-6"><label class="form-label fw-bold">Dari</label><p id="modal-student" class="p-2 rounded bg-light"></p></div>
                    <div class="col-md-6"><label class="form-label fw-bold">Tanggal</label><p id="modal-date" class="p-2 rounded bg-light"></p></div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6"><label class="form-label fw-bold">Lokasi</label><p id="modal-location" class="p-2 rounded bg-light"></p></div>
                    <div class="col-md-6"><label class="form-label fw-bold">Status</label><p id="modal-status" class="p-2 rounded"></p></div>
                </div>
                <div class="mb-3"><label class="form-label fw-bold">Isi Aspirasi</label><p id="modal-content" class="p-2 rounded bg-light"></p></div>
                <div class="mb-3" id="existing-feedback-div" style="display:none;">
                    <label class="form-label fw-bold text-info"><i class="fas fa-reply"></i> Feedback Sebelumnya</label>
                    <p id="modal-feedback" class="p-2 rounded bg-info bg-opacity-10"></p>
                </div>
                <hr>
                <h6 class="mb-3"><i class="fas fa-paper-plane"></i> Kirim Feedback</h6>
                <form id="feedbackForm" method="POST">
                    @csrf
                    <input type="hidden" name="complaint_id" id="feedback-complaint-id">
                    <div class="mb-3"><label class="form-label">Feedback</label><textarea name="message" class="form-control" rows="4" required placeholder="Tulis feedback Anda di sini..."></textarea></div>
                    <div class="mb-3"><label class="form-label">Update Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Pending - Menunggu</option>
                            <option value="processed">Diproses - Sedang ditangani</option>
                            <option value="resolved">Selesai - Aspirasi terselesaikan</option>
                            <option value="rejected">Ditolak - Aspirasi ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient w-100"><i class="fas fa-paper-plane"></i> Kirim Feedback</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card { border: none; border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.05); transition: transform 0.3s; position: relative; overflow: hidden; }
.stat-card:hover { transform: translateY(-5px); }
.stat-icon { position: absolute; right: 20px; top: 20px; font-size: 3rem; opacity: 0.15; }
.status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
.complaint-item { transition: all 0.3s; }
.complaint-item:hover { background-color: #f8f9fc; transform: translateX(5px); }
.btn-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; transition: all 0.3s; }
.btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); color: white; }
</style>

<script>
const detailModal = document.getElementById('detailModal');
if (detailModal) {
    detailModal.addEventListener('show.bs.modal', function(event) {
        const btn = event.relatedTarget;
        document.getElementById('modal-title').innerText = btn.getAttribute('data-complaint-title');
        document.getElementById('modal-content').innerText = btn.getAttribute('data-complaint-content');
        document.getElementById('modal-location').innerText = btn.getAttribute('data-complaint-location') || '-';
        document.getElementById('modal-student').innerHTML = `<strong>${btn.getAttribute('data-student-name')}</strong> (NIS: ${btn.getAttribute('data-student-nis')})`;
        document.getElementById('modal-date').innerText = btn.getAttribute('data-created-at');
        document.getElementById('feedback-complaint-id').value = btn.getAttribute('data-complaint-id');
        const statusSelect = document.querySelector('#feedbackForm select[name="status"]');
        if (statusSelect) statusSelect.value = btn.getAttribute('data-status');
        const status = btn.getAttribute('data-status');
        const statusEl = document.getElementById('modal-status');
        let statusClass = '', statusText = '';
        if (status == 'pending') { statusClass = 'bg-warning text-dark'; statusText = 'Pending - Menunggu'; }
        else if (status == 'processed') { statusClass = 'bg-info text-white'; statusText = 'Diproses'; }
        else if (status == 'resolved') { statusClass = 'bg-success text-white'; statusText = 'Selesai'; }
        else if (status == 'rejected') { statusClass = 'bg-danger text-white'; statusText = 'Ditolak'; }
        else { statusClass = 'bg-secondary text-white'; statusText = status; }
        statusEl.className = `p-2 rounded ${statusClass}`;
        statusEl.innerText = statusText;
        const existingFeedback = btn.getAttribute('data-feedback');
        if (existingFeedback && existingFeedback.trim() !== '') {
            document.getElementById('modal-feedback').innerText = existingFeedback;
            document.getElementById('existing-feedback-div').style.display = 'block';
        } else {
            document.getElementById('existing-feedback-div').style.display = 'none';
        }
        document.getElementById('feedbackForm').action = `/admin/feedback/${btn.getAttribute('data-complaint-id')}`;
    });
}
</script>
@endsection
