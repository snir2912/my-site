<?php
get_header();
?>

<div class="single-post-container">
    <div class="blog-slider column-container">
        <h1 class="h1-home-page"><?php the_title(); ?></h1>
    </div>
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class="blog-card">
            <div class="blog-card-content">
                <p class="category-tag"><?php echo get_the_category_list(); ?></p>
                <h3 class="article-title"><a href="<?php the_permalink(); ?>" class="article-title"><?php the_title(); ?></a></h3>
                <p class="article-ecerpt"><?php the_excerpt(); ?></p>
                <p><a class="blog-card-read" href="<?php the_permalink(); ?> ">למאמר המלא &raquo;</a></p>
            </div>
        </div>

    <?php }
    ?>
</div>

<?php get_footer(); ?>