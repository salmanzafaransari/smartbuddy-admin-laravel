<!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand">
                <i class="fas fa-brain brand-icon"></i>
                <span class="brand-text">SmartBuddy</span>
            </div>
            <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <!-- Administration -->
             @auth
                @if(auth()->user()->is_superuser)
                <div class="menu-section">
                    <div class="menu-section-title">Administration</div>
                    <ul class="menu-items">
                        <li class="menu-item">
                            <a href="{{route('users.index')}}" class="menu-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="fas fa-users menu-icon"></i>
                                <span class="menu-text">User Management</span>
                                <span class="menu-badge" id="allUserCount">0</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{route('users.track')}}" class="menu-link {{ request()->routeIs('users.track') ? 'active' : '' }}">
                                <i class="fas fa-location menu-icon"></i>
                                <span class="menu-text">Tracker</span>
                                <span class="menu-badge" id="allTrackerCount">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            @endauth
            <!-- Main Navigation -->
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <ul class="menu-items">
                    <li class="menu-item">
                        <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt menu-icon"></i>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('chatbot') }}" class="menu-link {{ request()->routeIs('chatbot') ? 'active' : '' }}">
                            <i class="fas fa-robot menu-icon"></i>
                            <span class="menu-text">ChatBot</span>
                        </a>
                    </li>
                    <!-- <li class="menu-item">
                        <a href="ai-analytics.html" class="menu-link">
                            <i class="fas fa-chart-line menu-icon"></i>
                            <span class="menu-text">Analytics Dashboard</span>
                            <span class="menu-badge info">Hot</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ai-social-media-manager.html" class="menu-link">
                            <i class="fas fa-hashtag menu-icon"></i>
                            <span class="menu-text">AI SM Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ai-cs-monitor.html" class="menu-link">
                            <i class="fas fa-headset menu-icon"></i>
                            <span class="menu-text">AI CS Dashboard</span>
                            <span class="menu-badge success">New</span>
                        </a>
                    </li> -->
                </ul>
            </div>

            <!-- User Management -->
            <div class="menu-section">
                <div class="menu-section-title">User</div>
                <ul class="menu-items">
                    <li class="menu-item">
                        <a href="{{route('profile')}}" class="menu-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                            <i class="fas fa-user menu-icon"></i>
                            <span class="menu-text">Profile</span>
                        </a>
                        <ul class="submenu-items">
                            <li><a href="{{route('profile')}}" class="submenu-link">
                                <i class="fas fa-id-card submenu-icon"></i>
                                <span class="menu-text">View Profile</span>
                            </a></li>
                            <li><a href="{{route('editProfile')}}" class="submenu-link">
                                <i class="fas fa-edit submenu-icon"></i>
                                <span class="menu-text">Edit Profile</span>
                            </a></li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('setting')}}" class="menu-link">
                            <i class="fas fa-cog menu-icon"></i>
                            <span class="menu-text">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>


        </div>
        
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <img src="{{ asset('' . (Auth::user()->profile_photo ?? 'user-avatar.jpg')) }}" alt="User Avatar" class="user-avatar-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                </div>
                <div class="user-details">
                    <div class="user-name" style="text-transform:capitalize;">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</div>
                    <!-- <div class="user-role">Premium User</div> -->
                </div>
            </div>
        </div>
    </nav>