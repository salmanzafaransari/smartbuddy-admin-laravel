@extends('default')
@section('pageTitle', $chatbot->name . ' Configure')
@section('pageAction')
<a href="/chatbot" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Back to Chatbots
</a>
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
.text-italic{
 font-style:italic;
}
.custom-active .active {
    background: linear-gradient(135deg, rgb(var(--primary)) 0%, rgb(var(--primary-dark)) 100%);
    color: #fff !important;
}
.prev{
    font-size:12px;
}
.prev .col-md-4, .prev .col-md-6{
    margin-top:0px;
}
.prev .form-group{
    padding:0px;
}
.prev .form-control{
font-size:12px;
padding: 5px 10px;
}
.prev .btn-primary{
    font-size:14px;
}
.chatbot-preview-container {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    background: #fff;
}

.chatbot-box {
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    height: 400px;
    border: 1px solid #ddd;
}

.chat-header {
    padding: 10px;
    font-weight: bold;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 5px;
}

.chat-body {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    background: #f5f5f5;
}

.bot-message {
    background: #F1F0F0;
    padding: 8px 12px;
    border-radius: 10px;
    margin-bottom: 8px;
    max-width: 75%;
    color: #000;
}

.user-message {
    background: #DCF8C6;
    padding: 8px 12px;
    border-radius: 10px;
    margin-bottom: 8px;
    max-width: 75%;
    margin-left: auto;
    color: #000;
}

/* === Speech Bubble Patterns === */
.pattern-rounded .bot-message,
.pattern-rounded .user-message {
    border-radius: 16px;
}

.pattern-sharp .bot-message,
.pattern-sharp .user-message {
    border-radius: 0;
}

.pattern-bubble .bot-message {
    border-radius: 16px 16px 16px 0;
}
.pattern-bubble .user-message {
    border-radius: 16px 16px 0 16px;
}

.pattern-minimal .bot-message,
.pattern-minimal .user-message {
    border-radius: 8px;
    box-shadow: none;
}

/* === Background Patterns === */
.bg-solid .chat-body {
    background: #f5f5f5;
}

.bg-stripes .chat-body {
    background: repeating-linear-gradient(
        45deg,
        #f5f5f5,
        #f5f5f5 10px,
        #e0e0e0 10px,
        #e0e0e0 20px
    );
}

