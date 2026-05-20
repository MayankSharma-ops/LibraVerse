import { gsap } from 'gsap';

export function initSearchAnimation() {
    const input = document.getElementById('live-search-input');
    const executeBtn = document.getElementById('search-execute-btn');
    const voiceBtn = document.getElementById('voice-search-trigger');
    const voiceOverlay = document.getElementById('voice-overlay');
    const voiceClose = document.getElementById('voice-close-btn');
    const voiceTranscript = document.getElementById('voice-transcript');
    const resultsGrid = document.getElementById('results-grid');
    const categoryFilter = document.getElementById('category-filter');
    const sortFilter = document.getElementById('sort-filter');
    const yearFrom = document.getElementById('year-from');
    const yearTo = document.getElementById('year-to');
    const availabilityFilter = document.getElementById('availability-filter');
    const typeRadios = document.querySelectorAll('input[name="type"]');

    if (!input) return;

    // Stagger load initial results
    staggerCards();

    function staggerCards() {
        const cards = resultsGrid.querySelectorAll('.result-card');
        gsap.fromTo(cards, 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.5, stagger: 0.08, ease: 'power2.out' }
        );
    }

    // Trigger AJAX Search
    function performSearch() {
        // Simple loading spin indicator
        resultsGrid.style.opacity = 0.5;

        const params = new URLSearchParams();
        params.append('q', input.value);
        params.append('category', categoryFilter.value);
        params.append('sort', sortFilter.value);
        params.append('year_from', yearFrom.value);
        params.append('year_to', yearTo.value);
        if (availabilityFilter.checked) {
            params.append('availability', 'available');
        }
        
        const checkedType = document.querySelector('input[name="type"]:checked');
        if (checkedType && checkedType.value) {
            params.append('type', checkedType.value);
        }

        fetch(`/search/results?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            resultsGrid.innerHTML = data.html;
            resultsGrid.style.opacity = 1;
            staggerCards();
            
            const resultsCount = document.getElementById('results-count');
            if (resultsCount) {
                resultsCount.textContent = `Found ${data.total} matching resources`;
            }
        });
    }

    // Bind event listeners
    executeBtn.addEventListener('click', performSearch);
    input.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') performSearch();
    });

    categoryFilter.addEventListener('change', performSearch);
    sortFilter.addEventListener('change', performSearch);
    yearFrom.addEventListener('input', performSearch);
    yearTo.addEventListener('input', performSearch);
    availabilityFilter.addEventListener('change', performSearch);
    typeRadios.forEach(radio => radio.addEventListener('change', performSearch));

    // Voice search simulated flow
    voiceBtn.addEventListener('click', () => {
        voiceOverlay.style.display = 'flex';
        gsap.fromTo(voiceOverlay, { opacity: 0 }, { opacity: 1, duration: 0.4 });
        
        // Simulate listening transcription
        setTimeout(() => {
            voiceTranscript.textContent = '"Algorithms and Data Structures..."';
        }, 1500);

        setTimeout(() => {
            voiceTranscript.textContent = '"Searching for Algorithms..."';
            input.value = 'Algorithms';
        }, 3000);

        setTimeout(() => {
            closeVoice();
            performSearch();
        }, 4500);
    });

    function closeVoice() {
        gsap.to(voiceOverlay, {
            opacity: 0,
            duration: 0.4,
            onComplete: () => {
                voiceOverlay.style.display = 'none';
                voiceTranscript.textContent = '"Search Computer Science Books..."';
            }
        });
    }

    voiceClose.addEventListener('click', closeVoice);
}
