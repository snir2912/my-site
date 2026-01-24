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
    <?php if ( have_posts() ) : ?>
        
        <section class="archive-posts-grid">
            <div class="services-loop-container"> 
                <?php
                while ( have_posts() ) : the_post();
                    $service_link = get_permalink();
                    $service_title = get_the_title();
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium'); 
                ?>
                    <a href="<?php echo esc_url($service_link); ?>" class="service-card" aria-label="<?php echo esc_attr($service_title); ?>">
                        <div class="folder-cover"></div>
                        <div class="service-image-container">
                            <?php if ($thumbnail_url) : ?>
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($service_title); ?>" class="service-image">
                            <?php else: ?>
                                <div class="placeholder-image">אין תמונה</div>
                            <?php endif; ?>
                        </div>
                        <h3 class="service-card-title"><?php echo esc_html($service_title); ?></h3>
                    </a>
                <?php
                endwhile;
                ?>
            </div> 
        </section>

        <div class="pagination-wrapper">
            <?php
            the_posts_pagination( array(
                'prev_text'          => '<i class="fas fa-chevron-right"></i>', 
                'next_text'          => '<i class="fas fa-chevron-left"></i>', 
                'mid_size'           => 2, 
                'screen_reader_text' => __( 'Posts navigation', 'snir-theme' ), 
            ) );
            ?>
        </div>

    <?php else : ?>
        <section class="no-posts-found container">
            <h2><?php esc_html_e( 'לא נמצאו שירותים.', 'snir-theme' ); ?></h2>
            <p><?php esc_html_e( 'נראה שאין עדיין שירותים בארכיון זה.', 'snir-theme' ); ?></p>
        </section>
    <?php endif; ?>
</div>

<?php
get_footer(); 
?>