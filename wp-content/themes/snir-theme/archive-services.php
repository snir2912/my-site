<?php
/**
 * The template for displaying 'Service' custom post type archive pages
 *
 * @package SnirTheme
 */

get_header(); // כולל את קובץ ה-header.php
?>

<section class="archive-banner">
    <div class="banner-content container">
        <h1 class="archive-title">
            <?php
            // בדיקה האם מדובר בארכיון של סוג פוסט מותאם אישית
            if ( is_post_type_archive( 'service' ) ) :
                // נשתמש ב-post_type_archive_title() כדי להציג את כותרת הארכיון של השירותים
                post_type_archive_title( '', true ); 
            // אם זהו ארכיון כללי אחר (כמו בקוד המקורי, אם תרצה להשתמש בקובץ זה גם עבור קטגוריות שירותים)
            elseif ( is_category() ) :
                single_cat_title(); 
            // ... (מצבי ארכיון אחרים מהקוד המקורי, כגון is_tag, is_author וכו' אם רלוונטי)
            else :
                esc_html_e( 'Archives', 'snir-theme' );
            endif;
            ?>
        </h1>
        <?php
        // תיאור הארכיון - אם קיים
        if ( is_post_type_archive() && get_the_archive_description() ) :
            ?>
            <div class="archive-description"><?php echo get_the_archive_description(); ?></div>
        <?php
        endif;
        // ... (הוספת breadcrumbs אם יש קוד עבורם) ...
        ?>
    </div>
</section>
<hr>

<div class="site-content container">
    <?php if ( have_posts() ) : ?>
        <section class="archive-posts-grid">
            <div class="services-loop-container"> 
                <?php
                // לולאת וורדפרס ראשית להצגת הפוסטים (השירותים)
                while ( have_posts() ) : the_post();
                    // משתנים שימושיים
                    $service_link = get_permalink();
                    $service_title = get_the_title();
                    // שימוש ב-get_post_thumbnail_url() עם get_the_ID() כפרמטר ראשון מחוץ ללולאה הראשית לא נחוץ אך תקין
                    // מספיק get_the_post_thumbnail_url('medium')
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium'); 
                ?>
                    <a href="<?php echo esc_url($service_link); ?>" class="service-card" aria-label="<?php echo esc_attr($service_title); ?>">
                        <div class="folder-cover"></div>
                        <div class="service-image-container">
                            <?php if (has_post_thumbnail()) : ?>
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
        <hr>

        <?php
        // פגינציה (אם נדרש להצגה רגילה)
        the_posts_pagination( array(
            'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'snir-theme' ) . '</span><i class="fas fa-chevron-right"></i>', 
            'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'snir-theme' ) . '</span><i class="fas fa-chevron-left"></i>', 
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'snir-theme' ) . ' </span>',
            'mid_size'           => 2, 
            'screen_reader_text' => __( 'Posts navigation', 'snir-theme' ), 
            'class'              => 'pagination', 
        ) );

    else : // אם אין פוסטים בארכיון הזה
        ?>
        <section class="no-posts-found container">
            <h2><?php esc_html_e( 'Sorry, no posts found.', 'snir-theme' ); ?></h2>
            <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'snir-theme' ); ?></p>
            <?php get_search_form(); // הצג טופס חיפוש ?>
        </section>
    <?php endif; ?>
</div>
<hr>

<?php
get_footer(); // כולל את קובץ ה-footer.php
?>