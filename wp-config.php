<?php
define( 'WP_CACHE', true ); // Added by WP Rocket

 define('WPCF7_LOAD_JS', false);
 // Added by WP Rocket







 // Added by WP Rocket
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
 
// define( 'WP_HTTP_BLOCK_EXTERNAL', TRUE );
// define( 'WP_ACCESSIBLE_HOSTS', 'sirstore.ir, wordpress.org' );
//   ------------------------------------------
 
define( 'DISABLE_WP_CRON', true );

//   ------------------------------------------

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "sitedb" );

/** MySQL database username */
define( 'DB_USER', "root" );

/** MySQL database password */
define( 'DB_PASSWORD', "" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         'Md^9<)_ukBQ b7)cIWNt}5hoFx)ZN`0+VpasR6[vin~#P5yF&TkQ$W|.1uFp lmg' );
define( 'SECURE_AUTH_KEY',  'k]bmHYnLwD!5A8+=wUzh9](Jv7c!9!@<!HnDBf)5[EbfcLhr}Z-O_OA?# U#<)r^' );
define( 'LOGGED_IN_KEY',    'b|{ikF2U1x2hDx4Q2I`~vX/hbhM $fxqQK,zS!Q=?o8N4rsmWrEoX{1QNBMbk93-' );
define( 'NONCE_KEY',        '|ma8e=`~vN;_s-#*WkEf/+-nvyl3oa+/ZdUm,{;w?i}Qu%2%8mG1Q4xMw^; :.!:' );
define( 'AUTH_SALT',        'Mz*#_8~x09%:Tex7*jQ-Yzl)~al2kfjobkIPOC(wSUL?)|q?<!Du]F<,|p?wz*yr' );
define( 'SECURE_AUTH_SALT', '|g1aSU%[s${-w984p6Yd2K6~bRJo+tiC)EqUASr$,?FnrQqhjj4` n*xyVu~>rH^' );
define( 'LOGGED_IN_SALT',   'B^HQ30 4l.4:m|W[xyR[{ bseA@1&84fcto6XOw^CB~}ibmaL=}7p0N.$n+=S.;S' );
define( 'NONCE_SALT',       '%6j?#anIp6TXPx1j!)JqF?i&Pz4-vQ=5/GIIZlscE17F@fD?{C}x}RKu,]so=Ub2' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
 

 
define( 'WP_DEBUG', false );
define('FS_METHOD','direct');
define( 'WP_MEMORY_LIMIT', '256M' );

define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'WP_SITEURL', 'http://localhost/sirstore' );
define( 'DUPLICATOR_AUTH_KEY', 'I2j$D</{(=f7R^/=u{ JLnW[Rp2;%$|<~$ `~m+;I8,<UKR@5Ct!2#)~Q[/WL]-L' );

define('WP_ALLOW_REPAIR', true);
set_time_limit(60);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
