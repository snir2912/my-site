<?php
/*
Template Name: Front Page Template
*/
?>

<?php get_header(); ?>
<?php
$h1 = get_field('h1');
$hero_paragraph = get_field('hero_paragraph');
$services_headline = get_field('services_headline');
$why_us_headline = get_field('why_us_headline');
$why_us_paragraph = get_field('why_us_paragraph');
$cf_headline = get_field('cf_headline');
$cf_paragraph = get_field('cf_paragraph');
?>

<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php echo $h1 ?></h1>
            <p><?php echo $hero_paragraph ?></p>
            <div class="search-form-container">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label>
            <span class="screen-reader-text">חפש:</span>
            <input type="search" class="search-field" placeholder="חפש באתר..." value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
        </label>
        <button type="submit" class="search-submit">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
        </button>
    </form>

    <div id="search-results-live" class="search-results-live-panel">
        <ul class="results-list">
            </ul>
        <div class="all-results-link-container" style="display: none;">
             <a href="#" class="all-results-link">הצג את כל התוצאות</a>
        </div>
        <p class="no-results" style="display: none;">לא נמצאו תוצאות.</p>
    </div>
</div>
            <a href="#contact" class="btn primary-btn">בואו נדבר על הפרויקט שלכם</a>
        </div>
    </div>
</section>

<section class="services-section" id="services">
    <div class="container">
        <h2 class="section-title"><?php echo $services_headline ?></h2>
        <?php
// הגדרת הארגומנטים לשאילתה
$args = array(
    'post_type'      => 'services', // הפוסט טייפ שביקשת
    'posts_per_page' => -1,         // הצגת כל הפוסטים מהפוסט טייפ הזה
    'post_status'    => 'publish',
);

// יצירת שאילתה חדשה
$services_query = new WP_Query( $args );

// בדיקה אם יש פוסטים להציג
if ( $services_query->have_posts() ) :
?>

    <div class="services-loop-container">
        <?php
        // התחלת הלולאה
        while ( $services_query->have_posts() ) : $services_query->the_post();
            // משתנים שימושיים
            $service_link = get_permalink();
            $service_title = get_the_title();
            $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' ); // אפשר גם 'large' או גודל מותאם אישית
        ?>
            <a href="<?php echo esc_url( $service_link ); ?>" class="service-card" aria-label="<?php echo esc_attr( $service_title ); ?>">
                <div class="folder-cover"></div> <div class="service-image-container">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( $service_title ); ?>" class="service-image">
                    <?php else: ?>
                        <div class="placeholder-image">אין תמונה</div>
                    <?php endif; ?>
                </div>
                <h3 class="service-card-title"><?php echo esc_html( $service_title ); ?></h3>
            </a>

        <?php endwhile; ?>
    </div>

    <?php
    // איפוס נתוני הפוסט
    wp_reset_postdata();

else :
    // הודעה אם אין פוסטים
    echo '<p>אין שירותים זמינים כרגע.</p>';
endif;
?>
        <div class="services-grid">
            <div class="service-item">
                <h3>בניית דפי נחיתה</h3>
                <p>דפי נחיתה ממוקדים ואפקטיביים המיועדים להמיר גולשים ללקוחות.</p>
            </div>
            <div class="service-item">
                <h3>כרטיס ביקור דיגיטלי</h3>
                <p>פתרון חדשני ומרשים להצגה מקצועית של העסק שלך ברשת.</p>
            </div>
            <div class="service-item">
                <h3>מיני סייט (3 עמודים)</h3>
                <p>אתר תדמיתי קומפקטי המכיל את כל המידע החשוב על העסק שלך.</p>
            </div>
            <div class="service-item">
                <h3>אתר תדמית</h3>
                <p>נוכחות אונליין מקצועית המציגה את הערכים והמומחיות של העסק.</p>
            </div>
            <div class="service-item">
                <h3>אתר בלוג</h3>
                <p>פלטפורמה שיתופית ליצירת תוכן איכותי, הגדלת תנועה וחיזוק המותג.</p>
            </div>
            <div class="service-item">
                <h3>אתר קטלוג מוצרים</h3>
                <p>הצגה ויזואלית ומרשימה של מגוון המוצרים שלך, עם אפשרויות סינון מתקדמות.</p>
            </div>
            <div class="service-item">
                <h3>אתר חנות (E-commerce)</h3>
                <p>חנות מקוונת מתקדמת, מאובטחת וידידותית למשתמש למכירה ישירה של מוצרים.</p>
            </div>
        </div>
    </div>
