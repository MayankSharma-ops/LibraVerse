import { gsap } from 'gsap';

export function initPreloader(onComplete) {
    const preloader = document.getElementById('preloader');
    const counter = document.querySelector('.preload-counter');
    const p1 = document.querySelector('.preload-page.p1');
    const p2 = document.querySelector('.preload-page.p2');
    const p3 = document.querySelector('.preload-page.p3');
    const logo = document.querySelector('.preload-logo');
    
    if (!preloader) {
        if (onComplete) onComplete();
        return;
    }

    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.floor(Math.random() * 8) + 2;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
            
            // Trigger exit sequence
            exitSequence();
        }
        counter.textContent = String(progress).padStart(2, '0') + '%';
    }, 100);

    // Initial page flappings in background
    const tl = gsap.timeline({ repeat: -1 });
    tl.to(p1, { rotateY: -180, duration: 1.2, ease: 'power1.inOut' })
      .to(p2, { rotateY: -180, duration: 1.2, ease: 'power1.inOut' }, '-=0.8')
      .to(p3, { rotateY: -180, duration: 1.2, ease: 'power1.inOut' }, '-=0.8')
      .to([p1, p2, p3], { rotateY: 0, duration: 0.8, ease: 'power1.inOut', stagger: 0.1 });

    function exitSequence() {
        // Kill background page turn loop
        tl.kill();

        const exitTl = gsap.timeline({
            onComplete: () => {
                preloader.style.display = 'none';
                if (onComplete) onComplete();
            }
        });

        exitTl.to(p1, { rotateY: -180, duration: 0.5, ease: 'power2.inOut' })
              .to(p2, { rotateY: -180, duration: 0.5, ease: 'power2.inOut' }, '-=0.3')
              .to(p3, { rotateY: -180, duration: 0.5, ease: 'power2.inOut' }, '-=0.3')
              .to(logo, { opacity: 1, scale: 1.2, duration: 0.6, ease: 'back.out(2)' }, '-=0.2')
              .to(preloader, { opacity: 0, duration: 0.8, ease: 'power2.out' }, '+=0.5');
    }
}

export function initTransitions() {
    const overlay = document.getElementById('page-transition-overlay');
    const links = document.querySelectorAll('a[data-transition]');

    if (!overlay) return;

    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const href = link.getAttribute('href');

            // Slide Transition Overlay Up
            gsap.timeline({
                onComplete: () => {
                    window.location.href = href;
                }
            })
            .to(overlay, {
                y: '0%',
                duration: 0.6,
                ease: 'power3.inOut'
            })
            .to(overlay.querySelector('.preload-book'), {
                rotateY: -15,
                rotateX: 15,
                duration: 0.4
            });
        });
    });

    // If we just landed on page (slide overlay down to reveal content)
    gsap.fromTo(overlay, 
        { y: '0%' },
        { y: '-100%', duration: 0.8, ease: 'power3.inOut', delay: 0.2, pointerEvents: 'none' }
    );
}
