<!-- Header -->
<header class="header">
    <div class="header-left">
        <button class="sidebar-toggle d-lg-none" id="mobileSidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <button class="sidebar-collapse-toggle d-none d-lg-block" id="sidebarCollapseToggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">@yield('pageTitle')</h1>
    </div>
    <div class="header-right">
        <div class="header-actions">
            <button class="btn btn-icon theme-toggle" id="themeToggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle Theme">
                <i class="fas fa-moon"></i>
            </button>

            @yield('pageAction')
            <!-- <button class="btn btn-icon" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <h6 class="dropdown-header">Notifications</h6>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-info-circle text-primary"></i>
                    New AI model available
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-check-circle text-success"></i>
                    Image generation complete
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    API usage at 80%
                </a>
            </div> -->
        </div>
        
        <div class="dropdown user-dropdown">
            <button class="btn user-menu-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar-wrapper">
                    <img src="{{ asset('' . (Auth::user()->profile_photo ?? 'user-avatar.jpg')) }}" alt="User Avatar" class="user-avatar-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="user-avatar-fallback">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="user-info-header d-none d-md-block">
                    <div class="user-name-header" style="text-transform:capitalize;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                    <div class="user-status">
                        <span class="status-indicator online"></span>
                        <span class="status-text">Online</span>
                    </div>
                </div>
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                <div class="dropdown-header">
                    <div class="user-profile-section">
                        <div class="user-avatar-large">
                            <img src="{{ asset('' . (Auth::user()->profile_photo ?? 'user-avatar.jpg')) }}" alt="User Avatar" class="user-avatar-img-large" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="user-avatar-fallback-large">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="status-badge online">
                                <i class="fas fa-circle"></i>
                            </div>
                        </div>
                        <div class="user-details-dropdown">
                            <h6 class="user-name-dropdown" style="text-transform:capitalize;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                            <!-- <div class="user-plan">
                                <span class="plan-badge premium">
                                    <i class="fas fa-crown"></i> Premium User
                                </span>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item enhanced-item" href="{{ route('profile')  }}">
                    <div class="item-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="item-content">
                        <span class="item-title">My Profile</span>
                        <span class="item-subtitle">View and manage profile</span>
                    </div>
                    <i class="fas fa-chevron-right item-arrow"></i>
                </a>
                <a class="dropdown-item enhanced-item" href="{{route('editProfile')}}">
                    <div class="item-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="item-content">
                        <span class="item-title">Edit Profile</span>
                        <span class="item-subtitle">Update your information</span>
                    </div>
                    <i class="fas fa-chevron-right item-arrow"></i>
                </a>
                <a class="dropdown-item enhanced-item" href="{{ route('setting') }}">
                    <div class="item-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="item-content">
                        <span class="item-title">Settings</span>
                        <span class="item-subtitle">Preferences and privacy</span>
                    </div>
                    <i class="fas fa-chevron-right item-arrow"></i>
                </a>
                
                <a class="dropdown-item enhanced-item logout-item mb-2"
                href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="item-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="item-content">
                        <span class="item-title">Sign Out</span>
                        <span class="item-subtitle">Logout from account</span>
                    </div>
                    <i class="fas fa-chevron-right item-arrow"></i>
                </a>

            </div>
        </div>
    </div>
</header>
@auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth