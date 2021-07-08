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
define( 'DB_NAME', 'lavamania' );

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
define( 'AUTH_KEY',         's,2l5~ARJTU]bhs`U/IX^4*k)5NBk_/%.L}yf&LqkjV)4O)&(n_dEXIr-%`(PV%0' );
define( 'SECURE_AUTH_KEY',  'EYG2@C`A>^+s%zD]P:HKx}Q2iuEcR>brU3-H:t%a`wZ[~ctu6-6vH(NT&`jQkEfC' );
define( 'LOGGED_IN_KEY',    ';nLZT2@UnFb?EI_17Cd{adBu IAg]w_A,4.M8ZhLLP9c%#&/p)|pbufY>BFxxWCy' );
define( 'NONCE_KEY',        '>NCLH|?+@Yt>,-1[Q%FN9n,)JO@$qd4j[K6fGVGfjr5xhr^<o?m/,5C##rbOm ]`' );
define( 'AUTH_SALT',        ';qs-@*{CS1o9*})zvtyFX}BHG|d7&CyC86i@SLG|wAw}l-_}skh%XB%,n0;=X;g9' );
define( 'SECURE_AUTH_SALT', 'X|FdgEF;XrV{W>zY5]A&f$)}s5 cH&j,Z{#>C.3GR(8+k}7HZfHq|F,jw!&X6N+r' );
define( 'LOGGED_IN_SALT',   'zheXGO #S:07:v]#e{oG2%24g;1>accq1=@@hNC_P`&H;fy5B~5bOB!*;lP?uz0c' );
define( 'NONCE_SALT',       '8srcxVTLVkR_=iE8<Xjai+p3_Q1^t@:>H6MSRBb~myBrsN=|cU??3!eXC>/E<DaF' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_HOME', 'http://localhost/lavamania-1' );
define( 'WP_SITEURL', 'http://localhost/lavamania-1' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
