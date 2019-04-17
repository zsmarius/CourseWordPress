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
define( 'DB_NAME', 'iap' );

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
define( 'AUTH_KEY',         'Q?WuueN2y?+.SkV-WiqJ-_&XcnYcgeAbxq3>/j`0eSs+qO&CT?7N!9$vgP%@pRa`' );
define( 'SECURE_AUTH_KEY',  'g^lsN~6#%`0~xty-&L{.],n. :2y/kiw6k.:]E}x_Y?3CAX mI=#OC{_jQo74fuf' );
define( 'LOGGED_IN_KEY',    'pmzk }Lv~=8a t/%/@s_4s#R9ZPvTq#&0s+%%15o7XYH6o%G].i9-;NGE{,X/_YG' );
define( 'NONCE_KEY',        'XFt3U?QEuGsdrV5[{@+fv1rClMn{JFEv<&zy` Yw8C/078($Q.[ar+Mg}NJgGByN' );
define( 'AUTH_SALT',        'pi|:)qja;9vk,6 s<GK=YU__L=mBw*s:$&$}qlVlsQNCmO%rl;C7y64oe7yV`f*1' );
define( 'SECURE_AUTH_SALT', 'y#fDSZ{#OkvM<;I5GYk9/&vqo79qz@ag|xb^i^0X%PbC{9st9warUcr{M DKQ9Hn' );
define( 'LOGGED_IN_SALT',   '=z!0;AhAA&c=Rl![<o]08aW64Yyy{9@I-Z49k1YWFH0vGnY-Gk$Fmt yhGHQBn7T' );
define( 'NONCE_SALT',       '<x#w2C::gMgWn[q#KKpUULc*D5LZS>%< *:4aux-hVTbhx)0fum]v)=`&<W6i]/+' );

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
