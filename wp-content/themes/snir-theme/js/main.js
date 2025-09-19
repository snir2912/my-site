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
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        var distance = (window.innerHeight || document.documentElement.clientHeight);
        return (
            rect.top <= distance && rect.bottom >= 0
        );
    }

    function handleScroll() {
        var elements = document.querySelectorAll('.fade-in-up');
        elements.forEach(function(el) {
            if (isElementInViewport(el)) {
                el.classList.add('visible');
            }
        });
    }

    handleScroll();
    window.addEventListener('scroll', handleScroll);
});

// ajax search
document.addEventListener('DOMContentLoaded', function() {
    const searchField = document.querySelector('.search-field');
    const resultsPanel = document.getElementById('search-results-live');
    const resultsList = resultsPanel.querySelector('.results-list');
    const allResultsLinkContainer = resultsPanel.querySelector('.all-results-link-container');
    const allResultsLink = resultsPanel.querySelector('.all-results-link');
    const noResultsText = resultsPanel.querySelector('.no-results');

    let timeoutId;

    // פונקציה לשליחת בקשת Ajax
    function fetchResults(query) {
        // הדרך המקובלת לבצע בקשות Ajax בוורדפרס
        const ajaxUrl = '<?php echo home_url('/wp-content/themes/your-theme-name/ajax-search.php'); ?>'; // החלף בנתיב הנכון לקובץ שלך
        const url = `${ajaxUrl}?s=${query}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                displayResults(data.data);
                // עדכון הקישור לעמוד החיפוש הרגיל
                allResultsLink.href = `<?php echo home_url('/'); ?>?s=${query}`;
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                displayResults([]);
            });
    }

    // פונקציה להצגת התוצאות
    function displayResults(results) {
        resultsList.innerHTML = ''; // מנקה תוצאות קודמות
        if (results.length > 0) {
            results.forEach(item => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = item.permalink;
                a.textContent = item.title;
                li.appendChild(a);
                resultsList.appendChild(li);
            });
            allResultsLinkContainer.style.display = 'block';
            noResultsText.style.display = 'none';
            resultsPanel.classList.add('active');
        } else {
            noResultsText.style.display = 'block';
            allResultsLinkContainer.style.display = 'none';
            resultsPanel.classList.add('active');
        }
    }

    // האזנה לאירוע הקלדה בשדה החיפוש
    searchField.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const query = this.value.trim();

        if (query.length > 2) { // מתחיל לחפש רק אחרי 3 תווים
            timeoutId = setTimeout(() => {
                fetchResults(query);
            }, 300); // השהייה קטנה למניעת עומס על השרת
        } else {
            // הסתרת החלונית אם הטקסט קצר מדי
            resultsPanel.classList.remove('active');
        }
    });

    // סגירת החלונית בלחיצה מחוץ לטופס
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-form-container')) {
            resultsPanel.classList.remove('active');
        }
    });
});