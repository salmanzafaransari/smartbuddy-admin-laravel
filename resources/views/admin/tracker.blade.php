@extends('default')
@section('pageTitle', 'Tracker')
@section('pageAction')

@endsection
@section('style')
<link href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/datatables/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
@endsection
@section('content')
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