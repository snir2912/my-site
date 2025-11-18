<?php

// ----------------------------------------------------
//  1. טעינת קבצי CSS ו-JavaScript
//      (שימו לב: snir_theme_enqueue_toc_assets() מופרדת למטה לבהירות)
// ----------------------------------------------------
function mytheme_setup_logo() {
    add_theme_support( 'custom-logo', array(
        'flex-height' => true, // עדיין מומלץ לאפשר גמישות בגובה
        'flex-width'  => true,  // עדיין מומלץ לאפשר גמישות ברוחב
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
add_action( 'after_setup_theme', 'mytheme_setup_logo' );
function snir_theme_assets() {
    // טעינת פונטים של גוגל - Heebo
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700;800&display=swap');

    // טעינת Font Awesome (גרסה עדכנית יותר מ-4.7)
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4', 'all');

    // טעינת קובץ ה-CSS הראשי שלך
    wp_enqueue_style('snir_main_styles', get_theme_file_uri('/css/my-style.css'), array(), filemtime(get_theme_file_path('/css/my-style.css')), 'all');

    // טעינת קובץ ה-JavaScript הראשי שלך
    wp_enqueue_script('main-snir-js', get_theme_file_uri('/js/main.js'), array('jquery'), filemtime(get_theme_file_path('/js/main.js')), true);
    
    wp_enqueue_script(
        'custom-coloring', // שם ייחודי לסקריפט
        get_stylesheet_directory_uri() . './js/headline-color.js', // נתיב לקובץ ה-JS
        array(), // מערך של תלויות (אם יש)
        null, // גרסת קובץ (null לשימוש בגרסה של וורדפרס)
        true // נכון: טען את הסקריפט בפוטר (מומלץ לביצועים)
    );


    // הסרה של טעינת סקריפט תוכן העניינים מכאן.
    // הוא יטען דרך הפונקציה snir_theme_enqueue_toc_assets() למטה, שם ה-jQuery מוגדר כתלות.
}
add_action('wp_enqueue_scripts', 'snir_theme_assets');

// ----------------------------------------------------
//  2. רישום מיקומי תפריטים
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
//  3. תמיכה בתכונות תבנית
// ----------------------------------------------------
// הוספת תמיכה בתמונות ממוזערות (Featured Images)
add_theme_support('post-thumbnails');

// ----------------------------------------------------
//  4. שינויים בתצוגה
// ----------------------------------------------------
// הסרת הכותרת "ארכיון" מפוסטים
add_filter('get_the_archive_title_prefix', '__return_empty_string');

// הגבלת אורך תקציר (Excerpt)
function my_excerpt_length($length) {
    return 15;
}
add_filter('excerpt_length', 'my_excerpt_length');

// ----------------------------------------------------
//  5. פונקציית פירורי לחם (Breadcrumbs)
// ----------------------------------------------------
function snir_theme_breadcrumbs() {

    // הגדרות
    $delimiter = '<i class="fas fa-chevron-left" style="font-size: 0.8em; margin: 0 8px; opacity: 0.7;"></i>'; // המפריד (אייקון או טקסט)
    $home = 'דף הבית'; // הטקסט של דף הבית
    $before = '<span class="current">'; // עטיפה לטקסט הנוכחי
    $after = '</span>';

    if ( !is_home() && !is_front_page() || is_paged() ) {

        echo '<nav class="breadcrumbs-nav">'; // עטיפה ראשית

        global $post;
        
        // קישור לדף הבית
        echo '<a href="' . home_url() . '">' . $home . '</a>' . $delimiter;

        // === בדיקות עבור ארכיונים (כאן השינוי שלך) ===
        
        if ( is_post_type_archive('client') ) {
            // עבור עמוד הלקוחות
            echo $before . 'הפרויקטים שלנו' . $after;
            
        } elseif ( is_post_type_archive('services') ) {
            // עבור עמוד השירותים (אם זה ארכיון פוסט טייפ)
            echo $before . 'השירותים שלנו' . $after;
            
        } elseif ( is_page('services') ) { 
            // אם השירותים זה "עמוד" רגיל ולא ארכיון
            echo $before . get_the_title() . $after;

        } elseif ( is_category() ) {
            // קטגוריות רגילות (בלוג)
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            echo $before . single_cat_title('', false) . $after;

        } elseif ( is_search() ) {
            // תוצאות חיפוש
            echo $before . 'תוצאות חיפוש עבור "' . get_search_query() . '"' . $after;

        } elseif ( is_single() && !is_attachment() ) {
            // עמוד פוסט בודד (Single)
            if ( get_post_type() != 'post' ) {
                // פוסט טייפ מותאם אישית (כמו פרויקט בודד)
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                
                // כאן נגדיר ידנית את שם הארכיון בנתיב
                $archive_title = $post_type->labels->singular_name;
                if ($post_type->name == 'client') {
                    $archive_title = 'הפרויקטים שלנו';
                } elseif ($post_type->name == 'services') {
                    $archive_title = 'השירותים שלנו';
                }

                echo '<a href="' . home_url() . '/' . $slug['slug'] . '/">' . $archive_title . '</a>';
                echo $delimiter . $before . get_the_title() . $after;
            } else {
                // פוסט רגיל (בלוג)
                $cat = get_the_category(); $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo $before . get_the_title() . $after;
            }

        } elseif ( is_page() && !$post->post_parent ) {
            // עמוד רגיל (ללא הורה)
            echo $before . get_the_title() . $after;

        } elseif ( is_404() ) {
            echo $before . 'שגיאה 404' . $after;
        }

        echo '</nav>'; // סגירת עטיפה ראשית
    }
}

// ----------------------------------------------------
//  6. פונקציות לטבלת תוכן (Table of Contents - TOC)
// ----------------------------------------------------

/**
 * Helper function to create a clean, valid HTML ID from a string.
 * This is more aggressive than sanitize_title() for problematic characters,
 * ensuring jQuery selectors work correctly with Hebrew characters.
 * @param string $string The input string.
 * @return string The clean ID.
 */
function snir_theme_clean_id( $string ) {
    // Remove common problematic characters for IDs (like Hebrew URL-encoded parts)
    $string = remove_accents( $string ); // Remove accents from characters
    $string = strtolower( $string ); // Convert to lowercase
    $string = preg_replace( '/[^a-z0-9_\-]/', '-', $string ); // Replace non-alphanumeric (except hyphen and underscore) with hyphens
    $string = preg_replace( '/-+/', '-', $string ); // Replace multiple hyphens with a single hyphen
    $string = trim( $string, '-' ); // Trim hyphens from start/end
    // If it's still empty or starts with a number, add a prefix (IDs cannot start with numbers)
    if ( empty( $string ) || is_numeric( substr( $string, 0, 1 ) ) ) {
        $string = 'toc-' . $string; // Add a prefix to ensure valid ID
    }
    return $string;
}

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
        // Load HTML, converting encoding for proper parsing of non-ASCII characters.
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
            }
            $heading_text = trim( $heading_text );

            // Fallback if no direct text found (e.g., if H2 contains only wrapped elements like <strong>)
            if ( empty( $heading_text ) ) {
                $heading_text = trim( strip_tags( $dom->saveHTML($heading) ) );
            }

            if ( ! empty( $heading_text ) ) {
                // Sanitize heading text to create a URL-friendly anchor using the custom clean ID function.
                $id = snir_theme_clean_id( $heading_text ); // *** THIS IS THE KEY CHANGE ***

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
                    'text' => $heading_text, // Full text for display in TOC, will be truncated later if too long
                ];
            }
        }

        // Limit the length of the heading text for the TOC item to avoid long strings
        foreach ( $toc_items as &$item ) { // Use & to modify the item directly
            if ( mb_strlen( $item['text'] ) > 100 ) { // Adjust 100 to a suitable character limit for your titles.
                $item['text'] = mb_substr( $item['text'], 0, 97 ) . '...';
            }
        }
        unset($item); // Unset the reference after the loop

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

