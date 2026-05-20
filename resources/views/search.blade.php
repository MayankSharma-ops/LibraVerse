@extends('layouts.app')

@section('title', 'Discover — LibraVerse Catalog')

@section('content')
<section class="search-page-section" style="padding-top: 140px; min-height: 100vh; position: relative; z-index: 10;">
    <div class="container">
        <!-- Page Title -->
        <div style="text-align: center; margin-bottom: 50px;">
            <h1 style="font-family: var(--font-serif); font-size: 48px; color: var(--accent-gold); margin-bottom: 10px;">Search Archives</h1>
            <p style="color: var(--text-secondary);">Query our neural catalogs and resource nodes</p>
        </div>

        <!-- Main Search Bar -->
        <div class="search-main-wrapper" style="max-width: 800px; margin: 0 auto 50px auto;">
            <div class="search-bar-wrapper" style="padding: 10px 10px 10px 30px;">
                <span class="search-icon" style="font-size: 20px;">🔍</span>
                <input type="text" id="live-search-input" placeholder="Type title, author, or keywords..." style="font-size: 18px;">
                <button id="voice-search-trigger" style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: var(--text-primary); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; margin-right: 10px; transition: all 0.3s;">🎙️</button>
                <button id="search-execute-btn" class="search-btn">Query</button>
            </div>
        </div>

        <!-- Search Layout -->
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 40px; align-items: start;">
            <!-- Filters Sidebar -->
            <aside class="glass-panel" style="padding: 30px; position: sticky; top: 100px;">
                <h3 style="font-size: 16px; text-transform: uppercase; letter-spacing: 2px; color: var(--accent-gold); margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Filters</h3>
                
                <!-- Resource Type -->
                <div style="margin-bottom: 30px;">
                    <h4 style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); margin-bottom: 15px;">Resource Type</h4>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <label class="filter-option" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="type" value="" checked style="accent-color: var(--accent-gold);">
                            All Formats
                        </label>
                        <label class="filter-option" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="type" value="book" style="accent-color: var(--accent-gold);">
                            Books
                        </label>
                        <label class="filter-option" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="type" value="journal" style="accent-color: var(--accent-gold);">
                            Journals
                        </label>
                        <label class="filter-option" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="type" value="ebook" style="accent-color: var(--accent-gold);">
                            E-Books
                        </label>
                        <label class="filter-option" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="type" value="research_paper" style="accent-color: var(--accent-gold);">
                            Research Papers
                        </label>
                    </div>
                </div>

                <!-- Categories -->
                <div style="margin-bottom: 30px;">
                    <h4 style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); margin-bottom: 15px;">Category</h4>
                    <select id="category-filter" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); color: var(--text-primary); border-radius: 6px; outline: none;">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Slider -->
                <div style="margin-bottom: 30px;">
                    <h4 style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); margin-bottom: 15px;">Published Year</h4>
                    <div style="display: flex; gap: 10px;">
                        <input type="number" id="year-from" placeholder="From" style="width: 50%; padding: 10px; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); color: var(--text-primary); border-radius: 6px; text-align: center;">
                        <input type="number" id="year-to" placeholder="To" style="width: 50%; padding: 10px; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); color: var(--text-primary); border-radius: 6px; text-align: center;">
                    </div>
                </div>

                <!-- Availability -->
                <div>
                    <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                        <input type="checkbox" id="availability-filter" style="accent-color: var(--accent-gold); width: 16px; height: 16px;">
                        Available Only
                    </label>
                </div>
            </aside>

            <!-- Results Section -->
            <main>
                <!-- Sorting & Info -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <p id="results-count" style="font-size: 14px; color: var(--text-secondary);">Showing all resources</p>
                    <div>
                        <select id="sort-filter" style="padding: 8px 16px; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); color: var(--text-primary); border-radius: 6px; outline: none;">
                            <option value="relevance">Popularity</option>
                            <option value="title">Title A-Z</option>
                            <option value="year">Newest First</option>
                            <option value="rating">Highest Rated</option>
                        </select>
                    </div>
                </div>

                <!-- Results Grid -->
                <div id="results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 30px;">
                    <!-- Will be populated by AJAX, initial load from controller -->
                    @include('partials.search-results', ['resources' => $recentResources])
                </div>
            </main>
        </div>
    </div>
</section>

<!-- Voice Search Overlay -->
<div id="voice-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(4,6,11,0.95); z-index: 10000; display: none; align-items: center; justify-content: center; flex-direction: column; gap: 40px; backdrop-filter: blur(10px);">
    <div style="color: var(--accent-gold); font-size: 24px; font-family: var(--font-serif); letter-spacing: 2px;">LISTENING...</div>
    
    <!-- Soundwaves animation -->
    <div class="waves-container" style="display: flex; align-items: center; gap: 8px; height: 80px;">
        <div class="wave-bar w1" style="width: 4px; height: 30px; background: var(--accent-gold); border-radius: 2px;"></div>
        <div class="wave-bar w2" style="width: 4px; height: 50px; background: var(--accent-gold); border-radius: 2px;"></div>
        <div class="wave-bar w3" style="width: 4px; height: 20px; background: var(--accent-gold); border-radius: 2px;"></div>
        <div class="wave-bar w4" style="width: 4px; height: 60px; background: var(--accent-gold); border-radius: 2px;"></div>
        <div class="wave-bar w5" style="width: 4px; height: 40px; background: var(--accent-gold); border-radius: 2px;"></div>
    </div>
    
    <p id="voice-transcript" style="color: var(--text-secondary); max-width: 400px; text-align: center; font-style: italic;">"Search Computer Science Books..."</p>
    
    <button id="voice-close-btn" style="background: transparent; border: 1px solid var(--accent-gold); color: var(--accent-gold); padding: 10px 24px; border-radius: 50px; cursor: pointer; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; transition: all 0.3s;">Cancel</button>
</div>

<style>
/* CSS waves micro-animation */
.waves-container .wave-bar {
    animation: pulseWave 1.2s infinite ease-in-out;
}
.waves-container .w1 { animation-delay: 0.1s; }
.waves-container .w2 { animation-delay: 0.3s; }
.waves-container .w3 { animation-delay: 0.5s; }
.waves-container .w4 { animation-delay: 0.2s; }
.waves-container .w5 { animation-delay: 0.4s; }

@keyframes pulseWave {
    0%, 100% { transform: scaleY(1); }
    50% { transform: scaleY(2); }
}
</style>
@endsection
