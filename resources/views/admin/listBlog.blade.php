@extends('default')
@section('pageTitle', 'Blogs')
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
            <table id="blogTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Blog Image</th>
                        <th>Blog Name</th>
                        <th>Created on</th>
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

<!-- edit blog modal -->
<div class="modal fade" id="editBlogModal" tabindex="-1" aria-labelledby="editBlogLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editBlogLabel">Edit Blog</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="blogFormEdit" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <input type="hidden" id="editBlogId" name="id">

          <div class="row">
              <!-- Title -->
              <div class="col-md-12 mb-3">
                  <label class="form-label fw-bold">Title</label>
                  <input type="text" class="form-control" id="edit_title" name="title">
              </div>

              <!-- Slug -->
              <div class="col-md-4 mb-3">
                  <label class="form-label fw-bold">Slug</label>
                  <input type="text" class="form-control" id="edit_slug" name="slug">
              </div>

              <!-- Author -->
              <div class="col-md-4 mb-3">
                  <label class="form-label fw-bold">Author</label>
                  <input type="text" class="form-control" id="edit_author" name="author">
              </div>

              
              <div class="col-md-4 mb-3">
                  <label class="form-label fw-bold">Meta Keywords</label>
                  <input type="text" class="form-control" id="edit_meta_keywords" name="meta_keywords">
              </div>

              <!-- Image -->
              <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Featured Image</label>
                  <input type="file" class="form-control" id="edit_image" name="image">
                  <div class="mt-2">
                    <img id="preview_image" src="" style="max-height:120px;border-radius:6px;">
                  </div>
              </div>

              <!-- SEO -->
              <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Meta Title</label>
                  <input type="text" class="form-control" id="edit_meta_title" name="meta_title">

                  <label class="form-label fw-bold">Meta Description</label>
                  <textarea class="form-control" id="edit_meta_description" name="meta_description" rows="3"></textarea>
                  <br/>
                  <div class="form-check">
                      <input class="form-check-input" name="status" value="1" type="checkbox" id="edit_status">
                      <label class="form-check-label" for="edit_status">Status</label>
                  </div>
              </div>


              <!-- Content -->
              <div class="col-md-12 mb-3">
                  <label class="form-label fw-bold">Content</label>
                  <textarea name="content" id="edit_content" class="form-control" rows="6"></textarea>
              </div>

              
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="updateBlogBtn" class="btn btn-primary">
          <span class="btn-text"><i class="fas fa-save"></i> Update Blog</span>
          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- delete blog modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteLabel">Confirm Blog Deletion</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="deleteMsg">Are you sure you want to delete this blog?</p>
        <input type="hidden" id="deleteBlogId">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-outline-danger">
          Confirm Delete
        </button>
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
document.addEventListener('DOMContentLoaded', function() {
    let table = $('#blogTable').DataTable({
        processing: true,
        ajax: "{{ route('getBlogs') }}", // must return {"data": [...]} JSON
        columns: [
            { data: null }, // Serial number
            { data: 'image',
              render: function(data) {
                  let img = data ? data : '/default-blog.png';
                  return `<img src="${img}" alt="Blog Image" 
                             style="width:60px;height:60px;object-fit:cover;border-radius:6px;">`;
              }
            },
            { data: 'title' },
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
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-primary btn-edit" 
                                    data-id="${row.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" 
                                    data-id="${row.id}" 
                                    data-title="${row.title}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>`;
              }
            }
        ]
    });

    // Serial number counter
    table.on('order.dt search.dt', function() {
        table.column(0, { search:'applied', order:'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $(document).on('click', '.btn-delete', function() {
        let blogId = $(this).data('id');
        let blogTitle = $(this).data('title');
        $('#deleteBlogId').val(blogId);
        $('#deleteMsg').text(`Are you sure you want to delete "${blogTitle}"?`);
        $('#confirmDeleteModal').modal('show');
    });

    // Confirm delete
    $('#confirmDeleteBtn').on('click', function() {
       let blogId = $('#deleteBlogId').val();
       let $btn = $(this);
       // Save original button text
       let originalText = $btn.html();
       // Show loader in button
       $btn.prop('disabled', true).html(`
           <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
           Deleting...
       `);

       $.ajax({
           url: `/admin/blogs/${blogId}`,
           type: 'DELETE',
           data: {
               _token: "{{ csrf_token() }}"
           },
           success: function(response) {
               $('#confirmDeleteModal').modal('hide');
                   table.ajax.reload(null, false); // reload table

                   // Restore button
                   $btn.prop('disabled', false).html(originalText);
               },
               error: function(xhr) {
                   alert("Failed to delete blog.");

                   // Restore button
                   $btn.prop('disabled', false).html(originalText);
               }
       });
    });

   $(document).on('click', '.btn-edit', function() {
    let blogId = $(this).data('id');

    $.ajax({
        url: `/admin/blogs/${blogId}/edit`,
        type: 'GET',
        success: function(blog) {
            // Fill form fields
            $('#editBlogId').val(blog.id);
            $('#edit_title').val(blog.title);
            $('#edit_slug').val(blog.slug);
            $('#edit_author').val(blog.author);
            $('#edit_content').val(blog.content);
            $('#edit_meta_title').val(blog.meta_title);
            $('#edit_meta_keywords').val(blog.meta_keywords);
            $('#edit_meta_description').val(blog.meta_description);
            $('#edit_status').prop('checked', blog.status == 1);

            if (blog.image) {
                $('#preview_image').attr('src', blog.image).show();
            } else {
                $('#preview_image').hide();
            }

            $('#editBlogModal').modal('show');
        },
        error: function(xhr) {
            alert("Failed to fetch blog details.");
        }
    });
});

    // Submit Update
$('#updateBlogBtn').on('click', function() {
    let blogId = $('#editBlogId').val();
    let formData = new FormData($('#blogFormEdit')[0]);

    // Add CKEditor content
    if (editEditorInstance) {
        formData.set('content', editEditorInstance.getData());
    }

    let $btn = $(this);
    let originalText = $btn.html();
    $btn.prop('disabled', true);
    $btn.find('.btn-text').addClass('d-none');
    $btn.find('.spinner-border').removeClass('d-none');

    $.ajax({
        url: `/admin/blogs/${blogId}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-HTTP-Method-Override': 'PUT' },
        success: function(res) {
            $('#editBlogModal').modal('hide');
            table.ajax.reload(null, false);

            $btn.prop('disabled', false).html(originalText);
        },
        error: function(xhr) {
            alert("Failed to update blog.");
            $btn.prop('disabled', false).html(originalText);
        }
    });
});

});

</script>
<!-- CKEditor script -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script>
let editEditorInstance = null;
function initEditEditor() {
    const editContentEl = document.querySelector('#edit_content');
    if (!editContentEl) {
        console.warn("No #edit_content found in modal.");
        return;
    }

    if (editEditorInstance) {
        // Already initialized → reset content if needed
        return;
    }

    ClassicEditor
        .create(editContentEl, {
            ckfinder: {
                uploadUrl: "{{ route('blogs.upload.image') }}?_token={{ csrf_token() }}"
            }
        })
        .then(editor => {
            editEditorInstance = editor;
            console.log("CKEditor (Edit) initialized");
        })
        .catch(error => console.error("CKEditor (Edit) error:", error));
}

$('#editBlogModal').on('shown.bs.modal', function () {
    initEditEditor();
});

$('#editBlogModal').on('hidden.bs.modal', function () {
    if (editEditorInstance) {
        editEditorInstance.destroy()
            .then(() => {
                editEditorInstance = null;
                console.log("CKEditor (Edit) destroyed");
            })
            .catch(err => console.error("CKEditor destroy error:", err));
    }
});
</script>


@endsection
