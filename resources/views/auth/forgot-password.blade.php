<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Smart Buddy</title>

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
    <!-- Auth Container -->
    <div class="auth-container">
        <div class="auth-card">
            <!-- Auth Header -->
            <div class="auth-header">
                <div class="brand-logo">
                    <i class="fas fa-brain"></i>
                    <h1>SmartBuddy</h1>
                </div>
                <h2>Reset Password</h2>
                <p>Enter your email address and we'll send you a link to reset your password</p>
            </div>
              @if (session('status'))
                  <div class="success-message success-message-hidden" id="successMessage">
                     <div class="success-icon">
                         <i class="fas fa-check-circle"></i>
                     </div>
                     <h3>Check Your Email</h3>
                     <p>{{ session('status') }}</p>
                     <p>We've sent a password reset link to your email address. Please check your inbox and follow the instructions to reset your password.</p>
                 </div>
              @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom Auth pages JS -->
    <script src="{{ asset('assets/js/auth.js') }}"></script>
</body>
</html>