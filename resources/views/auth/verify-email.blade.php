<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="auth-body">
    <!-- Background Elements -->
    <div class="auth-background">
        <div class="bg-pattern"></div>
        <div class="floating-elements">
            <div class="floating-element"><i class="fas fa-brain"></i></div>
            <div class="floating-element"><i class="fas fa-robot"></i></div>
            <div class="floating-element"><i class="fas fa-chart-line"></i></div>
            <div class="floating-element"><i class="fas fa-image"></i></div>
        </div>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Auth Header -->
            <div class="auth-header">
                <div class="brand-logo">
                    <i class="fas fa-brain"></i>
                    <h1>SmartBuddy</h1>
                </div>
                <h2>Verify Your Email</h2>
            </div>

            <div class="success-message" id="successMessage" style="display:block;">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>Check Your Email</h3>
                <p>
                    We've sent a password reset link to your email address. Please check your inbox.<br/>
                    @if (session('message'))
                        {{ session('message') }}
                    @endif
                </p>

                <form id="resendForm" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" id="resendBtn">
                        <span id="btnText">Resend Verification Email</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                    </button>
                </form>
                <p id="ajaxResponse" class="mt-2 text-success" style="display:none;"></p>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#resendForm').on('submit', function(e) {
                e.preventDefault();

                let $btn = $('#resendBtn');
                let $text = $('#btnText');
                let $spinner = $('#btnSpinner');
                let $msg = $('#ajaxResponse');

                // Reset message
                $msg.hide().removeClass('text-danger text-success');

                // Disable button & show spinner
                $btn.prop('disabled', true);
                $text.text('Sending...');
                $spinner.show();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $msg.text('Verification email has been resent successfully.')
                            .addClass('text-success').show();
                    },
                    error: function(xhr) {
                        $msg.text('Something went wrong. Please try again.')
                            .addClass('text-danger').show();
                    },
                    complete: function() {
                        // Reset button state
                        $btn.prop('disabled', false);
                        $text.text('Resend Verification Email');
                        $spinner.hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
