<?php
# BEGIN WP Cache by 10Web
define( 'TWO_PLUGIN_DIR_CACHE', '/var/www/ntechsmarthomes.com/wp-content/plugins/tenweb-speed-optimizer/' );
# END WP Cache by 10Web
// Begin AIOWPSEC Firewall
if (file_exists('/var/www/ntechsmarthomes.com/aios-bootstrap.php')) {
	include_once('/var/www/ntechsmarthomes.com/aios-bootstrap.php');
}
// End AIOWPSEC Firewall
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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ntechn' );
/** Database username */
define( 'DB_USER', 'root' );
/** Database password */
define( 'DB_PASSWORD', 'ntech@12321' );
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
define( 'AUTH_KEY',         'oIPcELH<apMN;j=D*#z|:-gP&Uc!yhr^2S:k,uhK[5}}RBgGayc)497~u&GU~Pj*' );
define( 'SECURE_AUTH_KEY',  '2NckxM&P~`5okxXL3PD_0}%`J,[<7`nI-Xc<4+8:eYyNq!?moH!8zTF6seBe5~,W' );
define( 'LOGGED_IN_KEY',    '%_5KEni4k,`f!k!bFRB3ZW@|jQHPq=D^JQSH(Oh9zB{kD0br0tOOndmn].2H:nb}' );
define( 'NONCE_KEY',        '@~{LBUk??@^tj}.F^/<!A8E&LXa<.;D:Q)(/5)k*zedNdQh#tQ//5Q4~l3`F]Q#N' );
define( 'AUTH_SALT',        '(o2oqyPg+%ezGvktx)MaZAb)&NYK -K=p&~ySO7fQMM+![z7`rzzJ:1d8JU}4nUB' );
define( 'SECURE_AUTH_SALT', '<Lr4@:B^o}&:6U0x]Jg><<mB{ocmdT,bB:O=<`}X+/~L)=fZX8@Byi$$ pQloC6(' );
define( 'LOGGED_IN_SALT',   'O5Hr foX7{~XX]%0820i)r5_AX|YFBc]E|.7|uL.`;*+Ck3/az1LP/GuiC=-)FKn' );
define( 'NONCE_SALT',       '!}%^INnK;>VG(Io0pwS@/C]Qy*6L`q^ZA$oNR+:=#Y|:+.=e${0_wWW7n&]Kyirr' );
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
//Disable File Edits
define('DISALLOW_FILE_EDIT', true);