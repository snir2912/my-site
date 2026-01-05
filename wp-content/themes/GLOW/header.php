<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />       
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="main-header">
        <div class="container header-content">
            
            <div class="header-logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title-text">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php
                }
                ?>
            </div>

            <nav class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container'      => false, // ביטול עטיפת ה-div המיותרת
                    'menu_class'     => 'nav-list',
                    'fallback_cb'    => false
                ));
                ?>
            </nav>

            <div class="header-controls">
                
                <button id="search-trigger-btn" class="control-btn search-btn" aria-label="חיפוש באתר">
                    <i class="fas fa-search"></i>
                </button>

                <button id="theme-toggle" class="control-btn theme-toggle" aria-label="החלף מצב תצוגה">
                    <span class="icon-dark"><i class="fas fa-moon"></i></span>
                    <span class="icon-light"><i class="fas fa-sun"></i></span>
                </button>

                <button class="hamburger-menu" aria-label="תפריט ניווט ראשי">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>

        </div>
    </header>

    <div class="mobile-menu-overlay">
        <nav class="mobile-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'container'      => false,
                'menu_class'     => 'mobile-nav-list',
                'fallback_cb'    => false
            ));
            ?>
        </nav>
    </div>