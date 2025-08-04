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
?>

<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php echo $h1 ?></h1>
            <p><?php echo $hero_paragraph ?></p>
            <a href="#contact" class="btn primary-btn">בואו נדבר על הפרויקט שלכם</a>
        </div>
    </div>
</section>

<section class="services-section" id="services">
    <div class="container">
        <h2 class="section-title"><?php echo $services_headline ?></h2>
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
        <h2 class="section-title"><?php esc_html_e('החדשות בבלוג שלנו', 'snir-theme'); ?></h2>

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
<div>
    <?php echo do_shortcode('[contact-form-7 id="285c83c" title="טופס צור קשר"]'); ?>
</div>

<?php get_footer(); ?>