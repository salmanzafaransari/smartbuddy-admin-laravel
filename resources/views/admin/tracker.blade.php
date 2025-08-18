@extends('default')
@section('pageTitle', 'Tracker')
@section('pageAction')

@endsection
@section('style')
<link href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/datatables/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content">
    <!-- trackers Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h5 class="card-title">Trackers List</h5>
        </div>
        <div class="card-body">
            <table id="trackersTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">User</th>
                        <th>Chatbot</th>
                        <th class="text-center">Website</th>
                        <th class="text-center">Tracked Pages</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Get Details</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal for details -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-gredient text-white">
        <h5 class="modal-title">Tracker Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="detailsContent">Loading...</div>
      </div>
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
    $('#trackersTable').DataTable({
        processing: true,
        serverSide: false, 
        ajax: {
            url: "{{ route('tracker.trackList') }}",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; // auto index
                }
            },
            { 
                data: "users",
                render: function(data) {
                    return data ? data.first_name + '&nbsp;' + data.last_name : 'N/A';
                }
            },
            { 
                data: "chatbots",
                render: function(data) {
                    return data ? data.name : 'N/A';
                }
            },
            { data: "website",
              render: function(data) {
                return `<a href="${data}">${data}</a>`;
              }
            },
            { data: "total_pages",
             className: "text-center" 
            },
            { 
                data: "created_at",
                render: function(data) {
                    return new Date(data).toLocaleString();
                }
            },
            { data: 'chatbot_id', render: function(data, type, row) {
                return `<button class="btn btn-sm btn-primary details" data-chatbotid=${data}>
                               <i class="fas fa-info"></i> Details
                           </button>`;
            }}
        ]
    });

    $('#trackersTable').on('click', '.details', function(){
     let chatbot_id = $(this).data('chatbotid');
     console.log(chatbot_id);

     $('#detailsContent').html('Loading...');
        $.ajax({
            url: "{{ route('tracker.trackerDetails', ['id' => ':id']) }}".replace(':id', chatbot_id),
            method: 'GET',
            success: function(response) {
                $('.modal-title').html(`
                    "${response.chatbot.name}" Chatbot Details
                `);

                $('#detailsContent').html(response.html);
                $('#detailsModal').modal('show');

                if (response.trackers.length > 5) {
                    $('.table-responsive').css('max-height', '400px').addClass('scrollable-table');
                }
            },
            error: function() {
                $('#detailsContent').html(`
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger mb-3"></i>
                        <h5 class="text-danger">Failed to load details</h5>
                    </div>
                `);
            }
        });
    })
     
});
</script>
@endsection