document.addEventListener('DOMContentLoaded', function() {
    // --- לוגיקת תפריט המבורגר ---
    const hamburger = document.querySelector('.hamburger-menu');
    const mainNav = document.querySelector('.main-nav');
    const body = document.body;
    const navLinks = document.querySelectorAll('.main-menu-list a');

    // בדיקה לוודא שהאלמנטים קיימים לפני הוספת אירועים
    if (hamburger && mainNav && body) {
        // פונקציה לפתיחת/סגירת התפריט
        function toggleMenu() {
            hamburger.classList.toggle('active');
            mainNav.classList.toggle('active'); // זהו הקלאס שפותח/סוגר את תפריט המובייל
            body.classList.toggle('no-scroll');
        }

        // אירוע לחיצה על כפתור ההמבורגר
        hamburger.addEventListener('click', toggleMenu);

        // אירוע לחיצה על כל קישור בתפריט (רק אם יש קישורים)
        if (navLinks.length > 0) {
            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    const isMobileView = window.getComputedStyle(hamburger).display !== 'none';
                    if (isMobileView && mainNav.classList.contains('active')) {
                        toggleMenu(); // סוגר את תפריט המובייל רק אם הוא פתוח ובמצב מובייל
                    }

                    if (this.hash !== '') {
                        const targetId = this.hash;
                        const targetElement = document.querySelector(targetId);

                        if (targetElement) {
                            event.preventDefault();
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
        }
    } else {
        console.warn('One or more required elements for the hamburger menu were not found. Please check your HTML structure: .hamburger-menu, .main-nav');
    }

    // --- לוגיקת Dark/Light Mode ---
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                localStorage.setItem('theme', 'light');
            } else {
                localStorage.setItem('theme', 'dark');
            }
        });

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-mode');
        }
    } else {
        console.warn('Theme toggle button with ID "theme-toggle" not found. Dark/Light mode functionality will not work.');
    }

    // (אופציונלי) טיפול בשינוי גודל חלון - לסגור את המובייל אם עוברים לדסקטופ
    window.addEventListener('resize', function() {
        const desktopBreakpoint = 768; // הגדר את נקודת השבירה שלך בפיקסלים
        if (window.innerWidth > desktopBreakpoint && mainNav && mainNav.classList.contains('active')) {
            toggleMenu(); // סגור את התפריט
        }
    });

    // --- לוגיקת הגדלה/הקטנה של הפונט ---
    const contentContainer = document.querySelector('.single-post-content');
    const increaseBtn = document.getElementById('increase-font-size');
    const decreaseBtn = document.getElementById('decrease-font-size');
    const storageKey = 'user-font-size';
    
    // בודק אם הכפתורים והקונטיינר קיימים בעמוד לפני שממשיך
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
    } else {
        console.warn('Font size controls or content container not found. Font size functionality will not work.');
    }
// --- לוגיקת אקורדיון FAQ ---
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
                    // סגירת כל שאר השאלות הפתוחות לפני הפתיחה הנוכחית
                    faqQuestions.forEach(otherQuestion => {
                        otherQuestion.classList.remove('active');
                        otherQuestion.nextElementSibling.classList.remove('active');
                    });
                    
                    question.classList.add('active');
                    answer.classList.add('active');
                }
            });
        });
    } else {
        console.warn('FAQ questions were not found. Accordion functionality will not work.');
    }
});


document.addEventListener("DOMContentLoaded", function() {
    // Function to check if an element is in the viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Function to handle the scroll event
    function handleScroll() {
        var elements = document.querySelectorAll('.image-col');
        elements.forEach(function(el) {
            if (isElementInViewport(el)) {
                el.classList.add('visible');
            }
        });
    }

    // Run the function once on load and add a scroll listener
    handleScroll();
    window.addEventListener('scroll', handleScroll);
});


document.addEventListener("DOMContentLoaded", function() {
    // Function to check if an element is in the viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        var distance = (window.innerHeight || document.documentElement.clientHeight);
        return (
            rect.top <= distance && rect.bottom >= 0
        );
    }

    // Function to handle the scroll event
    function handleScroll() {
        var elements = document.querySelectorAll('.fade-in-up');
        elements.forEach(function(el) {
            if (isElementInViewport(el)) {
                el.classList.add('visible');
            }
        });
    }

    // Run the function once on load and add a scroll listener
    handleScroll();
    window.addEventListener('scroll', handleScroll);
});