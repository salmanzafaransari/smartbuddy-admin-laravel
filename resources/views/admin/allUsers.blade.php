@extends('default')
@section('pageTitle', 'All Users')
@section('pageAction')

@endsection
@section('style')
<link href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/datatables/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">

@endsection
@section('content')
<div class="content">
    <!-- Stats Cards -->
    <!-- <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number totalUsers">loading</h3>
                    <p class="stat-label">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">1,189</h3>
                    <p class="stat-label">Active Users</p>
                    <span class="stat-change positive">+12%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">34</h3>
                    <p class="stat-label">Pending</p>
                    <span class="stat-change negative">-2%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="fas fa-user-slash"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">24</h3>
                    <p class="stat-label">Suspended</p>
                    <span class="stat-change positive">-15%</span>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Users Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h5 class="card-title">Users List</h5>
            <!-- <div class="card-actions">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-filter"></i> Filter by Status
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-filter="all">All Users</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="active">Active</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="pending">Pending</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="suspended">Suspended</a></li>
                    </ul>
                </div>
            </div> -->
        </div>
        <div class="card-body">
            <table id="usersTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Chatbot</th>
                        <th>Last Login</th>
                        <th>Register on</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/responsive.bootstrap5.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#usersTable').DataTable({
        processing: true,
        ajax: "{{ route('users.list') }}",
        columns: [
            { data: null,
              render: function(data, type, row) {
                  return `<div class="d-flex align-items-center"><div class="user-avatar-sm me-3"><div class="avatar-placeholder-sm" style="overflow:hidden;"><img src="{{asset('${row.profile_photo}')}}" style="width:100%;" /></div></div><div><strong>${row.first_name} ${row.last_name}</strong></div></div>`;
              }
            },
            { data: 'email' },
            { data: 'chatbots_count',
              render: function(data, type, row){
               return `<strong>${row.chatbots_count}</strong>`;
              }
            },
            { data: 'last_login_at', 
              render: function(data) {
                  if (!data) return 'Never';
                  
                  const dateObj = new Date(data);
                  const date = dateObj.toLocaleDateString('en-US'); // 1/15/2024
                  const time = dateObj.toLocaleTimeString('en-US'); // 8:00:00 AM
                  
                  return `${date}<br><small class="text-muted">${time}</small>`;
              }
            },
            { data: 'created_at', 
              render: function(data) {
                  if (!data) return 'Never';
                  
                  const dateObj = new Date(data);
                  const date = dateObj.toLocaleDateString('en-US'); // 1/15/2024
                  const time = dateObj.toLocaleTimeString('en-US'); // 8:00:00 AM
                  
                  return `${date}<br><small class="text-muted">${time}</small>`;
              }
            },
            { data: 'id', render: function(data, type, row) {
                return `<div class="dropdown">
                           <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                               <i class="fas fa-ellipsis-v"></i>
                           </button>
                           <ul class="dropdown-menu">
                               <li><a class="dropdown-item" href="#"><i class="fas fa-info"></i> Details</a></li>
                               <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line"></i> Analytics</a></li>
                               <li><hr class="dropdown-divider"></li>
                               <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Delete</a></li>
                           </ul>
                       </div>`;
            }}
        ]
    });
});

</script>
@endsection
