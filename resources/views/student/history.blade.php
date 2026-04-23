@extends('layouts.student')

@section('title', 'History Aspirasi')

@section('content')
<div class="card chart-card">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-history"></i> Semua Aspirasi</h6>
    </div>
    <div class="card-body">
        @forelse($complaints as $complaint)
            <div class="complaint-item" style="border-left-color:
                @if($complaint->status == 'pending') #f6c23e
                @elseif($complaint->status == 'processed') #36b9cc
                @elseif($complaint->status == 'resolved') #1cc88a
                @else #e74a3b @endif">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="mb-0">{{ $complaint->title }}</h5>
                    <span class="status-badge
                        @if($complaint->status == 'pending') bg-warning text-dark
                        @elseif($complaint->status == 'processed') bg-info text-white
                        @elseif($complaint->status == 'resolved') bg-success text-white
                        @else bg-danger text-white @endif">
                        {{ ucfirst($complaint->status) }}
                    </span>
                </div>
                <p class="text-muted small mb-2">
                    <i class="fas fa-tag"></i> Kategori: {{ ucfirst($complaint->category->name) }}
                    <span class="mx-2">•</span>
                    <i class="fas fa-calendar"></i> {{ $complaint->created_at->format('d F Y H:i') }}
                </p>
                <p class="mb-3">{{ $complaint->content }}</p>

                @if($complaint->feedback)
                    <div class="alert alert-info mt-2">
                        <strong><i class="fas fa-reply"></i> Feedback Admin:</strong>
                        <p class="mb-0 mt-1">{{ $complaint->feedback->message }}</p>
                        <small class="text-muted">{{ $complaint->feedback->created_at->diffForHumans() }}</small>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted"></i>
                <p class="text-muted mt-2">Belum ada aspirasi</p>
                <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#addAspirasiModal">
                    <i class="fas fa-plus"></i> Buat Aspirasi
                </button>
            </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $complaints->links() }}
        </div>
    </div>
</div>
@endsection
