<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediRemind') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Cairo', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Dark Mode Script -->
    <script>
        // Apply immediately
        if (localStorage.darkMode === 'true') {
            document.documentElement.classList.add('dark');
        }

        // Toggle function
        window.toggleDark = function() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.darkMode = isDark.toString();

            // Update buttons
            document.querySelectorAll('[data-dark-toggle]').forEach(btn => {
                btn.textContent = isDark ? '☀️' : '🌙';
            });
        };
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-50">

    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    <script>
        lucide.createIcons();

        // Setup buttons on load
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('[data-dark-toggle]').forEach(btn => {
                btn.textContent = isDark ? '☀️' : '🌙';
                btn.addEventListener('click', window.toggleDark);
            });
        });
    </script>
</body>

</html>
