<?php
/**
 * The template for displaying Client Archive pages.
 * עם סינון JS חי
 */

get_header(); 

// הגדרות כותרת (אפשר לשלוף משדה ACF באופשן פייג' בעתיד, כרגע סטטי ומרשים)
$archive_title = "הפרויקטים שלנו";
$archive_subtitle = "תיק עבודות נבחר המציג חדשנות, טכנולוגיה ויצירתיות.";
?>

<main id="primary" class="site-main client-archive-page">

    <section class="archive-hero">
        <div class="container">
            <h1 class="page-title"><?php echo esc_html($archive_title); ?></h1>
            <p class="page-subtitle"><?php echo esc_html($archive_subtitle); ?></p>
            
            <div class="archive-breadcrumbs">
                <?php
                if (function_exists('snir_theme_breadcrumbs')) {
                    snir_theme_breadcrumbs();
                }
                ?>
            </div>
        </div>
    </section>

    <section class="projects-filter-section">
        <div class="container">
            <div class="filter-buttons-group">
                <button class="filter-btn active" data-filter="all">כל הפרויקטים</button>
                
                <?php
                // שליפת כל הקטגוריות של הפרויקטים
                $terms = get_terms(array(
                    'taxonomy' => 'client_category',
                    'hide_empty' => true, // לא להציג קטגוריות ריקות
                ));

                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        // ה-slug ישמש אותנו לסינון ב-JS
                        echo '<button class="filter-btn" data-filter="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</button>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <section class="projects-grid-section">
        <div class="container">
            
            <?php if (have_posts()) : ?>
                <div class="projects-grid">
                    
                    <?php while (have_posts()) : the_post(); 
                        // שליפת הקטגוריות של הפוסט הנוכחי כדי להוסיף אותן כ-Class
                        $item_terms = get_the_terms(get_the_ID(), 'client_category');
                        $item_classes = '';
                        $primary_cat_name = '';
                        
                        if ($item_terms && !is_wp_error($item_terms)) {
                            foreach ($item_terms as $term) {
                                $item_classes .= ' ' . $term->slug; // שרשור הקטגוריות לקלאס
                            }
                            $primary_cat_name = $item_terms[0]->name; // שם הקטגוריה הראשונה לתצוגה
                        }
                    ?>

                        <article class="project-item <?php echo esc_attr($item_classes); ?>">
                            
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
                                    <?php if ($primary_cat_name) : ?>
                                        <span class="card-category-badge">
                                            <?php echo esc_html($primary_cat_name); ?>
                                        </span>
                                    <?php endif; ?>
                                    <h3 class="card-title"><?php the_title(); ?></h3>
                                </div>
                            </a>

                        </article>

                    <?php endwhile; ?>

                </div>
                
                <div class="pagination-wrapper">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __( 'הקודם', 'textdomain' ),
                        'next_text' => __( 'הבא', 'textdomain' ),
                    ));
                    ?>
                </div>

            <?php else : ?>
                <p class="no-projects-found">לא נמצאו פרויקטים כרגע.</p>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>