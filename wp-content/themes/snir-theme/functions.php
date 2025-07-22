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

<?php
/**
 * Generates a Table of Contents (TOC) from h2 headings in post content.
 *
 * @param string $content The post content.
 * @return string The post content with the TOC prepended.
 */
function snir_theme_add_table_of_contents( $content ) {
    // Check if it's a single post and if the content is not empty.
    if ( is_single() && ! empty( $content ) ) {
        // Use DOMDocument to parse the HTML content.
        $dom = new DOMDocument();
        // Suppress warnings for malformed HTML.
        libxml_use_internal_errors(true);
        $dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
        libxml_clear_errors();

        $headings = $dom->getElementsByTagName('h2');
        $toc_items = [];
        $heading_id_count = [];

        foreach ( $headings as $heading ) {
            // Attempt to get just the direct text content, ignoring children elements that are not text nodes
$heading_text = '';
foreach ($heading->childNodes as $child) {
    if ($child->nodeType === XML_TEXT_NODE) {
        $heading_text .= $child->nodeValue;
    }
    // If you want to include text from direct <span> or <strong> tags inside H2
    // you might need a more complex loop, but for now, we focus on direct text.
}
$heading_text = trim( $heading_text );

// Fallback if no direct text found, or if you still want to strip tags and limit length
if ( empty( $heading_text ) ) {
    $heading_text = trim( strip_tags( $dom->saveHTML($heading) ) );
}

// Limit the length of the heading text for the TOC item to avoid long strings
// Adjust 100 to a suitable character limit for your titles.
if ( mb_strlen( $heading_text ) > 100 ) {
    $heading_text = mb_substr( $heading_text, 0, 97 ) . '...';
}
            if ( ! empty( $heading_text ) ) {
                // Sanitize heading text to create a URL-friendly anchor.
                $id = sanitize_title( $heading_text );

                // Ensure unique IDs by appending a number if the ID already exists.
                if ( isset( $heading_id_count[$id] ) ) {
                    $heading_id_count[$id]++;
                    $id .= '-' . $heading_id_count[$id];
                } else {
                    $heading_id_count[$id] = 1;
                }

                // Set the 'id' attribute for the heading element.
                $heading->setAttribute( 'id', $id );
                $toc_items[] = [
                    'id'   => $id,
                    'text' => $heading_text,
                ];
            }
        }

        // Only generate TOC if there are h2 headings found.
        if ( ! empty( $toc_items ) ) {
            $toc_html = '<div class="table-of-contents-wrapper">';
            $toc_html .= '<div class="toc-header">';
            $toc_html .= '<span>תוכן עניינים</span>';
            $toc_html .= '<button class="toc-toggle" aria-expanded="false" aria-controls="toc-list">';
            $toc_html .= '<span class="arrow-icon"></span>'; // Icon for toggle
            $toc_html .= '</button>';
            $toc_html .= '</div>'; // End toc-header
            $toc_html .= '<nav class="toc-list" id="toc-list" aria-hidden="true">';
            $toc_html .= '<ul>';
            foreach ( $toc_items as $item ) {
                $toc_html .= '<li><a href="#' . esc_attr( $item['id'] ) . '">' . esc_html( $item['text'] ) . '</a></li>';
            }
            $toc_html .= '</ul>';
            $toc_html .= '</nav>';
            $toc_html .= '</div>'; // End table-of-contents-wrapper

            // Convert DOMDocument back to HTML and prepend the TOC.
            $content = $dom->saveHTML();
            return $toc_html . $content;
        }
    }
    return $content;
}
add_filter( 'the_content', 'snir_theme_add_table_of_contents' );

// Enqueue scripts and styles for the TOC
// functions.php

function snir_theme_enqueue_toc_assets() {
    if ( is_single() ) {
        // ודא ש-jQuery נטען לפני הסקריפט שלך
        wp_enqueue_script( 'jquery' ); // ודא ש-jQuery רשום ונטען

        // טען את הסקריפט שלך עם תלות ב-jQuery
        wp_enqueue_script( 'snir-theme-toc-script', get_template_directory_uri() . '/js/toc.js', array('jquery'), null, true );
        // הפרמטר הרביעי 'null' יכול להיות גם מספר גרסה, והפרמטר החמישי 'true' מבטיח שהסקריפט יטען בפוטר.
    }
}
add_action( 'wp_enqueue_scripts', 'snir_theme_enqueue_toc_assets' );