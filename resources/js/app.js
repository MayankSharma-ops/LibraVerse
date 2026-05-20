import './bootstrap';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Import custom animations
import { initPreloader, initTransitions } from './animations/preloader';
import { initCursor } from './animations/cursorEffects';
import { initHeroAnimation } from './animations/heroAnimation';
import { initBookScrollAnimation } from './animations/bookScrollAnimation';
import { initDashboardAnimation } from './animations/dashboardAnimation';
import { initSearchAnimation } from './animations/searchAnimation';
import { initCorridorAnimation } from './animations/corridorAnimation';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Lenis Smooth Scrolling
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        orientation: 'vertical',
        gestureOrientation: 'vertical'
    });

    // Synchronize Lenis with GSAP's Ticker
    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    gsap.ticker.lagSmoothing(0);

    // 2. Start preloader first. Once completed, initialize the rest of the animations
    initPreloader(() => {
        // Initialize global effects
        initCursor();
        initTransitions();

        // Navbar scrolled background class toggle
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Initialize page-specific animations
        if (document.getElementById('hero')) {
            initHeroAnimation();
        }
        
        if (document.getElementById('storytelling')) {
            initBookScrollAnimation();
        }

        if (document.getElementById('corridor-section')) {
            initCorridorAnimation();
        }

        if (document.getElementById('live-search-input')) {
            initSearchAnimation();
        }

        if (document.querySelector('.dashboard-section')) {
            initDashboardAnimation();
        }
    });
});
