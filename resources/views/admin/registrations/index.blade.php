@extends('admin.layout')

@section('title', 'Manage Registrations')
@section('page-title', 'Manage Registrations')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Conference Registrations</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary mt-2">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </div>
</div>


{{-- STATISTICS --}}
<div class="row mb-4">

    <div class="col-md-3 mb-3">
        <div class="card border-start border-primary border-4 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total</h6>
                <h3>{{ $stats['total'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-start border-success border-4 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Approved</h6>
                <h3>{{ $stats['approved'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Pending</h6>
                <h3>{{ $stats['pending'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-start border-danger border-4 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Rejected</h6>
                <h3>{{ $stats['rejected'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>


{{-- FILTERS --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.registrations.index') }}">
            <div class="row g-3">

                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="approved" {{ request('payment_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="platform" class="form-select">
                        <option value="">All Platforms</option>
                        <option value="physical" {{ request('platform') == 'physical' ? 'selected' : '' }}>Physical</option>
                        <option value="virtual" {{ request('platform') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search name or email">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>



{{-- REGISTRATIONS TABLE --}}
<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Participant</th>
                        <th>Institution</th>
                        <th>Platform</th>
                        <th>Category</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Ticket</th>
                        <th>Date</th>
                        <th width="80">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($registrations as $registration)
                    <tr>

                        <td><strong>#{{ $registration->id }}</strong></td>

                        <td>
                            <div>
                                <strong>{{ $registration->full_name }}</strong><br>
                                <small class="text-muted">{{ $registration->email }}</small>
                            </div>
                        </td>

                        <td>{{ $registration->institution }}</td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ ucfirst($registration->platform) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-info">
                                {{ ucfirst(str_replace('_',' ', $registration->category)) }}
                            </span>
                        </td>

                        <td>
                            {{ $registration->fee_currency }}
                            {{ number_format($registration->fee, 2) }}
                        </td>

                        <td>
                            @if($registration->payment_status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($registration->payment_status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($registration->ticket_number)
                                <span class="text-success fw-bold">
                                    {{ $registration->ticket_number }}
                                </span>
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            {{ $registration->created_at->format('M d, Y') }}
                        </td>

                        <td>
                            <a href="{{ route('admin.registrations.show', $registration->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            No registrations found.
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>


        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $registrations->withQueryString()->links() }}
        </div>

    </div>
</div>

@endsection
