@extends('admin.layout')

@section('title', 'Manage Exhibition Registrations')
@section('page-title', 'Manage Exhibition Registrations')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Exhibition Registrations</h1>
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
        <form method="GET" action="{{ route('admin.exhibitions.index') }}">
            <div class="row g-3">

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="registration_type" class="form-select">
                        <option value="">All Packages</option>
                        <option value="with_meals" {{ request('registration_type') == 'with_meals' ? 'selected' : '' }}>Premium</option>
                        <option value="without_meals" {{ request('registration_type') == 'without_meals' ? 'selected' : '' }}>Standard</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search company or contact">
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

{{-- QUICK FILTER LINKS --}}
<div class="row mb-3">
    <div class="col-12">
        <div class="btn-group flex-wrap gap-2">
            <a href="{{ route('admin.exhibitions.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-clock me-1"></i> Pending ({{ $stats['pending'] ?? 0 }})
            </a>
            <a href="{{ route('admin.exhibitions.index', ['status' => 'approved']) }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-check-circle me-1"></i> Approved ({{ $stats['approved'] ?? 0 }})
            </a>
            <a href="{{ route('admin.exhibitions.index', ['status' => 'rejected']) }}" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-times-circle me-1"></i> Rejected ({{ $stats['rejected'] ?? 0 }})
            </a>
            <a href="{{ route('admin.exhibitions.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-list me-1"></i> All ({{ $stats['total'] ?? 0 }})
            </a>
        </div>
    </div>
</div>

{{-- REGISTRATIONS TABLE --}}
<div class="card shadow-sm">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Ref #</th>
                        <th>Organization / Contact</th>
                        <th>Package</th>
                        <th>Booths</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="80">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($registrations as $registration)
                    <tr>

                        <td>
                            <strong class="text-primary">#{{ $registration->reference_number }}</strong>
                            @if($registration->booth_number)
                                <br><small class="text-success">Booth: {{ $registration->booth_number }}</small>
                            @endif
                        </td>

                        <td>
                            <div>
                                <strong>{{ $registration->organization_name }}</strong><br>
                                <small class="text-muted">{{ $registration->contact_name }}</small><br>
                                <small class="text-muted">{{ $registration->contact_email }}</small>
                            </div>
                        </td>

                        <td>
                            @if($registration->registration_type == 'with_meals')
                                <span class="badge bg-success">Premium</span>
                            @else
                                <span class="badge bg-secondary">Standard</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-info">{{ $registration->booth_count }}</span>
                            <br><small>Team: {{ $registration->team_size }}</small>
                        </td>

                        <td>
                            <strong>KES {{ number_format($registration->total_amount) }}</strong>
                            <br><small>{{ $registration->payment_method_label }}</small>
                        </td>

                        <td>
                            {!! $registration->payment_status_badge !!}
                            {!! $registration->status_badge !!}
                        </td>

                        <td>
                            {{ $registration->created_at->format('d M Y') }}
                        </td>

                        <td>
                            <a href="{{ route('admin.exhibitions.show', $registration->id) }}"
                               class="btn btn-sm btn-outline-primary"
                               title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-store fa-3x mb-3"></i>
                            <p>No exhibition registrations found.</p>
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