{{-- Admin Sidebar for KALRO Conference Platform --}}
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="{{ asset('images/kalro-logo.png') }}" alt="KALRO Logo" class="logo-img">
            <div class="logo-text">
                <h3>KALRO</h3>
                <span>Conference Admin</span>
            </div>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="user-info">
            <h4>{{ Auth::user()->name ?? 'Admin User' }}</h4>
            <span class="user-role">{{ ucfirst(Auth::user()->role ?? 'Administrator') }}</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            {{-- Dashboard --}}
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Manage Abstracts --}}
            <li class="nav-item {{ request()->routeIs('admin.abstracts*') ? 'active' : '' }}">
                <a href="#abstractsSubmenu" class="nav-link" data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('admin.abstracts*') ? 'true' : 'false' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Manage Abstracts</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="collapse submenu {{ request()->routeIs('admin.abstracts*') ? 'show' : '' }}" id="abstractsSubmenu">
                    <li><a href="{{ route('admin.abstracts.index') }}" class="{{ request()->routeIs('admin.abstracts.index') ? 'active' : '' }}">All Abstracts</a></li>
                    <li><a href="{{ route('admin.abstracts.pending') }}" class="{{ request()->routeIs('admin.abstracts.pending') ? 'active' : '' }}">Pending</a></li>
                    <li><a href="{{ route('admin.abstracts.under-review') }}" class="{{ request()->routeIs('admin.abstracts.under-review') ? 'active' : '' }}">Under Review</a></li>
                    <li><a href="{{ route('admin.abstracts.approved') }}" class="{{ request()->routeIs('admin.abstracts.approved') ? 'active' : '' }}">Approved</a></li>
                    <li><a href="{{ route('admin.abstracts.rejected') }}" class="{{ request()->routeIs('admin.abstracts.rejected') ? 'active' : '' }}">Rejected</a></li>
                    <li><a href="{{ route('admin.abstracts.assign') }}" class="{{ request()->routeIs('admin.abstracts.assign') ? 'active' : '' }}">Assign Reviewers</a></li>
                </ul>
            </li>

            {{-- Manage Full Papers --}}
            <li class="nav-item {{ request()->routeIs('admin.papers*') ? 'active' : '' }}">
                <a href="#papersSubmenu" class="nav-link" data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('admin.papers*') ? 'true' : 'false' }}">
                    <i class="fas fa-file-pdf"></i>
                    <span>Manage Full Papers</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="collapse submenu {{ request()->routeIs('admin.papers*') ? 'show' : '' }}" id="papersSubmenu">
                    <li><a href="{{ route('admin.papers.index') }}" class="{{ request()->routeIs('admin.papers.index') ? 'active' : '' }}">All Papers</a></li>
                    <li><a href="{{ route('admin.papers.pending') }}" class="{{ request()->routeIs('admin.papers.pending') ? 'active' : '' }}">Pending Review</a></li>
                    <li><a href="{{ route('admin.papers.approved') }}" class="{{ request()->routeIs('admin.papers.approved') ? 'active' : '' }}">Approved</a></li>
                    <li><a href="{{ route('admin.papers.rejected') }}" class="{{ request()->routeIs('admin.papers.rejected') ? 'active' : '' }}">Rejected</a></li>
                </ul>
            </li>

            {{-- Manage Registrations --}}
            <li class="nav-item {{ request()->routeIs('admin.registrations*') ? 'active' : '' }}">
                <a href="#registrationsSubmenu" class="nav-link" data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('admin.registrations*') ? 'true' : 'false' }}">
                    <i class="fas fa-users"></i>
                    <span>Manage Registrations</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="collapse submenu {{ request()->routeIs('admin.registrations*') ? 'show' : '' }}" id="registrationsSubmenu">
                    <li><a href="{{ route('admin.registrations.index') }}" class="{{ request()->routeIs('admin.registrations.index') ? 'active' : '' }}">All Registrations</a></li>
                    <li><a href="{{ route('admin.registrations.participants') }}" class="{{ request()->routeIs('admin.registrations.participants') ? 'active' : '' }}">Participants</a></li>
                    <li><a href="{{ route('admin.registrations.pending') }}" class="{{ request()->routeIs('admin.registrations.pending') ? 'active' : '' }}">Pending Approval</a></li>
                </ul>
            </li>

            {{-- Manage Exhibitions --}}
            <li class="nav-item {{ request()->routeIs('admin.exhibitions*') ? 'active' : '' }}">
                <a href="#exhibitionsSubmenu" class="nav-link" data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('admin.exhibitions*') ? 'true' : 'false' }}">
                    <i class="fas fa-store"></i>
                    <span>Manage Exhibitions</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="collapse submenu {{ request()->routeIs('admin.exhibitions*') ? 'show' : '' }}" id="exhibitionsSubmenu">
                    <li><a href="{{ route('admin.exhibitions.index') }}" class="{{ request()->routeIs('admin.exhibitions.index') ? 'active' : '' }}">All Exhibitors</a></li>
                    <li><a href="{{ route('admin.exhibitions.pending') }}" class="{{ request()->routeIs('admin.exhibitions.pending') ? 'active' : '' }}">Pending Approval</a></li>
                    <li><a href="{{ route('admin.exhibitions.approved') }}" class="{{ request()->routeIs('admin.exhibitions.approved') ? 'active' : '' }}">Approved</a></li>
                </ul>
            </li>

            {{-- Manage Users (Admin Only) --}}
            @if(Auth::user()->role === 'admin')
            <li class="nav-item {{ request()->routeIs('admin.users*') || request()->routeIs('admin.reviewers*') ? 'active' : '' }}">
                <a href="#usersSubmenu" class="nav-link" data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->routeIs('admin.users*') || request()->routeIs('admin.reviewers*') ? 'true' : 'false' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Manage Users</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="collapse submenu {{ request()->routeIs('admin.users*') || request()->routeIs('admin.reviewers*') ? 'show' : '' }}" id="usersSubmenu">
                    <li><a href="{{ route('admin.reviewers.index') }}" class="{{ request()->routeIs('admin.reviewers.index') ? 'active' : '' }}">Reviewers</a></li>
                    <li><a href="{{ route('admin.reviewers.create') }}" class="{{ request()->routeIs('admin.reviewers.create') ? 'active' : '' }}">Add Reviewer</a></li>
                    <li><a href="{{ route('admin.reviewers.assign-subtheme') }}" class="{{ request()->routeIs('admin.reviewers.assign-subtheme') ? 'active' : '' }}">Assign Sub-themes</a></li>
                    <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">All Users</a></li>
                </ul>
            </li>
            @endif

            {{-- Sub-themes --}}
            <li class="nav-item {{ request()->routeIs('admin.subthemes*') ? 'active' : '' }}">
                <a href="{{ route('admin.subthemes.index') }}" class="nav-link">
                    <i class="fas fa-layer-group"></i>
                    <span>Sub-themes</span>
                </a>
            </li>

            {{-- Settings --}}
            @if(Auth::user()->role === 'admin')
            <li class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('admin.profile') }}" class="footer-link">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
        <a href="{{ route('logout') }}" class="footer-link" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</aside>

