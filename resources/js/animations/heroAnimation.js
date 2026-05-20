import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initHeroAnimation() {
    const typewriter = document.getElementById('typewriter-search');
    const heroTitle = document.querySelector('.hero-title');
    const heroSubtitle = document.querySelector('.hero-subtitle');
    const searchWrapper = document.querySelector('.search-bar-wrapper');
    const fallingBookWrapper = document.querySelector('.falling-book-wrapper');
    const layers = document.querySelectorAll('.parallax-layer');

    if (!typewriter) return;

    // 1. Text slide-up & bar expand
    gsap.fromTo(heroTitle.querySelectorAll('.word'), 
        { y: 50, opacity: 0 }, 
        { y: 0, opacity: 1, duration: 1, ease: 'power4.out', stagger: 0.2 }
    );

    gsap.fromTo(heroSubtitle, 
        { y: 30, opacity: 0 }, 
        { y: 0, opacity: 1, duration: 1, delay: 0.4, ease: 'power3.out' }
    );

    gsap.fromTo(searchWrapper, 
        { scaleX: 0.5, opacity: 0 }, 
        { scaleX: 1, opacity: 1, duration: 0.8, delay: 0.6, ease: 'back.out(1.5)' }
    );

    // 2. Typewriter search animation
    const searchPhrases = [
        'Search Books...',
        'Search Journals...',
        'Search Research Papers...',
        'Search eBooks...'
    ];
    let phraseIndex = 0;
    let letterIndex = 0;
    let isDeleting = false;

    function type() {
        const currentPhrase = searchPhrases[phraseIndex];
        
        if (isDeleting) {
            typewriter.placeholder = currentPhrase.substring(0, letterIndex - 1);
            letterIndex--;
        } else {
            typewriter.placeholder = currentPhrase.substring(0, letterIndex + 1);
            letterIndex++;
        }

        let speed = isDeleting ? 50 : 100;

        if (!isDeleting && letterIndex === currentPhrase.length) {
            speed = 2000; // Pause at end of phrase
            isDeleting = true;
        } else if (isDeleting && letterIndex === 0) {
            isDeleting = false;
            phraseIndex = (phraseIndex + 1) % searchPhrases.length;
            speed = 500; // Pause before next phrase
        }

        setTimeout(type, speed);
    }
    setTimeout(type, 1000);

    // 3. Mouse Parallax layers
    window.addEventListener('mousemove', (e) => {
        const x = (e.clientX - window.innerWidth / 2) / window.innerWidth;
        const y = (e.clientY - window.innerHeight / 2) / window.innerHeight;

        layers.forEach(layer => {
            const speed = layer.dataset.speed || 0.2;
            gsap.to(layer, {
                x: x * 100 * speed,
                y: y * 100 * speed,
                duration: 0.6,
                ease: 'power2.out'
            });
        });
    });

    // 4. Floating Parallax Book Objects
    layers.forEach(layer => {
        gsap.to(layer, {
            y: '+=20',
            rotation: '+=10',
            duration: 'random(3, 6)',
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });
    });

    // 5. PHYSICAL GRAVITY BOOK DROP ANIMATION
    // As the user scrolls down slightly, the book drops from the top and lands on the shelf with a bounce.
    if (fallingBookWrapper) {
        const frontCover = fallingBookWrapper.querySelector('.f-cover.front');
        const page = fallingBookWrapper.querySelector('.f-page');

        // Create a Timeline for the falling book
        const dropTl = gsap.timeline({ 
            paused: true,
            onComplete: () => {
                initScrollAnimations();
            }
        });

        // Set initial positions
        gsap.set(fallingBookWrapper, { 
            y: -400, 
            rotationX: 180, 
            rotationY: 45, 
            rotationZ: -120 
        });
        if (frontCover) gsap.set(frontCover, { transformOrigin: 'left center', rotateY: 0 });
        if (page) gsap.set(page, { transformOrigin: 'left center', rotateY: 0 });

        // Build the animation (Duration: 2.2 seconds total)
        dropTl.to(fallingBookWrapper, {
            y: 60,
            rotationX: 20,
            rotationY: -30,
            rotationZ: 0,
            duration: 2.2,
            ease: 'bounce.out'
        });

        // Add cover/page flutter as the book falls
        if (frontCover && page) {
            dropTl.to(frontCover, {
                rotateY: -45,
                duration: 0.7,
                yoyo: true,
                repeat: 1,
                ease: 'power1.inOut'
            }, 0.2)
            .to(page, {
                rotateY: -25,
                duration: 0.6,
                yoyo: true,
                repeat: 1,
                ease: 'power1.inOut'
            }, 0.3);
        }

        // Setup auto-play on page load (right after preloader closes)
        gsap.delayedCall(0.3, () => {
            dropTl.play();
        });

        function initScrollAnimations() {
            // 6. SCROLL FLIGHT & FLIP ANIMATION
            // As the user scrolls down, the book rises from the shelf and opens (flips pages)
            gsap.fromTo(fallingBookWrapper,
                {
                    y: 60,
                    rotationX: 20,
                    rotationY: -30,
                    rotationZ: 0
                },
                {
                    y: -350,
                    rotationX: -45,
                    rotationY: 45,
                    rotationZ: 15,
                    scrollTrigger: {
                        trigger: '#hero',
                        start: 'top top',
                        end: 'bottom top',
                        scrub: 1,
                        immediateRender: false
                    }
                }
            );

            if (frontCover) {
                gsap.fromTo(frontCover,
                    { rotateY: 0 },
                    {
                        rotateY: -150,
                        scrollTrigger: {
                            trigger: '#hero',
                            start: 'top top',
                            end: 'bottom top',
                            scrub: 1,
                            immediateRender: false
                        }
                    }
                );
            }

            if (page) {
                gsap.fromTo(page,
                    { rotateY: 0 },
                    {
                        rotateY: -130,
                        scrollTrigger: {
                            trigger: '#hero',
                            start: 'top top',
                            end: 'bottom top',
                            scrub: 1,
                            immediateRender: false
                        }
                    }
                );
            }
        }
    }
}
