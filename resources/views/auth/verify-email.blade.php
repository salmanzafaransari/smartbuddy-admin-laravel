<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2>Verify Your Email</h2>
                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <p>We’ve sent a verification link to your email. Please check your inbox.</p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
