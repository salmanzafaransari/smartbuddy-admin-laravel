@extends('default')
@section('pageTitle', 'Profile')
@section('pageAction')
@endsection
@section('style')
<style>
  .notification-toast {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      min-width: 250px;
      max-width: 350px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      opacity: 1;
  }
</style>
@endsection

@section('content')
<div class="content">
    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="profile-avatar mb-3">
                        <div class="avatar-placeholder">
                          <img src="{{ asset('' . (Auth::user()->profile_photo ?? 'user-avatar.jpg')) }}" alt="User Avatar" class="user-avatar-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" style="width:115px; height:115px;">
                        </div>
                    </div>
                    <h4 class="mb-1" style="text-transform:capitalize;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
                    <p class="text-muted mb-2">{{ Auth::user()->job_title }}</p>
                    <!-- <span class="badge bg-primary mb-3">Premium Member</span> -->
                    
                    <div class="profile-stats">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-number">{{ $totalBotCalls }}</div>
                                <div class="stat-label">API Calls</div>
                            </div>
                            <div class="col-6">
                                <div class="stat-number">{{ $totalModels }}</div>
                                <div class="stat-label">ChatBot</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('editProfile') }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Details -->
        <div class="col-lg-8">
            <!-- About Section -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">About</h5>
                </div>
                <div class="card-body">
                    <p>{{ Auth::user()->bio }}</p>
                    <div class="row g-4 mt-3">
                      <div class="col-md-6">
                          <div class="stat-box">
                              <div class="stat-icon bg-primary">
                                  <i class="fas fa-envelope"></i>
                              </div>
                              <div class="stat-details">
                                  <h6>Email</h6>
                                  <p>{{ Auth::user()->email }}</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="stat-box">
                              <div class="stat-icon bg-success">
                                  <i class="fas fa-phone"></i>
                              </div>
                              <div class="stat-details">
                                  <h6>Phone</h6>
                                  <p>{{ Auth::user()->phone }}</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="stat-box">
                              <div class="stat-icon bg-warning">
                                  <i class="fas fa-map-marker-alt"></i>
                              </div>
                              <div class="stat-details">
                                  <h6>Location</h6>
                                  <p>{{ Auth::user()->location }}</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="stat-box">
                              <div class="stat-icon bg-danger">
                                  <i class="fas fa-building"></i>
                              </div>
                              <div class="stat-details">
                                  <h6>Company</h6>
                                  <p>{{ Auth::user()->company }}</p>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="profile-stats">
                     <h5 class="mb-4">Account Statistics</h5>
                    </div>
                    <div class="row g-4">
                      <div class="col-md-6">
                          <div class="stat-box">
                              <div class="stat-icon bg-primary">
                                  <i class="fas fa-calendar-alt"></i>
                              </div>
                              <div class="stat-details">
                                  <h6>Member Since</h6>
                                  <p>{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('F d, Y') }}</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="stat-box">
                              <div class="stat-icon bg-warning">
                                  <i class="fas fa-clock"></i>
                              </div>
                              <div class="stat-details">
                                  <h6>Last Login</h6>
                                  <p>{{ $formattedLogin }}</p>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const message = @json(session('success'));
        const type = 'success';

        const notification = document.createElement('div');
        notification.className = `alert alert-${type} notification-toast`;
        notification.style.transition = 'opacity 0.5s ease';

        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${getNotificationIcon(type)} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close ms-auto" onclick="this.closest('.notification-toast').remove()"></button>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto-fade and remove after 5 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500); // Wait for fade-out
        }, 5000);

        function getNotificationIcon(type) {
            switch (type) {
                case 'success': return 'check-circle';
                case 'error': return 'times-circle';
                case 'warning': return 'exclamation-circle';
                default: return 'info-circle';
            }
        }
    });
</script>
@endif
@endsection