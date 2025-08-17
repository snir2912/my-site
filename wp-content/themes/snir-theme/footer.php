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
    <style>
        /* איפוס הגדרות בסיסיות */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        /* עיצוב הפנס (העיגול) */
        #spotlight {
            position: fixed; /* מיקום קבוע על המסך */
            top: 0;
            left: 0;
            width: 150px; /* גודל התחלתי */
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%; /* הופך לעיגול */
            transform: translate(-50%, -50%); /* ממקם את הפנס במרכז העכבר */
            pointer-events: none; /* מאפשר ללחוץ על אלמנטים שמתחת לפנס */
            backdrop-filter: invert(1); /* האפקט המרכזי - היפוך צבעים */
            -webkit-backdrop-filter: invert(1); /* תמיכה בדפדפנים שונים */
            transition: transform 0.2s ease, width 0.3s ease, height 0.3s ease; /* אנימציה חלקה לשינוי גודל */
            will-change: transform; /* אופטימיזציה לביצועים */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* הסתרת טקסט חורג */
        }

        /* עיצוב הטקסט בתוך הפנס */
        #spotlight span {
            font-size: 1.2rem;
            color: #fff;
            white-space: nowrap; /* מונע מעבר שורה */
            opacity: 0; /* נסתר בהתחלה */
            transition: opacity 0.3s ease;
        }

        /* הופך את הטקסט לגלוי כשהעכבר נמצא בתוך הפנס */
        body:hover #spotlight span {
            opacity: 1;
        }

        /* שינוי גודל הפנס בריחוף על קישור */
        #spotlight.grow {
            width: 200px; /* גודל גדול יותר */
            height: 200px;
        }

        /* עיצוב קישורים */
        a {
            color: #007bff;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #007bff;
            border-radius: 5px;
            font-size: 1.2rem;
            margin-top: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>אפקט פנס מרהיב!</h1>
    <p>הזיזו את העכבר על המסך וצפו באפקט.</p>
    <a href="#">קישור לדוגמה</a>

    <div id="spotlight">
        <span>לחץ עלי</span>
    </div>

    <script>
        // קבלת הפנס
        const spotlight = document.getElementById('spotlight');
        // קבלת כל הקישורים בעמוד
        const links = document.querySelectorAll('a');

        // פונקציה שמזיזה את הפנס אחרי העכבר
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX;
            const y = e.clientY;
            spotlight.style.transform = `translate(${x}px, ${y}px) translate(-50%, -50%)`;
        });

        // פונקציה שמשנה את גודל הפנס כשרק מרחפים על קישור
        links.forEach(link => {
            link.addEventListener('mouseenter', () => {
                spotlight.classList.add('grow');
            });

            link.addEventListener('mouseleave', () => {
                spotlight.classList.remove('grow');
            });
        });

    </script>
</body>
</html>
</body>
</html>