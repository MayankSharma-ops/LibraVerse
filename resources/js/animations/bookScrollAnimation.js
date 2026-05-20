import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initBookScrollAnimation() {
    const section = document.getElementById('storytelling');
    const container = document.querySelector('.story-pinned-container');
    const book = document.querySelector('.story-book');
    const p1 = document.getElementById('sp-page1');
    const p2 = document.getElementById('sp-page2');
    const p3 = document.getElementById('sp-page3');
    const p4 = document.getElementById('sp-page4');
    const p5 = document.getElementById('sp-page5');

    if (!section || !container || !book) return;

    // Make the pinned container visible when we enter this section
    gsap.set(container, { autoAlpha: 0 });

    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: section,
            start: 'top top',
            end: 'bottom bottom',
            scrub: 1.5,
            pin: true,
            onEnter: () => gsap.set(container, { autoAlpha: 1 }),
            onLeave: () => gsap.set(container, { autoAlpha: 0 }),
            onEnterBack: () => gsap.set(container, { autoAlpha: 1 }),
            onLeaveBack: () => gsap.set(container, { autoAlpha: 0 }),
        }
    });

    // Animate pages flip one-by-one
    tl.to(book, { rotateY: -10, duration: 1 }) // Open perspective shift
      .to(p1, { rotateY: -180, duration: 2, ease: 'power2.inOut' }) // Flip page 1
      .to(p2, { rotateY: -178, duration: 2, ease: 'power2.inOut' }, '+=0.5') // Flip page 2
      .to(p3, { rotateY: -176, duration: 2, ease: 'power2.inOut' }, '+=0.5') // Flip page 3
      .to(p4, { rotateY: -174, duration: 2, ease: 'power2.inOut' }, '+=0.5') // Flip page 4
      .to(p5, { rotateY: -172, duration: 2, ease: 'power2.inOut' }, '+=0.5') // Flip page 5
      // 3D Exit Animation: book spins, collapses, and fades out
      .to(book, {
          rotateX: 45,
          rotateY: -270,
          scale: 0.2,
          opacity: 0,
          duration: 3.5,
          ease: 'power2.inOut'
      }, '+=0.5')
      // Fade in the premium end quote message
      .to('.story-end-message', {
          opacity: 1,
          scale: 1,
          duration: 3.5,
          ease: 'power2.out'
      }, '-=2.0') // Overlap with book exit
      // Hold the message, then fade it out before the container is unpinned
      .to('.story-end-message', {
          opacity: 0,
          scale: 0.9,
          duration: 3.0,
          ease: 'power2.in'
      }, '+=2.0');
}
