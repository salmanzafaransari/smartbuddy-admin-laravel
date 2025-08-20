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
    <!-- Users Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h5 class="card-title">Users List</h5>
        </div>
        <div class="card-body">
            <table id="usersTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Chatbot[s]</th>
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
$(document).ready(function() {
    let table = $('#blogTable').DataTable({
        processing: true,
        ajax: "{{ route('admin.blogs.index') }}",
        columns: [
            { data: null, // Serial no.
              render: function(data, type, row, meta) {
                  return meta.row + 1; // auto increment row number
              }
            },
            { data: 'image',
              render: function(data, type, row) {
                  let img = data ? data : '/default-blog.png';
                  return `<img src="${img}" alt="Blog Image" 
                              style="width:60px;height:60px;object-fit:cover;border-radius:6px;">`;
              }
            },
            { data: 'title',
              render: function(data, type, row) {
                  return `<strong>${row.title}</strong>`;
              }
            },
            { data: 'created_at',
              render: function(data) {
                  if (!data) return '—';
                  const dateObj = new Date(data);
                  const date = dateObj.toLocaleDateString('en-US');
                  const time = dateObj.toLocaleTimeString('en-US');
                  return `${date}<br><small class="text-muted">${time}</small>`;
              }
            },
            { data: 'id',
              render: function(data, type, row) {
                  return `
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/admin/blogs/${row.id}/edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="/admin/blogs/${row.id}/delete">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>`;
              }
            }
        ]
    });
});

</script>
@endsection