{{-- Sidebar Overlay for Mobile --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
/* Sidebar Styles */
.admin-sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 280px;
    background: linear-gradient(180deg, #1a5f3a 0%, #0d3d25 100%);
    color: #ffffff;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    overflow-x: hidden;
}

.admin-sidebar::-webkit-scrollbar {
    width: 6px;
}

.admin-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

.admin-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

.admin-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Sidebar Header */
.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo-img {
    width: 45px;
    height: 45px;
    object-fit: contain;
    background: white;
    border-radius: 8px;
    padding: 4px;
}

.logo-text h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 0.5px;
}

.logo-text span {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 400;
}

.sidebar-toggle {
    display: none;
    background: none;
    border: none;
    color: #ffffff;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 5px;
    transition: transform 0.2s;
}

.sidebar-toggle:hover {
    transform: rotate(90deg);
}

/* Sidebar User */
.sidebar-user {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.user-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.user-info h4 {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: #ffffff;
}

.user-role {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    display: inline-block;
    background: rgba(255, 255, 255, 0.1);
    padding: 2px 8px;
    border-radius: 10px;
    margin-top: 4px;
}

/* Sidebar Navigation */
.sidebar-nav {
    flex: 1;
    padding: 20px 0;
}

.nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    margin-bottom: 2px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    font-size: 0.95rem;
    font-weight: 500;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    padding-left: 25px;
}

.nav-link i {
    width: 24px;
    font-size: 1.1rem;
    margin-right: 12px;
    color: rgba(255, 255, 255, 0.9);
}

.nav-link span {
    flex: 1;
}

.submenu-arrow {
    font-size: 0.8rem;
    margin-left: auto;
    margin-right: 0;
    transition: transform 0.3s ease;
}

.nav-link[aria-expanded="true"] .submenu-arrow {
    transform: rotate(180deg);
}

/* Active State */
.nav-item.active > .nav-link {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-weight: 600;
    border-left: 4px solid #ffc107;
}

.nav-item.active > .nav-link i {
    color: #ffc107;
}

/* Submenu */
.submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    background: rgba(0, 0, 0, 0.2);
}

.submenu li {
    margin: 0;
}

.submenu a {
    display: block;
    padding: 10px 20px 10px 56px;
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    position: relative;
}

.submenu a:before {
    content: '';
    position: absolute;
    left: 35px;
    top: 50%;
    transform: translateY(-50%);
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    transition: all 0.3s ease;
}

.submenu a:hover {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    padding-left: 60px;
}

.submenu a:hover:before {
    background: #ffc107;
    transform: translateY(-50%) scale(1.3);
}

.submenu a.active {
    background: rgba(255, 255, 255, 0.1);
    color: #ffc107;
    font-weight: 600;
    border-left: 3px solid #ffc107;
}

.submenu a.active:before {
    background: #ffc107;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 15px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.2);
}

.footer-link {
    display: flex;
    align-items: center;
    padding: 10px 0;
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.footer-link:hover {
    color: #ffc107;
    padding-left: 5px;
}

.footer-link i {
    width: 20px;
    margin-right: 10px;
    font-size: 1rem;
}

/* Sidebar Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
    display: block;
    opacity: 1;
}

/* Mobile Responsiveness */
@media (max-width: 991px) {
    .admin-sidebar {
        transform: translateX(-100%);
    }

    .admin-sidebar.active {
        transform: translateX(0);
    }

    .sidebar-toggle {
        display: block;
    }
}

@media (max-width: 576px) {
    .admin-sidebar {
        width: 260px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const menuToggle = document.getElementById('menuToggle'); // From navbar

    // Toggle sidebar on mobile
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        });
    }

    // Close sidebar
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Close sidebar when window is resized to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991) {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>