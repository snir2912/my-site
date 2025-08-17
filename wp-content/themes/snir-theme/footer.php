</main> <footer class="main-footer">
        <div class="container footer-content">
            <div class="footer-left">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo footer-logo"><?php bloginfo('name'); ?></a>
                <p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. כל הזכויות שמורות.</p>
            </div>

            <div class="footer-right">
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

    <?php wp_footer(); ?>
    <div id="spotlight">
        <span>לחץ עלי</span>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>