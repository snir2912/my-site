<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u588984589_my_sit_db' );

/** Database username */
define( 'DB_USER', 'u588984589_snir2912' );

/** Database password */
define( 'DB_PASSWORD', 'p]W0!:Er5yi' );

/** Database hostname */
define( 'DB_HOST', 'https://lightblue-eland-964577.hostingersite.com' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '`I^x$P_+hf|&nsJ*5Tferx]f;Np<T3k1*Im/mVi8RWa9tM[<),[Id4 /tP8S#WY%' );
define( 'SECURE_AUTH_KEY',   '-$5-xLXiike-4%l(nq6Wh{CB|Dn!If}@2/CG#0u/N$9g<Z@i<tCPtxWs!Cg4HftQ' );
define( 'LOGGED_IN_KEY',     '5xRUpnTr=I&at]/Ck2=Tyi&MNp<p1?*,:{K;Px8GXXP}`r}pqGub{r>//?eG1;Ng' );
define( 'NONCE_KEY',         ']5;Wg{WI8%Q,XhGpFkI>#+O=4%saFi-cD*|0.j^ZG9|HU%qXbu2<:S(P[[_QmrSR' );
define( 'AUTH_SALT',         '{B~G0$/ZqcG/2U2I)Z/__u[q?l/0Q]J9WM?zYbU9@Sr$lpZW- UUl({.r$JV|lt[' );
define( 'SECURE_AUTH_SALT',  'Qa2Zdgu=1}c48K|K7nGb7S)Jg}9&M: !kzb9fURTu9-U&Mlxtg*840z)UpF{XNd(' );
define( 'LOGGED_IN_SALT',    'b#g^xhd)|T5_q16;DqK;Q6Ks=k#qMc~C7&KU*x&$^0]A  S<Cg13SRBG0~kdj7=H' );
define( 'NONCE_SALT',        'zSdA>bICvxF?n@UIjB~S_*u7)P;4*OCK5bs4hP`I1GS&fP]GW+D1:?)J{,B4:ys}' );
define( 'WP_CACHE_KEY_SALT', '!a?yK7dpe>.tVq_|s&S,%_*~Ww$`jiT![{=bBD7nCn@uavxZTf))~o[/!)Ls5~,w' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */  
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
define('WP_HOME','https://lightblue-eland-964577.hostingersite.com/');
define('WP_SITEURL','https://lightblue-eland-964577.hostingersite.com/');
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
