@extends('layouts.app')

@section('title', '404 — Volume Lost')

@section('content')
<section style="height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; z-index: 10; overflow: hidden; background: radial-gradient(circle at center, #0f172a 0%, #04060b 80%);">
    <!-- Floating pages particles in HTML/CSS -->
    <div class="flying-page fp-1" style="position: absolute; width: 60px; height: 80px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: 2px; top: 20%; left: 20%; transform: rotate(45deg); pointer-events: none;"></div>
    <div class="flying-page fp-2" style="position: absolute; width: 80px; height: 100px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 2px; top: 60%; left: 75%; transform: rotate(-35deg); pointer-events: none;"></div>
    <div class="flying-page fp-3" style="position: absolute; width: 50px; height: 70px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); border-radius: 2px; top: 30%; left: 80%; transform: rotate(15deg); pointer-events: none;"></div>
    <div class="flying-page fp-4" style="position: absolute; width: 70px; height: 90px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 2px; top: 75%; left: 15%; transform: rotate(-65deg); pointer-events: none;"></div>

    <div class="container" style="text-align: center; display: flex; flex-direction: column; align-items: center; gap: 30px; position: relative; z-index: 5;">
        <!-- 3D Lost Book Visual -->
        <div style="perspective: 1000px; width: 140px; height: 180px; margin-bottom: 20px;">
            <div id="lost-book-3d" style="width: 100%; height: 100%; position: relative; transform-style: preserve-3d; transform: rotateX(25deg) rotateY(-45deg) rotateZ(10deg); animation: floatLostBook 6s infinite ease-in-out;">
                <!-- Front Cover -->
                <div style="position: absolute; width: 100%; height: 100%; border-radius: 4px 10px 10px 4px; background: linear-gradient(135deg, #ef4444, #7f1d1d); border: 1px solid var(--accent-gold); display: flex; align-items: center; justify-content: center; font-size: 40px; color: white; backface-visibility: hidden; z-index: 2;">❓</div>
                <!-- Spine -->
                <div style="position: absolute; left: -6px; top: 0; width: 12px; height: 100%; background: #7f1d1d; transform: rotateY(-90deg) translateZ(6px); border-radius: 2px;"></div>
                <!-- Pages -->
                <div style="position: absolute; right: -8px; top: 2%; width: 16px; height: 96%; background: #e2e8f0; transform: rotateY(90deg) translateZ(128px); border-radius: 0 3px 3px 0;"></div>
                <!-- Back Cover -->
                <div style="position: absolute; width: 100%; height: 100%; border-radius: 10px 4px 4px 10px; background: #7f1d1d; transform: translateZ(-12px); z-index: 1;"></div>
            </div>
        </div>

        <h1 style="font-family: var(--font-serif); font-size: 80px; font-weight: 800; color: #ef4444; line-height: 1; text-shadow: 0 0 30px rgba(239, 68, 68, 0.2);">404</h1>
        <h2 style="font-family: var(--font-serif); font-size: 32px; color: var(--text-primary); margin-top: -10px;">Volume Missing from Catalog</h2>
        <p style="color: var(--text-secondary); max-width: 500px; font-size: 16px; margin-bottom: 20px;">The requested URL points to a record node that has been relocated, archived, or does not exist in our system.</p>
        
        <a href="{{ route('home') }}" class="nav-btn btn-ripple" style="padding: 15px 40px; font-size: 14px; border-radius: 8px;">Return to Library</a>
    </div>
</section>

<style>
/* CSS float lost book animation */
@keyframes floatLostBook {
    0%, 100% { transform: rotateX(25deg) rotateY(-45deg) rotateZ(10deg) translateY(0); }
    50% { transform: rotateX(15deg) rotateY(-35deg) rotateZ(5deg) translateY(-20px); }
}
</style>

<script>
// Simple GSAP page floating animations if loaded
document.addEventListener('DOMContentLoaded', () => {
    if (window.gsap) {
        window.gsap.to('.flying-page', {
            y: 'random(-50, 50)',
            x: 'random(-50, 50)',
            rotation: 'random(-180, 180)',
            duration: 10,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            stagger: 0.5
        });
    }
});
</script>
@endsection
