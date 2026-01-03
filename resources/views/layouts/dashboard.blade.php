{{-- resources/views/layouts/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - PT Transdata Inventory System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }

        /* Main Content Wrapper - UPDATED */
        .content-wrapper {
            padding: 1.5rem;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Desktop - Default state */
        @media (min-width: 992px) {
            .content-wrapper {
                margin-left: 260px; /* Lebar sidebar normal */
                padding-top: 90px;
            }
            
            /* Sidebar collapsed state */
            body.sidebar-collapsed .content-wrapper {
                margin-left: 80px; /* Lebar sidebar collapsed */
            }
        }

        /* Mobile - No margin */
        @media (max-width: 991px) {
            .content-wrapper {
                margin-left: 0;
                padding-top: 80px;
            }
        }

        @media (max-width: 575px) {
            .content-wrapper {
                padding: 1rem;
                padding-top: 75px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Include Sidebar -->
    @include('components.sidebar')
    
    <!-- Include Navbar -->
    @include('components.navbar')
    
    <!-- Main Content -->
    <main class="content-wrapper">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>