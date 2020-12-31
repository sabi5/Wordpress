<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'oj(9h`9K-D47Mm2;93&a>[hq4]FmNd^b~(7GcEh4S&2c,Upf=QE:m#DKx{l=NC2y' );
define( 'SECURE_AUTH_KEY',  'OH;HJ?%9KX~[eih]97p,q1#8WTQ8KCm5w!J%3-$vWJN?ZcKsVBPQ>j=*sfu&eMWk' );
define( 'LOGGED_IN_KEY',    'U@?*&@ YBo!bXp$3A+y^llstTnruY>$o8WCduxd5u,Wm1,nVAzVCh{(^?kv@2v=D' );
define( 'NONCE_KEY',        'D1?k;H(?,H+hz|e3%(uMS#+z0)|@TDR *C_r4]G9qBC*h.)|yR$JjSYfq&ZN#NrF' );
define( 'AUTH_SALT',        '}0(vht:?ETj/a%3wOAW7E.l8,i<a|mp(v^BOZ]wl_+J@FoN__spT/<=,.y!h`7[d' );
define( 'SECURE_AUTH_SALT', 'ys7U_:*e]4VQlw}O<<mJd )UZ`iRX^r5SJE8`./R<Lf6Y%#FS?sL$eXj$`sKuypl' );
define( 'LOGGED_IN_SALT',   'Mk:n^|+c(e@6_FoS{gs(u=>3pS84fr$tF9D!cGtI>9$teEU>bzEC^9& W{H][pN(' );
define( 'NONCE_SALT',       'zlR~z-=6J|.HOD[.#D`&jiGs~;W|&j!BwQ;-fu^(Quo 3rMq$hu*j`tPQlhJGzLt' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define('FS_METHOD','direct');

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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
