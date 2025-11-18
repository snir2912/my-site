document.addEventListener('DOMContentLoaded', function() {

    /* ==========================================================================
       1. Mobile Menu Logic (Updated) - תפריט מובייל מעודכן
       ========================================================================== */
    const hamburger = document.querySelector('.hamburger-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const body = document.body;
    
    if (hamburger && mobileMenuOverlay) {
        // פתיחה/סגירה בלחיצה על ההמבורגר
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active'); // אנימציית ה-X בכפתור
            mobileMenuOverlay.classList.toggle('active'); // החלקת התפריט פנימה
            body.classList.toggle('no-scroll'); // מניעת גלילה ברקע
        });

        // סגירת התפריט בלחיצה על קישור פנימי
        const mobileLinks = mobileMenuOverlay.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                body.classList.remove('no-scroll');
            });
        });
    }

    /* ==========================================================================
       2. Dark/Light Mode Toggle - מצב לילה/יום
       ========================================================================== */
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        // בדיקת העדפה שמורה בטעינה
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-mode');
        }

        // החלפת מצב בלחיצה
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
       3. Font Size Control (Accessibility) - נגישות פונטים
       ========================================================================== */
    const contentContainer = document.querySelector('.single-post-content');
    const increaseBtn = document.getElementById('increase-font-size');
    const decreaseBtn = document.getElementById('decrease-font-size');
    const storageKey = 'user-font-size';

    if (contentContainer && increaseBtn && decreaseBtn) {
        const pElements = contentContainer.querySelectorAll('p');
        const defaultFontSize = 16;
        let currentFontSize = parseFloat(localStorage.getItem(storageKey)) || defaultFontSize;

        const setFontSize = (size) => {
            pElements.forEach(p => {
                p.style.fontSize = `${size}px`;
            });
            localStorage.setItem(storageKey, size);
        };

        if (currentFontSize !== defaultFontSize) {
            setFontSize(currentFontSize);
        }

        increaseBtn.addEventListener('click', () => {
            currentFontSize += 1;
            setFontSize(currentFontSize);
        });

        decreaseBtn.addEventListener('click', () => {
            if (currentFontSize > 12) {
                currentFontSize -= 1;
                setFontSize(currentFontSize);
            }
        });
    }

    /* ==========================================================================
       4. FAQ Accordion - אקורדיון שאלות ותשובות
       ========================================================================== */
    const faqQuestions = document.querySelectorAll('.faq-question');

    if (faqQuestions.length > 0) {
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const isExpanded = question.classList.contains('active');

                if (isExpanded) {
                    question.classList.remove('active');
                    answer.classList.remove('active');
                } else {
                    // סגירת שאלות אחרות (אופציונלי)
                    faqQuestions.forEach(otherQuestion => {
                        otherQuestion.classList.remove('active');
                        otherQuestion.nextElementSibling.classList.remove('active');
                    });
                    
                    question.classList.add('active');
                    answer.classList.add('active');
                }
            });
        });
    }

    /* ==========================================================================
       5. Scroll Animations - אנימציות בגלילה
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
        // אלמנטים מסוג image-col
        const imageCols = document.querySelectorAll('.image-col');
        imageCols.forEach(el => {
            if (isElementInViewport(el)) el.classList.add('visible');
        });

        // אלמנטים מסוג fade-in-up
        const fadeElements = document.querySelectorAll('.fade-in-up');
        fadeElements.forEach(el => {
            if (isElementInViewport(el)) el.classList.add('visible');
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // הפעלה ראשונית

    /* ==========================================================================
       6. Client Gallery Lightbox (BaguetteBox) - לייטבוקס
       ========================================================================== */
    const galleryContainer = document.querySelector('.project-gallery-grid');
    
    if (galleryContainer) {
        if (typeof baguetteBox === 'function') {
            try {
                baguetteBox.run('.project-gallery-grid');
            } catch (e) {
                console.error("BaguetteBox failed to run: ", e);
            }
        } else {
            // טעינה דינמית אם הספרייה חסרה
            const cssLink = document.createElement('link');
            cssLink.rel = 'stylesheet';
            cssLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css';
            document.head.appendChild(cssLink);

            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js';
            script.async = true;
            
            script.onload = function() {
                try {
                    baguetteBox.run('.project-gallery-grid');
                } catch (e) {
                    console.error("BaguetteBox failed to initialize: ", e);
                }
            };
            document.body.appendChild(script);
        }
    }

    /* ==========================================================================
       7. Swiper Carousels (Reviews & Projects) - קרוסלות
       ========================================================================== */
    // א. קרוסלת המלצות
    const reviewsSlider = document.querySelector('.reviews-slider');
    if (reviewsSlider && typeof Swiper === 'function') {
        new Swiper('.reviews-slider', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: '.reviews-arrow-next',
                prevEl: '.reviews-arrow-prev',
            },
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 30 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    }

    // ב. קרוסלת פרויקטים
    const projectsSliderEl = document.querySelector('.projects-slider');
    if (projectsSliderEl && typeof Swiper === 'function') {
        new Swiper('.projects-slider', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: '.projects-arrow-next',
                prevEl: '.projects-arrow-prev',
            },
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 30 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    }

    /* ==========================================================================
       8. Custom Video Player - נגן וידאו מעוצב
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
        
        if (video) {
            video.addEventListener('click', function() {
                if (video.paused) playVideo();
            });
        }
    }

    /* ==========================================================================
       9. Portfolio Filter (Archive Page) - סינון פרויקטים
       ========================================================================== */
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    if (filterButtons.length > 0 && projectItems.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // ניהול קלאס active
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                projectItems.forEach(item => {
                    if (filterValue === 'all') {
                        item.classList.remove('hide');
                        // Reset animation
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
       10. AJAX Live Search - חיפוש חי
       ========================================================================== */
    const searchTrigger = document.getElementById('search-trigger-btn');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.querySelector('.search-close-btn');
    const searchInput = document.getElementById('live-search-input');
    const searchResults = document.getElementById('live-search-results');
    const searchSpinner = document.querySelector('.search-spinner');

    // פתיחה וסגירה
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

    // לוגיקת החיפוש עם Debounce
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
                // שימוש ב-snirAjax שמוגדר ב-footer.php
                if (typeof snirAjax !== 'undefined') {
                    const ajaxUrl = snirAjax.ajax_url;
                    const formData = new FormData();
                    formData.append('action', 'snir_live_search');
                    formData.append('keyword', keyword);

                    fetch(ajaxUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(html => {
                        searchResults.innerHTML = html;
                        searchSpinner.classList.remove('loading');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        searchSpinner.classList.remove('loading');
                    });
                } else {
                    console.error('snirAjax variable is not defined.');
                }
            }, doneTypingInterval);
        });
    }

}); // End DOMContentLoaded