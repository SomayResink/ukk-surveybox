@extends('layouts.app')

@section('title', 'Semua Aspirasi')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 15px;">
                <div class="card-body">
                    <h3 class="mb-2"><i class="fas fa-list"></i> Semua Aspirasi</h3>
                    <p class="mb-0">Kelola semua aspirasi dari semua kategori</p>
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
                    <input type="text" name="search" class="form-control" placeholder="Cari judul, isi, atau nama siswa..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ ucfirst($cat->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Diproses</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Sortir</label>
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
                <div class="col-md-1 mb-2">
                    <a href="{{ route('superadmin.complaints') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-sync"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Aspirasi -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-table"></i> Daftar Aspirasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Siswa</th>
                            <th>NIS</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $index => $complaint)
                        <tr>
                            <td>{{ $complaints->firstItem() + $index }}</td>
                            <td>{{ $complaint->student->name }}</td>
                            <td>{{ $complaint->student->nis }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($complaint->category->name) }}</span>
                            </td>
                            <td>{{ Str::limit($complaint->title, 30) }}</td>
                            <td>{{ Str::limit($complaint->content, 50) }}</td>
                            <td>
                                <span class="status-badge
                                    @if($complaint->status == 'pending') bg-warning text-dark
                                    @elseif($complaint->status == 'processed') bg-info text-white
                                    @elseif($complaint->status == 'resolved') bg-success text-white
                                    @else bg-danger text-white @endif">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </td>
                            <td>
                                @if($complaint->feedback)
                                    <span class="text-success">
                                        <i class="fas fa-check-circle"></i> Sudah
                                    </span>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-clock"></i> Belum
                                    </span>
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        data-complaint-title="{{ $complaint->title }}"
                                        data-complaint-content="{{ $complaint->content }}"
                                        data-student-name="{{ $complaint->student->name }}"
                                        data-student-nis="{{ $complaint->student->nis }}"
                                        data-category="{{ ucfirst($complaint->category->name) }}"
                                        data-created-at="{{ $complaint->created_at->format('d F Y H:i') }}"
                                        data-status="{{ $complaint->status }}"
                                        data-feedback="{{ $complaint->feedback ? $complaint->feedback->message : 'Belum ada feedback' }}"
                                        data-feedback-by="{{ $complaint->feedback ? $complaint->feedback->admin->name : '-' }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted"></i>
                                <p class="mt-2">Belum ada aspirasi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $complaints->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Aspirasi -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt"></i> Detail Aspirasi
                </h5>
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
                        <label class="form-label fw-bold">Kategori</label>
                        <p id="modal-category" class="p-2 bg-light rounded"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Dikirim</label>
                        <p id="modal-date" class="p-2 bg-light rounded"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <p id="modal-status" class="p-2 rounded"></p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Aspirasi</label>
                    <p id="modal-content" class="p-2 bg-light rounded" style="white-space: pre-wrap;"></p>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label fw-bold text-info">
                        <i class="fas fa-reply"></i> Feedback
                    </label>
                    <div class="p-3 bg-info bg-opacity-10 rounded">
                        <p id="modal-feedback" class="mb-1"></p>
                        <small id="modal-feedback-by" class="text-muted"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-block;
}
</style>

<script>
const detailModal = document.getElementById('detailModal');
if (detailModal) {
    detailModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        document.getElementById('modal-title').innerText = button.getAttribute('data-complaint-title');
        document.getElementById('modal-content').innerText = button.getAttribute('data-complaint-content');
        document.getElementById('modal-student').innerHTML = `<strong>${button.getAttribute('data-student-name')}</strong> (NIS: ${button.getAttribute('data-student-nis')})`;
        document.getElementById('modal-category').innerText = button.getAttribute('data-category');
        document.getElementById('modal-date').innerText = button.getAttribute('data-created-at');
        document.getElementById('modal-feedback').innerText = button.getAttribute('data-feedback');
        document.getElementById('modal-feedback-by').innerHTML = `Oleh: ${button.getAttribute('data-feedback-by')}`;

        const status = button.getAttribute('data-status');
        const statusEl = document.getElementById('modal-status');
        let statusClass = '', statusText = '';

        switch(status) {
            case 'pending':
                statusClass = 'bg-warning text-dark';
                statusText = 'Pending - Menunggu';
                break;
            case 'processed':
                statusClass = 'bg-info text-white';
                statusText = 'Diproses - Sedang ditangani';
                break;
            case 'resolved':
                statusClass = 'bg-success text-white';
                statusText = 'Selesai - Aspirasi terselesaikan';
                break;
            case 'rejected':
                statusClass = 'bg-danger text-white';
                statusText = 'Ditolak - Aspirasi ditolak';
                break;
            default:
                statusClass = 'bg-secondary text-white';
                statusText = status;
        }

        statusEl.className = `p-2 rounded ${statusClass}`;
        statusEl.innerText = statusText;
    });
}
</script>
@endsection
