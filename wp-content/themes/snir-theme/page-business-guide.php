<?php
/*
Template Name: Business Guide Template
*/

get_header(); 

$page_id = get_the_ID();
$page_title = get_the_title();
$banner_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url($page_id, 'full') : ''; 

$guide_subtitle = get_field('guide_subtitle');
$guide_cta_title = get_field('guide_cta_title');
$guide_cta_text = get_field('guide_cta_text');
?>

<main id="primary" class="site-main business-guide-page">

    <header class="client-banner" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url('<?php echo esc_url($banner_image_url); ?>');">
        <div class="banner-content">
            <h1 class="banner-title"><?php echo esc_html($page_title); ?></h1>
            <div class="banner-breadcrumbs">
                <?php if (function_exists('snir_theme_breadcrumbs')) snir_theme_breadcrumbs(); ?>
            </div>
        </div>
    </header>

    <?php if ($guide_subtitle) : ?>
    <section class="guide-intro">
        <div class="container">
            <p class="intro-text"><?php echo wp_kses_post($guide_subtitle); ?></p>
        </div>
    </section>
    <?php endif; ?>

    <?php if (have_rows('guide_steps')) : ?>
    <section class="guide-timeline-section">
        <div class="container">
            <div class="timeline">
                
                <?php 
                $step_count = 0;
                while (have_rows('guide_steps')) : the_row(); 
                    $step_count++;
                    $icon = get_sub_field('step_icon');
                    $title = get_sub_field('step_title');
                    $content = get_sub_field('step_content');
                ?>
                    <div class="timeline-item js-scroll-trigger">
                        <div class="timeline-icon">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="step-header">
                                <div class="step-number">0<?php echo $step_count; ?></div>
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                            <div class="step-body">
                                <?php echo wp_kses_post($content); ?>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="guide-cta-section">
        <div class="container">
            <div class="cta-content">
                <?php if ($guide_cta_title) : ?>
                    <h2 class="cta-title"><?php echo esc_html($guide_cta_title); ?></h2>
                <?php endif; ?>
                
                <?php if ($guide_cta_text) : ?>
                    <p class="cta-text"><?php echo wp_kses_post($guide_cta_text); ?></p>
                <?php endif; ?>
            </div>

            <div class="guide-form-wrapper">
                <?php echo do_shortcode('[contact-form-7 id="285c83c" title="טופס צור קשר" html_class="compact-form"]'); ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>