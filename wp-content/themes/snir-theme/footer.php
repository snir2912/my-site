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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    // מצא את האלמנט של העיגול בדף
    const spotlight = document.getElementById('spotlight');
    
    // אם לא נמצא אלמנט כזה, צא מהפונקציה
    if (!spotlight) return;

    // מצא את כל הקישורים שיש לשנות את גודל העיגול מעליהם
    const links = document.querySelectorAll('a, button, .interactive');

    // עקוב אחר תנועת העכבר והזז את העיגול
    document.addEventListener('mousemove', (e) => {
        spotlight.style.transform = `translate(${e.clientX}px, ${e.clientY}px) translate(-50%, -50%)`;
    });

    // עבור על כל האלמנטים האינטראקטיביים והוסף להם האזנה לאירועי ריחוף
    links.forEach(link => {
        link.addEventListener('mouseenter', () => {
            spotlight.classList.add('grow');
            spotlight.querySelector('span').textContent = link.getAttribute('data-text') || 'לחץ עלי';
        });

        link.addEventListener('mouseleave', () => {
            spotlight.classList.remove('grow');
        });
    });
});
    </script>
</body>
</html>