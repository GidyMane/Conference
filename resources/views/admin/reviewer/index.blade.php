@extends('admin.layout')

@section('title', 'Manage Reviewers')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Reviewers</h1>
        <div>
            <a href="{{ route('admin.reviewers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Reviewer
            </a>
            <a href="{{ route('admin.reviewers.workload') }}" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> View Workload
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Reviewers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Reviewers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Assignments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">48</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Completed Reviews</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">35</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reviewers.index') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label for="status" class="mr-2">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="form-group mr-3">
                    <label for="sub_theme_id" class="mr-2">Sub-theme:</label>
                    <select name="sub_theme_id" id="sub_theme_id" class="form-control">
                        <option value="">All Sub-themes</option>
                        <option value="1">Climate-Smart Agriculture</option>
                        <option value="2">Sustainable Crop Production</option>
                        <option value="3">Livestock Innovation</option>
                        <option value="4">Agricultural Mechanization</option>
                    </select>
                </div>

                <div class="form-group mr-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email...">
                </div>

                <button type="submit" class="btn btn-primary mr-2">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.reviewers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Reviewers Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Reviewers (12)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Sub-theme</th>
                            <th>Assignments</th>
                            <th>Completed</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // DUMMY DATA - Replace with actual database query
                        $dummyReviewers = [
                            [
                                'id' => 1,
                                'name' => 'Dr. John Kamau',
                                'email' => 'j.kamau@uonbi.ac.ke',
                                'organization' => 'University of Nairobi',
                                'sub_theme' => 'Climate-Smart Agriculture',
                                'sub_theme_code' => 'CSA-01',
                                'total_assignments' => 5,
                                'completed' => 4,
                                'status' => 'active',
                                'created_at' => '2026-01-15'
                            ],
                            [
                                'id' => 2,
                                'name' => 'Prof. Mary Wanjiru',
                                'email' => 'm.wanjiru@jkuat.ac.ke',
                                'organization' => 'JKUAT',
                                'sub_theme' => 'Sustainable Crop Production',
                                'sub_theme_code' => 'SCP-02',
                                'total_assignments' => 6,
                                'completed' => 5,
                                'status' => 'active',
                                'created_at' => '2026-01-10'
                            ],
                            [
                                'id' => 3,
                                'name' => 'Dr. Peter Omondi',
                                'email' => 'p.omondi@kalro.org',
                                'organization' => 'KALRO',
                                'sub_theme' => 'Livestock Innovation',
                                'sub_theme_code' => 'LI-03',
                                'total_assignments' => 4,
                                'completed' => 4,
                                'status' => 'active',
                                'created_at' => '2026-01-20'
                            ],
                            [
                                'id' => 4,
                                'name' => 'Dr. Sarah Muthoni',
                                'email' => 's.muthoni@egerton.ac.ke',
                                'organization' => 'Egerton University',
                                'sub_theme' => 'Climate-Smart Agriculture',
                                'sub_theme_code' => 'CSA-01',
                                'total_assignments' => 3,
                                'completed' => 2,
                                'status' => 'active',
                                'created_at' => '2026-01-25'
                            ],
                            [
                                'id' => 5,
                                'name' => 'Prof. David Njoroge',
                                'email' => 'd.njoroge@must.ac.ke',
                                'organization' => 'Meru University',
                                'sub_theme' => 'Agricultural Mechanization',
                                'sub_theme_code' => 'AM-04',
                                'total_assignments' => 5,
                                'completed' => 3,
                                'status' => 'active',
                                'created_at' => '2026-01-12'
                            ],
                            [
                                'id' => 6,
                                'name' => 'Dr. Grace Akinyi',
                                'email' => 'g.akinyi@mmust.ac.ke',
                                'organization' => 'Masinde Muliro University',
                                'sub_theme' => 'Sustainable Crop Production',
                                'sub_theme_code' => 'SCP-02',
                                'total_assignments' => 4,
                                'completed' => 3,
                                'status' => 'active',
                                'created_at' => '2026-01-18'
                            ],
                            [
                                'id' => 7,
                                'name' => 'Dr. James Otieno',
                                'email' => 'j.otieno@ku.ac.ke',
                                'organization' => 'Kenyatta University',
                                'sub_theme' => 'Livestock Innovation',
                                'sub_theme_code' => 'LI-03',
                                'total_assignments' => 5,
                                'completed' => 4,
                                'status' => 'active',
                                'created_at' => '2026-01-08'
                            ],
                            [
                                'id' => 8,
                                'name' => 'Prof. Elizabeth Mugo',
                                'email' => 'e.mugo@chuka.ac.ke',
                                'organization' => 'Chuka University',
                                'sub_theme' => 'Climate-Smart Agriculture',
                                'sub_theme_code' => 'CSA-01',
                                'total_assignments' => 4,
                                'completed' => 2,
                                'status' => 'active',
                                'created_at' => '2026-01-22'
                            ],
                            [
                                'id' => 9,
                                'name' => 'Dr. Michael Kimani',
                                'email' => 'm.kimani@dkut.ac.ke',
                                'organization' => 'Dedan Kimathi University',
                                'sub_theme' => 'Agricultural Mechanization',
                                'sub_theme_code' => 'AM-04',
                                'total_assignments' => 3,
                                'completed' => 3,
                                'status' => 'active',
                                'created_at' => '2026-01-14'
                            ],
                            [
                                'id' => 10,
                                'name' => 'Dr. Nancy Wambui',
                                'email' => 'n.wambui@seku.ac.ke',
                                'organization' => 'South Eastern Kenya University',
                                'sub_theme' => 'Sustainable Crop Production',
                                'sub_theme_code' => 'SCP-02',
                                'total_assignments' => 4,
                                'completed' => 4,
                                'status' => 'active',
                                'created_at' => '2026-01-16'
                            ],
                            [
                                'id' => 11,
                                'name' => 'Prof. Robert Kariuki',
                                'email' => 'r.kariuki@tum.ac.ke',
                                'organization' => 'Technical University of Mombasa',
                                'sub_theme' => 'Livestock Innovation',
                                'sub_theme_code' => 'LI-03',
                                'total_assignments' => 2,
                                'completed' => 1,
                                'status' => 'inactive',
                                'created_at' => '2026-01-05'
                            ],
                            [
                                'id' => 12,
                                'name' => 'Dr. Lucy Njeri',
                                'email' => 'l.njeri@karu.ac.ke',
                                'organization' => 'Karatina University',
                                'sub_theme' => 'Climate-Smart Agriculture',
                                'sub_theme_code' => 'CSA-01',
                                'total_assignments' => 3,
                                'completed' => 2,
                                'status' => 'inactive',
                                'created_at' => '2026-01-03'
                            ],
                        ];
                        ?>

                        @foreach($dummyReviewers as $reviewer)
                        <tr>
                            <td>{{ $reviewer['id'] }}</td>
                            <td>
                                <strong>{{ $reviewer['name'] }}</strong>
                            </td>
                            <td>{{ $reviewer['email'] }}</td>
                            <td>{{ $reviewer['organization'] }}</td>
                            <td>
                                <span class="badge badge-info">{{ $reviewer['sub_theme_code'] }}</span><br>
                                <small>{{ $reviewer['sub_theme'] }}</small>
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $reviewer['total_assignments'] }}</span>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $reviewer['completed'] }}</span>
                            </td>
                            <td>
                                @if($reviewer['status'] == 'active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.reviewers.show', $reviewer['id']) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.reviewers.edit', $reviewer['id']) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-warning" 
                                            title="Reset Password"
                                            onclick="resetPassword({{ $reviewer['id'] }}, '{{ $reviewer['name'] }}')">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            title="Delete"
                                            onclick="deleteReviewer({{ $reviewer['id'] }}, '{{ $reviewer['name'] }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Static for demo) -->
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

@push('scripts')
<script>
function resetPassword(id, name) {
    if (confirm('Reset password for ' + name + '?\n\nA new password will be generated and sent to their email.')) {
        // In real implementation, this would make an AJAX call
        alert('Password reset email sent to ' + name);
        // $.post('/admin/reviewers/' + id + '/reset-password', {_token: '{{ csrf_token() }}'});
    }
}

function deleteReviewer(id, name) {
    if (confirm('Are you sure you want to delete ' + name + '?\n\nThis action cannot be undone.')) {
        // In real implementation, this would submit a delete form
        alert('Reviewer ' + name + ' deleted successfully');
        // $('#delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection