// נחכה שכל העמוד ייטען לפני שנריץ את הקוד
window.addEventListener('load', function() {

    // --- 1. בדיקת תמיכה בדפדפן ---
    if (!('speechSynthesis' in window)) {
        console.warn('מצטערים, הדפדפן שלך אינו תומך בהקראת טקסט.');
        // נסתיר את הכפתורים אם אין תמיכה
        var controls = document.querySelector('.tts-controls');
        if (controls) {
            controls.style.display = 'none';
        }
        return; // נצא מהפונקציה
    }

    // --- 2. איתור הרכיבים שלנו ---
    const playButton = document.getElementById('tts-play');
    const pauseButton = document.getElementById('tts-pause');
    const stopButton = document.getElementById('tts-stop');

    // איתור תיבת התוכן של המאמר.
    // '.entry-content' הוא שם נפוץ בוורדפרס, 
    // ייתכן שתצטרך לשנות את זה בהתאם לתבנית שלך!
    const articleElement = document.querySelector('.single-post-content');

    // אם לא מצאנו את הכפתורים או את התוכן, נצא
    if (!playButton || !pauseButton || !stopButton || !articleElement) {
        console.error('לא נמצאו רכיבי ה-TTS הדרושים.');
        return;
    }

    // --- 3. הכנת הטקסט להקראה ---
    
    // ניקוי הטקסט: נשתמש ב-innerText כדי לקבל רק את הטקסט הנקי,
    // ללא תגיות HTML
    const articleText = articleElement.innerText;

    // יצירת אובייקט "הקראה"
    const utterance = new SpeechSynthesisUtterance(articleText);

    // --- 4. הגדרות שפה וקול (חשוב לעברית!) ---
    
    // אנו רוצים למצוא קול בעברית
    function loadVoices() {
        let voices = window.speechSynthesis.getVoices();
        let hebVoice = voices.find(voice => voice.lang === 'he-IL');

        if (hebVoice) {
            utterance.voice = hebVoice; // הגדרת הקול העברי
        } else {
            // אם לא מצאנו קול עברי ספציפי, לפחות נגדיר את השפה
            utterance.lang = 'he-IL';
            console.log('לא נמצא קול עברי (he-IL) ייעודי, ייתכן שההקראה לא תהיה מדויקת.');
        }
    }
    
    loadVoices();
    // הקולות נטענים לפעמים לאט, לכן נבקש רענון כשהם מסיימים להיטען
    if (window.speechSynthesis.onvoiceschanged !== undefined) {
        window.speechSynthesis.onvoiceschanged = loadVoices;
    }

    // --- 5. חיבור הפעולות לכפתורים ---

    playButton.addEventListener('click', () => {
        if (window.speechSynthesis.paused) {
            // אם ההקראה מושהית, פשוט נמשיך
            window.speechSynthesis.resume();
        } else if (!window.speechSynthesis.speaking) {
            // אם ההקראה לא התחילה (או נעצרה), נתחיל מההתחלה
            // (חשוב לבטל הקראה קודמת אם הייתה)
            window.speechSynthesis.cancel();
            window.speechSynthesis.speak(utterance);
        }
    });

    pauseButton.addEventListener('click', () => {
        // נשהה רק אם מתבצעת הקראה
        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.pause();
        }
    });

    stopButton.addEventListener('click', () => {
        // נעצור את ההקראה לחלוטין
        window.speechSynthesis.cancel();
    });

    // בונוס: ננקה את המצב כשההקראה מסתיימת באופן טבעי
    utterance.onend = function() {
        console.log('ההקראה הסתיימה.');
    };
});