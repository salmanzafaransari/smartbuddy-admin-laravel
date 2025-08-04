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
             <div class="success-message success-message-hidden" id="successMessage" style="display:block;">
               <div class="success-icon">
                   <i class="fas fa-check-circle"></i>
               </div>
               <h3>Check Your Email</h3>
               <p>We've sent a password reset link to your email address. Please check your inbox.<br/>
                  @if (session('message'))
                    {{ session('message') }}
                  @endif
               </p>
               <form method="POST" action="{{ route('verification.send') }}">
                   @csrf
                   <button type="submit" class="btn btn-primary">Resend Verification Email</button>
               </form>
             </div>
        </div>
    </div>

</body>
</html>
