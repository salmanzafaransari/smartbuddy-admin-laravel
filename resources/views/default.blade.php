<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBuddy Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
         .bg-gredient{
        background: linear-gradient(135deg, rgb(102, 126, 234) 0%, rgb(118, 75, 162) 100%);
        }
    </style>

    @yield('style')
</head>
<body>
        @include('layout.sidebar')
        <main class="main-content">
            @include('layout.topbar')
            @yield('content')
        </main>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        function confirmLogout() {
            // show modal when logout clicked
            var modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();

            // attach event listener only once
            document.getElementById('confirmLogoutBtn').onclick = function () {
                document.getElementById('logout-form').submit();
            };
        }
    </script>
    

    @yield('scripts')
    @auth
        @if(auth()->user()->is_superuser)
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('users.count') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.data);

                        // Update sidebar count
                        $('#allUserCount').text(response.data);
                        $('.totalUsers').text(response.data);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#allUserCount').text('0');
                        $('.totalUsers').text('0');
                    }
                });
                $.ajax({
                    url: "{{ route('tracker.trackCount') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.totalTrackerCount);
                        // Update sidebar count
                        $('#allTrackerCount').text(response.totalTrackerCount);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#allTrackerCount').text('0');
                    }
                });
            });

        </script>
        @endif
    @endauth
</body>

</html>