.bg-dots .chat-body {
    background: radial-gradient(#e0e0e0 1px, transparent 1px);
    background-size: 20px 20px;
}

.bg-diagonal .chat-body {
    background: repeating-linear-gradient(
        -45deg,
        #f5f5f5,
        #f5f5f5 15px,
        #e0e0e0 15px,
        #e0e0e0 30px
    );
}
</style>
@endsection
@section('content')
<!-- Configure -->
<div class="content">
    <div class="row g-4">
        <div class="col-lg-12">
              <div class="dashboard-card">
                  <nav>
                      <div class="nav nav-tabs custom-active" id="nav-tab" role="tablist">
                          <button class="nav-link w-50 active p-3" id="nav-token-tab" data-bs-toggle="tab" data-bs-target="#nav-token" type="button" role="tab" aria-controls="nav-token" aria-selected="true">
                            <i class="fas fa-key"></i>
                            <span><b>Access Token</b></span>
                          </button>
                          <button class="nav-link w-50 p-3" id="nav-prefence-tab" data-bs-toggle="tab" data-bs-target="#nav-prefence" type="button" role="tab" aria-controls="nav-prefence" aria-selected="false">
                            <i class="fas fa-image"></i>
                            <span><b>Preferences</b></span>
                          </button>
                      </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-token" role="tabpanel" aria-labelledby="nav-token-tab">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">API Key</h5>
                            @if(empty($chatbot->api) || empty($chatbot->api->access_token))
                                <button id="generate-btn-{{ $chatbot->id }}" class="btn btn-sm btn-primary" onclick="generateToken({{ $chatbot->id }}, this)">
                                    <i class="fas fa-plus"></i> <span class="btn-text">Generate New Key</span>
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($chatbot->api && $chatbot->api->access_token)
                                <div class="alert alert-warning">
                                    <i class="fas fa-book"></i>
                                    <i><strong>Note:</strong> If you regenerate your access token, your bot will not be able to answer any queries until you replace the CSS and JS files.</i>
                                </div>
                            @endif
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
                                            <button class="btn btn-sm btn-outline-success" onclick="generateToken({{ $chatbot->id }}, this)">Regenerate</button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle"></i>
                                <strong>Important:</strong> Keep your API keys secure and never share them publicly,
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-prefence" role="tabpanel" aria-labelledby="nav-prefence-tab">
                        <div class="card-header">
                            <h5 class="card-title">Customize</h5>
                        </div>
                        <div class="card-body prev">
                            <div class="row g2">
                                <div class="col-md-6">
                                    <div class="chatbot-preview-container">
                                        <!-- Chat Window Preview -->
                                        <div id="chatbot-preview" class="chatbot-box">
                                            <div class="chat-header">
                                                <img id="bot-header-image" src="{{ $chatbot->chatbot_photo ?? 'https://via.placeholder.com/30' }}" width="30" style="margin-right:5px;">
                                                <span id="bot-header-name">{{ $chatbot->name ?? 'Chatbot' }}</span>
                                            </div>
                                            <div class="chat-body">
                                                <div class="bot-message">Hello! How can I help you?</div>
                                                <div class="user-message">I want to know about your services.</div>
                                                <div class="bot-message">Sure! Here’s a quick overview...</div>
                                            </div>
                                        </div>
                                        <!-- Floating Button Preview -->
                                        <div id="chatbot-btn-preview" class="d-flex justify-content-end" style="margin-bottom: 15px;">
                                            <button style="border:none;background:none;">
                                                <img id="bot-btn-image" src="{{ $chatbot->chatbot_photo ?? 'https://via.placeholder.com/50' }}" width="50" style="border-radius:50%;">
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- resources/views/chatbot/customize.blade.php -->
                                    @if(empty($chatbot->api) || empty($chatbot->api->access_token))
                                        <div class="alert alert-warning mt-4">
                                            <i class="fas fa-info-circle"></i>
                                            To set up your chatbot prefence you need to generate a token first.
                                        </div>
                                    @else
                                    <form action="{{ route('chatbot.customize') }}" method="POST">
                                        @csrf
        
                                        <input type="hidden" name="chatbot_id" value="{{ $chatbot->id }}">
                                        <input type="hidden" name="user_id" value="{{ $chatbot->user_id }}">
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Preset Themes -->
                                                <div class="form-group">
                                                <label>Preset Theme</label>
                                                <select id="preset-theme" name="theme" class="form-control">
                                                <option value="">-- Select a Theme --</option>
                                                </select>
                                                </div>
                                            </div>

                                            <!-- ADDED: Pattern Style select (will be submitted as pattern_style) -->
                                            <div class="col-md-6">
                                                <!-- NEW: Speech Bubble Pattern -->
                                                <div class="form-group">
                                                    <label>Speech Bubble Style</label>
                                                    <select id="speech-bubble-style" name="bubble_pattern" class="form-control">
                                                        <option value="rounded" {{ ($chatbot->preference->bubble_pattern ?? '') === 'rounded' ? 'selected' : '' }}>Rounded</option>
                                                        <option value="sharp"  {{ ($chatbot->preference->bubble_pattern ?? '') === 'sharp' ? 'selected' : '' }}>Sharp Edges</option>
                                                        <option value="bubble"  {{ ($chatbot->preference->bubble_pattern ?? '') === 'bubble' ? 'selected' : '' }}>Speech Bubble Corner</option>
                                                        <option value="minimal"  {{ ($chatbot->preference->bubble_pattern ?? '') === 'minimal' ? 'selected' : '' }}>Minimal Flat</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- NEW: Background Pattern -->
                                                <div class="form-group">
                                                    <label>Background Pattern</label>
                                                    <select id="background-pattern-style" name="background_pattern" class="form-control">
                                                        <option value="solid" {{ ($chatbot->preference->background_pattern ?? '') === 'solid' ? 'selected' : '' }}>Solid</option>
                                                        <option value="stripes" {{ ($chatbot->preference->background_pattern ?? '') === 'stripes' ? 'selected' : '' }}>Stripes</option>
                                                        <option value="dots" {{ ($chatbot->preference->background_pattern ?? '') === 'dots' ? 'selected' : '' }}>Dots</option>
                                                        <option value="diagonal" {{ ($chatbot->preference->background_pattern ?? '') === 'diagonal' ? 'selected' : '' }}>Diagonal Lines</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <input type="hidden" name="user_text_color" id="user_text_color" value="{{ $chatbot->preference->user_text_color ?? '#000000' }}">
                                                <input type="hidden" name="bot_text_color" id="bot_text_color"  value="{{ $chatbot->preference->bot_text_color ?? '#000000' }}">
                                                <div class="form-group">
                                                    <input type="color" name="primary_color" id="primary_color" value="{{ $chatbot->preference->primary_color ?? '#0673f1' }}" required><br/>
                                                    <label>Primary Color</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="color" name="user_bubble" id="user_bubble" value="{{ $chatbot->preference->user_bubble ?? '#DCF8C6' }}" required><br/>
                                                    <label>User Message Color</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="color" name="bot_bubble" id="bot_bubble" value="{{ $chatbot->preference->bot_bubble ?? '#F1F0F0' }}" required><br/>
                                                    <label>Bot Message Color</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Position X (Horizontal)</label>
                                                    <select name="position_x" id="position_x" class="form-control" required>
                                                        <option value="left" {{ isset($chatbot->preference) && $chatbot->preference->position_x === 'left' ? 'selected' : '' }}>Left</option>
                                                        <option value="right" {{ isset($chatbot->preference) && $chatbot->preference->position_x === 'right' ? 'selected' : '' }}>Right</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Position Y (Vertical)</label>
                                                    <select name="position_y" id="position_y" class="form-control" required>
                                                        <option value="bottom" {{ isset($chatbot->preference) && $chatbot->preference->position_y === 'bottom' ? 'selected' : '' }}>Bottom</option>
                                                        <option value="top" {{ isset($chatbot->preference) && $chatbot->preference->position_y === 'top' ? 'selected' : '' }}>Top</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Offset X (px)</label>
                                                    <input type="number" name="offset_x" id="offset_x" value="{{ $chatbot->preference->offset_x ?? '20' }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Offset Y (px)</label>
                                                    <input type="number" name="offset_y" id="offset_y" value="{{ $chatbot->preference->offset_y ?? '20' }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-end">
                                                <button type="submit" class="btn btn-primary mt-2">Generate & Download</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
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
           window.location.reload();
       }
   });
}

