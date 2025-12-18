<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PT Transdata</title>
    <link rel="icon" type="image/png" href="{{ asset('images/transdata-logo.png') }}">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .menu-text-hidden {
            opacity: 0;
            width: 0;
            overflow: hidden;
            transition: opacity 0.2s ease;
        }
        .menu-text-visible {
            opacity: 1;
            width: auto;
            transition: opacity 0.3s ease 0.1s;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    
    @include('components.sidebar')
    
    <main id="mainContent" class="ml-64 min-h-screen transition-[margin] duration-300 ease-in-out">
        
        @include('components.navbar')
        
        <div class="p-8">
            @yield('content')
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleBtn');
        const menuTexts = document.querySelectorAll('.menu-text-visible');
        const logoText = document.getElementById('logoText');
        const navLabel = document.getElementById('navLabel');
        const appsLabel = document.getElementById('appsLabel');
        
        let isCollapsed = false;

        toggleBtn.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            
            if (isCollapsed) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-20');
                
                menuTexts.forEach(text => {
                    text.classList.remove('menu-text-visible');
                    text.classList.add('menu-text-hidden');
                });
                logoText.classList.add('menu-text-hidden');
                navLabel.style.display = 'none';
                appsLabel.style.display = 'none';
                
                toggleBtn.querySelector('i').classList.remove('fa-bars');
                toggleBtn.querySelector('i').classList.add('fa-angles-right');
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                mainContent.classList.remove('ml-20');
                mainContent.classList.add('ml-64');
                
                setTimeout(() => {
                    menuTexts.forEach(text => {
                        text.classList.remove('menu-text-hidden');
                        text.classList.add('menu-text-visible');
                    });
                    logoText.classList.remove('menu-text-hidden');
                    navLabel.style.display = 'block';
                    appsLabel.style.display = 'block';
                }, 150);
                
                toggleBtn.querySelector('i').classList.remove('fa-angles-right');
                toggleBtn.querySelector('i').classList.add('fa-bars');
            }
        });

        // Logout confirmation
        document.getElementById('logoutForm')?.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin logout?')) {
                e.preventDefault();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>