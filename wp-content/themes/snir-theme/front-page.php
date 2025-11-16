<?php
/*
Template Name: Front Page Template
*/
?>

<?php get_header(); ?>
<?php
// שליפת כל השדות של עמוד הבית
$h1 = get_field('h1');
$hero_paragraph = get_field('hero_paragraph');
$services_headline = get_field('services_headline');

// *** חדש: שדות לפרויקטים ***
$project_headline = get_field('project_headline');
$project_btn = get_field('project_btn');

$why_us_headline = get_field('why_us_headline');
$why_us_paragraph = get_field('why_us_paragraph');
$cf_headline = get_field('cf_headline');
$cf_paragraph = get_field('cf_paragraph');

// *** חדש: שדות להמלצות ***
$reviews_headline = get_field('reviews_headline');
$reviews_btn = get_field('reviews_btn');
$reviews_btn_link = get_field('reviews_btn_link'); // זה שדה Page Link, יחזיר URL
?>

<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php echo esc_html($h1); ?></h1>
            <p><?php echo esc_html($hero_paragraph); ?></p>
            <a href="#contact" class="btn primary-btn">בואו נדבר על הפרויקט שלכם</a>
        </div>
    </div>
</section>

<section class="services-section" id="services">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($services_headline); ?></h2>
        <?php
        $args = array(
            'post_type'      => 'services',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        $services_query = new WP_Query($args);
        if ($services_query->have_posts()) :
        ?>
            <div class="services-loop-container">
                <?php while ($services_query->have_posts()) : $services_query->the_post();
                    $service_link = get_permalink();
                    $service_title = get_the_title();
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
                <?php endwhile; ?>
            </div>
        <?php
            wp_reset_postdata();
        else :
            echo '<p>אין שירותים זמינים כרגע.</p>';
        endif;
        ?>
    </div>
</section>

<?php
// שליפת 9 פרויקטים (לקוחות) אחרונים
$projects_args = array(
    'post_type'      => 'client',
    'posts_per_page' => 9,
    'post_status'    => 'publish',
);
$projects_query = new WP_Query($projects_args);

if ($projects_query->have_posts()) :
?>
<section class="projects-carousel-section">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($project_headline); ?></h2>

        <div class="swiper projects-slider">
            <div class="swiper-wrapper">
                
                <?php 
                while ($projects_query->have_posts()) : $projects_query->the_post(); 
                    // קבלת הקטגוריה (כמו בעמוד לקוח)
                    $related_id = get_the_ID();
                    $related_categories = get_the_terms($related_id, 'client_category');
                    $related_primary_category = null;
                    if (!empty($related_categories) && !is_wp_error($related_categories)) {
                        $related_primary_category = $related_categories[0];
                    }
                ?>
                    <div class="swiper-slide">
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
                                <?php if ($related_primary_category) : ?>
                                    <span class="card-category-badge">
                                        <?php echo esc_html($related_primary_category->name); ?>
                                    </span>
                                <?php endif; ?>
                                <h3 class="card-title"><?php the_title(); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>

            </div>
        </div>
        
        <div class="swiper-button-prev projects-arrow-prev"></div>
        <div class="swiper-button-next projects-arrow-next"></div>

        <?php 
        $projects_archive_link = get_post_type_archive_link('client'); 
        if ($project_btn && $projects_archive_link) :
        ?>
            <div class="section-btn-container">
                <a href="<?php echo esc_url($projects_archive_link); ?>" class="btn secondary-btn">
                    <?php echo esc_html($project_btn); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>
<?php 
endif; 
wp_reset_postdata(); // איפוס השאילתה
?>
<section class="about-our-service-section" id="why-us">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($why_us_headline); ?></h2>
        <p><?php echo esc_html($why_us_paragraph); ?></p>
    </div>
</section>

<section class="latest-blog-posts">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e('מאמרים אחרונים', 'snir-theme'); ?></h2>
        <div class="related-posts-grid">
            <?php
            $latest_posts_args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'ignore_sticky_posts' => true,
            );
            $latest_posts_query = new WP_Query($latest_posts_args);
            if ($latest_posts_query->have_posts()) :
                while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post();
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
                wp_reset_postdata();
            else :
            ?>
                <p><?php esc_html_e('אין עדיין פוסטים בבלוג.', 'snir-theme'); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $blog_page_id = get_option('page_for_posts');
    if ($blog_page_id) :
    ?>
        <div style="text-align: center; margin-top: 40px;">
            <a href="<?php echo esc_url(get_permalink($blog_page_id)); ?>" class="card-button">
                <?php esc_html_e('לכל הפוסטים בבלוג', 'snir-theme'); ?>
            </a>
        </div>
    <?php endif; ?>
</section>

<?php
$video_background = get_field('video_background');
$img_background = get_field('img_backgrond');
$section_style = '';
$has_background = false;

if ($video_background) {
    $section_style .= 'background: url(' . esc_url($video_background['url']) . ') no-repeat center center / cover;';
    $has_background = true;
} elseif ($img_background) {
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

<?php
// שימוש ב-have_rows לשליפה נכונה מ-Repeater ב-Options Page
if (have_rows('reviews', 'option')) : 
?>
    <section class="reviews-section">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html($reviews_headline); ?></h2>
            
            <div class="swiper reviews-slider">
                <div class="swiper-wrapper">
                    
                    <?php 
                    while (have_rows('reviews', 'option')) : the_row();
                        $name = get_sub_field('name');
                        $review_content = get_sub_field('review-content');
                    ?>
                        <div class="swiper-slide">
                            <div class="review-card">
                                <span class="review-quote-icon">"</span>
                                <div class="review-content">
                                    <?php echo wp_kses_post($review_content); ?>
                                </div>
                                <div class="review-author">
                                    - <?php echo esc_html($name); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>
            
            <div class="swiper-button-prev reviews-arrow-prev"></div>
            <div class="swiper-button-next reviews-arrow-next"></div>

            <?php if ($reviews_btn && $reviews_btn_link) : ?>
                <div class="section-btn-container">
                    <a href="<?php echo esc_url($reviews_btn_link); ?>" class="btn reviews-btn-all">
                        <?php echo esc_html($reviews_btn); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </section>
<?php 
endif; 
?>
<div class="contact-form" id="contact">
    <div class="cintainer">
        <h2><?php echo esc_html($cf_headline); ?></h2>
        <p><?php echo esc_html($cf_paragraph); ?></p>
        <?php echo do_shortcode('[contact-form-7 id="285c83c" title="טופס צור קשר"]'); ?>
    </div>
</div>

<?php get_footer(); ?>