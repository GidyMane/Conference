{{-- Admin Navbar for KALRO Conference Platform --}}
<nav class="admin-navbar">
    <div class="navbar-content">
        {{-- Left Section: Menu Toggle & Breadcrumb --}}
        <div class="navbar-left">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Right Section: Notifications, User Dropdown --}}
        <div class="navbar-right">
            {{-- Quick Actions --}}
            <div class="quick-actions">
                <a href="{{ route('admin.abstracts.pending') }}" class="action-btn" title="Pending Abstracts">
                    <i class="fas fa-file-alt"></i>
                    @if(isset($pendingAbstractsCount) && $pendingAbstractsCount > 0)
                        <span class="badge">{{ $pendingAbstractsCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.papers.pending') }}" class="action-btn" title="Pending Papers">
                    <i class="fas fa-file-pdf"></i>
                    @if(isset($pendingPapersCount) && $pendingPapersCount > 0)
                        <span class="badge">{{ $pendingPapersCount }}</span>
                    @endif
                </a>
            </div>

            {{-- Notifications Dropdown --}}
            <div class="dropdown notifications-dropdown">
                <button class="notification-btn dropdown-toggle" type="button" id="notificationsDropdown" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end notification-menu" aria-labelledby="notificationsDropdown">
                    <li class="notification-header">
                        <h6>Notifications</h6>
                        <a href="{{ route('admin.notifications.mark-all-read') }}" class="mark-read">Mark all as read</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    
                    @if(isset($notifications) && $notifications->count() > 0)
                        @foreach($notifications->take(5) as $notification)
                            <li>
                                <a class="dropdown-item notification-item {{ $notification->read_at ? '' : 'unread' }}" 
                                   href="{{ $notification->data['url'] ?? '#' }}">
                                    <div class="notification-icon {{ $notification->data['type'] ?? 'info' }}">
                                        <i class="fas fa-{{ $notification->data['icon'] ?? 'info-circle' }}"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">{{ $notification->data['message'] }}</p>
                                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-center view-all" href="{{ route('admin.notifications.index') }}">
                                View All Notifications
                            </a>
                        </li>
                    @else
                        <li>
                            <div class="dropdown-item text-center no-notifications">
                                <i class="fas fa-bell-slash"></i>
                                <p>No new notifications</p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- User Dropdown --}}
            <div class="dropdown user-dropdown">
                <button class="user-btn dropdown-toggle" type="button" id="userDropdown" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar-small">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <span class="user-role-badge">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</span>
                    </div>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end user-menu" aria-labelledby="userDropdown">
                    <li class="user-info-item">
                        <div class="user-info-content">
                            <strong>{{ Auth::user()->name }}</strong>
                            <small>{{ Auth::user()->email }}</small>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ url('/') }}" target="_blank">
                            <i class="fas fa-external-link-alt"></i> View Public Site
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
/* Admin Navbar Styles */
.admin-navbar {
    position: fixed;
    top: 0;
    left: 280px;
    right: 0;
    height: 70px;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    z-index: 998;
    transition: left 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.navbar-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 25px;
}

/* Left Section */
.navbar-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #1a5f3a;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.menu-toggle:hover {
    background: #f3f4f6;
    transform: scale(1.1);
}

/* Breadcrumb */
.breadcrumb-wrapper {
    display: flex;
    align-items: center;
}

.breadcrumb {
    margin: 0;
    padding: 0;
    background: none;
    font-size: 0.9rem;
}

.breadcrumb-item {
    color: #6b7280;
}

.breadcrumb-item a {
    color: #1a5f3a;
    text-decoration: none;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.breadcrumb-item a:hover {
    color: #0d3d25;
}

.breadcrumb-item.active {
    color: #111827;
    font-weight: 500;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    color: #d1d5db;
    padding: 0 8px;
}

/* Right Section */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-right: 15px;
    border-right: 1px solid #e5e7eb;
}

.action-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #f9fafb;
    border-radius: 8px;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: #1a5f3a;
    color: #ffffff;
    transform: translateY(-2px);
}

.action-btn .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ef4444;
    color: white;
    font-size: 0.7rem;
    padding: 2px 6px;
    border-radius: 10px;
    font-weight: 600;
    min-width: 18px;
    text-align: center;
}

/* Notifications */
.notification-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #f9fafb;
    border: none;
    border-radius: 8px;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s ease;
}

