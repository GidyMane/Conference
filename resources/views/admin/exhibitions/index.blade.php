@extends('admin.layout')

@section('title', 'Manage Exhibitions')
@section('page-title', 'Manage Exhibitions')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Manage Exhibitions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Exhibitions</li>
                </ol>
            </nav>
        </div>
        <div>
            <div class="btn-group">
                <button class="btn btn-kalro-primary" data-bs-toggle="modal" data-bs-target="#addExhibitorModal">
                    <i class="fas fa-plus me-2"></i>Add Exhibitor
                </button>
                <button class="btn btn-outline-success" onclick="exportData()">
                    <i class="fas fa-file-excel me-2"></i>Export
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Exhibitors</h6>
                        <h3 class="mb-0">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-store fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Confirmed</h6>
                        <h3 class="mb-0">{{ $stats['confirmed'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending</h6>
                        <h3 class="mb-0">{{ $stats['pending'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Booth Spaces</h6>
                        <h3 class="mb-0">{{ $stats['booths_allocated'] ?? 0 }}/{{ $stats['total_booths'] ?? 50 }}</h3>
                    </div>
                    <i class="fas fa-map-marker-alt fa-2x text-info"></i>
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
        <form method="GET" action="{{ route('admin.exhibitions.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Booth Type</label>
                    <select name="booth_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="standard">Standard</option>
                        <option value="premium">Premium</option>
                        <option value="corner">Corner</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="agriculture">Agriculture</option>
                        <option value="technology">Technology</option>
                        <option value="research">Research</option>
                        <option value="equipment">Equipment</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-kalro-primary w-100">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Exhibition Floor Plan -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-map me-2"></i>Exhibition Floor Plan</h5>
        <button class="btn btn-sm btn-outline-primary" onclick="viewFloorPlan()">
            <i class="fas fa-expand me-2"></i>Full View
        </button>
    </div>
    <div class="card-body">
        <div class="text-center">
            <img src="/images/floor-plan-placeholder.png" alt="Floor Plan" class="img-fluid" style="max-height: 300px;" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22300%22%3E%3Crect width=%22800%22 height=%22300%22 fill=%22%23f0f0f0%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2224%22 text-anchor=%22middle%22 fill=%22%23999%22%3EFloor Plan Visualization%3C/text%3E%3C/svg%3E'">
        </div>
    </div>
</div>

<!-- Exhibitors Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Exhibitors</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Exhibitor ID</th>
                        <th>Company Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Booth</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exhibitors ?? [] as $exhibitor)
                    <tr>
                        <td><strong class="text-primary">{{ $exhibitor->exhibitor_id }}</strong></td>
                        <td>
                            <strong>{{ $exhibitor->company_name }}</strong>
                            @if($exhibitor->is_sponsor)
                            <span class="badge bg-warning ms-1">Sponsor</span>
                            @endif
                        </td>
                        <td>{{ $exhibitor->contact_person }}</td>
                        <td>{{ $exhibitor->email }}</td>
                        <td>{{ $exhibitor->phone }}</td>
                        <td>
                            @if($exhibitor->booth_number)
                                <span class="badge bg-info">Booth {{ $exhibitor->booth_number }}</span>
                            @else
                                <span class="text-muted">Not Assigned</span>
                            @endif
                        </td>
                        <td><span class="badge bg-secondary">{{ ucfirst($exhibitor->category) }}</span></td>
                        <td>
                            @if($exhibitor->status == 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($exhibitor->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.exhibitions.show', $exhibitor->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-primary" onclick="assignBooth({{ $exhibitor->id }})" title="Assign Booth">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button class="btn btn-success" onclick="confirmExhibitor({{ $exhibitor->id }})" title="Confirm">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-warning" onclick="editExhibitor({{ $exhibitor->id }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">No exhibitors found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Exhibitor Modal -->
<div class="modal fade" id="addExhibitorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Exhibitor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addExhibitorForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company/Organization Name *</label>
                            <input type="text" class="form-control" name="company_name" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person *</label>
                            <input type="text" class="form-control" name="contact_person" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" class="form-control" name="phone" placeholder="+254..." required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select class="form-select" name="category" required>
                                <option value="">Select Category</option>
                                <option value="agriculture">Agriculture</option>
                                <option value="technology">Technology</option>
                                <option value="research">Research</option>
                                <option value="equipment">Equipment</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Booth Type *</label>
                            <select class="form-select" name="booth_type" required>
                                <option value="">Select Booth Type</option>
                                <option value="standard">Standard (3x3m)</option>
                                <option value="premium">Premium (3x6m)</option>
                                <option value="corner">Corner (4x4m)</option>
                            </select>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Company Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control" name="website" placeholder="https://">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Number of Representatives</label>
                            <input type="number" class="form-control" name="representatives" value="2" min="1">
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="is_sponsor" id="isSponsor">
                                <label class="form-check-label" for="isSponsor">
                                    This exhibitor is also a sponsor
                                </label>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_confirmation" id="sendConfirmation" checked>
                                <label class="form-check-label" for="sendConfirmation">
                                    Send confirmation email
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Add Exhibitor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign Booth Modal -->
<div class="modal fade" id="assignBoothModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Booth</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignBoothForm">
                <input type="hidden" name="exhibitor_id" id="boothExhibitorId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Exhibitor</label>
                        <input type="text" class="form-control" id="boothExhibitorName" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Select Available Booth *</label>
                        <select class="form-select" name="booth_number" required>
                            <option value="">Choose booth...</option>
                            @for($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}">Booth {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Only available booths are shown in the list.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Assign Booth</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function assignBooth(exhibitorId) {
        // Fetch exhibitor details
        fetch(`/admin/exhibitions/${exhibitorId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('boothExhibitorId').value = data.id;
                document.getElementById('boothExhibitorName').value = data.company_name;
                new bootstrap.Modal(document.getElementById('assignBoothModal')).show();
            });
    }
    
    function confirmExhibitor(exhibitorId) {
        if (confirm('Confirm this exhibitor?')) {
            fetch(`/admin/exhibitions/${exhibitorId}/confirm`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
    
    function editExhibitor(exhibitorId) {
        window.location.href = `/admin/exhibitions/${exhibitorId}/edit`;
    }
    
    function viewFloorPlan() {
        window.open('/admin/exhibitions/floor-plan', '_blank');
    }
    
    function exportData() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '{{ route("admin.exhibitions.export") }}?' + params.toString();
    }
    
    // Add exhibitor form
    document.getElementById('addExhibitorForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('{{ route("admin.exhibitions.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    });
    
    // Assign booth form
    document.getElementById('assignBoothForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const exhibitorId = document.getElementById('boothExhibitorId').value;
        
        fetch(`/admin/exhibitions/${exhibitorId}/assign-booth`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    });
</script>
@endsection
