<?php
/*
Template Name: Front Page Template
*/
?>

<?php get_header(); ?>

<?php
// תחילת לולאת וורדפרס
// ודא שהעמוד שהוגדר כעמוד הבית (Front Page) בהגדרות קריאה מכיל את השדות של JetEngine.
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); // The Loop מתחילה כאן!
        $h1 = get_field('h1');
        $hero_paragraph = get_field( 'hero_paragraph' );
        $services_headline = get_field( 'services_headline' );
        $service_items = get_field( 'service' );
        $why_us_headline = get_field( 'why_us_headline' );
        $why_us_paragraph = get_field( 'why_us_paragraph' );
?> 

<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php
                // הצגת ה-h1
                if ( ! empty( $h1 ) ) {
                    echo esc_html( $h1 ); // ללא תג <p> מיותר בתוך h1
                } else {
                    echo 'כותרת ראשית (H1) חסרה'; // הודעת ברירת מחדל אם השדה ריק
                }
            ?></h1>
            <p>
                <?php
                // הצגת פסקת ההירו
                if ( ! empty( $hero_paragraph ) ) {
                    echo wp_kses_post( $hero_paragraph ); // השתמש ב-wp_kses_post אם מותר HTML
                } else {
                    echo 'תוכן פסקת הירו חסר.'; // הודעת ברירת מחדל
                }
                ?>
            </p>
            <a href="#contact" class="btn primary-btn">בואו נדבר על הפרויקט שלכם</a>
        </div>
    </div>
</section>

<section class="services-section" id="services">
    <div class="container">
        <h2 class="section-title"><?php
            // הצגת כותרת השירותים
            if ( ! empty( $services_headline ) ) {
                echo esc_html( $services_headline );
            } else {
                echo 'השירותים שלנו'; // כותרת ברירת מחדל
            }
        ?></h2>
        <div class="services-grid">
            <?php
            // **לולאה על שדה הרפטר 'service'**
            if ( ! empty( $service_items ) && is_array( $service_items ) ) {
                foreach ( $service_items as $single_service ) {
                    // גישה לשדות המשנה בתוך כל פריט רפטר
                    // שימו לב לשמות השדות בתוך הרפטר: 'icon', 'service_headline', 'service_description'
                    $icon_id = ! empty( $single_service['icon'] ) ? $single_service['icon'] : '';
                    $service_title = ! empty( $single_service['service_headline'] ) ? $single_service['service_headline'] : '';
                    $service_desc = ! empty( $single_service['service_description'] ) ? $single_service['service_description'] : '';
            ?>
                    <div class="service-item">
                        <?php if ( $icon_id ) : ?>
                            <?php echo wp_get_attachment_image( $icon_id, 'thumbnail' ); // מציג את התמונה לפי ה-ID שלה ?>
                        <?php endif; ?>
                        <h3><?php echo esc_html( $service_title ); ?></h3>
                        <p><?php echo esc_html( $service_desc ); ?></p>
                    </div>
            <?php
                } // סוף foreach
            } else {
                // תוכן ברירת מחדל אם אין שירותים מוגדרים דרך הרפטר
                ?>
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
                <?php
            }
            ?>
        </div>
    </div>
</section>

<section class="about-our-service-section" id="why-us">
    <div class="container">
        <h2 class="section-title"><?php
            // הצגת כותרת "למה לבחור בנו"
            if ( ! empty( $why_us_headline ) ) {
                echo esc_html( $why_us_headline );
            } else {
                echo 'למה לבחור בנו? חווית שירות יוצאת דופן'; // כותרת ברירת מחדל
            }
        ?></h2>
        <p>
            <?php
            // הצגת פסקת "למה לבחור בנו"
            if ( ! empty( $why_us_paragraph ) ) {
                echo wp_kses_post( $why_us_paragraph ); // שימוש ב-wp_kses_post מאפשר HTML בטוח
            } else {
                echo 'תוכן "למה לבחור בנו" חסר.'; // הודעת ברירת מחדל
            }
            ?>
        </p>
    </div>
</section>

<section class="latest-blog-posts related-posts-section">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'החדשות בבלוג שלנו', 'snir-theme' ); ?></h2>

        <div class="related-posts-grid">
            <?php
            // שאילתה לפוסטים האחרונים
            $latest_posts_args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'ignore_sticky_posts' => true,
            );

            $latest_posts_query = new WP_Query( $latest_posts_args );

            if ( $latest_posts_query->have_posts() ) :
                while ( $latest_posts_query->have_posts() ) : $latest_posts_query->the_post();
            ?>
                    <div class="article-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="card-image">
                            </a>
                        <?php endif; ?>
                        <div class="card-content">
                            <?php
                            $post_categories = get_the_category();
                            if ( ! empty( $post_categories ) ) {
                                $first_category = $post_categories[0];
                                echo '<div class="card-category"><a href="' . esc_url( get_category_link( $first_category->term_id ) ) . '">' . esc_html( $first_category->name ) . '</a></div>';
                            }
                            ?>
                            <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="card-excerpt">
                                <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="card-button">
                                <?php esc_html_e( 'למאמר המלא', 'snir-theme' ); ?>
                            </a>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata(); // חשוב לאפס את נתוני הפוסט לאחר לולאה משנית
            else :
                ?>
                <p><?php esc_html_e( 'אין עדיין פוסטים בבלוג.', 'snir-theme' ); ?></p>
            <?php endif; ?>
        </div>

        <?php
        $blog_page_id = get_option('page_for_posts');
        if ( $blog_page_id ) :
        ?>
            <div style="text-align: center; margin-top: 40px;">
                <a href="<?php echo esc_url( get_permalink( $blog_page_id ) ); ?>" class="card-button">
                    <?php esc_html_e( 'לכל הפוסטים בבלוג', 'snir-theme' ); ?>
                </a>
            </div>
        <?php
        endif;
        ?>

    </div>
</section>

<?php
    endwhile; // The Loop מסתיימת כאן!
else :
    // תוכן שיוצג אם אין עמוד בית (או אם אין פוסטים כלל, במקרה של בלוג ראשי)
    echo '<p>הגדר עמוד בית עבור האתר שלך בהגדרות &raquo; קריאה.</p>';
endif; // סוף if ( have_posts() )
?>

<?php get_footer(); ?>