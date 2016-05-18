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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gonow.local');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1111');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'N?|`>6!Hb>:.elbg0oyXye}OSyqP?wS>/pWAr<dOb1|?<D]o~##pxk{)7cVn/%+Y');
define('SECURE_AUTH_KEY',  'rui3<_~,W.!ISX<fE>K7tAj`~PP<;SiAI;G7o?`(ybwVq1eAC%9{JHC[@jQ]X?<t');
define('LOGGED_IN_KEY',    'ry(;f~B=<jWFiWK%qOO#9iK2QGy|m/2{^T~@nCMz&{EB gvpEMAmtDra%wmfg^n@');
define('NONCE_KEY',        ';FM4FK;[cT!3q~-+:iU``Y`gU9&0fFIK>2cqq$f9 |intoVM/~e&jrwR6f=36)#n');
define('AUTH_SALT',        '$5I#tw,=]l-BxaFj;jiP24(lzHSK4v~)_lEme49w5*>*3L:rb;gs/&PC>e9s<,TY');
define('SECURE_AUTH_SALT', 'gF%J531<Fw|,pt1H(j&LOkM?8@MuYpv4a$9TL@A#xwj5`(5-EzE1j}yBX$sHsxRz');
define('LOGGED_IN_SALT',   'I@V,MN-zoC5YlQIqww11T/lVNPzNcs0!>BVDpo {OM>E2qHIt8=@0Zo})BZ3mojb');
define('NONCE_SALT',       'fL4PSK;|xQHex,8VG;w}nrf7<+>L?P K$G.Fiq<!+nyp3%*n}S$D{A$~ @/Z@j>1');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

