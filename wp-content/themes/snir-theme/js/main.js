document.addEventListener('DOMContentLoaded', function() {

    /* ==========================================================================
       1. Mobile Menu Logic (With Close Button)
       ========================================================================== */
    const hamburger = document.querySelector('.hamburger-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const mobileCloseBtn = document.querySelector('.mobile-menu-close'); // כפתור הסגירה החדש
    const body = document.body;
    
    // פונקציה לסגירת התפריט
    function closeMobileMenu() {
        if(hamburger) hamburger.classList.remove('active');
        if(mobileMenuOverlay) mobileMenuOverlay.classList.remove('active');
        if(body) body.classList.remove('no-scroll');
    }

    if (hamburger && mobileMenuOverlay) {
        // פתיחה/סגירה בלחיצה על ההמבורגר
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            body.classList.toggle('no-scroll');
        });

        // סגירה בלחיצה על כפתור ה-X החדש
        if (mobileCloseBtn) {
            mobileCloseBtn.addEventListener('click', closeMobileMenu);
        }

        // סגירת התפריט בלחיצה על קישור פנימי
        const mobileLinks = mobileMenuOverlay.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    /* ==========================================================================
       2. Dark/Light Mode Toggle
       ========================================================================== */
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-mode');
        }

        themeToggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                localStorage.setItem('theme', 'light');
            } else {
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    /* ==========================================================================
       3. Scroll Animations & Elements Viewport
       ========================================================================== */
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function handleScroll() {
        const fadeElements = document.querySelectorAll('.fade-in-up, .image-col');
        fadeElements.forEach(el => {
            if (isElementInViewport(el)) el.classList.add('visible');
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); 

    /* ==========================================================================
       4. Client Gallery Lightbox (BaguetteBox)
       ========================================================================== */
    const galleryContainer = document.querySelector('.project-gallery-grid');
    if (galleryContainer) {
        if (typeof baguetteBox === 'function') {
            try { baguetteBox.run('.project-gallery-grid'); } catch (e) {}
        } else {
            // טעינה דינמית אם צריך
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js';
            script.async = true;
            script.onload = function() { try { baguetteBox.run('.project-gallery-grid'); } catch (e) {} };
            document.body.appendChild(script);
            
            const cssLink = document.createElement('link');
            cssLink.rel = 'stylesheet';
            cssLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css';
            document.head.appendChild(cssLink);
        }
    }

    /* ==========================================================================
       5. Swiper Carousels (Reviews & Projects)
       ========================================================================== */
    // Reviews
    const reviewsSlider = document.querySelector('.reviews-slider');
    if (reviewsSlider && typeof Swiper === 'function') {
        new Swiper('.reviews-slider', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: { nextEl: '.reviews-arrow-next', prevEl: '.reviews-arrow-prev' },
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 30 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    }

    // Projects
    const projectsSliderEl = document.querySelector('.projects-slider');
    if (projectsSliderEl && typeof Swiper === 'function') {
        new Swiper('.projects-slider', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: { nextEl: '.projects-arrow-next', prevEl: '.projects-arrow-prev' },
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 30 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    }

    /* ==========================================================================
       6. Custom Video Player
       ========================================================================== */
    const videoContainer = document.querySelector('.custom-video-player');
    if (videoContainer) {
        const video = videoContainer.querySelector('video');
        const playBtn = videoContainer.querySelector('.play-overlay-btn');

        function playVideo() {
            videoContainer.classList.add('is-playing');
            video.play();
            video.controls = true;
        }

        if (playBtn) playBtn.addEventListener('click', playVideo);
        if (video) video.addEventListener('click', function() { if (video.paused) playVideo(); });
    }

    /* ==========================================================================
       7. Portfolio Filter (Archive Page)
       ========================================================================== */
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    if (filterButtons.length > 0 && projectItems.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filterValue = btn.getAttribute('data-filter');

                projectItems.forEach(item => {
                    if (filterValue === 'all') {
                        item.classList.remove('hide');
                        item.style.animation = 'none';
                        item.offsetHeight; 
                        item.style.animation = null;
                    } else {
                        if (item.classList.contains(filterValue)) {
                            item.classList.remove('hide');
                            item.style.animation = 'none';
                            item.offsetHeight;
                            item.style.animation = null;
                        } else {
                            item.classList.add('hide');
                        }
                    }
                });
            });
        });
    }

    /* ==========================================================================
       8. AJAX Live Search
       ========================================================================== */
    const searchTrigger = document.getElementById('search-trigger-btn');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.querySelector('.search-close-btn');
    const searchInput = document.getElementById('live-search-input');
    const searchResults = document.getElementById('live-search-results');
    const searchSpinner = document.querySelector('.search-spinner');

    if(searchTrigger && searchOverlay) {
        searchTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            searchOverlay.classList.add('active');
            setTimeout(() => searchInput.focus(), 100);
        });

        searchClose.addEventListener('click', function() {
            searchOverlay.classList.remove('active');
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                searchOverlay.classList.remove('active');
            }
        });
    }

    let typingTimer;
    const doneTypingInterval = 500;

    if(searchInput) {
        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            const keyword = this.value;
            
            if (keyword.length < 2) {
                searchResults.innerHTML = '';
                return;
            }

            searchSpinner.classList.add('loading');

            typingTimer = setTimeout(function() {
                if (typeof snirAjax !== 'undefined') {
                    const formData = new FormData();
                    formData.append('action', 'snir_live_search');
                    formData.append('keyword', keyword);

                    fetch(snirAjax.ajax_url, { method: 'POST', body: formData })
                    .then(response => response.text())
                    .then(html => {
                        searchResults.innerHTML = html;
                        searchSpinner.classList.remove('loading');
                    })
                    .catch(error => {
                        console.error(error);
                        searchSpinner.classList.remove('loading');
                    });
                }
            }, doneTypingInterval);
        });
    }

}); // End DOMContentLoaded