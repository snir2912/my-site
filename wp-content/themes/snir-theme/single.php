<?php

/**
 * The template for displaying all single posts
 *
 * @package SnirTheme
 */

get_header();

// Loop WordPress ראשי
while (have_posts()) :
    the_post();
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <section class="post-banner"
            <?php
            // נמשוך את התמונה הראשית כ-inline style עבור background-image
            if (has_post_thumbnail()) {
                echo 'style="background-image: url(\'' . esc_url(get_the_post_thumbnail_url(null, 'full')) . '\');"';
            }
            ?>>
            <div class="banner-content">
                <h1 class="post-title"><?php the_title(); ?></h1>
                <?php
                // פירורי לחם (Breadcrumbs)
                if (function_exists('snir_theme_breadcrumbs')) {
                    snir_theme_breadcrumbs();
                }
                ?>
            </div>
        </section>
        </div>
        <section class="single-post-content container">
            <section class="single-post-content container">
                <div class="font-size-controls">
                    <button id="decrease-font-size" aria-label="הקטן גודל פונט">
                        <span class="font-icon smaller">א</span>
                        <span class="button-label">הקטן</span>
                    </button>
                    <button id="increase-font-size" aria-label="הגדל גודל פונט">
                        <span class="font-icon bigger">א</span>
                        <span class="button-label">הגדל</span>
                    </button>
                </div>
                <?php the_content(); ?>

                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'snir-theme'),
                    'after'  => '</div>',
                ));
                ?>
            </section>

            <?php
            $categories = get_the_category(get_the_ID());
            if ($categories) :
                $category_ids = array();
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }

                $related_posts_args = array(
                    'category__in'   => $category_ids,
                    'post__not_in'   => array(get_the_ID()),
                    'posts_per_page' => 3,
                    'orderby'        => 'rand',
                );

                $related_posts_query = new WP_Query($related_posts_args);

                if ($related_posts_query->have_posts()) :
            ?>
                    <section class="related-posts-section">
                        <div class="container">
                            <h2 class="section-title"><?php esc_html_e('מאמרים נוספים שעשויים לעניין אתכם', 'snir-theme'); ?></h2>
                            <div class="related-posts-grid">
                                <?php while ($related_posts_query->have_posts()) : $related_posts_query->the_post(); ?>
                                    <div class="article-card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="card-image">
                                            </a>
                                        <?php endif; ?>
                                        <div class="card-content">
                                            <?php
                                            $post_categories = get_the_category();
                                            if (! empty($post_categories)) {
                                                $first_category = $post_categories[0];
                                                echo '<div class="card-category"><a href="' . esc_url(get_category_link($first_category->term_id)) . '">' . esc_html($first_category->name) . '</a></div>';
                                            }
                                            ?>
                                            <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <div class="card-excerpt">
                                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                            </div>
                                            <a href="<?php the_permalink(); ?>" class="card-button">
                                                <?php esc_html_e('למאמר המלא', 'snir-theme'); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </section>
            <?php
                endif;
                wp_reset_postdata();
            endif;
            ?>

    </article><?php
            endwhile;

            get_footer();
