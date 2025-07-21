// js/table-scroll-indicator.js (הקוד המלא והמתוקן)

document.addEventListener('DOMContentLoaded', () => {
    const tableWrappers = document.querySelectorAll('.wp-block-table');

    tableWrappers.forEach(wrapper => {
        const table = wrapper.querySelector('table');
        if (!table) return;

        // ודא שה-wrapper הוא ה-div שהגלילה מתרחשת עליו
        // (במקרה של בלוק גוטנברג, ה-overflow-x הוא על ה-.wp-block-table עצמו)
        // אם ה-overflow-x היה על ה-table, היינו צריכים לכוון ל-table.

        const updateScrollIndicators = () => {
            // ודא שהטבלה בכלל רחבה יותר מהמיכל שלה כדי לדרוש גלילה
            const hasHorizontalScroll = table.scrollWidth > wrapper.clientWidth;

            if (!hasHorizontalScroll) {
                // אם אין צורך בגלילה, הסתר את שני האינדיקטורים
                wrapper.classList.add('no-scroll');
                return;
            } else {
                wrapper.classList.remove('no-scroll');
            }

            // לוגיקה עבור RTL:
            // ברוב הדפדפנים (Chrome, Firefox, Safari) עבור content direction:rtl:
            // - wrapper.scrollLeft מתחיל מ-0 כשהתוכן מיושר לימין (ההתחלה).
            // - כשגוללים שמאלה, wrapper.scrollLeft הופך להיות שלילי, עד לערך המקסימלי השלילי שהוא -(scrollWidth - clientWidth).

            // אינדיקטור ימני: מופיע אם לא גללנו עד הסוף ימינה
            // כלומר, אם scrollLeft אינו 0. (סובלנות קטנה לדיוק)
            if (Math.abs(wrapper.scrollLeft) > 2) { // אם גללנו טיפה שמאלה (scrollLeft שלילי)
                wrapper.classList.remove('scrolled-right-end'); // הראה את האינדיקטור הימני
            } else {
                wrapper.classList.add('scrolled-right-end'); // הסתר את האינדיקטור הימני (הגענו לימין)
            }

            // אינדיקטור שמאלי: מופיע אם יש עוד תוכן לגלול שמאלה
            // כלומר, אם לא גללנו עד הסוף שמאלה.
            const maxScrollLeftNegative = -(table.scrollWidth - wrapper.clientWidth);
            // אם wrapper.scrollLeft קרוב ל-maxScrollLeftNegative, סימן שגללנו עד הסוף שמאלה.
            if (Math.abs(wrapper.scrollLeft - maxScrollLeftNegative) > 2) {
                wrapper.classList.add('scrolled-left-visible'); // הראה את האינדיקטור השמאלי
            } else {
                wrapper.classList.remove('scrolled-left-visible'); // הסתר את האינדיקטור השמאלי (הגענו לשמאל)
            }

            // מקרה קצה: אם הטבלה בקושי גדולה מספיק כדי לגלול, ייתכן ששני האינדיקטורים יופיעו.
            // אם אין גלילה כלל, הם יוסתרו ע"י no-scroll.
        };

        wrapper.addEventListener('scroll', updateScrollIndicators);
        window.addEventListener('resize', updateScrollIndicators); // עדכן בגודל מסך משתנה

        // הפעל פעם אחת בטעינה ראשונית
        updateScrollIndicators();
    });
});