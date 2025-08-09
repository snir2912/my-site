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
    $output .= '<h3 class="toc-title">' . esc_html__('בתוכן העמוד', 'snir-theme') . '</h3>';
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
        
        <div class="container main-content-single">
            <div class="main-content">
                <section class="single-service-content">
                    <?php
                    // הצגת תוכן עניינים בצד העמוד
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
            
        </div>
    </article>

<?php
endwhile;

get_footer();
?>