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
                    <i class="fas fa-tag"></i> Kategori: {{ ucfirst($complaint->category->name) }}
                    <span class="mx-2">•</span>
                    <i class="fas fa-calendar"></i> {{ $complaint->created_at->format('d F Y H:i') }}
                </p>
                @if($complaint->location)
                    <p class="mb-2 text-muted small">
                        <i class="fas fa-map-marker-alt"></i> Lokasi: {{ $complaint->location }}
                    </p>
                @endif
                <p class="mb-3">{{ $complaint->content }}</p>

                @if($complaint->feedback)
                    <div class="mt-2 alert alert-info">
                        <strong><i class="fas fa-reply"></i> Feedback Admin:</strong>
                        <p class="mt-1 mb-0">{{ $complaint->feedback->message }}</p>
                        <small class="text-muted">{{ $complaint->feedback->created_at->diffForHumans() }}</small>
                    </div>
                @endif
            </div>
        @empty
            <div class="py-5 text-center">
                <i class="fas fa-inbox fa-3x text-muted"></i>
                <p class="mt-2 text-muted">Belum ada aspirasi</p>
                <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#addAspirasiModal">
                    <i class="fas fa-plus"></i> Buat Aspirasi
                </button>
            </div>
        @endforelse

        <div class="mt-4 d-flex justify-content-center">
            {{ $complaints->links() }}
        </div>
    </div>
</div>
@endsection
