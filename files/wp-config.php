<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'wordpress' );

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
define( 'AUTH_KEY',         'ZTmF xI+]SBiXL{b19J!j-Tr:2h==xJ_b`L8[!3pjuv/@1%ju>dcu)ub_.HOz]Xm' );
define( 'SECURE_AUTH_KEY',  'TBZ0&V1?|0&@0q{OLHq) .q)qlTE-MQhSs~p?W^c|13!|b,{=6]WR}jKD6przENU' );
define( 'LOGGED_IN_KEY',    '7OEJU*HSDq0vd6>7j8Gm6?9)p8UYj>Rk<SVNU,8GyOrBM-7U<(eTm;2}I%YY-gT)' );
define( 'NONCE_KEY',        '.]tY~,pRvutxHsin*wtEbe.b{fJ]@it#afr>@$dZ2BeD;Q,LnrU<O H!h9+,gZGh' );
define( 'AUTH_SALT',        'D]bB#aW66-??Ls3?:>bGM7SU`MZ.vx qabz<Y<.R/G+reOvww5{+Yv_$|es$94!t' );
define( 'SECURE_AUTH_SALT', '^|><e()rgfmZ^_?2>u39yz/,U.u!C{ 7[#H]HcdK[GvLgu(8z^b8UkOdY?+;lB12' );
define( 'LOGGED_IN_SALT',   '(^KvO/qxYS,5.k}8-Zi#X@AxS^h(~M?B ?-hDTdgably}.XsO;-qVj/{kYo&DyMC' );
define( 'NONCE_SALT',       'sd_,-n[1#R+}i}Ou ]U,r3PEHi|.bh-?T*uIwzTJR]35@cVUP9xE>Urn6ZKk&LF;' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
