document.addEventListener('DOMContentLoaded', function() {

    /* ==========================================================================
       1. Mobile Menu Logic (Fixed & Robust)
       ========================================================================== */
    const hamburger = document.querySelector('.hamburger-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const mobileCloseBtn = document.querySelector('.mobile-menu-close'); 
    const body = document.body;
    
    // פונקציה לסגירת התפריט
    function closeMobileMenu() {
        if(hamburger) hamburger.classList.remove('active');
        if(mobileMenuOverlay) mobileMenuOverlay.classList.remove('active');
        // הסרת החסימה לגלילה אם הוספה
        if(body) body.classList.remove('no-scroll');
    }

    if (hamburger && mobileMenuOverlay) {
        // פתיחה/סגירה בלחיצה על ההמבורגר
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            // body.classList.toggle('no-scroll'); // אופציונלי - אם רוצים למנוע גלילה ברקע
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
            // הוספת בדיקה פשוטה יותר ל-viewport (קצת יותר סלחנית)
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                el.classList.add('visible');
            }
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); 

    /* ==========================================================================
       4. FAQ Accordion - אקורדיון שאלות ותשובות (מתוקן)
       ========================================================================== */
    const faqItems = document.querySelectorAll('.faq-item');

    if (faqItems.length > 0) {
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');

                // 1. סגירת כל השאלות האחרות
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    if(otherAnswer) otherAnswer.style.maxHeight = null;
                });

                // 2. אם השאלה הנוכחית לא הייתה פתוחה - נפתח אותה
                if (!isActive) {
                    item.classList.add('active');
                    // הגדרת גובה דינמית לאנימציה חלקה
                    answer.style.maxHeight = answer.scrollHeight + "px";
                } 
            });
        });
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
                        // איפוס אנימציה כדי שתרוץ שוב
                        item.style.animation = 'none';
                        item.offsetHeight; /* trigger reflow */
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

    /* ==========================================================================
       9. Hero Text Scroll Reveal Effect (New!)
       ========================================================================== */
    function handleHeroTextReveal() {
        const heroSection = document.querySelector('.hero-section');
        const heroText = document.querySelector('.hero-text');

        if (!heroSection || !heroText) return;

        function updateTextOpacity() {
            const scrollY = window.scrollY || window.pageYOffset;
            const heroHeight = heroSection.offsetHeight;
            const startOffset = heroSection.offsetTop;
            const endOffset = startOffset + heroHeight * 0.6;
            let progress = (scrollY - startOffset) / (endOffset - startOffset);
            progress = Math.max(0, Math.min(1, progress));
            
            // מ-0.2 ל-1
            const minOpacity = 0.2;
            const maxOpacity = 1;
            const currentOpacity = minOpacity + (progress * (maxOpacity - minOpacity));

            heroText.style.setProperty('--hero-text-opacity', currentOpacity);
        }

        window.addEventListener('scroll', updateTextOpacity, { passive: true });
        updateTextOpacity();
    }
    
    // הפעלה
    handleHeroTextReveal();


    /* ==========================================================================
       10. Timeline Animation Bundle (Line Progress + Items Fade In)
       ========================================================================== */
    const timelineSection = document.querySelector('.guide-timeline-section');
    const timeline = document.querySelector('.timeline');
    const timelineItems = document.querySelectorAll('.js-scroll-trigger');

    function handleTimelineAnimations() {
        if (!timeline) return;

        // 1. לוגיקת הקו המתמלא (The Red Line)
        const timelineTop = timeline.offsetTop;
        const timelineHeight = timeline.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollY = window.scrollY || window.pageYOffset;
        
        // הקו מתחיל להתמלא כשאמצע המסך מגיע לתחילת הטיימליין
        const triggerPoint = scrollY + windowHeight / 2;
        let progressPx = triggerPoint - timelineTop;
        let progressPercent = (progressPx / timelineHeight) * 100;
        progressPercent = Math.max(0, Math.min(100, progressPercent));
        
        timeline.style.setProperty('--line-progress', `${progressPercent}%`);

        // 2. לוגיקת הופעת הכרטיסים (Fade In Items)
        const itemTriggerBottom = window.innerHeight / 5 * 4; // 80% גובה מסך

        timelineItems.forEach(item => {
            const itemTop = item.getBoundingClientRect().top;

            if (itemTop < itemTriggerBottom) {
                item.classList.add('visible'); // זה הקלאס שמחזיר את ה-Opacity ל-1
            }
        });
    }

    // הפעלה
    if (timelineSection) {
        window.addEventListener('scroll', handleTimelineAnimations, { passive: true });
        window.addEventListener('resize', handleTimelineAnimations);
        handleTimelineAnimations();
        window.addEventListener('load', handleTimelineAnimations);
    }

    /* ==========================================================================
       11. Interactive Service Cards Glow Effect (New!)
       ========================================================================== */
    const serviceCards = document.querySelectorAll('.service-card');

    if (serviceCards.length > 0) {
        serviceCards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                // קבלת מיקום וגודל הכרטיס במסך
                const rect = card.getBoundingClientRect();
                // חישוב מיקום העכבר יחסית לפינה השמאלית-עליונה של הכרטיס
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // עדכון משתני CSS דינמיים בתוך האלמנט הספציפי
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });
    }

}); // End DOMContentLoaded