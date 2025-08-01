/* ===================================
   AUTH Pages JS
   =================================== */

(function ($) {
    'use strict';

    $(document).ready(function() {


        // TWO FACTOR AUTH PAGE
        $(document).ready(function() {
            initializeVerification();
        });

        function initializeVerification() {
            const $codeInputs = $('.code-input');
            const $verifyBtn = $('#verifyBtn');
            const $resendBtn = $('#resendBtn');
            
            // Handle code input
            $codeInputs.each(function(index) {
                const $input = $(this);
                
                $input.on('input', function(e) {
                    const value = $(this).val().replace(/[^0-9]/g, '');
                    $(this).val(value);
                    
                    if (value && index < $codeInputs.length - 1) {
                        $codeInputs.eq(index + 1).focus();
                    }
                    
                    updateVerifyButton();
                    updateInputStates();
                });
                
                $input.on('keydown', function(e) {
                    if (e.key === 'Backspace' && !$(this).val() && index > 0) {
                        $codeInputs.eq(index - 1).focus().val('');
                        updateVerifyButton();
                        updateInputStates();
                    }
                });
                
                $input.on('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.originalEvent.clipboardData.getData('text').replace(/[^0-9]/g, '');
                    
                    for (let i = 0; i < Math.min(pastedData.length, $codeInputs.length - index); i++) {
                        $codeInputs.eq(index + i).val(pastedData[i]);
                    }
                    
                    updateVerifyButton();
                    updateInputStates();
                });
            });
            
            // Handle form submission
            $('#verificationForm').on('submit', function(e) {
                e.preventDefault();
                verifyCode();
            });
            
            // Handle resend
            $resendBtn.on('click', function() {
                resendCode();
            });
            
            // Auto-fill email from URL params
            const urlParams = new URLSearchParams(window.location.search);
            const email = urlParams.get('email');
            if (email) {
                $('#userEmail').text(email);
            }
        }
        
        function updateVerifyButton() {
            const $codeInputs = $('.code-input');
            const $verifyBtn = $('#verifyBtn');
            
            const allFilled = $codeInputs.toArray().every(input => $(input).val().length === 1);
            $verifyBtn.prop('disabled', !allFilled);
        }
        
        function updateInputStates() {
            const $codeInputs = $('.code-input');
            
            $codeInputs.each(function() {
                const $input = $(this);
                $input.removeClass('filled error');
                if ($input.val()) {
                    $input.addClass('filled');
                }
            });
        }
        
        function verifyCode() {
            const $codeInputs = $('.code-input');
            const code = $codeInputs.toArray().map(input => $(input).val()).join('');
            const $verifyBtn = $('#verifyBtn');
            
            // Show loading state
            $verifyBtn.html('<i class="fas fa-spinner fa-spin"></i> Verifying...').prop('disabled', true);
            
            // Simulate verification
            setTimeout(() => {
                if (code === '123456' || code === '000000') {
                    // Success
                    showSuccessModal();
                } else {
                    // Error
                    showError();
                    $verifyBtn.html('<i class="fas fa-check-circle"></i> Verify Email');
                    updateVerifyButton();
                }
            }, 2000);
        }
        
        function showError() {
            const $codeInputs = $('.code-input');
            
            $codeInputs.addClass('error').val('');
            
            // Remove error class after animation
            setTimeout(() => {
                $codeInputs.removeClass('error');
                $codeInputs.first().focus();
            }, 500);
            
            // Show error message
            showNotification('Invalid verification code. Please try again.', 'error');
        }
        
        function showSuccessModal() {
            const modal = new bootstrap.Modal($('#successModal')[0]);
            modal.show();
        }
        
        function completeVerification() {
            window.location.href = 'index.html';
        }
        
        function resendCode() {
            const $resendBtn = $('#resendBtn');
            const $resendTimer = $('#resendTimer');
            
            $resendBtn.prop('disabled', true).hide();
            $resendTimer.show();
            
            let countdown = 60;
            const timer = setInterval(() => {
                countdown--;
                $('#countdown').text(countdown);
                
                if (countdown <= 0) {
                    clearInterval(timer);
                    $resendBtn.prop('disabled', false).show();
                    $resendTimer.hide();
                }
            }, 1000);
            
            // Clear existing inputs
            const $codeInputs = $('.code-input');
            $codeInputs.val('').removeClass('filled error');
            updateVerifyButton();
            $codeInputs.first().focus();
            
            showNotification('Verification code sent successfully!', 'success');
        }
        
        function changeEmail() {
            if (confirm('Are you sure you want to change your email address? You will need to start the registration process again.')) {
                window.location.href = 'user-register.html';
            }
        }
        
        function contactSupport() {
            alert('Support feature would open here. This is a demo implementation.\n\nIn a real application, this would open a support chat or help center.');
        }
        
        function showNotification(message, type) {
            // Create notification element
            const $notification = $(`
                <div class="alert alert-${type === 'error' ? 'danger' : 'success'} notification-toast">
                    <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i>
                    ${message}
                </div>
            `);
            
            // Add styles
            $notification.css({
                position: 'fixed',
                top: '20px',
                right: '20px',
                zIndex: 9999,
                border: 'none',
                borderRadius: '8px',
                boxShadow: '0 10px 30px rgba(0, 0, 0, 0.15)',
                animation: 'slideIn 0.3s ease'
            });
            
            $('body').append($notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                $notification.css('animation', 'slideOut 0.3s ease');
                setTimeout(() => {
                    $notification.remove();
                }, 300);
            }, 3000);
        }
        
        // Add animation styles
        $('<style>').text(`
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `).appendTo('head');

        // User Registration
        // Password toggle functionality
        window.togglePassword = function(inputId) {
            const $input = $('#' + inputId);
            const $button = $input.parent().find('.password-toggle i');
            
            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $button.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $input.attr('type', 'password');
                $button.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        };

        // Password strength checker
        $('#password').on('input', function(e) {
            const password = $(this).val();
            const $strengthBar = $('#strengthBar');
            const $strengthText = $('#strengthText');
            
            let strength = 0;
            let strengthLabel = 'Weak';
            let strengthColor = 'rgb(239, 68, 68)'; // danger color
            
            // Check password criteria
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Set strength level
            if (strength >= 4) {
                strengthLabel = 'Strong';
                strengthColor = 'rgb(34, 197, 94)'; // success color
            } else if (strength >= 3) {
                strengthLabel = 'Good';
                strengthColor = 'rgb(245, 158, 11)'; // warning color
            } else if (strength >= 2) {
                strengthLabel = 'Fair';
                strengthColor = 'rgb(245, 158, 11)'; // warning color
            }
            
            // Update UI
            const percentage = (strength / 5) * 100;
            $strengthBar.css({
                'width': percentage + '%',
                'background': strengthColor
            });
            $strengthText.text(`Password strength: ${strengthLabel}`);
        });

        // Form submission
        // $('.auth-form').on('submit', function(e) {
        //     e.preventDefault();
            
        //     // Get form values
        //     const firstName = $('#firstName').val();
        //     const lastName = $('#lastName').val();
        //     const email = $('#email').val();
        //     const password = $('#password').val();
        //     const confirmPassword = $('#confirmPassword').val();
        //     const terms = $('#terms').is(':checked');
            
        //     // Validation
        //     if (!firstName || !lastName || !email || !password || !confirmPassword) {
        //         alert('Please fill in all fields');
        //         return;
        //     }
            
        //     if (password !== confirmPassword) {
        //         alert('Passwords do not match');
        //         return;
        //     }
            
        //     if (!terms) {
        //         alert('Please agree to the Terms of Service and Privacy Policy');
        //         return;
        //     }
            
        //     // Simulate registration success
        //     alert('Account created successfully! Redirecting to dashboard...');
        //     window.location.href = 'index.html';
        // });


        // User Login
        // Form submission
        // $('.auth-login-form').on('submit', function(e) {
        //     e.preventDefault();
            
        //     // Simple validation
        //     const email = $('#email').val();
        //     const password = $('#password').val();
            
        //     if (email && password) {
        //         // Simulate login success
        //         window.location.href = 'index.html';
        //     }
        // });


        // Forgot Password
        $('#forgotPasswordForm').on('submit', function(e) {
            e.preventDefault();
            
            const $submitBtn = $(this).find('button[type="submit"]');
            const originalText = $submitBtn.html();
            
            $submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);
            
            setTimeout(() => {
                $('.auth-forgot-password-form').hide();
                $('#successMessage').show();
            }, 2000);
        });


        // Coming Soon / Maintenance
        // Set launch date (7 days from now for demo)
        const launchDateTime = new Date().getTime() + (7 * 24 * 60 * 60 * 1000);
        const launchDateTimeInSeconds = Math.floor(launchDateTime / 1000);
        
        // Initialize FlipDown countdown
        var flipdown = new FlipDown(launchDateTimeInSeconds, {
            theme: 'dark',
            headings: ['Days', 'Hours', 'Minutes', 'Seconds']
        }).start();
        
        // Handle countdown end
        flipdown.ifEnded(() => {
            $('.coming-soon-subtitle').text('We\'re Live!');
            $('.coming-soon-description').text('Welcome to the future of AI! Our new platform is now available.');
        });
        
        // Notify me function using jQuery
        function notifyMe() {
            const email = $('.notify-input').val();
            if (email && email.includes('@')) {
                // Success animation
                $('.notify-btn').text('✓ Added!').addClass('btn-success');
                $('.notify-input').val('');
                
                // Show success message
                $('<div class="alert alert-success mt-2">Thank you! We\'ll notify you when we launch.</div>')
                    .insertAfter('.notify-input-group')
                    .delay(3000)
                    .fadeOut();
                
                // Reset button after delay
                setTimeout(function() {
                    $('.notify-btn').text('Notify Me').removeClass('btn-success');
                }, 3000);
            } else {
                // Error animation
                $('.notify-input').addClass('border-danger').focus();
                $('.notify-btn').text('Invalid Email').addClass('btn-danger');
                
                // Reset after delay
                setTimeout(function() {
                    $('.notify-input').removeClass('border-danger');
                    $('.notify-btn').text('Notify Me').removeClass('btn-danger');
                }, 2000);
            }
        }
        
        // jQuery event handler for notify button
        $('.notify-btn').on('click', notifyMe);
        
        // Handle Enter key in email input
        $('.notify-input').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                notifyMe();
            }
        });
        
        // Add smooth hover effects to feature items
        $('.feature-item').hover(
            function() {
                $(this).addClass('shadow-lg').css('transform', 'translateY(-5px)');
            },
            function() {
                $(this).removeClass('shadow-lg').css('transform', 'translateY(0)');
            }
        );


        // jQuery event handler for reload button
        $('.btn-light-outline').on('click', function(e) {
            if ($(this).attr('href') === '#') {
                e.preventDefault();
                location.reload();
            }
        });


    });
   
} (jQuery) );