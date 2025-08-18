@extends('default')
@section('pageTitle', 'Chatbot')
@section('style')
<link href="{{ asset('assets/chatbot/smartbuddy.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/chatbot/smartbuddy.min.js') }}"></script>
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
 .img-box{
  width:80px;
  height:80px;
  border:3px solid #fff;
  border-radius:50%;
  overflow:hidden;
  margin-top:-65px;
  background-color:#fff;
  border:3px solid #7259b5;
 }
 .img-box img{
  width: 100%;
  height:100%;
 }

 .fix-height{
  height:70px;
 }
 .select2-container--default .select2-results__option {
    padding: 10px 12px !important;  /* Increased from default 6px */
    line-height: 1.5 !important;
}
/* Larger scrollbar for better UX */
.select2-results__options::-webkit-scrollbar {
    width: 10px !important;
}
 .select2-selection--single{
  padding:5px;
  height:50px !important;
  border: 1px solid rgb(var(--border)) !important;
  border-radius: var(--border-radius-sm) !important;
 }
 .select2-selection__arrow {
  top:10px !important;
 }
 .select2-selection__rendered{
  padding-top:3px !important;
 }
 .select2-container--open {
    z-index: 1060 !important; /* Ensure dropdown appears above modals */
}

#customBusinessModal .modal-content {
    border: 2px solid var(--primary);
    box-shadow: 0 0 15px rgba(0, 123, 255, 0.2);
}

#customBusinessModal .invalid-feedback {
    display: none;
}

#customBusinessModal .is-invalid ~ .invalid-feedback {
    display: block;
}

/* Custom scrollbar for modal */
.modal-dialog-scrollable .modal-body::-webkit-scrollbar {
    width: 10px;
}

.modal-dialog-scrollable .modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.modal-dialog-scrollable .modal-body::-webkit-scrollbar-thumb {
    background: var(--primary); /* Uses your primary color variable */
    border-radius: 10px;
    border: 2px solid #f1f1f1;
}

.modal-dialog-scrollable .modal-body::-webkit-scrollbar-thumb:hover {
    background: #555; /* Darker shade on hover */
}

