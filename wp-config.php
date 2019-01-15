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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'nI=Y/A8Gg*Jx(,2$ ^~M3.6*gy899W_%a`p8^ 29,bEHn}C{P)1Cxe0!,!h~~k<s');
define('SECURE_AUTH_KEY',  'eg.WM+Id|%F4@S=D[F52VC)UiWK*d5X=oAf.MM`iBS!9gD||)DvV0-J[,=b(7f~{');
define('LOGGED_IN_KEY',    '}H`8E[zA1$Bk>D*c4qDn3m*jp?0T21h3J;zN8CUxz4=uv6oqGs9j.7SBMv;e#`?,');
define('NONCE_KEY',        'uO2[t?u/dB0i5UgPSu|&Hu_7r=G&Q Gp@8fJG#h&T!fo0MZ)6]9Hy/L$kNurr2Y*');
define('AUTH_SALT',        'w*-9APg90-1V<Mtr6G;h5gUo{M%qSXjF%k1|,3duI|0?<CdMhV/nT[gU;+CyIy$^');
define('SECURE_AUTH_SALT', 'ssY230S;unRBfuq5QU0E|l,gdx:<LBqr%.FwA <cA]m2pW_5dSy)OE+; 2qxPKm}');
define('LOGGED_IN_SALT',   '&qdEJ]V)>78$Bkt=*rn_jWQj@mhhLk{}.DjDNS>99kY*!oK=Nq.`%J5|kVy~E;cI');
define('NONCE_SALT',       '-QLp%>_Ew>b(V+-|_$!t`N]U+Uh9W[(hiQ2.gnhF+[jF{A{EZDp3k+,LJba,C!5V');

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
