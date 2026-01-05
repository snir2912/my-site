// toc.js

// שים לב: השינוי הוא רק בעטיפה של הפונקציה
(function($) { // עוטפים את הקוד בפונקציה אנונימית ומעבירים אליה את jQuery כ-$
    const tocWrapper = $('.table-of-contents-wrapper');
    const tocHeader = tocWrapper.find('.toc-header');
    const tocList = tocWrapper.find('.toc-list');
    const tocToggleButton = tocWrapper.find('.toc-toggle');

    // Initial state: TOC is closed, so set aria-hidden to true and aria-expanded to false.
    tocList.attr('aria-hidden', 'true');
    tocToggleButton.attr('aria-expanded', 'false');

    tocHeader.on('click', function() {
        const isExpanded = tocToggleButton.attr('aria-expanded') === 'true';

        if (isExpanded) {
            // Collapse the TOC
            tocList.attr('aria-hidden', 'true');
            tocToggleButton.attr('aria-expanded', 'false');
        } else {
            // Expand the TOC
            tocList.attr('aria-hidden', 'false');
            tocToggleButton.attr('aria-expanded', 'true');
        }
    });

    // Handle smooth scrolling for anchor links
    tocList.find('a').on('click', function(e) {
        e.preventDefault(); // מונע את פעולת ברירת המחדל של הדפדפן

        const targetId = $(this).attr('href'); // מקבל את ה-href של הקישור, לדוגמה: "#my-heading"

        // חשוב לוודא שה-ID הזה קיים ב-HTML.
        // אם ה-ID מתחיל ב-#, נחפש אותו ישירות.
        const targetElement = $(targetId);

        if (targetElement.length) { // ודא שהאלמנט נמצא לפני שמנסים לגלול אליו
            $('html, body').animate({
                // scrollTop: targetElement.offset().top - 80 // הורידו את ה-80px כדי לבדוק
                scrollTop: targetElement.offset().top
            }, 800, function() {
                // אופציונלי: הוסף את ה-ID ל-URL לאחר הגלילה
                // window.location.hash = targetId;
            });
        } else {
            console.warn('Target element not found for ID:', targetId); // הודעת אזהרה אם לא נמצא
        }

        // Optionally, close the TOC after clicking an item
        // tocList.attr('aria-hidden', 'true');
        // tocToggleButton.attr('aria-expanded', 'false');
    });
})(jQuery); // מעבירים את jQuery לפונקציה האנונימית כדי שתוכל להשתמש בה כ-$