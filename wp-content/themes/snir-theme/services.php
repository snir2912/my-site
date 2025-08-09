<?php
/**
 * The template for displaying a single 'services' post.
 *
 * @package SnirTheme
 */

get_header();

// פונקציית עזר ליצירת תוכן עניינים (ניתן לשנות את הכותרות המקבלות)
function generate_table_of_contents_list() {
    global $post;
    $content = $post->post_content;
    $matches = array();
    preg_match_all('/<h2.*?>(.*?)<\/h2>/i', $content, $matches);
    
    if (empty($matches[1])) {
        return;
    }
    
    $output = '<div class="table-of-contents-wrapper"><nav class="table-of-contents">';
    $output .= '<h3>' . esc_html__('תוכן עניינים', 'snir-theme') . '</h3>';
    $output .= '<ul>';
    
    foreach ($matches[1] as $index => $title) {
        $slug = sanitize_title($title);
        $output .= '<li><a href="#' . $slug . '">' . esc_html($title) . '</a></li>';
    }
    
    $output .= '</ul></nav></div>';
    
    return $output;
}

// לולאת WordPress הראשית
while (have_posts()) :
    the_post();
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <section class="service-banner"
            <?php
            if (has_post_thumbnail()) {
                echo 'style="background-image: url(\'' . esc_url(get_the_post_thumbnail_url(null, 'full')) . '\');"';
            }
            ?>>
            <div class="banner-content container">
                <h1 class="post-title"><?php the_title(); ?></h1>
            </div>
        </section>
        
        <div class="container main-content-with-sidebar">
            <div class="main-content">
                <section class="single-service-content">
                    <?php
                    // הצגת תוכן עניינים
                    echo generate_table_of_contents_list();
                    
                    // הצגת תוכן הפוסט
                    $content = get_the_content();
                    $processed_content = preg_replace_callback('/<h2.*?>(.*?)<\/h2>/i', function($matches) {
                        $slug = sanitize_title($matches[1]);
                        return '<h2 id="' . $slug . '">' . $matches[1] . '</h2>';
                    }, $content);
                    
                    echo apply_filters('the_content', $processed_content);
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('עמודים:', 'snir-theme'),
                        'after'  => '</div>',
                    ));
                    ?>
                </section>
            </div>
            
            <aside class="sidebar">
                <div class="related-services-widget">
                    <h3><?php esc_html_e('שירותים נוספים', 'snir-theme'); ?></h3>
                    <?php
                    // לולאה שמציגה שירותים אחרים (לא כולל הנוכחי)
                    $args = array(
                        'post_type'      => 'services',
                        'posts_per_page' => 5, // מציג 5 שירותים
                        'post__not_in'   => array(get_the_ID()),
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    );
                    
                    $services_query = new WP_Query($args);
                    
                    if ($services_query->have_posts()) :
                        echo '<ul>';
                        while ($services_query->have_posts()) :
                            $services_query->the_post();
                            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <div class="contact-form-widget">
                    <h3><?php esc_html_e('צרו קשר עוד היום', 'snir-theme'); ?></h3>
                    <p><?php esc_html_e('מלאו את הפרטים ונחזור אליכם בהקדם.', 'snir-theme'); ?></p>
                    <form action="#" method="post" class="placeholder-form">
                        <input type="text" placeholder="שם מלא" required>
                        <input type="email" placeholder="אימייל" required>
                        <textarea placeholder="תוכן ההודעה..." required></textarea>
                        <button type="submit">שלח</button>
                    </form>
                </div>
            </aside>
        </div>
    </article>

<?php
endwhile;

get_footer();
?>