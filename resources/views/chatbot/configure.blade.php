@extends('default')
@section('pageTitle', $chatbot->name . ' Configure')
@section('pageAction')

@endsection
@section('style')
<style>
 .notification-toast {
    position: fixed;
    top: 5rem;
    right: 20px;
    z-index: 9999;
    min-width: 250px;
    max-width: 350px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    opacity: 1;
    transition: opacity 0.5s ease;
}

</style>
@endsection
@section('content')
<!-- Configure -->
<div class="content">
    <div class="row g-4">
        <!-- Settings Navigation -->
        <div class="col-lg-3">
            <div class="dashboard-card">
                <div class="card-body">
                    <nav class="settings-nav">
                        <a href="#api" class="settings-nav-item active" data-tab="api">
                            <i class="fas fa-key"></i>
                            <span>Access Token</span>
                        </a>
                        <a href="#notifications" class="settings-nav-item" data-tab="notifications">
                            <i class="fas fa-image"></i>
                            <span>Preferences</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="col-lg-9">
          <!-- API Keys Settings -->
          <div class="settings-tab active" id="api">
              <div class="dashboard-card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="card-title">API Key</h5>
                      @if(empty($chatbot->api) || empty($chatbot->api->access_token))
                          <button id="generate-btn-{{ $chatbot->id }}" class="btn btn-sm btn-primary" onclick="generateToken({{ $chatbot->id }}, this)">
                              <i class="fas fa-plus"></i> <span class="btn-text">Generate New Key</span>
                          </button>
                      @endif
                  </div>
                  <div class="card-body">
                      <div class="api-key-list" id="api-key-list-{{ $chatbot->id }}">
                          @if($chatbot->api && $chatbot->api->access_token)
                              <div class="api-key-item">
                                  <div class="api-key-info">
                                      <strong>Access Token</strong>
                                      <small class="text-muted d-block">Created on {{ \Carbon\Carbon::parse($chatbot->created_at)->format('M d, Y') }}</small>
                                      <code id="token-box-{{ $chatbot->id }}" class="api-key-value">{{ $chatbot->api->access_token }}</code>
                                  </div>
                                  <div class="api-key-actions">
                                      <button class="btn btn-sm btn-outline-secondary copy-token-btn" data-id="{{ $chatbot->id }}">Copy</button>
                                      <button class="btn btn-sm btn-outline-success" onclick="generateToken({{ $chatbot->id }}, this)">Re-generate</button>
                                  </div>
                              </div>
                          @endif
                      </div>

                      <div class="alert alert-info mt-4">
                          <i class="fas fa-info-circle"></i>
                          <strong>Important:</strong> Keep your API keys secure and never share them publicly.
                      </div>
                  </div>
              </div>
          </div>
          <!-- Notifications Settings -->
          <div class="settings-tab" id="notifications">
              <div class="dashboard-card">
                  <div class="card-header">
                      <h5 class="card-title">Preferences</h5>
                  </div>
                  <div class="card-body">
                      <!-- <div class="notification-section">
                          <h6>Email Notifications</h6>
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="emailNews" checked>
                              <label class="form-check-label" for="emailNews">
                                  Newsletter and updates
                              </label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="emailSecurity" checked>
                              <label class="form-check-label" for="emailSecurity">
                                  Security alerts
                              </label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="emailBilling">
                              <label class="form-check-label" for="emailBilling">
                                  Billing notifications
                              </label>
                          </div>
                      </div>
                      
                      <div class="notification-section mt-4">
                          <h6>Push Notifications</h6>
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="pushTasks" checked>
                              <label class="form-check-label" for="pushTasks">
                                  AI task completions
                              </label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="pushErrors">
                              <label class="form-check-label" for="pushErrors">
                                  Error notifications
                              </label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="pushUsage">
                              <label class="form-check-label" for="pushUsage">
                                  Usage limit warnings
                              </label>
                          </div>
                      </div>
                      
                      <div class="mt-4">
                          <button type="submit" class="btn btn-primary">Save Preferences</button>
                      </div> -->
                      <!-- resources/views/chatbot/customize.blade.php -->
                       <form action="{{ route('chatbot.customize') }}" method="POST">
                         @csrf

                         <!-- Hidden field for chatbot ID -->
                         <input type="hidden" name="chatbot_id" value="{{ $chatbot->id }}">

                         <div class="form-group">
                             <label>Primary Color</label>
                             <input type="color" name="primary_color" value="#0673f1" required>
                         </div>

                         <div class="form-group">
                             <label>User Message Bubble Color</label>
                             <input type="color" name="user_bubble" value="#DCF8C6" required>
                         </div>

                         <div class="form-group">
                             <label>Bot Message Bubble Color</label>
                             <input type="color" name="bot_bubble" value="#F1F0F0" required>
                         </div>

                         <div class="form-group">
                             <label>Position X (Horizontal)</label>
                             <select name="position_x" class="form-control" required>
                                 <option value="left">Left</option>
                                 <option value="right" selected>Right</option>
                             </select>
                         </div>

                         <div class="form-group">
                             <label>Position Y (Vertical)</label>
                             <select name="position_y" class="form-control" required>
                                 <option value="bottom" selected>Bottom</option>
                                 <option value="top">Top</option>
                             </select>
                         </div>

                         <div class="form-group">
                             <label>Offset X (px)</label>
                             <input type="number" name="offset_x" value="20" class="form-control" required>
                         </div>

                         <div class="form-group">
                             <label>Offset Y (px)</label>
                             <input type="number" name="offset_y" value="20" class="form-control" required>
                         </div>

                         <button type="submit" class="btn btn-primary mt-3">Generate & Download</button>

                       </form>

                  </div>
              </div>
          </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
