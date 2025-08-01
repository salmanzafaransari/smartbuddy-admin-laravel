<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Smart Buddy</title>

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
                <!-- <p>Enter your email address and we'll send you a link to reset your password</p> -->
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}" required class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" required class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Reset Password</button>
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