<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right');
            bloginfo('name'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css">        
    <?php wp_head(); ?>
</head>

<body <?php body_class('dark-mode'); ?>>

    <header class="main-header">
        <div class="container header-content">
            <?php
            // בדיקה אם קיים לוגו מותאם אישית (שהוגדר ב-Customizer)
            if (has_custom_logo()) {
                // הצגת הלוגו המותאם אישית
                the_custom_logo();
            } else {
                // אם אין לוגו, הצג את שם האתר כטקסט
            ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><?php bloginfo('name'); ?></a>
            <?php
            }
            ?>

            <nav class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container' => 'ul',
                    'menu_class' => 'main-menu-list', // חשוב שיהיה menu-list
                    'fallback_cb' => false
                ));
                ?>
            </nav>
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