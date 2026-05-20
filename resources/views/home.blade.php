@extends('layouts.app')

@section('title', 'LibraVerse — Immersive Library Experience')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero-section">
    <div class="parallax-layer pl-1" data-speed="0.2">📖</div>
    <div class="parallax-layer pl-2" data-speed="-0.3">✨</div>
    <div class="parallax-layer pl-3" data-speed="0.5">📜</div>
    
    <div class="container hero-content">
        <div class="badge" data-aos="fade-down">The Labs Project</div>
        <h1 class="hero-title">
            <span class="word">LibraVerse</span>
            <span class="word">Library</span>
        </h1>
        <p class="hero-subtitle">
            An advanced cognitive catalog built with physical animations, spatial soundscapes, and immersive dimensions.
        </p>

        <!-- Search Bar with Typewriter -->
        <div class="hero-search-container">
            <div class="search-bar-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" id="typewriter-search" placeholder="" readonly>
                <a href="{{ route('search') }}" class="search-btn">Discover</a>
            </div>
        </div>

        <!-- Book Falling onto Shelf Shelf -->
        <div class="shelf-container">
            <div class="shelf-board"></div>
            <!-- The falling book container -->
            <div class="falling-book-wrapper">
                <div class="falling-book">
                    <div class="f-cover front">Calculus</div>
                    <div class="f-page"></div>
                    <div class="f-cover back"></div>
                </div>
            </div>
            <p class="shelf-label">Scroll to Drop Book onto Shelf</p>
        </div>
    </div>
</section>

<!-- Scroll Storytelling Section -->
<section id="storytelling" class="story-section">
    <div class="story-pinned-container">
        <div class="story-header">
            <h2>Unfold the Dimensions</h2>
            <p>Scroll down to flip through our core methodologies</p>
        </div>

        <div class="book-3d-wrapper">
            <div class="story-book">
                <!-- Book spine -->
                <div class="story-spine"></div>
                
                <!-- Base Cover Back -->
                <div class="story-cover back-cover"></div>

                <!-- Page 5 (Explore) -->
                <div class="story-page" id="sp-page5">
                    <div class="page-side front">
                        <div class="page-content">
                            <span class="page-number">5</span>
                            <h3>05 / Explore</h3>
                            <p>Dive deep into curated thematic maps and connect the threads of human discovery.</p>
                            <div class="page-visual explore-visual">
                                <div class="orbit-center"></div>
                                <div class="orbit-planet"></div>
                            </div>
                        </div>
                    </div>
                    <div class="page-side back"></div>
                </div>

                <!-- Page 4 (Recommend) -->
                <div class="story-page" id="sp-page4">
                    <div class="page-side front">
                        <div class="page-content">
                            <span class="page-number">4</span>
                            <h3>04 / Recommend</h3>
                            <p>Personalized cognitive recommendations fueled by semantic analysis of borrowing history.</p>
                            <div class="page-visual recommend-visual">
                                <div class="bar bar-1"></div>
                                <div class="bar bar-2"></div>
                                <div class="bar bar-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="page-side back"></div>
                </div>

                <!-- Page 3 (Analyze) -->
                <div class="story-page" id="sp-page3">
                    <div class="page-side front">
                        <div class="page-content">
                            <span class="page-number">3</span>
                            <h3>03 / Analyze</h3>
                            <p>Cross-reference metadata, extract entities, and compute citation density instantly.</p>
                            <div class="page-visual analyze-visual">
                                <div class="grid-line"></div>
                                <div class="chart-dot"></div>
                            </div>
                        </div>
                    </div>
                    <div class="page-side back"></div>
                </div>

                <!-- Page 2 (Filter) -->
                <div class="story-page" id="sp-page2">
                    <div class="page-side front">
                        <div class="page-content">
                            <span class="page-number">2</span>
                            <h3>02 / Filter</h3>
                            <p>Refine your inquiries using physical sliders, multi-layer parameters, and category tags.</p>
                            <div class="page-visual filter-visual">
                                <div class="slider-track"></div>
                                <div class="slider-handle"></div>
                            </div>
                        </div>
                    </div>
                    <div class="page-side back"></div>
                </div>

                <!-- Page 1 (Search) -->
                <div class="story-page" id="sp-page1">
                    <div class="page-side front">
                        <div class="page-content">
                            <span class="page-number">1</span>
                            <h3>01 / Search</h3>
                            <p>Query thousands of indexed volumes, historical manuscripts, and modern papers instantly.</p>
                            <div class="page-visual search-visual">
                                <div class="glass-lens"></div>
                            </div>
                        </div>
                    </div>
                    <div class="page-side back"></div>
                </div>

                <!-- Base Cover Front -->
                <div class="story-cover front-cover"></div>
            </div>
        </div>
        <!-- Premium end message overlay -->
        <div class="story-end-message">
            <div class="end-glow"></div>
            <h3>Where Knowledge Meets Dimension</h3>
            <p>Explore the archives of tomorrow</p>
        </div>
    </div>
</section>

<!-- Feature Grid Section -->
<section id="features" class="features-section">
    <div class="container">
        <h2 class="section-title">Catalytic Features</h2>
        <div class="feature-grid">
            <div class="feature-card" data-tilt>
                <div class="card-glow"></div>
                <div class="card-icon">⚡</div>
                <h3>Synchronized Speed</h3>
                <p>Lightning fast queries powered by indexed relational nodes and cached vectors.</p>
            </div>
            <div class="feature-card" data-tilt>
                <div class="card-glow"></div>
                <div class="card-icon">🌀</div>
                <h3>Spatial Search</h3>
                <p>Animate magnifying glasses and inspect results in physical space layouts.</p>
            </div>
            <div class="feature-card" data-tilt>
                <div class="card-glow"></div>
                <div class="card-icon">🎨</div>
                <h3>Cinematic Polish</h3>
                <p>Page turns and layouts driven by inertia, physics, and lighting engines.</p>
            </div>
        </div>
    </div>
</section>

<!-- Immersive 3D Corridor Section (Journey Through Knowledge) -->
<section id="corridor-section" class="corridor-trigger-section">
    <div class="corridor-overlay-content">
        <h2 class="corridor-heading">Journey Through Knowledge</h2>
        <p class="corridor-text">Scroll to travel down the physical corridors of the LibraVerse archives.</p>
        <div class="corridor-scroll-indicator">
            <div class="mouse-scroll"></div>
        </div>
    </div>
</section>
@endsection
