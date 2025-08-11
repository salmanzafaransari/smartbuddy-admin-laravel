@extends('default')
@section('pageTitle', 'Setting')
@section('pageAction')
<a href="/profile" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Back to Profile
</a>
@endsection
@section('content')
<!-- Settings Content -->
<div class="content">
   <div class="row g-4">
       <!-- Settings Navigation -->
       <div class="col-lg-3">
           <div class="dashboard-card">
               <div class="card-body">
                   <nav class="settings-nav">
                       <a href="#general" class="settings-nav-item active" data-tab="general">
                           <i class="fas fa-cog"></i>
                           <span>General</span>
                       </a>
                       <a href="#notifications" class="settings-nav-item" data-tab="notifications">
                           <i class="fas fa-bell"></i>
                           <span>Notifications</span>
                       </a>
                       <a href="#security" class="settings-nav-item" data-tab="security">
                           <i class="fas fa-shield-alt"></i>
                           <span>Security</span>
                       </a>
                       <a href="#api" class="settings-nav-item" data-tab="api">
                           <i class="fas fa-key"></i>
                           <span>API Keys</span>
                       </a>
                       <a href="#billing" class="settings-nav-item" data-tab="billing">
                           <i class="fas fa-credit-card"></i>
                           <span>Billing</span>
                       </a>
                       <a href="#advanced" class="settings-nav-item" data-tab="advanced">
                           <i class="fas fa-tools"></i>
                           <span>Advanced</span>
                       </a>
                   </nav>
               </div>
           </div>
       </div>
       
       <!-- Settings Content -->
       <div class="col-lg-9">
           <!-- General Settings -->
           <div class="settings-tab active" id="general">
               <div class="dashboard-card">
                   <div class="card-header">
                       <h5 class="card-title">General Settings</h5>
                   </div>
                   <div class="card-body">
                       <form>
                           <div class="row g-3">
                               <div class="col-md-6">
                                   <label for="timezone" class="form-label">Timezone</label>
                                   <select class="form-select" id="timezone">
                                       <option selected>UTC-8 (Pacific Time)</option>
                                       <option>UTC-5 (Eastern Time)</option>
                                       <option>UTC+0 (GMT)</option>
                                       <option>UTC+1 (Central European Time)</option>
                                   </select>
                               </div>
                               <div class="col-md-6">
                                   <label for="language" class="form-label">Language</label>
                                   <select class="form-select" id="language">
                                       <option selected>English</option>
                                       <option>Spanish</option>
                                       <option>French</option>
                                       <option>German</option>
                                   </select>
                               </div>
                               <div class="col-md-6">
                                   <label for="dateFormat" class="form-label">Date Format</label>
                                   <select class="form-select" id="dateFormat">
                                       <option selected>MM/DD/YYYY</option>
                                       <option>DD/MM/YYYY</option>
                                       <option>YYYY-MM-DD</option>
                                   </select>
                               </div>
                               <div class="col-md-6">
                                   <label for="theme" class="form-label">Theme</label>
                                   <select class="form-select" id="theme">
                                       <option selected>Light</option>
                                       <option>Dark</option>
                                       <option>Auto</option>
                                   </select>
                               </div>
                           </div>
                           
                           <div class="mt-4">
                               <h6>Dashboard Preferences</h6>
                               <div class="form-check">
                                   <input class="form-check-input" type="checkbox" id="showWelcome" checked>
                                   <label class="form-check-label" for="showWelcome">
                                       Show welcome message on dashboard
                                   </label>
                               </div>
                               <div class="form-check">
                                   <input class="form-check-input" type="checkbox" id="autoRefresh">
                                   <label class="form-check-label" for="autoRefresh">
                                       Auto-refresh dashboard data
                                   </label>
                               </div>
                               <div class="form-check">
                                   <input class="form-check-input" type="checkbox" id="compactMode">
                                   <label class="form-check-label" for="compactMode">
                                       Enable compact view mode
                                   </label>
                               </div>
                           </div>
                           
                           <div class="mt-4">
                               <button type="submit" class="btn btn-primary">Save Changes</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
           
           <!-- Notifications Settings -->
           <div class="settings-tab" id="notifications">
               <div class="dashboard-card">
                   <div class="card-header">
                       <h5 class="card-title">Notification Preferences</h5>
                   </div>
                   <div class="card-body">
                       <div class="notification-section">
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
                       </div>
                   </div>
               </div>
           </div>
           
           <!-- Security Settings -->
           <div class="settings-tab" id="security">
               <div class="dashboard-card">
                   <div class="card-header">
                       <h5 class="card-title">Security Settings</h5>
                   </div>
                   <div class="card-body">
                       <div class="security-section">
                           <h6>Password</h6>
                           <p class="text-muted">Last changed 30 days ago</p>
                           <button class="btn btn-outline-primary">Change Password</button>
                       </div>
                       
                       <div class="security-section mt-4">
                           <h6>Two-Factor Authentication</h6>
                           <div class="d-flex justify-content-between align-items-center">
                               <div>
                                   <p class="mb-1">Add an extra layer of security to your account</p>
                                   <small class="text-muted">Status: <span class="text-danger">Disabled</span></small>
                               </div>
                               <button class="btn btn-primary">Enable 2FA</button>
                           </div>
                       </div>
                       
                       <div class="security-section mt-4">
                           <h6>Active Sessions</h6>
                           <div class="session-list">
                               <div class="session-item">
                                   <div class="session-info">
                                       <strong>Current Session</strong>
                                       <small class="text-muted d-block">Chrome on Windows ??? San Francisco, CA</small>
                                       <small class="text-muted">Last active: Now</small>
                                   </div>
                                   <span class="badge bg-success">Current</span>
                               </div>
                               <div class="session-item">
                                   <div class="session-info">
                                       <strong>Mobile App</strong>
                                       <small class="text-muted d-block">iOS App ??? San Francisco, CA</small>
                                       <small class="text-muted">Last active: 2 hours ago</small>
                                   </div>
                                   <button class="btn btn-sm btn-outline-danger">Revoke</button>
                               </div>
                           </div>
                           <button class="btn btn-outline-danger mt-3">Sign out of all other sessions</button>
                       </div>
                   </div>
               </div>
           </div>
           
           <!-- API Keys Settings -->
           <div class="settings-tab" id="api">
               <div class="dashboard-card">
                   <div class="card-header">
                       <h5 class="card-title">API Keys</h5>
                       <button class="btn btn-primary btn-sm">
                           <i class="fas fa-plus"></i> Generate New Key
                       </button>
                   </div>
                   <div class="card-body">
                       <div class="api-key-list">
                           <div class="api-key-item">
                               <div class="api-key-info">
                                   <strong>Production Key</strong>
                                   <small class="text-muted d-block">Created on Jan 15, 2024</small>
                                   <code class="api-key-value">sk-************************************</code>
                               </div>
                               <div class="api-key-actions">
                                   <button class="btn btn-sm btn-outline-secondary">Copy</button>
                                   <button class="btn btn-sm btn-outline-danger">Revoke</button>
                               </div>
                           </div>
                           <div class="api-key-item">
                               <div class="api-key-info">
                                   <strong>Development Key</strong>
                                   <small class="text-muted d-block">Created on Dec 20, 2023</small>
                                   <code class="api-key-value">sk-************************************</code>
                               </div>
                               <div class="api-key-actions">
                                   <button class="btn btn-sm btn-outline-secondary">Copy</button>
                                   <button class="btn btn-sm btn-outline-danger">Revoke</button>
                               </div>
                           </div>
                       </div>
                       
                       <div class="alert alert-info mt-4">
                           <i class="fas fa-info-circle"></i>
                           <strong>Important:</strong> Keep your API keys secure and never share them publicly. If you suspect a key has been compromised, revoke it immediately.
                       </div>
                   </div>
               </div>
           </div>
           
           <!-- Billing Settings -->
           <div class="settings-tab" id="billing">
               <div class="dashboard-card">
                   <div class="card-header">
                       <h5 class="card-title">Billing & Subscription</h5>
                   </div>
                   <div class="card-body">
                       <div class="current-plan">
                           <h6>Current Plan</h6>
                           <div class="plan-info">
                               <div class="plan-details">
                                   <h4>Premium Pro <span class="badge bg-primary">Current</span></h4>
                                   <p class="text-muted">$29/month ??? Billed monthly</p>
                                   <ul class="plan-features">
                                       <li>Unlimited API calls</li>
                                       <li>Advanced AI models</li>
                                       <li>Priority support</li>
                                       <li>Custom integrations</li>
                                   </ul>
                               </div>
                               <div class="plan-actions">
                                   <button class="btn btn-outline-primary">Change Plan</button>
                                   <button class="btn btn-outline-danger">Cancel Subscription</button>
                               </div>
                           </div>
                       </div>
                       
                       <div class="billing-history mt-4">
                           <h6>Billing History</h6>
                           <div class="table-responsive">
                               <table class="table">
                                   <thead>
                                       <tr>
                                           <th>Date</th>
                                           <th>Description</th>
                                           <th>Amount</th>
                                           <th>Status</th>
                                           <th>Action</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <tr>
                                           <td>Feb 1, 2024</td>
                                           <td>Premium Pro - Monthly</td>
                                           <td>$29.00</td>
                                           <td><span class="badge bg-success">Paid</span></td>
                                           <td><button class="btn btn-sm btn-outline-secondary">Download</button></td>
                                       </tr>
                                       <tr>
                                           <td>Jan 1, 2024</td>
                                           <td>Premium Pro - Monthly</td>
                                           <td>$29.00</td>
                                           <td><span class="badge bg-success">Paid</span></td>
                                           <td><button class="btn btn-sm btn-outline-secondary">Download</button></td>
                                       </tr>
                                   </tbody>
                               </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           
           <!-- Advanced Settings -->
           <div class="settings-tab" id="advanced">
             <div class="dashboard-card">
                 <div class="card-header">
                     <h5 class="card-title">Advanced Settings</h5>
                 </div>
                 <div class="card-body">
                     <!-- <div class="advanced-section">
                         <h6>Data Export</h6>
                         <p class="text-muted">Export all your account data including models, chat history, and settings.</p>
                         <button class="btn btn-outline-primary">Request Data Export</button>
                     </div> -->
                     
                     <div class="advanced-section mt-4">
                         <h6>Account Deletion</h6>
                         <p class="text-muted">Permanently delete your account and all associated data. This action cannot be undone.</p>
                         <button class="btn btn-outline-danger" id="deleteAccountBtn" class="btn btn-outline-danger">Delete Account</button>
                     </div>
                     
                     <!-- <div class="advanced-section mt-4">
                         <h6>Developer Mode</h6>
                         <div class="form-check">
                             <input class="form-check-input" type="checkbox" id="developerMode">
                             <label class="form-check-label" for="developerMode">
                                 Enable developer mode (shows additional debugging information)
                             </label>
                         </div>
                     </div> -->
                 </div>
             </div>
           </div>
       </div>
   </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Account Deletion</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>We have sent a confirmation code to your registered email. Please enter it below to proceed.</p>
                <small id="deleteMsg" class="mt-2 d-block"></small>
                <input type="text" id="confirmationCode" class="form-control" placeholder="Enter confirmation code">
                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel Deletion</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-outline-danger">
                    Confirm Deletion
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    // Step 1: Request confirmation code
    $('#deleteAccountBtn').on('click', function() {
        let $btn = $(this);
        $btn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: "{{ route('account.sendDeleteCode') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}"},
            success: function(res) {
                $('#deleteMsg')
                    .removeClass()
                    .addClass('text-success')
                    .text('Code sent to your email.');

                // Correct ID here
                let modalEl = document.getElementById('confirmDeleteModal');
                let myModal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static', // Prevent closing on click outside
                    keyboard: false     // Prevent closing on ESC
                });
                myModal.show();
            },
            error: function() {
                alert("Error sending confirmation code.");
            },
            complete: function() {
                $btn.prop('disabled', false).text('Delete Account');
            }
        });
    });


    // Step 2: Confirm deletion
    $('#confirmDeleteBtn').on('click', function() {
        let code = $('#confirmationCode').val().trim();
        if (!code) {
            $('#deleteMsg').removeClass().addClass('text-danger').text('Please enter the confirmation code.');
            return;
        }

        $(this).prop('disabled', true).text('Deleting...');

        $.ajax({
            url: "{{ route('account.delete') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                code: code
            },
            success: function(res) {
                if (res.success) {
                    $('#deleteMsg').removeClass().addClass('text-success').text('Account deleted successfully.');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1500);
                } else {
                    $('#deleteMsg').removeClass().addClass('text-danger').text(res.message || 'Invalid code.');
                    $('#confirmDeleteBtn').prop('disabled', false).text('Confirm Deletion');
                }
            },
            error: function() {
                $('#deleteMsg').removeClass().addClass('text-danger').text('Error deleting account.');
                $('#confirmDeleteBtn').prop('disabled', false).text('Confirm Deletion');
            }
        });
    });
});
</script>
@endsection