import { gsap } from 'gsap';

export function initDashboardAnimation() {
    const counters = document.querySelectorAll('.stat-counter');
    const widgets = document.querySelectorAll('.stat-widget-card');
    const bars = document.querySelectorAll('.chart-bar');
    
    // 1. Stagger reveal widgets
    gsap.fromTo(widgets, 
        { y: 30, opacity: 0 }, 
        { y: 0, opacity: 1, duration: 0.6, ease: 'power2.out', stagger: 0.15 }
    );

    // 2. Count up stats using GSAP roundProps
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.target || '0', 10);
        
        // Setup initial value
        const obj = { val: 0 };
        gsap.to(obj, {
            val: target,
            duration: 2,
            ease: 'power2.out',
            delay: 0.4,
            onUpdate: () => {
                counter.textContent = Math.round(obj.val);
            }
        });
    });

    // 3. Draw chart bars
    bars.forEach((bar, idx) => {
        const targetHeight = bar.dataset.height || '0%';
        gsap.to(bar, {
            height: targetHeight,
            duration: 1.2,
            delay: 0.6 + idx * 0.1,
            ease: 'power3.out'
        });
    });

    // 4. Animate SVG Pie segments drawing
    const pieSegments = document.querySelectorAll('.pie-segment');
    pieSegments.forEach(segment => {
        const percent = parseInt(segment.dataset.percent || '0', 10);
        
        gsap.to(segment, {
            strokeDasharray: `${percent} ${100 - percent}`,
            duration: 1.5,
            delay: 0.8,
            ease: 'power3.out'
        });
    });
}
