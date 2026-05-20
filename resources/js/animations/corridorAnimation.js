import * as THREE from 'three';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initCorridorAnimation() {
    const canvas = document.getElementById('webgl-background');
    const triggerSection = document.getElementById('corridor-section');
    const overlay = document.querySelector('.corridor-overlay-content');
    
    if (!canvas || !triggerSection) return;

    // 1. Setup Three Scene
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x04060b, 0.015);

    // Camera
    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(0, 0, 10);

    // Renderer
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(window.innerWidth, window.innerHeight);

    // Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
    scene.add(ambientLight);

    const pointLightLeft = new THREE.PointLight(0xeab308, 2, 50);
    pointLightLeft.position.set(-5, 0, 5);
    scene.add(pointLightLeft);

    const pointLightRight = new THREE.PointLight(0x3b82f6, 2, 50);
    pointLightRight.position.set(5, 0, 5);
    scene.add(pointLightRight);

    // 2. Build 3D Corridor
    // Generate bookshelves along both sides of Z axis
    const corridorGroup = new THREE.Group();
    scene.add(corridorGroup);

    const bookshelfWidth = 1;
    const bookshelfHeight = 8;
    const bookshelfDepth = 4;

    const shelfGeometry = new THREE.BoxGeometry(bookshelfWidth, bookshelfHeight, bookshelfDepth);
    const shelfMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x1e293b, 
        roughness: 0.8,
        metalness: 0.2
    });

    const bookColors = [0xef4444, 0x3b82f6, 0x10b981, 0xeab308, 0x8b5cf6, 0xf43f5e];

    // Populate shelves along the corridor (from z = 0 down to z = -100)
    for (let z = 0; z > -150; z -= 15) {
        // Left shelf
        const leftShelf = new THREE.Mesh(shelfGeometry, shelfMaterial);
        leftShelf.position.set(-6, 0, z);
        corridorGroup.add(leftShelf);

        // Right shelf
        const rightShelf = new THREE.Mesh(shelfGeometry, shelfMaterial);
        rightShelf.position.set(6, 0, z);
        corridorGroup.add(rightShelf);

        // Add some random books inside the shelves
        for (let y = -3; y <= 3; y += 1.2) {
            // Left shelf books
            const numBooksL = Math.floor(Math.random() * 4) + 3;
            for (let b = 0; b < numBooksL; b++) {
                const bookHeight = 0.6 + Math.random() * 0.4;
                const bookWidth = 0.15;
                const bookDepth = 1.2;
                const bookGeom = new THREE.BoxGeometry(bookWidth, bookHeight, bookDepth);
                const bookMat = new THREE.MeshStandardMaterial({
                    color: bookColors[Math.floor(Math.random() * bookColors.length)],
                    roughness: 0.5
                });
                const bookMesh = new THREE.Mesh(bookGeom, bookMat);
                bookMesh.position.set(-5.6, y, z - 1.5 + (b * 0.5));
                bookMesh.rotation.y = (Math.random() - 0.5) * 0.1;
                corridorGroup.add(bookMesh);
            }

            // Right shelf books
            const numBooksR = Math.floor(Math.random() * 4) + 3;
            for (let b = 0; b < numBooksR; b++) {
                const bookHeight = 0.6 + Math.random() * 0.4;
                const bookWidth = 0.15;
                const bookDepth = 1.2;
                const bookGeom = new THREE.BoxGeometry(bookWidth, bookHeight, bookDepth);
                const bookMat = new THREE.MeshStandardMaterial({
                    color: bookColors[Math.floor(Math.random() * bookColors.length)],
                    roughness: 0.5
                });
                const bookMesh = new THREE.Mesh(bookGeom, bookMat);
                bookMesh.position.set(5.6, y, z - 1.5 + (b * 0.5));
                bookMesh.rotation.y = (Math.random() - 0.5) * 0.1;
                corridorGroup.add(bookMesh);
            }
        }
    }

    // 3. Floating particles (dust)
    const particleCount = 600;
    const particleGeometry = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);

    for (let i = 0; i < particleCount * 3; i += 3) {
        positions[i] = (Math.random() - 0.5) * 15;      // X
        positions[i + 1] = (Math.random() - 0.5) * 10;  // Y
        positions[i + 2] = -Math.random() * 150;        // Z
    }

    particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    const particleMaterial = new THREE.PointsMaterial({
        color: 0xeab308,
        size: 0.08,
        transparent: true,
        opacity: 0.6
    });

    const particles = new THREE.Points(particleGeometry, particleMaterial);
    scene.add(particles);

    // 4. Floating keywords (Canvas Sprite textures)
    const keywords = ['ALGORITHMS', 'PHYSICS', 'CALCULUS', 'MANUSCRIPTS', 'DYNAMICS', 'CHRONICLES', 'KNOWLEDGE'];
    const textSprites = [];

    function createTextSprite(text, color) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 256;
        canvas.height = 64;
        
        ctx.fillStyle = 'rgba(0,0,0,0)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        ctx.font = 'Bold 24px "JetBrains Mono"';
        ctx.fillStyle = color;
        ctx.textAlign = 'center';
        ctx.fillText(text, 128, 40);

        const texture = new THREE.CanvasTexture(canvas);
        const spriteMaterial = new THREE.SpriteMaterial({ map: texture, transparent: true });
        const sprite = new THREE.Sprite(spriteMaterial);
        sprite.scale.set(4, 1, 1);
        return sprite;
    }

    for (let k = 0; k < 15; k++) {
        const word = keywords[Math.floor(Math.random() * keywords.length)];
        const color = k % 2 === 0 ? '#eab308' : '#3b82f6';
        const sprite = createTextSprite(word, color);
        
        sprite.position.set(
            (Math.random() - 0.5) * 6,
            (Math.random() - 0.5) * 4,
            -Math.random() * 120
        );
        scene.add(sprite);
        textSprites.push(sprite);
    }

    // 5. Scroll trigger linking
    // When the user enters the corridor section, pin/lock & fade the overlay text in
    gsap.set(overlay, { autoAlpha: 0 });

    ScrollTrigger.create({
        trigger: triggerSection,
        start: 'top top',
        end: 'bottom bottom',
        scrub: 1.5,
        onUpdate: (self) => {
            // Map scroll progress to camera moving along Z-axis
            const targetZ = 10 - self.progress * 130;
            gsap.to(camera.position, { z: targetZ, duration: 0.5, ease: 'power2.out' });
            
            // Adjust light positions to follow the camera
            pointLightLeft.position.z = camera.position.z - 5;
            pointLightRight.position.z = camera.position.z - 5;

            // Fade in overlay content near middle, fade out at end
            if (self.progress > 0.1 && self.progress < 0.9) {
                gsap.to(overlay, { autoAlpha: 1, duration: 0.3 });
            } else {
                gsap.to(overlay, { autoAlpha: 0, duration: 0.3 });
            }
        }
    });

    // 6. Interactive Mouse Movement Effect
    let targetMouseX = 0;
    let targetMouseY = 0;
    window.addEventListener('mousemove', (e) => {
        targetMouseX = (e.clientX - window.innerWidth / 2) / (window.innerWidth / 2);
        targetMouseY = (e.clientY - window.innerHeight / 2) / (window.innerHeight / 2);
    });

    // 7. Render Loop
    function animate() {
        requestAnimationFrame(animate);

        // Camera slight lazy follow mouse orientation
        camera.rotation.y += (targetMouseX * 0.15 - camera.rotation.y) * 0.05;
        camera.rotation.x += (-targetMouseY * 0.15 - camera.rotation.x) * 0.05;

        // Subtle animation to keywords and lights
        textSprites.forEach((sprite, index) => {
            sprite.position.y += Math.sin(Date.now() * 0.001 + index) * 0.002;
        });

        renderer.render(scene, camera);
    }
    animate();

    // Handle Resize
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
}
