@extends('admin.layout')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users & Reviewers')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Manage Users & Reviewers</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-kalro-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Add New User
            </button>
            <button class="btn btn-warning ms-2" data-bs-toggle="modal" data-bs-target="#addTempReviewerModal">
                <i class="fas fa-user-clock me-2"></i>Temp Reviewer
            </button>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#extendTempReviewerModal">
                <i class="fas fa-user-clock me-2"></i>Extend
            </button>
            <button class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#PrequalifiedReviewerModal">
                <i class="fas fa-user-clock me-2"></i>Prequalified Reviewers
            </button>
        </div>
    </div>
</div>

<!-- User Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Users</h6>
                        <h3 class="mb-0">{{ $stats['total_users'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Active Reviewers</h6>
                        <h3 class="mb-0">{{ $stats['active_reviewers'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-user-check fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Admins</h6>
                        <h3 class="mb-0">{{ $stats['admins'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-user-shield fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending Setup</h6>
                        <h3 class="mb-0">{{ $stats['pending_setup'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-user-clock fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="#">
            <div class="row g-3">
                <input type="hidden" name="role" value="REVIEWER">

                
                <div class="col-md-3">
                    <label class="form-label">Sub-theme</label>
                    <select name="subtheme" class="form-select">
                        <option value="">All Sub-themes</option>
                        @foreach($subthemes ?? [] as $subtheme)
                        <option value="{{ $subtheme->id }}" {{ request('subtheme') == $subtheme->id ? 'selected' : '' }}>
                            {{ $subtheme->full_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-kalro-primary flex-grow-1">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Users</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Sub-theme</th>
                        <th>Assigned</th>
                        <th>Completed</th>
                        <th>Expiry date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="{{ !$user->is_active ? 'inactive-row' : '' }}">
                            <td>{{ $user->id }}</td>

                            <td>
                                <div class="d-flex align-items-center">

                                    <strong>{{ $user->full_name }}</strong>
                                </div>
                            </td>

                            <td>{{ $user->email }}</td>

                            <td>
                                <span class="badge {{ $user->role === 'ADMIN' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst(strtolower($user->role)) }}
                                </span>
                            </td>

                            

                    <td>
                        @if($user->role === 'TEMP_REVIEWER' && $user->tempReviewer && $user->tempReviewer->subTheme)
            
                            <span class="badge bg-secondary me-1">
                                {{ $user->tempReviewer->subTheme->form_field_value }}
                            </span>

                        @elseif($user->reviewer && $user->reviewer->subThemes->isNotEmpty())

                            @foreach($user->reviewer->subThemes as $subTheme)
                                <span class="badge bg-secondary me-1">
                                    {{ $subTheme->form_field_value }}
                                </span>
                            @endforeach

                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                            <td>
                                @if($user->role === 'REVIEWER')
                                    <span class="badge bg-info">
                                        {{ $user->assigned_abstracts_count ?? 0 }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if($user->role === 'REVIEWER')
                                    <span class="badge bg-success">
                                        {{ $user->completed_reviews_count ?? 0 }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if($user->tempReviewer)
                                    {{ \Carbon\Carbon::parse($user->tempReviewer->expires_at)->format('d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if($user->is_active)
                                    <div class="btn-group btn-group-sm">
                                        @if($user->role === 'REVIEWER' || $user->role === 'TEMP_REVIEWER')
                                            </button>
                                            <button class="btn btn-warning" onclick="resetPassword({{ $user->id }})" title="Reset Password">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            <button class="btn btn-danger" onclick="deleteUser({{ $user->id }}, this)" title="Deactivate">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm" action="{{route('admin.users.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        
                        <div class="col-md-6 mb-3" id="subthemeField">
                            <label class="form-label">Sub-theme *</label>
                                <select class="form-select" name="subtheme_ids[]" multiple required>
                                    @foreach($subthemes as $subtheme)
                                        <option value="{{ $subtheme->id }}">{{ $subtheme->full_name }}</option>
                                    @endforeach
                                </select>

                                <small class="text-muted">Hold Ctrl / Cmd to select multiple sub-themes</small>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> A temporary password will be generated and sent to the user's email. 
                                The user will be required to change it upon first login.
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_email" id="sendWelcomeEmail" checked>
                                <label class="form-check-label" for="sendWelcomeEmail">
                                    Send welcome email with login credentials
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addTempReviewerModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Create Temporary Reviewer</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form method="POST" action="{{ route('admin.temp-reviewers.store') }}">
@csrf

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" name="full_name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Sub Theme</label>
<select name="sub_theme_id" class="form-select" required>
<option value="">Select Sub Theme</option>

@foreach($subthemes as $sub)
<option value="{{ $sub->id }}">
{{ $sub->full_name }}
</option>
@endforeach

</select>
</div>

<div class="mb-3">
<label class="form-label">Access Duration</label>
<select name="expires_days" class="form-select">

<option value="7">7 Days</option>
<option value="14">14 Days</option>
<option value="30">30 Days</option>
<option value="60">60 Days</option>
<option value="90">90 Days</option>

</select>
</div>

</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-warning">
<i class="fas fa-save me-2"></i>Create Temp Reviewer
</button>
</div>

</form>

</div>
</div>
</div>


<div class="modal fade" id="extendTempReviewerModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Extend Temporary Reviewer</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form method="POST" action="{{ route('admin.temp-reviewers.extend') }}">
@csrf

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Temp Reviewer</label>
<select name="user_id" class="form-select" required>
<option value="">Select Temp Reviewer</option>


@forelse($users as $user)
@if($user->role === 'TEMP_REVIEWER')
<option value="{{ $user->id }}">
{{ $user->full_name }}
</option>
@endif
@endforeach


</select>
</div>

<div class="mb-3">
<label class="form-label">Extend Duration</label>
<select name="expires_days" class="form-select">

<option value="7">7 Days</option>
<option value="14">14 Days</option>
<option value="30">30 Days</option>
<option value="60">60 Days</option>
<option value="90">90 Days</option>

</select>
</div>

</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-warning">
<i class="fas fa-save me-2"></i>Extend Temp Reviewer
</button>
</div>

</form>

</div>
</div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                <input type="hidden" name="user_id" id="editUserId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="full_name" id="editUserName" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" name="email" id="editUserEmail" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role *</label>
                            <select class="form-select" name="role" id="editUserRole" required>
                                <option value="ADMIN">Admin</option>
                                <option value="REVIEWER">Reviewer</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sub-theme</label>
                            <select class="form-select" name="subtheme_id" id="editUserSubtheme">
                                <option value="">Select Sub-theme</option>
                                @foreach($subthemes ?? [] as $subtheme)
                                <option value="{{ $subtheme->id }}">{{ $subtheme->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Prequalified Reviewer Modal -->
<div class="modal fade" id="PrequalifiedReviewerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Prequalified Reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.prequalified-reviewers.store') }}">
                @csrf

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" placeholder="Dr, Prof, Mr..." required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Institution</label>
                            <input type="text" class="form-control" name="institution">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sub-theme *</label>
                            <select class="form-select" name="sub_theme_id" required>
                                <option value="">Select Sub-theme</option>
                                @foreach($subthemes as $subtheme)
                                    <option value="{{ $subtheme->id }}">
                                        {{ $subtheme->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Area of Specialization</label>
                            <textarea class="form-control" name="area_of_specialization"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save Reviewer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    
    // Add user form submission
    document.getElementById('addUserForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('{{ route("admin.users.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            if (!response.ok) {
                const err = await response.json();
                const message =
                    err?.message ||
                    (err?.errors ? Object.values(err.errors).flat().join('\n') : 'Something went wrong');

                alert(message);
                return;
            }
            return response.json();
        })

        .then(data => {
            if (data.success) {
                const modalEl = document.getElementById('addUserModal');
                bootstrap.Modal.getInstance(modalEl).hide();

                // reset form
                document.getElementById('addUserForm').reset();

                // show toast / alert
                alert('User created successfully');

                // optionally append row dynamically instead of reload
            }
        });
    });
    
    function viewUser(userId) {
        window.location.href = `/admin/users/${userId}`;
    }
    
    function editUser(userId) {
        // Fetch user data and populate edit modal
        fetch(`/admin/users/${userId}/edit`)
            .then(async response => {
                if (!response.ok) {
                    const err = await response.json();
                                        const message =
                        err?.message ||
                        (err?.errors ? Object.values(err.errors).flat().join('\n') : 'Something went wrong');

                    alert(message);
                    return;
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('editUserId').value = data.id;
                document.getElementById('editUserName').value = data.full_name;
                document.getElementById('editUserEmail').value = data.email;
                document.getElementById('editUserRole').value = data.role;
                document.getElementById('editUserSubtheme').value = data.subtheme_id || '';
                
                new bootstrap.Modal(document.getElementById('editUserModal')).show();
            });
    }
    
    function assignAbstracts(userId) {
        fetch(`/admin/users/${userId}/available-abstracts`)
            .then(async response => {
                if (!response.ok) {
                    const err = await response.json();
                    const message =
                        err?.message ||
                        (err?.errors ? Object.values(err.errors).flat().join('\n') : 'Something went wrong');
                    alert(message);
                    return;
                }
                return response.json();
            })
            .then(data => {
                const reviewer = data.reviewer;
                const subTheme = reviewer?.reviewer?.sub_theme;

                document.getElementById('assignReviewerId').value = reviewer.id;
                document.getElementById('assignReviewerName').value = reviewer.full_name;
                document.getElementById('assignReviewerSubtheme').value = subTheme?.full_name || 'None';

                const abstractsContainer = document.getElementById('availableAbstracts');
                abstractsContainer.innerHTML = '';

                if (!data.abstracts.length) {
                    abstractsContainer.innerHTML = '<p class="text-muted mb-0">No available abstracts for this sub-theme</p>';
                } else {
                    data.abstracts.forEach(abstract => {
                        abstractsContainer.innerHTML += `
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="abstracts[]" value="${abstract.id}" id="abstract_${abstract.id}">
                                <label class="form-check-label" for="abstract_${abstract.id}">
                                    <strong>${abstract.submission_code}</strong> - ${abstract.title}
                                </label>
                            </div>
                        `;
                    });
                }

                new bootstrap.Modal(document.getElementById('assignAbstractsModal')).show();
            });
    }

    function resetPassword(userId) {
        if (confirm('Are you sure you want to reset this user\'s password? A new password will be sent to their email.')) {
            fetch(`/admin/users/${userId}/reset-password`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                if (!response.ok) {
                    const err = await response.json();
                    const message =
                        err?.message ||
                        (err?.errors ? Object.values(err.errors).flat().join('\n') : 'Something went wrong');

                    alert(message);
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Password reset successfully. New credentials have been sent to the user\'s email.');
                }
            });
        }
    }
    
function deleteUser(userId, btn) {
    if (confirm('Are you sure you want to deactivate this user? This action cannot be undone.')) {
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            if (!response.ok) {
                const err = await response.json();
                const message =
                    err?.message ||
                    (err?.errors ? Object.values(err.errors).flat().join('\n') : 'Something went wrong');
                alert(message);
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message || 'User deactivated successfully.');
                // Reload the page so stats and table refresh
                location.reload();
            }
        });
    }
}

</script>
@endsection
