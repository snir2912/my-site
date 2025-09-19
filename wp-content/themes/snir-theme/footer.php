</main>
<footer class="main-footer">
    <div class="container footer-content">
        <div class="footer-center">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo footer-logo"><?php bloginfo('name'); ?></a>
            <p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. כל הזכויות שמורות.</p>
            
            <?php 
                // משיכת התוכן משדה ACF בשם 'footer_text'
                $footer_text = get_field('footer_text', 'option'); 
                if ( $footer_text ) : ?>
                    <div class="footer-text-area">
                        <p><?php echo esc_html($footer_text); ?></p>
                    </div>
            <?php endif; ?>
        </div>

        <div class="footer-nav-area">
            <nav class="footer-nav">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer-menu',
                    'container'      => 'ul',
                    'menu_class'     => 'footer-menu-list',
                    'fallback_cb'    => false
                ) );
                ?>
            </nav>
        </div>
    </div>
</footer>

<?php 
    // משיכת הנתונים משדות האפשרויות של ACF
    $whatsapp_number = get_field('whatsapp', 'option');
    $whatsapp_text = get_field('whatsapp_text', 'option');
    
    if ($whatsapp_number) : 
        $whatsapp_link = 'https://wa.me/' . preg_replace('/[^0-9+]/', '', $whatsapp_number);
?>
    <a href="<?php echo esc_url($whatsapp_link); ?>" class="whatsapp-float" target="_blank" aria-label="שלח לנו הודעה בוואטסאפ">
        <div class="whatsapp-icon">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.4C339.6 54.7 283.9 31.7 224 31.7S108.4 54.7 67.1 97.4 31.7 192.4 31.7 251.7c0 43.1 8.8 84.4 25.1 123.3L32 480l110.1-29.2c35 19.3 75.3 29.2 110.1 29.2 59.9 0 115.6-22.9 156.9-65.6S416.3 301 416.3 251.7c0-59.3-22.9-115-65.6-156.9zM224 380.3c-40 0-78.2-12.9-109.9-37.1l-6.1-4.7-27.1 7.2 7.2-27.1-4.7-6.1c-24.2-31.7-37.1-69.9-37.1-109.9 0-93.7 76-169.7 169.7-169.7s169.7 76 169.7 169.7-76 169.7-169.7 169.7z"></path></svg>
        </div>
        <?php if ($whatsapp_text) : ?>
            <div class="whatsapp-bubble"><?php echo esc_html($whatsapp_text); ?></div>
        <?php endif; ?>
    </a>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>