function generateToken(chatbotId, btn) {
   const $btn = $(btn);
   const $text = $btn.find('.btn-text');

   // Show loader
   $btn.prop('disabled', true);
   $text.html(`<i class="fas fa-spinner fa-spin"></i> Generating...`);

   $.ajax({
       url: `/chatbot/${chatbotId}/generate-token`,
       method: 'POST',
       headers: {
           'X-CSRF-TOKEN': '{{ csrf_token() }}',
       },
       success: function (data) {
           // Format date
           const createdDate = new Date().toLocaleDateString('en-US', {
               year: 'numeric', month: 'short', day: 'numeric'
           });

           // Replace API key section
           const keyHtml = `
               <div class="api-key-item">
                   <div class="api-key-info">
                       <strong>Production Key</strong>
                       <small class="text-muted d-block">Created on ${createdDate}</small>
                       <code id="token-box-${chatbotId}" class="api-key-value">${data.access_token}</code>
                   </div>
                   <div class="api-key-actions">
                       <button class="btn btn-sm btn-outline-secondary copy-token-btn" data-id="${chatbotId}">Copy</button>
                       <button class="btn btn-sm btn-outline-success" onclick="generateToken(${chatbotId}, this)">Re-generate</button>
                   </div>
               </div>`;

           $(`#api-key-list-${chatbotId}`).html(keyHtml);

           // Hide Generate button (if exists)
           $(`#generate-btn-${chatbotId}`).remove();

           showToast('API Key generated successfully', 'success');
       },
       error: function () {
           showToast('Failed to generate API key', 'error');
       },
       complete: function () {
           $btn.prop('disabled', false);
           $text.html('Generate New Key');
       }
   });
}

// ✅ Toast Notification
function showToast(message, type = 'success') {
   const icon = {
       success: 'check-circle',
       error: 'times-circle',
       warning: 'exclamation-circle',
       info: 'info-circle'
   }[type];

   const toast = $(`
       <div class="alert alert-${type} notification-toast">
           <div class="d-flex align-items-center">
               <i class="fas fa-${icon} me-2"></i>
               <span>${message}</span>
               <button type="button" class="btn-close ms-auto" onclick="$(this).closest('.notification-toast').remove()"></button>
           </div>
       </div>
   `);

   $('body').append(toast);

   setTimeout(() => {
       toast.fadeOut(400, () => toast.remove());
   }, 4000);
}

// 📋 Copy to clipboard
$(document).on('click', '.copy-token-btn', function () {
   const chatbotId = $(this).data('id');
   const tokenText = $(`#token-box-${chatbotId}`).text().trim();

   const $temp = $('<textarea>');
   $('body').append($temp);
   $temp.val(tokenText).select();
   document.execCommand('copy');
   $temp.remove();

   showToast('Copied to clipboard', 'info');
});
</script>
@endsection
