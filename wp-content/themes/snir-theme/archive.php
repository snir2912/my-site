<?php

/**
 * The template for displaying archive pages
 *
 * @package SnirTheme
 */

get_header(); // כולל את קובץ ה-header.php
?>

<section class="archive-banner">
    <div class="banner-content container">
        <h1 class="archive-title">
            <?php
            // שינוי כאן: נשתמש ב-single_cat_title() ללא פרמטרים או רק עם סיומת
            if (is_category()) :
                single_cat_title(); // מציג את שם הקטגוריה בלבד, ללא הקידומת 'Category:'
            elseif (is_tag()) :
                single_tag_title('', true); // מציג את שם התג בלבד
            elseif (is_author()) :
                the_post();
                echo esc_html__('Author: ', 'snir-theme') . get_the_author();
                rewind_posts();
            elseif (is_day()) :
                echo esc_html__('Daily Archives: ', 'snir-theme') . get_the_date();
            elseif (is_month()) :
                echo esc_html__('Monthly Archives: ', 'snir-theme') . get_the_date(_x('F Y', 'monthly archives date format', 'snir-theme'));
            elseif (is_year()) :
                echo esc_html__('Yearly Archives: ', 'snir-theme') . get_the_date(_x('Y', 'yearly archives date format', 'snir-theme'));
            else :
                esc_html_e('Archives', 'snir-theme');
            endif;
            ?>
        </h1>
        <div class="banner-breadcrumbs">
            <?php
            if (function_exists('snir_theme_breadcrumbs')) {
                snir_theme_breadcrumbs();
            }
            ?>
        </div>
    </div>
</section>

<div class="site-content container">
    <?php if (have_posts()) : ?>
        <section class="archive-posts-grid">
            <?php
            // לולאת וורדפרס ראשית להצגת הפוסטים
            while (have_posts()) : the_post();
                // נשתמש בקומפוננטת כרטיס המאמר הקיימת
            ?>
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
            <?php
            endwhile;
            ?>
        </section>

    <?php
        // פגינציה
        the_posts_pagination(array(
            'prev_text'          => '<span class="screen-reader-text">' . esc_html__('Previous page', 'snir-theme') . '</span><i class="fas fa-chevron-right"></i>', // שנה לחץ מתאים
            'next_text'          => '<span class="screen-reader-text">' . esc_html__('Next page', 'snir-theme') . '</span><i class="fas fa-chevron-left"></i>', // שנה לחץ מתאים
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'snir-theme') . ' </span>',
            'mid_size'           => 2, // מספר קישורי עמודים לפני ואחרי העמוד הנוכחי
            'screen_reader_text' => __('Posts navigation', 'snir-theme'), // טקסט נגישות
            'class'              => 'pagination', // הקלאס שיצרנו עבור הסגנונות ב-SCSS
        ));

    else : // אם אין פוסטים בארכיון הזה
    ?>
        <section class="no-posts-found container">
            <h2><?php esc_html_e('Sorry, no posts found.', 'snir-theme'); ?></h2>
            <p><?php esc_html_e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'snir-theme'); ?></p>
            <?php get_search_form(); // הצג טופס חיפוש 
            ?>
        </section>
    <?php endif; ?>
</div>

<?php
get_footer(); // כולל את קובץ ה-footer.php
?>