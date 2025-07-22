document.addEventListener('DOMContentLoaded', function() {
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
                    // **התיקון כאן:**
                    // נבדוק אם כפתור ההמבורגר גלוי (כלומר, אנחנו במצב מובייל)
                    // ואם התפריט במצב 'active' (פתוח).
                    // זה יבטיח שהפונקציה toggleMenu() תופעל רק לסגירת תפריט המובייל.
                    const isMobileView = window.getComputedStyle(hamburger).display !== 'none';

                    if (isMobileView && mainNav.classList.contains('active')) {
                        toggleMenu(); // סוגר את תפריט המובייל רק אם הוא פתוח ובמצב מובייל
                    }

                    // אם הקישור הוא עוגן (לדף הנוכחי), נטפל בגלילה חלקה
                    if (this.hash !== '') {
                        // event.preventDefault(); // נשאיר את זה רק אם אין מעבר דף בפועל

                        const targetId = this.hash;
                        const targetElement = document.querySelector(targetId);

                        // ודא שהאלמנט קיים לפני הגלילה
                        if (targetElement) {
                            // מונע את פעולת ברירת המחדל רק אם יש אלמנט יעד וגלילה חלקה אפשרית
                            event.preventDefault();
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                            // history.pushState(null, null, targetId); // אופציונלי: מעדכן את ה-URL
                        }
                    }
                });
            });
        }
    } else {
        console.warn('One or more required elements for the hamburger menu were not found. Please check your HTML structure: .hamburger-menu, .main-nav');
    }


    // Dark/Light Mode Toggle
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        // קוד הדארק/לייט מוד נשאר ללא שינוי
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
        // אם רוחב המסך גדול מנקודת השבירה וגם התפריט פתוח
        if (window.innerWidth > desktopBreakpoint && mainNav.classList.contains('active')) {
            toggleMenu(); // סגור את התפריט
        }
    });
});