.notification-btn:hover {
    background: #1a5f3a;
    color: #ffffff;
    transform: translateY(-2px);
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ef4444;
    color: white;
    font-size: 0.7rem;
    padding: 2px 6px;
    border-radius: 10px;
    font-weight: 600;
    min-width: 18px;
    text-align: center;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Notification Menu */
.notification-menu {
    width: 350px;
    max-height: 450px;
    overflow-y: auto;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid #e5e7eb;
}

.notification-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
}

.notification-header h6 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
}

.mark-read {
    font-size: 0.8rem;
    color: #1a5f3a;
    text-decoration: none;
}

.mark-read:hover {
    text-decoration: underline;
}

.notification-item {
    display: flex;
    gap: 12px;
    padding: 12px 20px;
    transition: background 0.3s ease;
    border-left: 3px solid transparent;
}

.notification-item:hover {
    background: #f9fafb;
}

.notification-item.unread {
    background: #f0fdf4;
    border-left-color: #1a5f3a;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notification-icon.info {
    background: #dbeafe;
    color: #1e40af;
}

.notification-icon.success {
    background: #d1fae5;
    color: #065f46;
}

.notification-icon.warning {
    background: #fef3c7;
    color: #92400e;
}

.notification-icon.danger {
    background: #fee2e2;
    color: #991b1b;
}

.notification-content {
    flex: 1;
}

.notification-text {
    margin: 0 0 5px 0;
    font-size: 0.875rem;
    color: #374151;
    line-height: 1.4;
}

.notification-time {
    font-size: 0.75rem;
    color: #9ca3af;
}

.view-all {
    color: #1a5f3a;
    font-weight: 500;
    padding: 12px;
}

.view-all:hover {
    background: #f9fafb;
}

.no-notifications {
    padding: 30px 20px;
    text-align: center;
}

.no-notifications i {
    font-size: 2rem;
    color: #d1d5db;
    margin-bottom: 10px;
}

.no-notifications p {
    margin: 0;
    color: #9ca3af;
    font-size: 0.9rem;
}

/* User Dropdown */
.user-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 6px 12px 6px 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.user-btn:hover {
    background: #ffffff;
    border-color: #1a5f3a;
    box-shadow: 0 4px 12px rgba(26, 95, 58, 0.1);
}

.user-avatar-small {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.user-details {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #111827;
    line-height: 1.2;
}

.user-role-badge {
    font-size: 0.7rem;
    color: #1a5f3a;
    background: #d1fae5;
    padding: 2px 8px;
    border-radius: 8px;
    font-weight: 500;
}

.dropdown-arrow {
    font-size: 0.7rem;
    color: #6b7280;
    transition: transform 0.3s ease;
}

.user-btn[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(180deg);
}

/* User Menu */
.user-menu {
    min-width: 250px;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid #e5e7eb;
}

.user-info-item {
    padding: 15px 20px;
    background: #f9fafb;
}

.user-info-content strong {
    display: block;
    font-size: 0.95rem;
    color: #111827;
    margin-bottom: 3px;
}

.user-info-content small {
    display: block;
    font-size: 0.8rem;
    color: #6b7280;
}

.user-menu .dropdown-item {
    padding: 10px 20px;
    font-size: 0.9rem;
    color: #374151;
    transition: all 0.3s ease;
}

.user-menu .dropdown-item:hover {
    background: #f9fafb;
    color: #1a5f3a;
}

.user-menu .dropdown-item i {
    width: 20px;
    margin-right: 10px;
    text-align: center;
}

.user-menu .dropdown-item.text-danger:hover {
    background: #fef2f2;
    color: #dc2626;
}

/* Responsive Adjustments */
@media (max-width: 991px) {
    .admin-navbar {
        left: 0;
    }

    .menu-toggle {
        display: block;
    }

    .breadcrumb-wrapper {
        display: none;
    }
}

@media (max-width: 768px) {
    .navbar-content {
        padding: 0 15px;
    }

    .quick-actions {
        padding-right: 10px;
    }

    .user-details {
        display: none;
    }

    .notification-menu {
        width: 320px;
    }

    .user-menu {
        min-width: 220px;
    }
}

@media (max-width: 576px) {
    .quick-actions {
        display: none;
    }

    .notification-menu {
        width: 280px;
    }
}
</style>