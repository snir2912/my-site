<?php

/**
 * The template for displaying Client Archive pages.
 * כולל באנר מעוצב וסינון פרויקטים חי.
 */

get_header();
?>

<section class="archive-banner">
    <div class="banner-content container">
        <h1 class="archive-title">הפרויקטים שלנו</h1>
        <div class="breadcrumbs">
            <div class="banner-breadcrumbs">
                <?php
                if (function_exists('snir_theme_breadcrumbs')) {
                    snir_theme_breadcrumbs();
                }
                ?>
            </div>
        </div>
    </div>
</section>

<div class="site-content container">

    <section class="projects-filter-bar">
        <button class="filter-btn active" data-filter="all">כל הפרויקטים</button>
        <?php
        // שליפת כל הקטגוריות הקיימות בטקסונומיה client_category
        $terms = get_terms(array(
            'taxonomy' => 'client_category',
            'hide_empty' => true,
        ));

        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                // הכפתור מכיל את ה-Slug של הקטגוריה ב-data-filter
                echo '<button class="filter-btn" data-filter="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</button>';
            }
        }
        ?>
    </section>

    <?php if (have_posts()) : ?>

        <section class="client-archive-grid">
            <?php while (have_posts()) : the_post();

                // שליפת נתונים לכרטיס
                $client_id = get_the_ID();
                $client_categories = get_the_terms($client_id, 'client_category');
                $primary_category = null;
                $item_classes = ''; // משתנה לקלאסים של הקטגוריות (לסינון)

                if (!empty($client_categories) && !is_wp_error($client_categories)) {
                    $primary_category = $client_categories[0];

                    // יצירת רשימת קלאסים לסינון (למשל: "tech finance")
                    foreach ($client_categories as $cat) {
                        $item_classes .= ' ' . $cat->slug;
                    }
                }
            ?>

                <div class="project-item <?php echo esc_attr($item_classes); ?>">

                    <a href="<?php the_permalink(); ?>" class="client-card">
                        <div class="card-image-wrapper">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else : ?>
                                <div class="card-image-placeholder"></div>
                            <?php endif; ?>
                            <div class="card-image-overlay"></div>
                        </div>
                        <div class="card-content">
                            <?php if ($primary_category) : ?>
                                <span class="card-category-badge">
                                    <?php echo esc_html($primary_category->name); ?>
                                </span>
                            <?php endif; ?>
                            <h3 class="card-title"><?php the_title(); ?></h3>
                        </div>
                    </a>

                </div>

            <?php endwhile; ?>
        </section>

        <div class="pagination-wrapper">
            <?php
            the_posts_pagination(array(
                'prev_text'          => '<i class="fas fa-chevron-right"></i>',
                'next_text'          => '<i class="fas fa-chevron-left"></i>',
                'mid_size'           => 2,
                'screen_reader_text' => __('Posts navigation', 'snir-theme'),
            ));
            ?>
        </div>

    <?php else : ?>
        <section class="no-posts-found container">
            <h2>לא נמצאו פרויקטים כרגע.</h2>
        </section>
    <?php endif; ?>

</div>

<?php get_footer(); ?>