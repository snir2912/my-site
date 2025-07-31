document.addEventListener('DOMContentLoaded', function() {
    // 1. הגדר את הסלקטור של אלמנט הכותרת שלך.
    // אם שדה ה-ACF מוצג בתוך כותרת H1, H2, DIV או כל תג אחר, שנה את הסלקטור בהתאם.
    // לדוגמה, אם הכותרת נמצאת בתוך אלמנט עם ID "my-acf-title", השתמש ב: '#my-acf-title'
    // אם הכותרת נמצאת בתוך אלמנט עם קלאס "acf-title-field", השתמש ב: '.acf-title-field'
    // חשוב לוודא שהסלקטור הזה מפנה במדויק לאלמנט ה-HTML שמציג את התוכן של שדה ה-ACF.
    const titleElement = document.querySelector('h2'); // דוגמה: שינוי ל-H1. שנה לפי הצורך!

    // ודא שהאלמנט קיים לפני שממשיכים
    if (titleElement) {
        let originalText = titleElement.innerHTML; // השתמש ב-innerHTML כדי לשמור תגי HTML אם יש

        // ביטוי רגולרי למציאת מילים שמתחילות ונגמרות בסימן |
        // g - גלובלי (מוצא את כל ההתאמות, לא רק את הראשונה)
        // i - אינו רגיש לאותיות גדולות/קטנות (לא רלוונטי במקרה של | אבל טוב לדעת)
        const regex = /\|([^|]+)\|/g;

        // החלף כל התאמה בתג span עם העיצוב הרצוי
        // $1 מייצג את הטקסט שתפסנו בתוך הסוגריים בביטוי הרגולרי (כלומר, המילה עצמה ללא ה- | )
        const newText = originalText.replace(regex, '<span style="color: var(--primary-color, crimson);">\$1</span>');

        // עדכן את תוכן האלמנט
        titleElement.innerHTML = newText;
    }
});