<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Smart Buddy</title>

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
                <h2>Create Account</h2>
                <p>Join thousands of AI developers and researchers</p>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Auth Form -->
            <form class="auth-form"  action="{{ route('register.signup') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName" class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="first_name" class="form-control" id="firstName" placeholder="Enter first name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastName" class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="last_name" class="form-control" id="lastName" placeholder="Enter last name" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Create a password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthBar"></div>
                        </div>
                        <small class="form-text" id="strengthText">Password strength: Weak</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="Confirm your password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" class="forgot-link">Terms of Service</a> and <a href="#" class="forgot-link">Privacy Policy</a>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-auth">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </button>
            </form>

            <!-- Auth Divider -->
            <div class="auth-divider">
                <span>or sign up with</span>
            </div>

            <!-- Social Auth -->
            <div class="social-auth">
                <button class="social-btn">
                    <i class="fab fa-google"></i>
                    Sign up with Google
                </button>
            </div>

            <!-- Auth Footer -->
            <div class="auth-footer">
                Already have an account? 
                <a href="/log-in">Log in here</a>
            </div>
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