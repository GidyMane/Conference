@extends('reviewer.layout')

@section('title', 'Manage Registrations')
@section('page-title', 'Manage Registrations')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Conference Registrations</h1>
            <a href="{{ route('finance.dashboard') }}" class="btn btn-sm btn-secondary mt-2">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
        </div>
        <a href="{{ route('finance.dashboard') }}" class="btn btn-success">
            <i class="fas fa-chart-line me-2"></i> Revenue Summary
        </a>
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
        <form method="GET" action="{{ route('finance.registrations.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="approved" {{ request('payment_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending"  {{ request('payment_status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="platform" class="form-select">
                        <option value="">All Platforms</option>
                        <option value="physical" {{ request('platform') == 'physical' ? 'selected' : '' }}>Physical</option>
                        <option value="virtual"  {{ request('platform') == 'virtual'  ? 'selected' : '' }}>Virtual</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search name or email">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- INDIVIDUAL REGISTRATIONS TABLE --}}
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Individual Registrations</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3" style="width:50px;">#</th>
                        <th>Participant</th>
                        <th>Platform / Category</th>
                        <th>Fee &amp; Status</th>
                        <th>Date</th>
                        <th class="text-center pe-3" style="width:100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($registrations as $registration)
                    <tr>
                        <td class="ps-3 text-muted fw-bold">#{{ $registration->id }}</td>

                        <td>
                            <div class="fw-semibold">{{ $registration->full_name }}</div>
                            <div class="text-muted small">{{ $registration->email }}</div>
                            <div class="text-muted small">{{ $registration->institution }}</div>
                        </td>

                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($registration->platform) }}</span><br>
                            <span class="badge bg-info mt-1">{{ ucfirst(str_replace('_',' ', $registration->category)) }}</span>
                        </td>

                        <td>
                            <div class="fw-semibold">{{ $registration->fee_currency }} {{ number_format($registration->fee, 2) }}</div>
                            <div class="mt-1">
                                @if($registration->payment_status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($registration->payment_status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </div>
                            @if($registration->ticket_number)
                                <div class="text-success small fw-bold mt-1">{{ $registration->ticket_number }}</div>
                            @endif
                        </td>

                        <td class="text-muted small">
                            {{ $registration->created_at->format('M d, Y') }}
                        </td>

                        <td class="text-center pe-3">
                            <a href="{{ route('finance.registrations.show', $registration->id) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No registrations found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-3 py-3">
            {{ $registrations->withQueryString()->links() }}
        </div>
    </div>
</div>


{{-- GROUP REGISTRATIONS TABLE --}}
<div class="card shadow-sm mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Group Registrations</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3" style="width:50px;">#</th>
                        <th>Coordinator</th>
                        <th>Members</th>
                        <th>Total Fee &amp; Status</th>
                        <th>Date</th>
                        <th class="text-center pe-3" style="width:100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($groupRegistrations as $group)
                    <tr>
                        <td class="ps-3 text-muted fw-bold">#{{ $group->id }}</td>

                        <td>
                            <div class="fw-semibold">{{ $group->first_name }} {{ $group->last_name }}</div>
                            <div class="text-muted small">{{ $group->email }}</div>
                            <div class="text-muted small">{{ $group->institution }}</div>
                        </td>

                        <td>
                            <ul class="mb-0 ps-3 small">
                                @foreach($group->members as $member)
                                    <li>{{ $member->first_name }} {{ $member->last_name }}
                                        @if($member->category)
                                            <span class="text-muted">({{ $member->category }})</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <td>
                            <div class="fw-semibold">{{ $group->currency }} {{ number_format($group->total_fee, 2) }}</div>
                            <div class="mt-1">
                                @if($group->payment_status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($group->payment_status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </div>
                        </td>

                        <td class="text-muted small">
                            {{ $group->created_at->format('M d, Y') }}
                        </td>

                        <td class="text-center pe-3">
                            <a href="{{ route('finance.groupRegistrations.show', $group->id) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No group registrations found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-3 py-3">
            {{ $groupRegistrations->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection