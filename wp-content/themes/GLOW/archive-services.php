<?php
/**
 * The template for displaying 'Service' custom post type archive pages
 *
 * @package SnirTheme
 */

get_header(); 
?>

<section class="archive-banner">
    <div class="banner-content container">
        <h1 class="archive-title">
            <?php post_type_archive_title(); ?>
        </h1>
        
        <?php if ( get_the_archive_description() ) : ?>
            <div class="archive-description"><?php echo get_the_archive_description(); ?></div>
        <?php endif; ?>

        <div class="breadcrumbs">
            <?php
            if (function_exists('snir_theme_breadcrumbs')) {
                snir_theme_breadcrumbs();
            }
            ?>
        </div>
    </div>
</section>

<div class="site-content container">
    
    <?php
    // הגדרת שאילתה חדשה כדי למשוך את *כל* השירותים (-1)
    // זה עוקף את הגדרות ברירת המחדל של וורדפרס (שבדרך כלל מציגות 10 פוסטים)
    $args = array(
        'post_type'      => 'services',
        'posts_per_page' => -1, // מציג הכל ללא עמודים
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title', // סידור אופציונלי (לפי סדר תפריט או א'-ב')
        'order'          => 'ASC',
    );
    $services_query = new WP_Query($args);
    
    if ($services_query->have_posts()) :
    ?>
        <section class="archive-posts-grid">
            <div class="services-loop-container glass-grid">
                
                <?php while ($services_query->have_posts()) : $services_query->the_post();
                    // הגדרת משתנים
                    $service_link = get_permalink();
                    $service_title = get_the_title();
                    // שליפת האייקון מ-ACF (כמו בעמוד הבית)
                    $icon_image = get_field('icon'); 
                ?>
                    
                    <a href="<?php echo esc_url($service_link); ?>" class="service-card glass-card" aria-label="<?php echo esc_attr($service_title); ?>">
                        <div class="card-glow"></div>
                        
                        <div class="card-content">
                            <div class="card-header">
                                <span class="arrow-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                                </span>
                                
                                <div class="service-icon-wrapper">
                                    <?php if( $icon_image ) : ?>
                                        <img src="<?php echo esc_url($icon_image['url']); ?>" alt="<?php echo esc_attr($icon_image['alt']); ?>" class="service-icon">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-body">
                                <h3 class="service-card-title"><?php echo esc_html($service_title); ?></h3>
                                <div class="service-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                </div>
                            </div>
                        </div>
                    </a>

                <?php endwhile; ?>
            </div> 
        </section>

    <?php 
        // איפוס נתונים אחרי שימוש ב-WP_Query
        wp_reset_postdata();
        
    else : 
    ?>
        <section class="no-posts-found container">
            <h2><?php esc_html_e( 'לא נמצאו שירותים.', 'snir-theme' ); ?></h2>
            <p><?php esc_html_e( 'נראה שאין עדיין שירותים בארכיון זה.', 'snir-theme' ); ?></p>
        </section>
    <?php endif; ?>
    
</div>

<?php
get_footer(); 
?>