import { gsap } from 'gsap';

export function initCursor() {
    const cursor = document.getElementById('custom-cursor');
    const cursorDot = document.getElementById('custom-cursor-dot');
    
    if (!cursor || !cursorDot) return;

    let mouseX = 0;
    let mouseY = 0;

    window.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        // Immediately move dot
        gsap.to(cursorDot, {
            x: mouseX,
            y: mouseY,
            duration: 0.1,
            ease: 'power2.out'
        });

        // Delay move ring
        gsap.to(cursor, {
            x: mouseX,
            y: mouseY,
            duration: 0.3,
            ease: 'power2.out'
        });
    });

    // Hover effect on books/interactives
    const hoverables = document.querySelectorAll('.result-card, .detail-book-cover, .story-book, .falling-book');
    hoverables.forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursor.classList.add('hovered');
            cursor.innerHTML = 'Explore';
        });
        el.addEventListener('mouseleave', () => {
            cursor.classList.remove('hovered');
            cursor.innerHTML = '';
        });
    });

    // Magnetic buttons attraction
    const buttons = document.querySelectorAll('.nav-btn, .search-btn, .tab-btn');
    buttons.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            gsap.to(btn, {
                x: x * 0.3,
                y: y * 0.3,
                duration: 0.3,
                ease: 'power2.out'
            });

            gsap.to(cursor, {
                scale: 1.5,
                borderColor: 'var(--accent-gold)',
                duration: 0.3
            });
        });

        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, {
                x: 0,
                y: 0,
                duration: 0.5,
                ease: 'elastic.out(1, 0.3)'
            });

            gsap.to(cursor, {
                scale: 1,
                borderColor: 'rgba(234, 179, 8, 0.5)',
                duration: 0.3
            });
        });
    });
}
