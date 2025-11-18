<?php
/**
 * The template for displaying archive pages
 * (General Blog Archive)
 */

get_header(); 
?>

<section class="archive-banner">
    <div class="banner-content container">
        <h1 class="archive-title">
            <?php
            if ( is_category() ) :
                single_cat_title();
            elseif ( is_tag() ) :
                single_tag_title();
            elseif ( is_author() ) :
                echo esc_html__( 'Author: ', 'snir-theme' ) . get_the_author();
            elseif ( is_day() ) :
                echo esc_html__( 'Daily Archives: ', 'snir-theme' ) . get_the_date();
            elseif ( is_month() ) :
                echo esc_html__( 'Monthly Archives: ', 'snir-theme' ) . get_the_date( 'F Y' );
            elseif ( is_year() ) :
                echo esc_html__( 'Yearly Archives: ', 'snir-theme' ) . get_the_date( 'Y' );
            else :
                esc_html_e( 'Archives', 'snir-theme' );
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
    <?php if ( have_posts() ) : ?>
        
        <section class="archive-posts-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                
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

            <?php endwhile; ?>
        </section>

        <div class="pagination-wrapper">
            <?php
            the_posts_pagination( array(
                'prev_text'          => '<i class="fas fa-chevron-right"></i>', 
                'next_text'          => '<i class="fas fa-chevron-left"></i>',
                'mid_size'           => 2,
                'screen_reader_text' => __( 'Posts navigation', 'snir-theme' ),
            ) );
            ?>
        </div>

    <?php else : ?>
        <section class="no-posts-found container" style="padding: 4rem 0; text-align: center;">
            <h2><?php esc_html_e( 'לא נמצאו מאמרים.', 'snir-theme' ); ?></h2>
            <p><?php esc_html_e( 'נראה שאין כאן כלום כרגע. אולי חיפוש יעזור?', 'snir-theme' ); ?></p>
            <?php get_search_form(); ?>
        </section>
    <?php endif; ?>
</div>

<?php get_footer(); ?>