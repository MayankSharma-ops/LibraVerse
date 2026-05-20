@extends('layouts.app')

@section('title', $resource->title . ' — Detail')

@section('content')
<section class="detail-page-section" style="padding-top: 140px; min-height: 100vh; position: relative; z-index: 10;">
    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('search') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); text-decoration: none; font-size: 14px; margin-bottom: 40px; transition: color 0.3s;" onmouseover="this.style.color='var(--accent-gold)'" onmouseout="this.style.color='var(--text-secondary)'">
            ← Back to Catalog
        </a>

        <!-- Main Details Grid -->
        <div style="display: grid; grid-template-columns: 350px 1fr; gap: 60px; align-items: start; margin-bottom: 60px;">
            <!-- Cover Art Column -->
            <div style="perspective: 1500px; display: flex; flex-direction: column; align-items: center;">
                <div class="detail-book-cover" style="width: 240px; height: 350px; transform-style: preserve-3d; transform: rotateY(-20deg) rotateX(5deg); position: relative; box-shadow: 10px 20px 40px rgba(0,0,0,0.5); transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1); cursor: pointer;" onclick="this.style.transform = this.style.transform.includes('-20deg') ? 'rotateY(0deg) rotateX(0deg) scale(1.05)' : 'rotateY(-20deg) rotateX(5deg)'">
                    <!-- Front Cover -->
                    <div style="position: absolute; width: 100%; height: 100%; border-radius: 4px 12px 12px 4px; background: linear-gradient(135deg, {{ $resource->category->color ?? '#6366f1' }}, #0f172a); border: 2px solid rgba(255,255,255,0.2); display: flex; flex-direction: column; justify-content: space-between; padding: 30px; color: white; backface-visibility: hidden; z-index: 2;">
                        <div>
                            <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7; margin-bottom: 10px;">{{ $resource->type }}</div>
                            <h2 style="font-family: var(--font-serif); font-size: 20px; font-weight: 700; line-height: 1.3;">{{ $resource->title }}</h2>
                        </div>
                        <div style="font-size: 12px; opacity: 0.9; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 15px;">{{ $resource->author }}</div>
                    </div>
                    <!-- Spine -->
                    <div style="position: absolute; left: -10px; top: 0; width: 20px; height: 100%; background: #0f172a; transform: rotateY(-90deg) translateZ(10px); border-radius: 2px;"></div>
                    <!-- Pages edge -->
                    <div style="position: absolute; right: -12px; top: 2%; width: 24px; height: 96%; background: #e2e8f0; transform: rotateY(90deg) translateZ(228px); border-radius: 0 4px 4px 0; border: 1px solid rgba(0,0,0,0.1);"></div>
                    <!-- Back Cover -->
                    <div style="position: absolute; width: 100%; height: 100%; border-radius: 12px 4px 4px 12px; background: #0f172a; transform: translateZ(-20px); z-index: 1;"></div>
                </div>
                
                <p style="font-size: 11px; color: var(--text-secondary); margin-top: 30px; text-align: center; opacity: 0.6; letter-spacing: 1px;">CLICK COVER TO ROTATE IN 3D</p>
            </div>

            <!-- Details Content Column -->
            <div>
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                    <span style="font-size: 12px; padding: 6px 16px; border-radius: 30px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: var(--accent-gold); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                        {{ $resource->category->name }}
                    </span>
                    <span style="font-size: 13px; color: var(--text-secondary);">
                        {{ $resource->views }} Reads
                    </span>
                </div>

                <h1 style="font-family: var(--font-serif); font-size: 48px; font-weight: 800; line-height: 1.2; margin-bottom: 15px; color: var(--text-primary);">
                    {{ $resource->title }}
                </h1>
                
                <p style="font-size: 20px; color: var(--text-secondary); margin-bottom: 30px;">
                    by <span style="color: var(--text-primary); font-weight: 600;">{{ $resource->author }}</span>
                </p>

                <!-- Dynamic Tab Menu -->
                <div style="display: flex; gap: 30px; border-bottom: 1px solid var(--border-color); margin-bottom: 30px;">
                    <button class="tab-btn active" data-tab="overview">Overview</button>
                    <button class="tab-btn" data-tab="metadata">Metadata</button>
                    <button class="tab-btn" data-tab="availability">Availability</button>
                    <button class="tab-btn" data-tab="reviews">Reviews ({{ count($resource->reviews) }})</button>
                </div>

                <!-- Tab Contents -->
                <div class="tab-content-container" style="min-height: 200px; position: relative;">
                    <!-- Overview Tab -->
                    <div class="tab-panel active" id="tab-overview">
                        <p style="font-size: 16px; color: var(--text-secondary); line-height: 1.8; margin-bottom: 30px;">
                            {{ $resource->description ?: 'No overview description has been cataloged for this resource yet.' }}
                        </p>
                        
                        <!-- Borrow CTA -->
                        <div style="display: flex; gap: 20px; align-items: center;">
                            @auth
                                @php
                                    $hasBorrowed = \App\Models\Borrowing::where('user_id', auth()->id())
                                        ->where('resource_id', $resource->id)
                                        ->whereNull('returned_at')
                                        ->exists();
                                @endphp
                                @if($hasBorrowed)
                                    <a href="{{ route('dashboard') }}" class="nav-btn btn-ripple" style="padding: 15px 40px; font-size: 14px; border-radius: 8px; text-decoration: none; text-align: center; display: inline-block; background: rgba(234,179,8,0.2); border-color: var(--accent-gold);">Currently Reading (View Dashboard)</a>
                                @elseif($resource->available_copies > 0)
                                    <button class="nav-btn btn-ripple" style="padding: 15px 40px; font-size: 14px; border-radius: 8px; cursor: pointer;" onclick="borrowResource()">Borrow Resource</button>
                                    <form id="borrow-form" action="{{ route('resources.borrow', $resource->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <span style="font-size: 14px; color: var(--accent-emerald);">● Ready for checkout</span>
                                @else
                                    <button class="nav-btn" style="padding: 15px 40px; font-size: 14px; border-radius: 8px; opacity: 0.5; cursor: not-allowed;" disabled>Out of Stock</button>
                                    <span style="font-size: 14px; color: #ef4444;">● All copies currently loaned</span>
                                @endif
                            @else
                                @if($resource->available_copies > 0)
                                    <a href="{{ route('login') }}" class="nav-btn btn-ripple" style="padding: 15px 40px; font-size: 14px; border-radius: 8px; text-decoration: none; text-align: center; display: inline-block;">Login to Borrow</a>
                                    <span style="font-size: 14px; color: var(--accent-emerald);">● Ready for checkout</span>
                                @else
                                    <button class="nav-btn" style="padding: 15px 40px; font-size: 14px; border-radius: 8px; opacity: 0.5; cursor: not-allowed;" disabled>Out of Stock</button>
                                    <span style="font-size: 14px; color: #ef4444;">● All copies currently loaned</span>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Metadata Tab -->
                    <div class="tab-panel" id="tab-metadata" style="display: none;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 15px 0; color: var(--text-secondary); width: 150px;">ISBN</td>
                                <td style="padding: 15px 0; font-family: var(--font-mono); color: var(--text-primary);">{{ $resource->isbn ?: 'N/A' }}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 15px 0; color: var(--text-secondary);">Publisher</td>
                                <td style="padding: 15px 0; color: var(--text-primary);">{{ $resource->publisher ?: 'N/A' }}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 15px 0; color: var(--text-secondary);">Published Year</td>
                                <td style="padding: 15px 0; color: var(--text-primary);">{{ $resource->published_year ?: 'N/A' }}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 15px 0; color: var(--text-secondary);">Page Count</td>
                                <td style="padding: 15px 0; color: var(--text-primary);">{{ $resource->pages ?: 'N/A' }} pages</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 15px 0; color: var(--text-secondary);">Language</td>
                                <td style="padding: 15px 0; color: var(--text-primary);">{{ $resource->language }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Availability Tab -->
                    <div class="tab-panel" id="tab-availability" style="display: none;">
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                            <div class="glass-panel" style="padding: 20px; text-align: center; border-radius: 8px;">
                                <div style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 10px;">Total Copies</div>
                                <div style="font-size: 28px; font-weight: 700; color: var(--text-primary);">{{ $resource->total_copies }}</div>
                            </div>
                            <div class="glass-panel" style="padding: 20px; text-align: center; border-radius: 8px;">
                                <div style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 10px;">Available</div>
                                <div style="font-size: 28px; font-weight: 700; color: var(--accent-emerald);">{{ $resource->available_copies }}</div>
                            </div>
                            <div class="glass-panel" style="padding: 20px; text-align: center; border-radius: 8px;">
                                <div style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 10px;">Average Rating</div>
                                <div style="font-size: 28px; font-weight: 700; color: var(--accent-gold);">★ {{ number_format($resource->rating, 1) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-panel" id="tab-reviews" style="display: none;">
                        <!-- Review list -->
                        <div style="display: flex; flex-direction: column; gap: 25px;">
                            @forelse($resource->reviews as $review)
                                <div class="glass-panel" style="padding: 20px; border-radius: 8px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                        <span style="font-weight: 600;">{{ $review->user->name }}</span>
                                        <span style="color: var(--accent-gold);">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                                    </div>
                                    <p style="color: var(--text-secondary); font-size: 14px;">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <div style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                    <p>No critical reviews registered. Be the first to express an opinion.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Borrow Modal Overlay -->
<div id="borrow-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(4,6,11,0.9); z-index: 10000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
    <div class="glass-panel" style="width: 450px; padding: 40px; border-radius: 12px; text-align: center; box-shadow: var(--shadow-glow);">
        <h2 style="font-family: var(--font-serif); font-size: 28px; color: var(--accent-gold); margin-bottom: 15px;">Confirm Checkout</h2>
        <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 30px;">You are about to borrow "{{ $resource->title }}". You will have 14 days to return this resource before it is flagged as overdue.</p>
        
        <div style="display: flex; justify-content: center; gap: 20px;">
            <button onclick="closeBorrowModal()" style="background: transparent; border: 1px solid var(--text-secondary); color: var(--text-secondary); padding: 12px 30px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 600; text-transform: uppercase;">Cancel</button>
            <button onclick="executeBorrow()" class="nav-btn" style="padding: 12px 30px;">Proceed</button>
        </div>
    </div>
</div>

<style>
/* Tab Button Styling */
.tab-btn {
    background: transparent;
    border: none;
    outline: none;
    color: var(--text-secondary);
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    padding: 10px 0;
    position: relative;
    transition: color 0.3s;
}
.tab-btn.active, .tab-btn:hover {
    color: var(--accent-gold);
}
.tab-btn::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 0;
    height: 2px;
    background-color: var(--accent-gold);
    transition: width 0.3s ease;
}
.tab-btn.active::after {
    width: 100%;
}
</style>

<script>
// Inline JS to handle detail tabs switching with animations
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;

            // Remove active status
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => {
                p.style.display = 'none';
                p.classList.remove('active');
            });

            // Set active
            tab.classList.add('active');
            const targetPanel = document.getElementById('tab-' + target);
            targetPanel.style.display = 'block';
            targetPanel.classList.add('active');
            
            // Simple GSAP animate if loaded
            if (window.gsap) {
                window.gsap.fromTo(targetPanel, 
                    { opacity: 0, y: 15 },
                    { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' }
                );
            }
        });
    });
});

function borrowResource() {
    document.getElementById('borrow-modal').style.display = 'flex';
}

function closeBorrowModal() {
    document.getElementById('borrow-modal').style.display = 'none';
}

function executeBorrow() {
    document.getElementById('borrow-form').submit();
}
</script>
@endsection
