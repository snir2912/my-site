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
            mainNav.classList.toggle('active');
            body.classList.toggle('no-scroll');
        }

        // אירוע לחיצה על כפתור ההמבורגר
        hamburger.addEventListener('click', toggleMenu);

        // אירוע לחיצה על כל קישור בתפריט (רק אם יש קישורים)
        if (navLinks.length > 0) {
            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    if (this.hash !== '') {
                        event.preventDefault();

                        toggleMenu();

                        const targetId = this.hash;
                        const targetElement = document.querySelector(targetId);

                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                            history.pushState(null, null, targetId);
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
});