<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<main id="primary" class="site-main error-404-page">
    <div class="container error-content">
        
        <h1 class="error-code">404</h1>
        
        <h2 class="error-title">אופס! נראה שהלכתם לאיבוד בחלל.</h2>
        <p class="error-text">העמוד שחיפשתם לא קיים, הוסר, או שמעולם לא היה כאן. אל דאגה, תמיד אפשר לחזור הביתה.</p>

        <div class="error-buttons">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn primary-btn">חזרה לדף הבית</a>
            <button id="error-search-trigger" class="btn secondary-btn">חיפוש באתר</button>
        </div>

    </div>
</main>

<script>
    document.getElementById('error-search-trigger').addEventListener('click', function() {
        document.getElementById('search-overlay').classList.add('active');
        setTimeout(() => document.getElementById('live-search-input').focus(), 100);
    });
</script>

<?php
get_footer();
?>