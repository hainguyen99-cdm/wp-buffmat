<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'buffmat' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '_^udLM$q5]{KL>d[I?RO.uwy~7}L?q;n|a#{i?eiDoKCWs6>D7-n4!A:tF/,I#At' );
define( 'SECURE_AUTH_KEY',  'AQ3EX`ad>$e2~?txwwLJ|B,w=0`/8D;QE_I{]O j0%SLUmf1ca,n-K5{sY3)=?YW' );
define( 'LOGGED_IN_KEY',    'OyXW^0~PiBbSshNm&&L*jz)&JG+&gq%>Cb*?slVuw3ad)I7V)E BkN+bJ1 pNB|m' );
define( 'NONCE_KEY',        'mE.nfypr[JB@oV:@=v^P/L#{GgCEV|m@I8>oVxa!q,fV*`Akf*|>SEugX{ZC<m!Y' );
define( 'AUTH_SALT',        'FJwgw01>Nxgf50X(oeG!liJ5SyifH[=Xf,fiVt3T>6e^}|+k*Bx3Tw5|+x?_!EOA' );
define( 'SECURE_AUTH_SALT', 'oE/0~;J)&E!$qh!z(d0_=mm]N/`:LI?%u0?}MA!C)rt)j`q%w,W yH[vW95KroMU' );
define( 'LOGGED_IN_SALT',   'HBmanXy(R}DA@ZV)i&dTaJ^fG_nF__wQ:OH8R+=4W@{KQ?guoAJ<`JDB,uf2$-L)' );
define( 'NONCE_SALT',       ',I2>#mONrZlgw!r4Ao6/0N1R+<O2Su.s*Uvzputn0s&Qs>*j9Onv(S1G>09$i{6v' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