// Toast Notification
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

// Copy to clipboard
$(document).on('click', '.copy-token-btn', function () {
   $(this).text('Copied');
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
<script>
    const themes = {
        classic: { primary_color: '#0673f1', user_bubble: '#90c1f9', bot_bubble: '#F1F0F0', position_x: 'right', position_y: 'bottom', offset_x: 20, offset_y: 20 },
        light: { primary_color: '#FFFFFF', user_bubble: '#F0F0F0', bot_bubble: '#E6E6E6', position_x: 'left', position_y: 'bottom', offset_x: 15, offset_y: 15 },
        whatsapp: { primary_color: '#25D366', user_bubble: '#DCF8C6', bot_bubble: '#FFFFFF', position_x: 'right', position_y: 'bottom', offset_x: 20, offset_y: 20 },
        midnight_aurora: { primary_color: '#6A00F4', user_bubble: '#2D00AA', bot_bubble: '#0A0A2A', position_x: 'right', position_y: 'bottom', offset_x: 20, offset_y: 20 },
        coral_bliss: { primary_color: '#FF6B6B', user_bubble: '#FFE3E3', bot_bubble: '#FFF5F5', position_x: 'left', position_y: 'top', offset_x: 25, offset_y: 25 },
        cyber_neon: { primary_color: '#00F5D0', user_bubble: '#003844', bot_bubble: '#001C24', position_x: 'right', position_y: 'bottom', offset_x: 30, offset_y: 30 },
        sunset_gradient: { primary_color: '#FF7D00', user_bubble: '#FFBB00', bot_bubble: '#FFEECC', position_x: 'right', position_y: 'bottom', offset_x: 15, offset_y: 15 },
        forest_whisper: { primary_color: '#2E8B57', user_bubble: '#D8E2DC', bot_bubble: '#F8F9FA', position_x: 'left', position_y: 'bottom', offset_x: 18, offset_y: 18 },
        royal_velvet: { primary_color: '#5E35B1', user_bubble: '#E1D5F6', bot_bubble: '#F3EFFF', position_x: 'right', position_y: 'top', offset_x: 22, offset_y: 22 },
        ocean_depth: { primary_color: '#0077B6', user_bubble: '#CAE9FF', bot_bubble: '#E6F2FF', position_x: 'right', position_y: 'bottom', offset_x: 20, offset_y: 20 },
        mars_horizon: { primary_color: '#E2711D', user_bubble: '#FFB347', bot_bubble: '#412722', position_x: 'left', position_y: 'bottom', offset_x: 25, offset_y: 25 },
        cyberpunk: { primary_color: '#FF2A6D', user_bubble: '#05D9E8', bot_bubble: '#0C0032', position_x: 'right', position_y: 'bottom', offset_x: 30, offset_y: 30 }
    };

    const themeSelect = document.getElementById('preset-theme');
    const selectedTheme = "{{ $chatbot->preference->theme ?? 'whatsapp' }}";

    // Populate select options dynamically
    Object.keys(themes).forEach(key => {
        const opt = document.createElement('option');
        opt.value = key;
        opt.textContent = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

        if (key === selectedTheme) {
            opt.selected = true;
        }
        themeSelect.appendChild(opt);
    });

    function getContrastYIQ(hexcolor) {
        hexcolor = hexcolor.replace('#', '');
        const r = parseInt(hexcolor.substr(0, 2), 16);
        const g = parseInt(hexcolor.substr(2, 2), 16);
        const b = parseInt(hexcolor.substr(4, 2), 16);
        const yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
        return (yiq >= 128) ? '#000000' : '#FFFFFF';
    }

    themeSelect.addEventListener('change', function () {
        const selected = themes[this.value];
        if (selected) {
            // Fill in normal values
            document.getElementById('primary_color').value = selected.primary_color;
            document.getElementById('user_bubble').value = selected.user_bubble;
            document.getElementById('bot_bubble').value = selected.bot_bubble;
            document.getElementById('position_x').value = selected.position_x;
            document.getElementById('position_y').value = selected.position_y;
            document.getElementById('offset_x').value = selected.offset_x;
            document.getElementById('offset_y').value = selected.offset_y;

            // Auto contrast text colors
            const userTextColor = getContrastYIQ(selected.user_bubble);
            const botTextColor  = getContrastYIQ(selected.bot_bubble);

            // Hidden inputs for form submission
            document.getElementById('user_text_color').value = userTextColor;
            document.getElementById('bot_text_color').value = botTextColor;

            // Update preview to keep pattern + colors in sync
            updatePreview();
        }
    });
</script>
<script>
    // Ensure previewBox variable exists
    const previewBox = document.getElementById('chatbot-preview');
    const bubbleSelect = document.getElementById('speech-bubble-style');
    const bgSelect = document.getElementById('background-pattern-style');

    bubbleSelect.addEventListener('change', function () {
        previewBox.classList.remove('pattern-rounded','pattern-sharp','pattern-bubble','pattern-minimal');
        previewBox.classList.add(`pattern-${this.value}`);
        updatePreview();
    });

    bgSelect.addEventListener('change', function () {
        previewBox.classList.remove('bg-solid','bg-stripes','bg-dots','bg-diagonal');
        previewBox.classList.add(`bg-${this.value}`);
        updatePreview();
    });

    document.addEventListener('DOMContentLoaded', function () {
        if (!previewBox) return;

        // Apply prefilled bubble pattern
        const bubbleVal = bubbleSelect.value;
        previewBox.classList.remove('pattern-rounded','pattern-sharp','pattern-bubble','pattern-minimal');
        previewBox.classList.add(`pattern-${bubbleVal}`);

        // Apply prefilled background pattern
        const bgVal = bgSelect.value;
        previewBox.classList.remove('bg-solid','bg-stripes','bg-dots','bg-diagonal');
        previewBox.classList.add(`bg-${bgVal}`);

        // Apply theme if already set
        if (themeSelect && themeSelect.value && themes[themeSelect.value]) {
            // Optional: Do something with selected theme if needed
        }

        // Finally update colors, images, text, etc.
        updatePreview();
    });


    function updatePreview() {
        if (!previewBox) return;
        const primaryColor = document.getElementById('primary_color').value;
        const userBubble   = document.getElementById('user_bubble').value;
        const botBubble    = document.getElementById('bot_bubble').value;

        // Set CSS vars used by pattern styles (keeps pattern logic working)
        previewBox.style.setProperty('--user-bubble', userBubble);
        previewBox.style.setProperty('--bot-bubble', botBubble);

        // Header color
        const headerEl = document.querySelector('#chatbot-preview .chat-header');
        if (headerEl) headerEl.style.backgroundColor = primaryColor;

        // User messages
        document.querySelectorAll('#chatbot-preview .user-message').forEach(el => {
            el.style.backgroundColor = userBubble;
            el.style.color = getContrastYIQ(userBubble);
        });

        // Bot messages
        document.querySelectorAll('#chatbot-preview .bot-message').forEach(el => {
            el.style.backgroundColor = botBubble;
            el.style.color = getContrastYIQ(botBubble);
        });
    }

    // Image + Name Live Change
    document.getElementById('bot_image_input')?.addEventListener('input', function () {
        document.getElementById('bot-btn-image').src = this.value;
        document.getElementById('bot-header-image').src = this.value;
    });

    document.getElementById('bot_name_input')?.addEventListener('input', function () {
        document.getElementById('bot-header-name').textContent = this.value;
    });

    // Color update on input change
    ['primary_color', 'user_bubble', 'bot_bubble'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
    });

    // Theme change -> keep preview in sync
    themeSelect.addEventListener('change', function () {
        const selected = themes[this.value];
        if (selected) {
            updatePreview();
        }
    });

</script>
@endsection