/* For Firefox */
.modal-dialog-scrollable .modal-body {
    scrollbar-width: thin;
    scrollbar-color: var(--primary) #f1f1f1;
}
.border-img{
    border:1px solid var(--bs-gray-500);
    border-radius:10px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('pageAction')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModelModal">
    <i class="fas fa-plus"></i> Add Chatbot
</button>
@endsection
@section('content')
<div class="content">
    <!-- Models Grid -->
    <div class="models-container" id="modelsContainer">
        <div class="row g-4  justify-content-center">
            <!-- ChatBot Item -->
            <div class="row g-4 justify-content-center">
                @forelse($chatbots as $bot)
                    <div class="col-lg-4 col-md-6 model-item" data-category="text">
                        <div class="model-card">
                            <div class="model-header fix-height bg-gredient"></div>
                            <div class="model-body">
                                <div class="w-100 d-flex justify-content-center">
                                    <div class="img-box">
                                        <img src="{{ $bot->chatbot_photo ?? asset('assets/images/favicon.png') }}" alt="Chatbot Image" />
                                    </div>
                                </div>
                                <h5 class="model-name mt-3 text-center">{{ $bot->name }}</h5>
                                <p class="model-description text-center">
                                    {{ ucfirst(str_replace('-', ' ', $bot->type)) }} Chatbot
                                </p>
                                <div class="model-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">Usage</span>
                                        <span class="stat-value">{{ $bot->logs_count ?? 0 }}</span> <!-- Optional: dynamic usage stats -->
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Response Time</span>
                                        <span class="stat-value">
                                             {{ $bot->logs_avg_response_time 
                                                ? round($bot->logs_avg_response_time) . ' ms' 
                                                : '--' }}
                                        </span> <!-- Optional: response stats -->
                                    </div>
                                </div>
                            </div>
                            <div class="model-actions justify-content-center">
                                <button class="btn btn-sm btn-outline-primary p-2" onclick="editModel('{{ $bot->id }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="{{ route('chatbot.configure', $bot->id) }}" class="btn btn-sm btn-outline-success p-2">
                                    <i class="fas fa-cog"></i> Configure
                                </a>
                                <button class="btn btn-sm btn-outline-danger p-2 delete" data-bsid="{{ $bot->id }}" data-bsname="{{ $bot->name }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No chatbots found. Create one now!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<!-- Add Model Modal -->
<div class="modal fade" id="addModelModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New ChatBot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addModelForm" method="POST" action="{{ route('chatbot.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- Avatar Upload -->
                        <div class="col-md-6">
                            <div class="card-body text-center border-img pt-4">
                                <div class="profile-avatar mb-3">
                                    <img width="100" src="{{ asset('assets/images/favicon.png') }}" alt="Profile" class="rounded-circle" id="profileImage">
                                    <button type="button" class="btn btn-sm btn-primary bg-gredient avatar-edit" onclick="document.getElementById('imageUpload').click()">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                    <input type="file" name="chatbot_photo" id="imageUpload" accept="image/*" style="display: none;">
                                </div>
                                <p class="text-muted">Upload a Chatbot image. JPG or PNG only.</p>
                            </div>
                        </div>

                        <!-- Chatbot Name and Type -->
                        <div class="col-md-6">
                            <label for="modelName" class="form-label">Chatbot Name</label>
                            <input type="text" name="name" class="form-control" id="modelName" required>

                            <label for="modelType" class="form-label mt-3">Chatbot Type</label>
                            <select name="type" class="form-control" id="businessTypeselect" required>
                                <option value="">Select Business Type</option>

                                <!-- Education -->
                                <optgroup label="Education">
                                    <option value="school">School</option>
                                    <option value="college">College/University</option>
                                    <option value="online-learning">Online Learning Platform</option>
                                    <option value="tutoring">Tutoring Service</option>
                                </optgroup>

                                <!-- Healthcare -->
                                <optgroup label="Healthcare">
                                    <option value="hospital">Hospital/Clinic</option>
                                    <option value="telemedicine">Telemedicine</option>
                                    <option value="mental-health">Mental Health App</option>
                                    <option value="pharmacy">Pharmacy</option>
                                </optgroup>

                                <!-- E-Commerce & Retail -->
                                <optgroup label="E-Commerce & Retail">
                                    <option value="ecommerce">Online Store</option>
                                    <option value="fashion">Fashion Brand</option>
                                    <option value="electronics">Electronics Retailer</option>
                                    <option value="local-shop">Local Shop</option>
                                </optgroup>

                                <!-- Finance -->
                                <optgroup label="Finance">
                                    <option value="bank">Bank</option>
                                    <option value="fintech">FinTech App</option>
                                    <option value="insurance">Insurance Company</option>
                                </optgroup>

                                <!-- Others -->
                                <optgroup label="Others">
                                    <option value="hospitality">Hospitality & Travel</option>
                                    <option value="real-estate">Real Estate</option>
                                    <option value="legal">Legal Services</option>
                                    <option value="tech">Tech/SaaS</option>
                                    <option value="entertainment">Entertainment & Media</option>
                                    <option value="government">Government Services</option>
                                    <option value="custom">Other (Specify)...</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- File Upload -->
                        <div class="col-md-12">
                            <label for="modelfile" class="form-label">Reply From</label>
                            <input type="file" class="form-control" name="reply_file" id="modelfile" accept=".pdf,.doc,.docx" required>
                            <p class="text-muted">Upload a document the chatbot will respond from. PDF or DOCX only.</p>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addModelForm" class="btn btn-primary" id="submitBtn">
                 <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="spinner"></span>
                 <span id="submitText">Add Chatbot</span>
                </button>
                
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Model Modal -->
<div class="modal fade" id="editModelModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit ChatBot</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editModelForm" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" id="editBotId">

          <div class="row g-3">
            <!-- Avatar -->
            <div class="col-md-12">
              <div class="card-body text-center">
                <div class="profile-avatar">
                  <img width="100" src="{{ asset('assets/images/favicon.png') }}" alt="Profile" class="rounded-circle" id="editProfileImage">
                  <button type="button" class="btn btn-sm btn-primary bg-gredient avatar-edit" onclick="document.getElementById('editImageUpload').click()">
                    <i class="fas fa-camera"></i>
                  </button>
                  <input type="file" name="chatbot_photo" id="editImageUpload" accept="image/*" style="display: none;">
                </div>
                <p class="text-muted">Upload new image (optional).</p>
              </div>
            </div>

            <!-- Name -->
            <div class="col-md-12">
             <label for="editModelName" class="form-label">Chatbot Name</label>
             <input type="text" name="name" class="form-control" id="editModelName" required>
            </div>
            <!-- Type -->
            <div class="col-md-12">
              <label for="editBusinessTypeSelect" class="form-label mt-3">Chatbot Type</label>
              <select name="type" class="form-control" id="editBusinessTypeSelect" required>
                <option value="">Select Business Type</option>
                <optgroup label="Education">
                  <option value="school">School</option>
                  <option value="college">College</option>
                  <option value="online-learning">Online Learning</option>
                  <option value="tutoring">Tutoring</option>
                </optgroup>
                <optgroup label="Healthcare">
                  <option value="hospital">Hospital</option>
                  <option value="telemedicine">Telemedicine</option>
                  <option value="mental-health">Mental Health</option>
                  <option value="pharmacy">Pharmacy</option>
                </optgroup>
                <optgroup label="E-Commerce & Retail">
                  <option value="ecommerce">Online Store</option>
                  <option value="fashion">Fashion Brand</option>
                  <option value="electronics">Electronics</option>
                  <option value="local-shop">Local Shop</option>
                </optgroup>
                <optgroup label="Finance">
                  <option value="bank">Bank</option>
                  <option value="fintech">FinTech App</option>
                  <option value="insurance">Insurance</option>
                </optgroup>
                <optgroup label="Others">
                  <option value="hospitality">Hospitality</option>
                  <option value="real-estate">Real Estate</option>
                  <option value="legal">Legal</option>
                  <option value="tech">Tech/SaaS</option>
                  <option value="entertainment">Entertainment</option>
                  <option value="government">Government</option>
                  <option value="custom">Other</option>
                </optgroup>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="editModelForm" class="btn btn-primary" id="editSubmitBtn">
          <span class="spinner-border spinner-border-sm me-2 d-none" id="editSpinner"></span>
          <span id="editSubmitText">Update Chatbot</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Custom Business Modal -->
<div class="modal fade" id="customBusinessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gredient text-white">
                <h5 class="modal-title">Add Custom Business Type</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
             
                <div class="mb-3">
                    <label class="form-label">Enter your business type:</label>
                    <input type="text" id="customBusinessInput" class="form-control" 
                           placeholder="e.g., Solar Energy Consulting" autofocus>
                    <div class="invalid-feedback">Please enter a business type</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" id="saveCustomBusiness" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title delConf">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this chatbot?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
let previousEditModelName = '';

jQuery(document).ready(function($) {
    const form = document.querySelector('#addModelForm');
    const submitBtn = document.querySelector('#submitBtn');
    const spinner = document.querySelector('#spinner');
    const submitText = document.querySelector('#submitText');

    if (form) {
        form.addEventListener('submit', function () {
            spinner.classList.remove('d-none');
            submitText.textContent = 'Submitting...';
            submitBtn.setAttribute('disabled', true);
        });
    }

    // ADD form select2
    const $businessSelect = $('#businessTypeselect');
    $businessSelect.select2({
        placeholder: "Select Business Type",
        width: '100%',
        dropdownParent: $('#addModelModal'),
        allowClear: true,
        dropdownAutoWidth: true,
        closeOnSelect: true
    });

    $businessSelect.on('select2:select', function(e) {
        if (e.params.data.id === 'custom') {
            $businessSelect.val(null).trigger('change');
            $('#customBusinessModal').modal('show');
            $('#customBusinessInput').val('').focus();
        }
    });

    // EDIT form select2
    const $editBusinessSelect = $('#editBusinessTypeSelect');
    $editBusinessSelect.select2({
        placeholder: "Select Business Type",
        width: '100%',
        dropdownParent: $('#editModelModal'),
        allowClear: true,
        dropdownAutoWidth: true,
        closeOnSelect: true
    });

    $editBusinessSelect.on('select2:select', function(e) {
        if (e.params.data.id === 'custom') {
            previousEditModelName = $('#editModelName').val();
            $editBusinessSelect.val(null).trigger('change');
            $('#customBusinessModal').modal('show');
            $('#customBusinessInput').val('').focus();
        }
    });

    $('#saveCustomBusiness').click(function() {
        const customValue = $('#customBusinessInput').val().trim();
        if (customValue) {
            const newOption = new Option(customValue, customValue, true, true);

            if ($('#addModelModal').hasClass('show')) {
                $businessSelect.find('option[value="custom"]').before(newOption);
                $businessSelect.append(newOption).trigger('change');
                $businessSelect.val(customValue).trigger('change');
            }

            if ($('#editModelModal').hasClass('show')) {
                $editBusinessSelect.find('option[value="custom"]').before(newOption);
                $editBusinessSelect.append(newOption).trigger('change');
                $editBusinessSelect.val(customValue).trigger('change');
                $('#editModelName').val(previousEditModelName);
            }

            $('#customBusinessModal').modal('hide');
        } else {
            $('#customBusinessInput').addClass('is-invalid');
        }
    });

    $('#customBusinessInput').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});

// DELETE
$('.delete').on('click', function() {
    var botname = $(this).data('bsname');
    var botId = $(this).data('bsid');
    $('.delConf').text("Delete " + botname)
    const url = `/chatbot/${botId}`;
    document.getElementById('deleteForm').setAttribute('action', url);
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
});

// EDIT
function editModel(botId) {
    fetch(`/chatbot/${botId}/edit`)
        .then(res => res.json())
        .then(data => {
            // Set values
            document.getElementById('editModelName').value = data.name;
            document.getElementById('editBotId').value = botId;

            const profileImg = data.chatbot_photo ?? "{{ asset('assets/images/favicon.png') }}";
            document.getElementById('editProfileImage').src = profileImg;

            // Handle select2 pre-fill
            const $editBusinessSelect = $('#editBusinessTypeSelect');
            if ($editBusinessSelect.find(`option[value="${data.type}"]`).length === 0 && data.type) {
                const newOption = new Option(data.type, data.type, true, true);
                $editBusinessSelect.append(newOption).trigger('change');
            } else {
                $editBusinessSelect.val(data.type).trigger('change');
            }

            // Set form action
            const form = document.getElementById('editModelForm');
            form.action = `/chatbot/${botId}`;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editModelModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Failed to fetch bot data:', error);
            alert("Failed to load chatbot data.");
        });
}
</script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // Toast Notification if session success exists
    @if(session('success'))
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
    @endif
});
</script>
@endif
@endsection