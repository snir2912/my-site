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
        // שימוש ב-admin-ajax.php
        const data = new FormData();
        data.append('action', 'my_ajax_search'); // שם הפעולה שהגדרנו ב-PHP
        data.append('s', query);

        fetch(ajax_search_object.ajax_url, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayResults(data.data);
                // עדכון הקישור לעמוד החיפוש הרגיל
                allResultsLink.href = `<?php echo home_url('/'); ?>?s=${query}`;
            } else {
                displayResults([]);
            }
        })
        .catch(error => {
            console.error('Error fetching search results:', error);
            displayResults([]);
        });
    }

    // פונקציה להצגת התוצאות
    function displayResults(results) {
        resultsList.innerHTML = '';
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

        if (query.length > 2) {
            timeoutId = setTimeout(() => {
                fetchResults(query);
            }, 300);
        } else {
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