@extends('reviewer.layout')

@section('title', 'Full Paper Review Management')
@section('page-title', 'Full Paper Review Management')

@section('content')
<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,.08);
        border-left: 4px solid;
        transition: transform .2s;
    }
    .stat-card h3 {
    color: #000;
}
    .stat-card:hover { transform: translateY(-4px); }
    .stat-card.primary { border-left-color: #1e5a96; }
    .stat-card.warning { border-left-color: #ffc107; }
    .stat-card.success { border-left-color: #28a745; }
    .stat-card.danger { border-left-color: #dc3545; }
    
    .stat-card h3 {
        font-size: 36px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .stat-card p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-assigned { background: #dbeafe; color: #1e40af; }
    .status-under-review { background: #e0e7ff; color: #5b21b6; }
    .status-awaiting-decision { background: #fed7aa; color: #9a3412; }
    .status-approved { background: #d1fae5; color: #065f46; }
    .status-rejected { background: #fee2e2; color: #991b1b; }
    
    .review-progress {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .progress-circle {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
    }
    .progress-circle.completed { background: #d1fae5; color: #065f46; }
    .progress-circle.pending { background: #e5e7eb; color: #6b7280; }
</style>

<div class="container-fluid py-4">
    
    {{-- Header --}}
    <div class="mb-4">
        <h2 class="mb-1">
            <i class="fas fa-file-alt text-primary me-2"></i>
            Full Paper Review Management
        </h2>
        <p class="text-muted mb-0">
            Assign reviewers and track review progress for papers in your sub-theme
        </p>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card warning">
                <div>
                    <p>Pending Assignment</p>
                    <h3>3</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card primary">
                <div>
                    <p>Under Review</p>
                    <h3>5</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card danger">
                <div>
                    <p>Awaiting Decision</p>
                    <h3>2</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card success">
                <div>
                    <p>Completed</p>
                    <h3>12</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Papers Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-table me-2"></i>
                Full Papers in Your Sub-Theme
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="100">Paper ID</th>
                            <th>Title</th>
                            <th width="150">Author</th>
                            <th width="140">Status</th>
                            <th width="120" class="text-center">Reviews</th>
                            <th width="250">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Pending Assignment --}}
                        <tr>
                            <td><strong class="text-primary">FP-0001</strong></td>
                            <td>Climate-Smart Agriculture Practices in Smallholder Farming Systems</td>
                            <td>Dr. Jane Kamau</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td class="text-center">
                                <strong class="fs-5">0</strong><span class="text-muted">/3</span>
                            </td>
                            <td>
                                <a href="{{ url('/reviewer/fullpapers/1/assign') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i>Assign Reviewers
                                </a>
                            </td>
                        </tr>

                        {{-- Under Review --}}
                        <tr>
                            <td><strong class="text-primary">FP-0002</strong></td>
                            <td>Impact of Organic Fertilizers on Maize Yield in Semi-Arid Regions</td>
                            <td>Prof. John Odhiambo</td>
                            <td><span class="status-badge status-under-review">Under Review</span></td>
                            <td class="text-center">
                                <div class="review-progress justify-content-center">
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                    <div class="progress-circle pending">3</div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('/reviewer/fullpapers/2/reviews') }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye me-1"></i>View Reviews (2/3)
                                </a>
                            </td>
                        </tr>

                        {{-- Awaiting Decision --}}
                        <tr>
                            <td><strong class="text-primary">FP-0003</strong></td>
                            <td>Sustainable Water Management Techniques for Crop Production</td>
                            <td>Dr. Mary Wanjiru</td>
                            <td><span class="status-badge status-awaiting-decision">Awaiting Decision</span></td>
                            <td class="text-center">
                                <div class="review-progress justify-content-center">
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('/reviewer/fullpapers/3/decision') }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-gavel me-1"></i>Make Decision
                                </a>
                                <a href="{{ url('/reviewer/fullpapers/3/reviews') }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye me-1"></i>View Reviews
                                </a>
                            </td>
                        </tr>

                        {{-- Another Under Review --}}
                        <tr>
                            <td><strong class="text-primary">FP-0004</strong></td>
                            <td>Integrated Pest Management Strategies in Vegetable Production</td>
                            <td>Dr. Peter Mwangi</td>
                            <td><span class="status-badge status-under-review">Under Review</span></td>
                            <td class="text-center">
                                <div class="review-progress justify-content-center">
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                    <div class="progress-circle pending">2</div>
                                    <div class="progress-circle pending">3</div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('/reviewer/fullpapers/4/reviews') }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye me-1"></i>View Reviews (1/3)
                                </a>
                            </td>
                        </tr>

                        {{-- Approved --}}
                        <tr>
                            <td><strong class="text-primary">FP-0005</strong></td>
                            <td>Genetic Improvement of Drought-Resistant Crop Varieties</td>
                            <td>Dr. Sarah Njeri</td>
                            <td><span class="status-badge status-approved">Approved</span></td>
                            <td class="text-center">
                                <div class="review-progress justify-content-center">
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                    <div class="progress-circle completed"><i class="fas fa-check"></i></div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success" onclick="alert('Decision: APPROVED\nAvg Score: 82/100\nAuthor has been notified to upload presentation.')">
                                    <i class="fas fa-check-circle me-1"></i>View Decision
                                </button>
                            </td>
                        </tr>

                        {{-- Pending Assignment --}}
                        <tr>
                            <td><strong class="text-primary">FP-0006</strong></td>
                            <td>Soil Conservation Practices in Highland Agriculture</td>
                            <td>Prof. David Kimani</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td class="text-center">
                                <strong class="fs-5">0</strong><span class="text-muted">/3</span>
                            </td>
                            <td>
                                <a href="{{ url('/reviewer/fullpapers/6/assign') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus me-1"></i>Assign Reviewers
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Help Text --}}
    <div class="alert alert-info mt-4">
        <h6 class="alert-heading">
            <i class="fas fa-info-circle me-2"></i>Workflow Guide
        </h6>
        <ol class="mb-0 small">
            <li><strong>Assign Reviewers:</strong> Click "Assign" to select 3 reviewers (1 prequalified + 2 peer authors)</li>
            <li><strong>Track Progress:</strong> Monitor review completion in the "Reviews" column</li>
            <li><strong>Make Decision:</strong> Once all 3 reviews are complete, click "Make Decision" to approve or reject</li>
            <li><strong>Notify Author:</strong> System automatically emails the author with your decision</li>
        </ol>
    </div>

</div>
@endsection