</section>

<section class="about-our-service-section" id="why-us">
    <div class="container">
        <h2 class="section-title"><?php echo $why_us_headline ?></h2>
        <p><?php echo $why_us_paragraph ?></p>
        <!-- <?php echo do_shortcode('[contact-form-7 id="285c83c" title="טופס צור קשר"]'); ?> -->
    </div>
</section>

<section class="latest-blog-posts">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e('מאמרים אחרונים', 'snir-theme'); ?></h2>
        <div class="related-posts-grid"> <?php
                                            // שאילתה לפוסטים האחרונים
                                            $latest_posts_args = array(
                                                'post_type'      => 'post',
                                                'posts_per_page' => 3, // כמה פוסטים להציג (כדי שיתאים ל-3 בעמודה)
                                                'orderby'        => 'date',
                                                'order'          => 'DESC',
                                                'ignore_sticky_posts' => true, // לא להתייחס לפוסטים נעוצים
                                            );

                                            $latest_posts_query = new WP_Query($latest_posts_args);

                                            if ($latest_posts_query->have_posts()) :
                                                while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post();
                                                    // שימוש בקומפוננטת כרטיס המאמר הקיימת
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
                                                wp_reset_postdata(); // חשוב לאפס את נתוני הפוסט לאחר לולאה משנית
                                            else :
                                                // אם אין פוסטים להציג
                ?>
                <p><?php esc_html_e('אין עדיין פוסטים בבלוג.', 'snir-theme'); ?></p>
            <?php endif; ?>
        </div>
    </div>


    <?php
    // אופציונלי: כפתור "לכל הפוסטים"
    $blog_page_id = get_option('page_for_posts'); // מזהה עמוד הבלוג הראשי אם הוגדר
    if ($blog_page_id) :
    ?>
        <div style="text-align: center; margin-top: 40px;">
            <a href="<?php echo esc_url(get_permalink($blog_page_id)); ?>" class="card-button">
                <?php esc_html_e('לכל הפוסטים בבלוג', 'snir-theme'); ?>
            </a>
        </div>
    <?php
    endif;
    ?>

    </div>
</section>

<?php
// בדיקה אם יש רקע וידאו או תמונה שהוגדרו ב-ACF
$video_background = get_field('video_background');
$img_background = get_field('img_backgrond');

$section_style = '';
$has_background = false;

if ($video_background) {
    // אם יש וידאו, נגדיר אותו כרקע
    $section_style .= 'background: url(' . esc_url($video_background['url']) . ') no-repeat center center / cover;';
    $has_background = true;
} elseif ($img_background) {
    // אם אין וידאו אבל יש תמונה, נשתמש בה
    $section_style .= 'background: url(' . esc_url($img_background['url']) . ') no-repeat center center / cover;';
    $has_background = true;
}
?>

<section class="faq-section" id="faq" style="<?php echo esc_attr($section_style); ?>">
    <?php if ($has_background) : ?>
        <div class="background-overlay"></div>
    <?php endif; ?>
    <div class="container">
        <h2 class="section-title">שאלות נפוצות</h2>
        <div class="faq-accordion">
            <?php
            if (have_rows('faq')) :
                while (have_rows('faq')) : the_row();
                    $question = get_sub_field('question');
                    $answer = get_sub_field('answer');
            ?>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span class="faq-icon">?</span>
                            <h3 class="question-text"><?php echo esc_html($question); ?></h3>
                            <div class="toggle-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <?php echo $answer; ?>
                        </div>
                    </div>
                <?php
                endwhile;
            else :
                ?>
                <p>אין עדיין שאלות נפוצות.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<div class="contact-form" id="contact">
    <div class="cintainer">
        <h2><?php echo $cf_headline ?></h2>
        <p><?php echo $cf_paragraph ?></p>
        <?php echo do_shortcode('[contact-form-7 id="285c83c" title="טופס צור קשר"]'); ?>
    </div>
</div>

<?php get_footer(); ?>