@extends('default')
@section('pageTitle', 'Create New Blog')
@section('style')
<style>
  .notification-toast {
   position: fixed;
   bottom: 20px;
   left: 50%;
   transform: translateX(-50%);
   z-index: 9999;
   min-width: 250px;
   max-width: 350px;
   box-shadow: 0 2px 10px rgba(0,0,0,0.1);
   opacity: 1;
}
</style>
@endsection
@section('pageAction')
<a href="{{route('admin.blogs.index')}}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Back to Blogs
</a>
@endsection
@section('content')
<div class="content">
    <div class="row h-100">
        <div class="col-lg-12">
            <div class="dashboard-card h-100">
                <div class="card-header d-flex align-items-center">
                    <div class="template-icon me-3">
                        <i class="fas fa-blog fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Create Blog</h4>
                        <p class="mb-0 text-muted">Fill in the details below to publish a blog post</p>
                    </div>
                </div>

                <!-- Form Area -->
                <div class="card-body">
                    <form id="blogFormCreate" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label fw-bold">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter blog title">
                            </div>

                            <!-- Slug -->
                            <div class="col-md-12 mb-3">
                                <label for="slug" class="form-label fw-bold">Slug (SEO URL)</label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="auto-generated or enter manually">
                                <div class="form-text">Example: my-first-blog</div>
                            </div>

                            <!-- Author -->
                            <div class="col-md-12 mb-3">
                                <label for="author" class="form-label fw-bold">Author</label>
                                <input type="text" class="form-control" id="author" name="author" placeholder="Author name">
                            </div>

                            <!-- Content -->
                            <div class="col-md-12 mb-3">
                                <label for="content" class="form-label fw-bold">Content</label>
                                <textarea name="content" id="content" class="form-control textarea-resize-vertical" rows="6" placeholder="Write your blog content..."></textarea>
                            </div>

                            <!-- Image -->
                            <div class="col-md-12 mb-3">
                                <label for="image" class="form-label fw-bold">Featured Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>

                            <!-- SEO Fields -->
                            <div class="col-md-12">
                                <h5 class="fw-bold mt-4">SEO Settings</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="meta_title" class="form-label fw-bold">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="SEO title for the blog">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="meta_keywords" class="form-label fw-bold">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="e.g. laravel, blog, seo">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Short SEO description..."></textarea><br/>
                                <div class="form-check">
                                    <input class="form-check-input" name="status" value="1" type="checkbox" id="includeBulletPoints" checked>
                                    <label class="form-check-label" for="includeBulletPoints">
                                        Status
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <small><i class="fas fa-info-circle"></i> Please review before publishing</small>
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-lg">
                                <span class="btn-text"><i class="fas fa-save"></i> Save Blog</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script>
// Declare editorInstance at the top level scope
let editorInstance = null;

// Initialize CKEditor and assign to editorInstance
ClassicEditor
   .create(document.querySelector('#content'), {
       ckfinder: {
           uploadUrl: "{{ route('blogs.upload.image') }}?_token={{ csrf_token() }}"
       }
   })
   .then(editor => {
       editorInstance = editor; // Assign the editor instance
       console.log("CKEditor initialized");
   })
   .catch(error => console.error(error));
</script>

<script>
$(document).ready(function () {
     document.getElementById('includeBulletPoints').addEventListener('change', function() {
         this.value = this.checked ? "true" : "false";
     });
     
     function showNotification(message, type = 'success') {
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

         setTimeout(() => {
             notification.style.opacity = '0';
             setTimeout(() => notification.remove(), 500);
         }, 5000);
     }

     function getNotificationIcon(type) {
         switch (type) {
             case 'success': return 'check-circle';
             case 'error': return 'times-circle';
             case 'warning': return 'exclamation-circle';
             default: return 'info-circle';
         }
     }

    $('#blogFormCreate').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let submitBtn = $('#submitBtn');
        let btnText = submitBtn.find('.btn-text');
        let spinner = submitBtn.find('.spinner-border');

        // Show loader
        btnText.addClass('d-none');
        spinner.removeClass('d-none');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.blog.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    
                    // Reset form safely
                    const form = document.getElementById("blogFormCreate");
                    if (form) {
                        form.reset();
                    }
                    
                    // Clear editor safely
                    if (editorInstance) {
                        editorInstance.setData('');
                    } else {
                        console.warn('Editor instance not available');
                        // Fallback: try to clear the content area directly
                        const contentArea = document.querySelector('#content');
                        if (contentArea) {
                            contentArea.innerHTML = '';
                        }
                    }
                    
                    // window.location.href = "{{ route('admin.blogs.index') }}";
                } else {
                    showNotification('Something went wrong', 'error');
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        showNotification(value[0], 'error');
                    });
                } else {
                    showNotification("An error occurred!", 'error');
                }
            },
            complete: function () {
                // Reset loader
                btnText.removeClass('d-none');
                spinner.addClass('d-none');
                submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>

@endsection
