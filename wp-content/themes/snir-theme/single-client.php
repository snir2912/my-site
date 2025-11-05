<?php
/**
 * The template for displaying a single Client post.
 * (v6 - תיקון גלריה לטיפול בנתוני ACF מעורבים)
 */

get_header(); // טוען את ה-header של האתר

// משתנים ראשיים לפוסט הנוכחי
$client_id = get_the_ID();
$client_title = get_the_title();

// שדות ACF
$client_description = get_field('client_description');
$client_website_url = get_field('client_website_url');
$project_gallery = get_field('project_gallery'); // קבלת הגלריה

// טקסונומיה (קטגוריות)
$client_categories = get_the_terms($client_id, 'client_category');
$primary_category = null;
if (!empty($client_categories) && !is_wp_error($client_categories)) {
    $primary_category = $client_categories[0]; // לוקח את הקטגוריה הראשונה
}

// תמונת באנר (תמונה ראשית)
$banner_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url($client_id, 'full') : ''; // השתמש ב-full לגמישות

?>

<main id="primary" class="site-main single-client-page">

    <?php while ( have_posts() ) : the_post(); ?>

        <header class="client-banner" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('<?php echo esc_url($banner_image_url); ?>');">
            <div class="banner-content">
                <h1 class="banner-title"><?php echo esc_html($client_title); ?></h1>
                
                <div class="banner-breadcrumbs">
                    <?php
                    if (function_exists('snir_theme_breadcrumbs')) {
                        snir_theme_breadcrumbs();
                    }
                    ?>
                </div>

            </div>
        </header>

        <div class="client-content-wrapper">
            <div class="client-main-content">
                
                <div class="client-meta">
                    <?php if ($primary_category) : ?>
                        <span class="client-category-badge">
                            <?php echo esc_html($primary_category->name); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($client_website_url) : ?>
                        <a href="<?php echo esc_url($client_website_url); ?>" class="client-website-link" target="_blank" rel="noopener noreferrer">
                            בקרו באתר של <?php echo esc_html($client_title); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ($client_description) : ?>
                    <div class="client-description">
                        <?php echo wp_kses_post($client_description); // משתמש ב-wp_kses_post כי זה מ-WYSIWYG ?>
                    </div>
                <?php endif; ?>

                <?php if ($project_gallery) : ?>
                    <section class="project-gallery-section">
                        <h2>תמונות מהפרויקט</h2>
                        <div class="project-gallery-grid">
                            
                            <?php foreach ($project_gallery as $image_data) : ?>
                                
                                <?php
                                // --- לוגיקה חדשה: בדיקת סוג הנתונים ---
                                $image_full_url = '';
                                $image_thumb_url = '';
                                $image_alt = '';
                                $image_caption = '';

                                if (is_array($image_data)) {
                                    // מצב תקין: הנתונים הם "מערך תמונה"
                                    $image_full_url = $image_data['url'];
                                    $image_thumb_url = $image_data['sizes']['medium_large'];
                                    $image_alt = $image_data['alt'];
                                    $image_caption = $image_data['caption'];
                                } else {
                                    // מצב תיקון: הנתונים הם "מזהה תמונה" (ID)
                                    $image_id = (int) $image_data;
                                    $image_full_url = wp_get_attachment_url($image_id);
                                    $image_thumb_url = wp_get_attachment_image_url($image_id, 'medium_large');
                                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                    $image_caption = wp_get_attachment_caption($image_id);
                                }
                                // --- סוף לוגיקה חדשה ---
                                ?>

                                <?php if ($image_full_url && $image_thumb_url) : // ודא שיש לנו קישורים לעבוד איתם ?>
                                    <a href="<?php echo esc_url($image_full_url); ?>" 
                                       class="gallery-item"
                                       data-caption="<?php echo esc_attr($image_caption); ?>">
                                        
                                        <img src="<?php echo esc_url($image_thumb_url); ?>" 
                                             alt="<?php echo esc_attr($image_alt); ?>" />
                                    </a>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
                </div>

            <aside class="client-contact-sidebar">
                <div class="client-contact-form">
                    <h3>מעוניינים בפרויקט דומה?</h3>
                    <p>דברו איתנו ונשמח לעזור.</p>
                    <?php echo do_shortcode('[contact-form-7 id="285c83c" title="טופס צור קשר"]'); ?>
                </div>
            </aside>
        </div>

        <?php
        $related_clients_query = null;
        if ($primary_category) {
            $args = array(
                'post_type' => 'client',
                'posts_per_page' => 3, // הצג עד 3 לקוחות נוספים
                'post__not_in' => array($client_id), // אל תכלול את הלקוח הנוכחי
                'tax_query' => array(
                    array(
                        'taxonomy' => 'client_category',
                        'field' => 'term_id',
                        'terms' => $primary_category->term_id,
                    ),
                ),
            );
            $related_clients_query = new WP_Query($args);
        }
        ?>

        <?php if ($related_clients_query && $related_clients_query->have_posts()) : ?>
            <section class="related-clients-section">
                <div class="related-clients-wrapper">
                    <h2>לקוחות נוספים מ-<?php echo esc_html($primary_category->name); ?></h2>
                    <div class="related-clients-grid">
                        
                        <?php while ($related_clients_query->have_posts()) : $related_clients_query->the_post(); ?>
                            
                            <?php
                            $related_id = get_the_ID();
                            $related_categories = get_the_terms($related_id, 'client_category');
                            $related_primary_category = null;
                            if (!empty($related_categories) && !is_wp_error($related_categories)) {
                                $related_primary_category = $related_categories[0];
                            }
                            ?>

                            <a href="<?php the_permalink(); ?>" class="client-card">
                                <div class="card-image-wrapper">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large'); // תמונה בגודל בינוני-גדול ?>
                                    <?php else : ?>
                                        <div class="card-image-placeholder"></div>
                                    <?php endif; ?>
                                    <div class="card-image-overlay"></div>
                                </div>
                                <div class="card-content">
                                    <?php if ($related_primary_category) : ?>
                                        <span class="card-category-badge">
                                            <?php echo esc_html($related_primary_category->name); ?>
                                        </span>
                                    <?php endif; ?>
                                    <h3 class="card-title"><?php the_title(); ?></h3>
                                </div>
                            </a>

                        <?php endwhile; ?>

                    </div>
                </div>
            </section>
            <?php wp_reset_postdata();?>
        <?php endif; ?>


    <?php endwhile;  ?>

</main><?php
get_footer(); 
?>