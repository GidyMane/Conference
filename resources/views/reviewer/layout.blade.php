<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Reviewer Dashboard') - KALRO Conference</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --reviewer-blue: #1e5a96;
            --reviewer-dark-blue: #143d66;
            --reviewer-light-blue: #e3f2fd;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--reviewer-blue) 0%, var(--reviewer-dark-blue) 100%);
            color: white;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header img {
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
            background: white;
            padding: 8px;
            border-radius: 8px;
        }

        .sidebar-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .sidebar-header p {
            margin: 5px 0 0 0;
            font-size: 11px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #64b5f6;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: #64b5f6;
        }

        .menu-item i {
            width: 25px;
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 3px solid var(--reviewer-blue);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand h5 {
            color: var(--reviewer-dark-blue);
            font-weight: 600;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-menu .btn-link {
            color: #5a6c7d;
            text-decoration: none;
            position: relative;
        }

        .user-menu .btn-link:hover {
            color: var(--reviewer-blue);
        }

        .user-menu .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            padding: 3px 5px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--reviewer-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-header {
            background: white;
            border-bottom: 2px solid #f0f0f0;
            padding: 15px 20px;
            font-weight: 600;
        }

        /* Buttons */
        .btn-reviewer-primary {
            background: var(--reviewer-blue);
            color: white;
            border: none;
        }

        .btn-reviewer-primary:hover {
            background: var(--reviewer-dark-blue);
            color: white;
        }

        /* Badges */
        .badge-pending {
            background: #ffc107;
            color: #000;
        }

        .badge-under-review {
            background: #17a2b8;
            color: white;
        }

        .badge-approved {
            background: #28a745;
            color: white;
        }

        .badge-rejected {
            background: #dc3545;
            color: white;
        }

        .badge-reviewed {
            background: #6c757d;
            color: white;
        }

        /* Stats Cards */
        .stat-card {
            padding: 20px;
            border-radius: 8px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .stat-card-icon {
            font-size: 40px;
            opacity: 0.3;
            position: absolute;
            right: 20px;
            bottom: 20px;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .stat-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Table Styles */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background: var(--reviewer-blue);
            color: white;
            border: none;
            font-weight: 600;
        }

        /* Dropdown */
        .dropdown-menu {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        /* Reviewer Badge */
        .reviewer-badge {
            background: var(--reviewer-light-blue);
            color: var(--reviewer-dark-blue);
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 15px;
        }

        .reviewer-badge i {
            margin-right: 5px;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('assets/images/kalro-logo.gif') }}" alt="KALRO Logo">
            <h4>KALRO Conference</h4>
            <p>Reviewer Portal</p>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('reviewer.dashboard') }}" class="menu-item {{ request()->routeIs('reviewer.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('reviewer.abstracts.index') }}" class="menu-item {{ request()->is('reviewer/abstracts*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>My Abstracts</span>
            </a>
            
            <a href="#" class="menu-item {{ request()->is('reviewer/pending*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                <span>Pending Reviews</span>
            </a>
            
            <a href="#" class="menu-item {{ request()->is('reviewer/completed*') ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i>
                <span>Completed Reviews</span>
            </a>
            
            <a href="#" class="menu-item {{ request()->is('reviewer/profile*') ? 'active' : '' }}">
    <i class="fas fa-book-reader"></i>
    <span>Full Papers</span>
</a>

            
            <div style="margin: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <a href="#" class="menu-item {{ request()->is('reviewer/help*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i>
                    <span>Help & Guidelines</span>
                </a>
                
                <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('reviewer.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="navbar-brand">
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>
            
            <div class="user-menu">
                <div class="dropdown">

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#">New abstract assigned</a></li>
                        <li><a class="dropdown-item" href="#">Review deadline approaching</a></li>
                        <li><a class="dropdown-item" href="#">System update</a></li>
                    </ul>
                </div>
                
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'R', 0, 1)) }}</div>
                        
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('reviewer.profile') }}"><i class="fas fa-user me-2"></i>My Profile</a></li>
                        
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('reviewer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Initialize DataTables
        $(document).ready(function() {
            $('.data-table').DataTable({
                order: [[0, 'desc']],
                pageLength: 25,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries"
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>