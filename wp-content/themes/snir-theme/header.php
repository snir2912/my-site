<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('dark-mode'); ?>>

    <header class="main-header">
        <div class="container header-content">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><?php bloginfo('name'); ?></a>
<nav class="main-nav">
    <?php
    wp_nav_menu( array(
        'theme_location' => 'header-menu',
        'container'      => 'ul',
        'menu_class'     => 'main-menu-list', // חשוב שיהיה menu-list
        'fallback_cb'    => false
    ) );
    ?>
</nav>
            <div class="search-form-container">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <label>
                        <span class="screen-reader-text">חפש:</span>
                        <input type="search" class="search-field" placeholder="חפש באתר..." value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                    </label>
                    <button type="submit" class="search-submit">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg>
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
            <div class="header-controls">
                <button id="theme-toggle" class="theme-toggle">
                    <span class="icon-dark">🌙</span>
                    <span class="icon-light">☀️</span>
                </button>
<button class="hamburger-menu" aria-label="תפריט ניווט ראשי">
    <span class="line line-1"></span>
    <span class="line line-2"></span>
    <span class="line line-3"></span>
</button>
            </div>
        </div>
    </header>
</html>