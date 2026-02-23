@extends('admin.layout')

@section('title', 'Full Paper Reviewer Assignment')

@section('content')
<style>
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
        border-left: 4px solid;
    }
    .stat-card h3 {
    color: #000;
}
    .stat-card.primary { border-left-color: #007bff; }
    .stat-card.warning { border-left-color: #ffc107; }
    .stat-card.success { border-left-color: #28a745; }
    
    .admin-notice {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        border-left: 4px solid #ffc107;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid py-4">
    
    <div class="mb-4">
        <h2 class="mb-1">
            <i class="fas fa-user-check text-primary me-2"></i>
            Full Paper Reviewer Assignment
        </h2>
        <p class="text-muted mb-0">
            Manage reviewer assignments across all sub-themes
        </p>
    </div>

    {{-- Admin Notice --}}
    <div class="admin-notice">
        <h6><i class="fas fa-info-circle me-2"></i>Admin Role Permissions</h6>
        <ul class="mb-0 small">
            <li><strong>You CAN:</strong> Assign reviewers to any full paper across all sub-themes</li>
            <li><strong>You CANNOT:</strong> Approve or reject papers (only Sub-Theme Leaders can make final decisions)</li>
            <li>Assignments you make will be visible to the respective Sub-Theme Leaders</li>
        </ul>
    </div>

    {{-- Statistics --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stat-card warning">
                <p class="text-muted mb-1">PENDING ASSIGNMENT</p>
                <h3 class="mb-0">8</h3>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stat-card primary">
                <p class="text-muted mb-1">ASSIGNED BY ADMIN</p>
                <h3 class="mb-0">15</h3>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stat-card success">
                <p class="text-muted mb-1">TOTAL PAPERS</p>
                <h3 class="mb-0">42</h3>
            </div>
        </div>
    </div>

    {{-- Papers Table --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-table me-2"></i>All Full Papers
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Paper ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Sub-Theme</th>
                            <th>Reviews</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>FP-0007</strong></td>
                            <td>Soil Fertility Management in Arid Regions</td>
                            <td>Dr. James Muturi</td>
                            <td><span class="badge bg-secondary">Soil Science</span></td>
                            <td class="text-center">0/3</td>
                            <td>
                                <a href="{{ url('/admin/fullpapers/7/assign') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i>Assign Reviewers
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FP-0008</strong></td>
                            <td>Post-Harvest Loss Reduction Technologies</td>
                            <td>Dr. Anne Wambui</td>
                            <td><span class="badge bg-info">Post-Harvest</span></td>
                            <td class="text-center">1/3</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="alert('Review Progress:\nReviewer 1: Completed (85/100)\nReviewer 2: Pending\nReviewer 3: Pending')">
                                    <i class="fas fa-eye me-1"></i>View Status
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FP-0009</strong></td>
                            <td>Livestock Feed Optimization in Dry Seasons</td>
                            <td>Prof. Daniel Kiptoo</td>
                            <td><span class="badge bg-warning text-dark">Livestock</span></td>
                            <td class="text-center">0/3</td>
                            <td>
                                <a href="{{ url('/admin/fullpapers/9/assign') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i>Assign Reviewers
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FP-0010</strong></td>
                            <td>Urban Agriculture: Opportunities and Challenges</td>
                            <td>Dr. Linda Achieng</td>
                            <td><span class="badge bg-success">Urban Agriculture</span></td>
                            <td class="text-center">3/3</td>
                            <td>
                                <button class="btn btn-sm btn-secondary" disabled>
                                    <i class="fas fa-clock me-1"></i>Awaiting Sub-Theme Leader Decision
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FP-0011</strong></td>
                            <td>Indigenous Crop Varieties Conservation</td>
                            <td>Dr. Robert Ng'ang'a</td>
                            <td><span class="badge bg-primary">Crop Science</span></td>
                            <td class="text-center">2/3</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="alert('Review Progress:\nReviewer 1: Completed (78/100)\nReviewer 2: Completed (82/100)\nReviewer 3: In Progress')">
                                    <i class="fas fa-eye me-1"></i>View Status
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FP-0012</strong></td>
                            <td>Aquaculture Development in Coastal Areas</td>
                            <td>Dr. Patricia Otieno</td>
                            <td><span class="badge bg-info">Fisheries</span></td>
                            <td class="text-center">0/3</td>
                            <td>
                                <a href="{{ url('/admin/fullpapers/12/assign') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i>Assign Reviewers
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Info Alert --}}
    <div class="alert alert-info mt-4">
        <h6><i class="fas fa-lightbulb me-2"></i>Assignment Process</h6>
        <ol class="mb-0 small">
            <li>Click "Assign Reviewers" to select 3 reviewers (1 prequalified + 2 peer authors)</li>
            <li>System sends email notifications with unique review links</li>
            <li>Monitor progress in the "Reviews" column</li>
            <li>Once all 3 reviews complete, Sub-Theme Leader makes final decision</li>
        </ol>
    </div>

</div>
@endsection