// Enqueue scripts and styles specifically for the TOC functionality.
// This function ensures jQuery is loaded before the TOC script and handles its dependency.
function snir_theme_enqueue_toc_assets() {
    if ( is_singular( 'post' ) ) { // Using is_singular('post') for better specificity (single post pages)
        // Ensure jQuery is loaded first
        wp_enqueue_script( 'jquery' );

        // Load your TOC script, with jQuery as a dependency.
        wp_enqueue_script( 'snir-theme-toc-script', get_theme_file_uri( '/js/table-of-contents.js' ), array( 'jquery' ), filemtime(get_theme_file_path('/js/table-of-contents.js')), true );
    }
}
add_action( 'wp_enqueue_scripts', 'snir_theme_enqueue_toc_assets' );
?>
<?php

// קוד זה יירשם את ה-Custom Post Type החדש שנקרא 'services'
function snir_theme_register_services_post_type() {
    
    $labels = array(
        'name'                  => _x( 'שירותים', 'Post type general name', 'snir-theme' ),
        'singular_name'         => _x( 'שירות', 'Post type singular name', 'snir-theme' ),
        'menu_name'             => _x( 'שירותים', 'Admin Menu text', 'snir-theme' ),
        'name_admin_bar'        => _x( 'שירות', 'Add New on Toolbar', 'snir-theme' ),
        'add_new'               => __( 'הוסף שירות חדש', 'snir-theme' ),
        'add_new_item'          => __( 'הוספת שירות חדש', 'snir-theme' ),
        'new_item'              => __( 'שירות חדש', 'snir-theme' ),
        'edit_item'             => __( 'ערוך שירות', 'snir-theme' ),
        'view_item'             => __( 'צפה בשירות', 'snir-theme' ),
        'all_items'             => __( 'כל השירותים', 'snir-theme' ),
        'search_items'          => __( 'חפש שירותים', 'snir-theme' ),
        'parent_item_colon'     => __( 'שירות הורה:', 'snir-theme' ),
        'not_found'             => __( 'לא נמצאו שירותים', 'snir-theme' ),
        'not_found_in_trash'    => __( 'לא נמצאו שירותים באשפה', 'snir-theme' ),
        'featured_image'        => _x( 'תמונה ראשית של השירות', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'snir-theme' ),
        'set_featured_image'    => _x( 'הגדר תמונה ראשית', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'snir-theme' ),
        'remove_featured_image' => _x( 'הסר תמונה ראשית', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'snir-theme' ),
        'use_featured_image'    => _x( 'השתמש כתמונה ראשית', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'snir-theme' ),
        'archives'              => _x( 'ארכיון שירותים', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'snir-theme' ),
        'insert_into_item'      => _x( 'הכנס לשירות', 'Overrides the “Insert into post” phrase for this post type. Added in 4.4', 'snir-theme' ),
        'uploaded_to_this_item' => _x( 'הועלה לשירות זה', 'Overrides the “Uploaded to this post” phrase for this post type. Added in 4.4', 'snir-theme' ),
        'filter_items_list'     => _x( 'סנן רשימת שירותים', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”. Added in 4.4', 'snir-theme' ),
        'items_list_navigation' => _x( 'ניווט רשימת שירותים', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”. Added in 4.4', 'snir-theme' ),
        'items_list'            => _x( 'רשימת שירותים', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”. Added in 4.4', 'snir-theme' ),
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'services' ), // סלאג באנגלית
        'capability_type'       => 'post',
        'menu_icon'             => 'dashicons-hammer', // אייקון של פטיש שמתאים לנושא
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
        'show_in_rest'          => true, // תמיכה בעורך גוטנברג
        'hierarchical'          => false,
    );
    
    register_post_type( 'services', $args );

}
add_action( 'init', 'snir_theme_register_services_post_type' );

// כדי לוודא שוורדפרס מכיר את מבנה הקישורים החדש, יש לבצע ריענון
// לאחר הוספת הקוד, יש להיכנס לפאנל הניהול -> הגדרות -> מבנה קישורים וללחוץ 'שמור שינויים'.
// הפונקציה הזו מבצעת את הפעולה הזו אוטומטית.
function snir_theme_flush_rewrite_rules_on_activation() {
    snir_theme_register_services_post_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'snir_theme_flush_rewrite_rules_on_activation' );

// ajax search

// קובץ: functions.php
// פונקציית החיפוש של Ajax
function my_ajax_search_scripts() {
    // טעינת קובץ ה-JavaScript של החיפוש
    wp_enqueue_script( 'ajax-search', get_template_directory_uri() . './js/ajax-search.js', array('jquery'), null, true );
    
    // העברת נתוני PHP ל-JavaScript
    wp_localize_script( 'ajax-search', 'ajax_search_object', array(
        'ajax_url'   => admin_url( 'admin-ajax.php' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'my_ajax_search_scripts' );
function my_ajax_search_callback() {
    if (!isset($_POST['s'])) {
        wp_send_json_error('No search query provided.');
    }
    
    $search_query = sanitize_text_field($_POST['s']);
    
    $args = array(
        'post_type'      => array('post', 'services'),
        's'              => $search_query,
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    );
    
    $query = new WP_Query($args);
    
    $results = array();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $results[] = array(
                'title'     => get_the_title(),
                'permalink' => get_permalink(),
                'post_type' => get_post_type($post_id),
            );
        }
    }
    
    wp_reset_postdata();
    wp_send_json_success($results);
}
add_action('wp_ajax_my_ajax_search', 'my_ajax_search_callback');
add_action('wp_ajax_nopriv_my_ajax_search', 'my_ajax_search_callback');

// ===== 1. רישום Custom Post Type: Client =====

function create_client_post_type() {
    $labels = array(
        'name'               => _x( 'clients', 'post type general name', 'your-theme-text-domain' ),
        'singular_name'      => _x( 'client', 'post type singular name', 'your-theme-text-domain' ),
        'menu_name'          => _x( 'clients', 'admin menu', 'your-theme-text-domain' ),
        'name_admin_bar'     => _x( 'client', 'add new on admin bar', 'your-theme-text-domain' ),
        'add_new'            => _x( 'Add New', 'client', 'your-theme-text-domain' ),
        'add_new_item'       => __( 'Add New Client', 'your-theme-text-domain' ),
        'new_item'           => __( 'New Client', 'your-theme-text-domain' ),
        'edit_item'          => __( 'Edit Client', 'your-theme-text-domain' ),
        'view_item'          => __( 'View Client', 'your-theme-text-domain' ),
        'all_items'          => __( 'All Clients', 'your-theme-text-domain' ),
        'search_items'       => __( 'Search Clients', 'your-theme-text-domain' ),
        'parent_item_colon'  => __( 'Parent Clients:', 'your-theme-text-domain' ),
        'not_found'          => __( 'No clients found.', 'your-theme-text-domain' ),
        'not_found_in_trash' => __( 'No clients found in Trash.', 'your-theme-text-domain' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'clients' ), // הקישור ייראה: yoursite.com/clients/client-name
        'capability_type'    => 'post',
        'has_archive'        => true, // מאפשר עמוד ארכיון לכל הלקוחות
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-businesswoman', // אייקון נחמד
        'supports'           => array( 'title', 'thumbnail' ) // כפי שביקשת: רק כותרת ותמונה ראשית
    );

    register_post_type( 'client', $args );
}
add_action( 'init', 'create_client_post_type' );

// ===== 2. רישום טקסונומיה: Client Category =====

function create_client_taxonomy() {
    $labels = array(
        'name'              => _x( 'Client Categories', 'taxonomy general name', 'your-theme-text-domain' ),
        'singular_name'     => _x( 'Client Category', 'taxonomy singular name', 'your-theme-text-domain' ),
        'search_items'      => __( 'Search Client Categories', 'your-theme-text-domain' ),
        'all_items'         => __( 'All Client Categories', 'your-theme-text-domain' ),
        'parent_item'       => __( 'Parent Client Category', 'your-theme-text-domain' ),
        'parent_item_colon' => __( 'Parent Client Category:', 'your-theme-text-domain' ),
        'edit_item'         => __( 'Edit Client Category', 'your-theme-text-domain' ),
        'update_item'       => __( 'Update Client Category', 'your-theme-text-domain' ),
        'add_new_item'      => __( 'Add New Client Category', 'your-theme-text-domain' ),
        'new_item_name'     => __( 'New Client Category Name', 'your-theme-text-domain' ),
        'menu_name'         => __( 'Client Categories', 'your-theme-text-domain' ),
    );

    $args = array(
        'hierarchical'      => true, // זה הופך את זה לקטגוריה (במקום תגית)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'client-category' ),
    );

    register_taxonomy( 'client_category', array( 'client' ), $args ); // משייך את הטקסונומיה לפוסט טייפ 'client'
}
add_action( 'init', 'create_client_taxonomy' );

/* =======================================
   AJAX Live Search Handler
   ======================================= */
add_action('wp_ajax_snir_live_search', 'snir_live_search_handler');
add_action('wp_ajax_nopriv_snir_live_search', 'snir_live_search_handler');

function snir_live_search_handler() {
    // ניקוי קלט
    $keyword = sanitize_text_field($_POST['keyword']);

    if (empty($keyword)) {
        wp_die();
    }

    // הגדרת השאילתה: חיפוש בפוסטים, שירותים ולקוחות
    $args = array(
        'post_type'      => array('post', 'services', 'client'),
        'post_status'    => 'publish',
        'posts_per_page' => 6, // מקסימום תוצאות
        's'              => $keyword,
    );

    $search_query = new WP_Query($args);

    if ($search_query->have_posts()) :
        while ($search_query->have_posts()) : $search_query->the_post();
            
            $post_type = get_post_type();
            $post_type_label = '';
            $badge_color = '';

            // התאמת תווית וצבע לפי סוג
            switch ($post_type) {
                case 'client':
                    $post_type_label = 'פרויקט/לקוח';
                    $badge_color = '#e91e63'; // קרימזון
                    break;
                case 'services':
                    $post_type_label = 'שירות';
                    $badge_color = '#00bcd4'; // ציאן
                    break;
                case 'post':
                    $post_type_label = 'מאמר';
                    $badge_color = '#4caf50'; // ירוק
                    break;
            }

            // בדיקת תמונה
            $thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') : ''; 
            ?>

            <a href="<?php the_permalink(); ?>" class="search-result-card animated-item">
                <div class="result-image" style="background-image: url('<?php echo $thumbnail ? esc_url($thumbnail) : ''; ?>');">
                    <?php if(!$thumbnail): ?><div class="no-img-placeholder"></div><?php endif; ?>
                </div>
                <div class="result-content">
                    <span class="result-type" style="background-color: <?php echo $badge_color; ?>">
                        <?php echo esc_html($post_type_label); ?>
                    </span>
                    <h4 class="result-title"><?php the_title(); ?></h4>
                </div>
            </a>

            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<div class="no-results">לא מצאנו תוצאות עבור "' . esc_html($keyword) . '" :(</div>';
    endif;

    wp_die();
}