<?php

// ----------------------------------------------------
//  1. טעינת קבצי CSS ו-JavaScript
// ----------------------------------------------------
function snir_theme_assets() {
    // טעינת פונטים של גוגל - Heebo
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700;800&display=swap');

    // טעינת Font Awesome (גרסה עדכנית יותר מ-4.7)
    // מומלץ להשתמש בגרסה עדכנית יותר אם אפשר, למשל 5.15.4 או 6
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4', 'all');

    // טעינת קובץ ה-CSS הראשי שלך
    // נתיב: wp-content/themes/snir-theme/css/my-style.css
    wp_enqueue_style('snir_main_styles', get_theme_file_uri('/css/my-style.css'), array(), filemtime(get_theme_file_path('/css/my-style.css')), 'all');

    // טעינת קובץ ה-JavaScript הראשי שלך
    // נתיב: wp-content/themes/snir-theme/js/main.js
    // תלוי ב-jQuery, נטען בפוטר (true)
    wp_enqueue_script('main-snir-js', get_theme_file_uri('/js/main.js'), array('jquery'), filemtime(get_theme_file_path('/js/main.js')), true);

    // טעינת סקריפט תוכן העניינים רק בפוסטים בודדים
    if ( is_singular( 'post' ) ) {
        wp_enqueue_script( 'snir-theme-toc-script', get_theme_file_uri('/js/table-of-contents.js'), array(), filemtime(get_theme_file_path('/js/table-of-contents.js')), true );
    }

    // אם יש לך קובץ JS מתיקיית build/index.js, טען אותו כאן (כרגע מוגן בהערה)
    // wp_enqueue_script('university-js-bundle', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'snir_theme_assets');

// ----------------------------------------------------
//  2. רישום מיקומי תפריטים
// ----------------------------------------------------
function snir_theme_register_menus() {
    register_nav_menus(
        array(
            'header-menu' => esc_html__( 'תפריט ראשי (הדר)', 'snir-theme' ),
            'footer-menu' => esc_html__( 'תפריט פוטר', 'snir-theme' ),
        )
    );
}
add_action( 'after_setup_theme', 'snir_theme_register_menus' );

// ----------------------------------------------------
//  3. תמיכה בתכונות תבנית
// ----------------------------------------------------
// הוספת תמיכה בתמונות ממוזערות (Featured Images)
add_theme_support('post-thumbnails');

// ----------------------------------------------------
//  4. שינויים בתצוגה
// ----------------------------------------------------
// הסרת הכותרת "ארכיון" מפוסטים
add_filter('get_the_archive_title_prefix', '__return_empty_string');

// הגבלת אורך תקציר (Excerpt)
function my_excerpt_length($length) {
    return 15;
}
add_filter('excerpt_length', 'my_excerpt_length');

// ----------------------------------------------------
//  5. פונקציית פירורי לחם (Breadcrumbs)
// ----------------------------------------------------
function snir_theme_breadcrumbs() {
    echo '<div class="breadcrumbs">';
    if ( ! is_home() ) {
        echo '<a href="' . esc_url( home_url() ) . '">' . esc_html__( 'Home', 'snir-theme' ) . '</a> <span class="separator">/</span> ';
        if ( is_single() ) {
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a> <span class="separator">/</span> ';
            }
            echo '<span class="current">' . esc_html( get_the_title() ) . '</span>';
        } elseif ( is_category() || is_archive() ) {
            single_cat_title();
        } elseif ( is_page() ) {
            echo '<span class="current">' . esc_html( get_the_title() ) . '</span>';
        }
    }
    echo '</div>';
}

?>