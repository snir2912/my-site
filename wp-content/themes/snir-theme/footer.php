</main>

    <footer class="main-footer">
        <div class="container">
            
            <div class="footer-widgets-grid">
                
                <div class="footer-col about-col">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                        <?php bloginfo('name'); ?>
                    </a>
                    <p class="footer-tagline">
                        <?php echo get_bloginfo('description'); ?>
                    </p>
                    <div class="footer-socials">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Linkedin"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div class="footer-col nav-col">
                    <h3 class="footer-title">ניווט מהיר</h3>
                    <nav class="footer-nav">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'header-menu', // *** שינוי: מושך את תפריט ההדר ***
                            'container'      => false,
                            'menu_class'     => 'footer-menu-list', // משאיר את העיצוב של הפוטר (רשימה אנכית)
                            'fallback_cb'    => false
                        ) );
                        ?>
                    </nav>
                </div>

                <div class="footer-col contact-col">
                    <h3 class="footer-title">יצירת קשר</h3>
                    <?php 
                        $footer_text = get_field('footer_text', 'option'); 
                        if ( $footer_text ) : ?>
                        <div class="footer-text-area">
                            <?php echo wp_kses_post($footer_text); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="footer-col newsletter-col">
                    <h3 class="footer-title">הישארו מעודכנים</h3>
                    <p>הירשמו לניוזלטר שלנו לקבלת עדכונים וטיפים חמים.</p>
                    <div class="footer-newsletter-form">
                        <?php echo do_shortcode('[contact-form-7 id="1234" title="Newsletter Footer"]'); ?>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <p class="copyright">&copy; <?php echo date('Y'); ?> <strong><?php bloginfo('name'); ?></strong>. כל הזכויות שמורות.</p>
                <p class="credit">נבנה ע"י <a href="#">SnirTheme</a></p>
            </div>
        </div>
    </footer>

    <?php 
        $whatsapp_number = get_field('whatsapp', 'option');
        $whatsapp_text = get_field('whatsapp_text', 'option');
        
        if ($whatsapp_number) : 
            $whatsapp_link = 'https://wa.me/' . preg_replace('/[^0-9+]/', '', $whatsapp_number);
    ?>
        <a href="<?php echo esc_url($whatsapp_link); ?>" class="whatsapp-float" target="_blank" aria-label="שלח לנו הודעה בוואטסאפ">
            <div class="whatsapp-icon">
                 <i class="fab fa-whatsapp"></i>
            </div>
            <?php if ($whatsapp_text) : ?>
                <div class="whatsapp-bubble"><?php echo esc_html($whatsapp_text); ?></div>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <div id="search-overlay" class="search-overlay">
        <div class="search-close-btn">&times;</div>
        
        <div class="search-container">
            <div class="search-input-wrapper">
                <input type="text" id="live-search-input" placeholder="הקלידו לחיפוש לקוח, שירות או מאמר..." autocomplete="off">
                <div class="search-spinner"></div>
            </div>
            
            <div id="live-search-results" class="search-results-grid"></div>
        </div>
    </div>

    <script>
        var snirAjax = { 
            ajax_url: "<?php echo admin_url('admin-ajax.php'); ?>" 
        };
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    <?php wp_footer(); ?>

</body>
</html>