<?php
// ajax-search.php
// טוען את קובץ וורדפרס כדי לאפשר שימוש בפונקציות הליבה
require_once('../../../wp-load.php');

// בדיקת אבטחה בסיסית - לוודא שהבקשה הגיעה בשיטת GET ושיש פרמטר חיפוש
if (!isset($_GET['s']) || empty($_GET['s'])) {
    wp_send_json_error('No search query provided.');
    exit;
}

// קבלת מילת החיפוש מהבקשה
$search_query = sanitize_text_field($_GET['s']);

// הגדרת ארגומנטים לשאילתה
$args = array(
    'post_type'      => array('post', 'services'), // סוגי פוסטים לחיפוש
    's'              => $search_query,            // מילת החיפוש
    'posts_per_page' => 3,                        // מספר התוצאות המקסימלי להצגה
    'post_status'    => 'publish',
);

// יצירת שאילתה חדשה
$query = new WP_Query($args);

$results = array();

// בדיקה אם יש תוצאות
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $results[] = array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'post_type' => get_post_type($post_id),
        );
    }
}

// איפוס נתוני הפוסט
wp_reset_postdata();

// שליחת הנתונים בפורמט JSON
wp_send_json_success($results);
?>