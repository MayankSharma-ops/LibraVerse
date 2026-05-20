<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LibraVerse — Journey Through Knowledge')</title>
    <meta name="description" content="Experience a cinematic journey through knowledge. Browse, analyze, and borrow books, research papers, and journals in an immersive 3D space.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- WebGL Background Canvas -->
    <canvas id="webgl-background"></canvas>

    <!-- Custom Cursor -->
    <div id="custom-cursor"></div>
    <div id="custom-cursor-dot"></div>

    <!-- Preloader Screen -->
    <div id="preloader">
        <div class="preload-book-container">
            <div class="preload-book">
                <div class="preload-cover front"></div>
                <div class="preload-page p1"></div>
                <div class="preload-page p2"></div>
                <div class="preload-page p3"></div>
                <div class="preload-cover back"></div>
            </div>
            <div class="preload-logo">📖</div>
        </div>
        <div class="preload-counter">00%</div>
    </div>

    <!-- Page Transition Overlay -->
    <div id="page-transition-overlay">
        <div class="transition-book">
            <div class="preload-book">
                <div class="preload-cover front"></div>
                <div class="preload-page p1"></div>
                <div class="preload-cover back"></div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="nav-logo" data-transition>
            <span>📖</span> LIBRAVERSE
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}" data-transition>Home</a></li>
            <li><a href="{{ route('search') }}" class="{{ Route::currentRouteName() == 'search' ? 'active' : '' }}" data-transition>Search</a></li>
            <li><a href="{{ route('dashboard') }}" class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" data-transition>Dashboard</a></li>
        </ul>
        @auth
            <a href="{{ route('dashboard') }}" class="nav-btn" data-transition>Account</a>
        @else
            <a href="{{ route('dashboard') }}" class="nav-btn" data-transition>Explore Lab</a>
        @endauth
    </nav>

    <!-- Page Content Container -->
    <main id="main-content">
        @yield('content')
    </main>

    <!-- Simple Page Footer -->
    <footer style="padding: 60px 20px; border-top: 1px solid var(--border-color); background-color: rgba(4,6,13,0.9); margin-top: 100px; text-align: center; font-size: 14px; color: var(--text-secondary); position: relative; z-index: 10;">
        <div class="container" style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
            <div class="nav-logo">
                <span>📖</span> LIBRAVERSE
            </div>
            <p>A premium interactive portal built for researchers, innovators, and thinkers.</p>
            <p style="font-size: 12px; opacity: 0.6;">&copy; {{ date('Y') }} LibraVerse Lab. Built with Laravel & GSAP.</p>
        </div>
    </footer>

</body>
</html>
