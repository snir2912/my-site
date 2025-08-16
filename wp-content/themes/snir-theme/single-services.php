<?php
/**
 * The template for displaying a single 'service' custom post type.
 */

get_header();

// Get the ACF field values
$banner_image = get_field('banner_image');
$subtitle = get_field('subtitle');
$section_1_title = get_field('section_1_title');
$section_1_content = get_field('section_1_content');
$atmosphere_image_1 = get_field('atmosphere_image_1');
$section_2_title = get_field('section_2_title');
$section_2_content = get_field('section_2_content');
$atmosphere_image_2 = get_field('atmosphere_image_2');
$cta_button_text = get_field('cta_button_text');

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while ( have_posts() ) : the_post(); ?>

            <section class="service-banner" style="background-image: url('<?php echo esc_url($banner_image['url']); ?>');">
                <div class="banner-overlay"></div>
                <div class="banner-content">
                    <?php if ($subtitle) : ?>
                        <p class="banner-subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <div class="breadcrumbs">
                        <?php
                            if (function_exists('yoast_breadcrumb')) {
                                yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                            } else {
                                echo '<a href="' . esc_url(home_url('/')) . '">Home</a> &raquo; ' . get_the_title();
                            }
                        ?>
                    </div>
                </div>
            </section>

            <div class="container-wrapper">
                <div class="service-content-main">
                    <?php if ($section_1_title || $section_1_content || $atmosphere_image_1) : ?>
                        <section class="service-section">
                            <div class="text-and-image-row first-row">
                                <div class="text-col fade-in-up">
                                    <?php if ($section_1_title) : ?>
                                        <h2><?php echo esc_html($section_1_title); ?></h2>
                                    <?php endif; ?>
                                    <?php if ($section_1_content) : ?>
                                        <div class="content-text"><?php echo $section_1_content; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="image-col fade-in-up">
                                    <?php if ($atmosphere_image_1) : ?>
                                        <img src="<?php echo esc_url($atmosphere_image_1['sizes']['large']); ?>" alt="<?php echo esc_attr($atmosphere_image_1['alt']); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if ($cta_button_text) : ?>
                        <section class="cta-section">
                            <a href="#contact-form-section" class="cta-button pulse-effect"><?php echo esc_html($cta_button_text); ?></a>
                        </section>
                    <?php endif; ?>

                    <?php if ($section_2_title || $section_2_content || $atmosphere_image_2) : ?>
                        <section class="service-section">
                            <div class="text-and-image-row second-row">
                                <div class="image-col fade-in-up">
                                    <?php if ($atmosphere_image_2) : ?>
                                        <img src="<?php echo esc_url($atmosphere_image_2['sizes']['large']); ?>" alt="<?php echo esc_attr($atmosphere_image_2['alt']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="text-col fade-in-up">
                                    <?php if ($section_2_title) : ?>
                                        <h2><?php echo esc_html($section_2_title); ?></h2>
                                    <?php endif; ?>
                                    <?php if ($section_2_content) : ?>
                                        <div class="content-text"><?php echo $section_2_content; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                </div>

                <aside class="service-sidebar">
                    <div class="sidebar-block other-services">
                        <h3>שירותים נוספים</h3>
                        <ul>
                            <?php
                                $args = array(
                                    'post_type' => 'service',
                                    'posts_per_page' => -1,
                                    'post__not_in' => array( get_the_ID() )
                                );
                                $other_services_query = new WP_Query( $args );

                                if ( $other_services_query->have_posts() ) :
                                    while ( $other_services_query->have_posts() ) : $other_services_query->the_post();
                                        $sidebar_thumbnail = get_field('banner_image');
                            ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if ($sidebar_thumbnail) : ?>
                                                <div class="sidebar-thumbnail" style="background-image: url('<?php echo esc_url($sidebar_thumbnail['sizes']['medium']); ?>');"></div>
                                            <?php else : ?>
                                                <div class="sidebar-thumbnail placeholder"></div>
                                            <?php endif; ?>
                                            <h4><?php the_title(); ?></h4>
                                        </a>
                                    </li>
                            <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                            ?>
                        </ul>
                    </div>
                </aside>
            </div>

            <section id="contact-form-section" class="contact-form-section">
                <h2>צרו קשר</h2>
                <?php echo do_shortcode('[contact-form-7 id="285c83c" title="טופס צור קשר"]'); ?>
            </section>

        <?php endwhile; // End of the loop. ?>
    </main></div><?php
get_footer();
?>