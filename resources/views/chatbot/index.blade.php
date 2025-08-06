@extends('default')
@section('pageTitle', 'Chatbot')
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
 .img-box{
  width:80px;
  height:80px;
  border:3px solid #fff;
  border-radius:50%;
  overflow:hidden;
  margin-top:-65px;
 }
 .img-box img{
  width: 100%;
  height:100%;
 }
 .bg-gredient{
  background: linear-gradient(135deg, rgb(102, 126, 234) 0%, rgb(118, 75, 162) 100%);
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
    <!-- Model Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">24</h3>
                    <p class="stat-label">Active Models</p>
                    <span class="stat-change positive">+3 this month</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">18</h3>
                    <p class="stat-label">Running</p>
                    <span class="stat-change positive">+2 today</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-pause-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">4</h3>
                    <p class="stat-label">Paused</p>
                    <span class="stat-change neutral">No change</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">2</h3>
                    <p class="stat-label">Issues</p>
                    <span class="stat-change negative">+1 today</span>
                </div>
            </div>
        </div>
    </div>

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
                                        <img src="{{ $bot->chatbot_photo }}" alt="Chatbot Image" />
                                    </div>
                                </div>
                                <h5 class="model-name mt-3 text-center">{{ $bot->name }}</h5>
                                <p class="model-description text-center">
                                    {{ ucfirst(str_replace('-', ' ', $bot->type)) }} Chatbot
                                </p>
                                <div class="model-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">Usage</span>
                                        <span class="stat-value">--</span> <!-- Optional: dynamic usage stats -->
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Response Time</span>
                                        <span class="stat-value">--</span> <!-- Optional: response stats -->
                                    </div>
                                </div>
                            </div>
                            <div class="model-actions justify-content-center">
                                <button class="btn btn-sm btn-outline-primary p-2" onclick="configureModel('{{ $bot->id }}')">
                                    <i class="fas fa-edit"></i> Edit &nbsp;
                                </button>
                                <button class="btn btn-sm btn-outline-success p-2">
                                    <i class="fas fa-play"></i> Test &nbsp;
                                </button>
                                <button class="btn btn-sm btn-outline-danger p-2" onclick="deleteModel('{{ $bot->id }}')">
                                    <i class="fas fa-trash"></i> Delete &nbsp;
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


            <!-- Error Model -->
            <!-- <div class="col-lg-4 col-md-6 model-item" data-category="text">
                <div class="model-card error">
                    <div class="model-header">
                        <div class="model-icon bg-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="model-status">
                            <span class="status-badge error">Error</span>
                        </div>
                    </div>
                    <div class="model-body">
                        <h5 class="model-name">Legacy GPT-3</h5>
                        <p class="model-description">Older generation language model with basic text capabilities.</p>
                        <div class="model-stats">
                            <div class="stat-item">
                                <span class="stat-label">Last Used</span>
                                <span class="stat-value">2 days ago</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Error</span>
                                <span class="stat-value text-danger">API Timeout</span>
                            </div>
                        </div>
                        <div class="model-tags">
                            <span class="tag">Legacy</span>
                            <span class="tag">Deprecated</span>
                        </div>
                    </div>
                    <div class="model-actions">
                        <button class="btn btn-sm btn-outline-warning" onclick="restartModel('legacy-gpt3')">
                            <i class="fas fa-redo"></i> Restart
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="viewLogs('legacy-gpt3')">
                            <i class="fas fa-file-alt"></i> Logs
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-info"></i> Details</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-wrench"></i> Troubleshoot</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
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
                            <div class="card-body text-center">
                                <div class="profile-avatar mb-3">
                                    <img width="100" src="{{ asset('assets/images/user-avatar.jpg') }}" alt="Profile" class="rounded-circle" id="profileImage">
                                    <button type="button" class="btn btn-sm btn-primary avatar-edit" onclick="document.getElementById('imageUpload').click()">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                    <input type="file" name="chatbot_photo" id="imageUpload" accept="image/*" style="display: none;" required>
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

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
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

     const $businessSelect = $('#businessTypeselect');
     
     // Initialize Select2 with proper configuration
     $businessSelect.select2({
         placeholder: "Select Business Type",
         width: '100%',
         dropdownParent: $('#addModelModal'),
         allowClear: true,
         dropdownAutoWidth: true,
         closeOnSelect: true
     });

     // Handle custom option selection
     $businessSelect.on('select2:select', function(e) {
         // Check if "Other (Specify)..." was selected
         if (e.params.data.id === 'custom') {
             // Reset the selection
             $businessSelect.val(null).trigger('change');
             
             // Show custom input modal
             $('#customBusinessModal').modal('show');
             
             // Clear any previous input and focus
             $('#customBusinessInput').val('').focus();
         }
     });

     // Save custom business type
     $('#saveCustomBusiness').click(function() {
         const customValue = $('#customBusinessInput').val().trim();
         
         if (customValue) {
             // Create new option (both value and text same)
             const newOption = new Option(customValue, customValue, true, true);
             
             // Add it before the "Other (Specify)..." option
             $businessSelect.find('option[value="custom"]').before(newOption);
             $businessSelect.trigger('change');
             
             // Select the new option
             $businessSelect.val(customValue).trigger('change');
             
             // Close modal
             $('#customBusinessModal').modal('hide');
         } else {
             // Show validation error
             $('#customBusinessInput').addClass('is-invalid');
         }
     });

     // Clear validation when typing
     $('#customBusinessInput').on('input', function() {
         $(this).removeClass('is-invalid');
     });
     // var val = $businessSelect.val();
     // $('#businessTypeselect').on('change', function(e){
     //  const selectedValue = $('#businessTypeselect').val();
     //  console.log(selectedValue, 'jsldjflkdjflkdj');
     // })
 });
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