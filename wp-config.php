<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

define('WP_HOME', 'http://www.ecaesthetics.com/');
define('WP_SITEURL', 'http://www.ecaesthetics.com/');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'db179144_eca_wp');

/** MySQL database username */
define('DB_USER', 'db179144_eca_t');

/** MySQL database password */
define('DB_PASSWORD', 'ecAesthetics928');
/** MySQL hostname */
define('DB_HOST', 'internal-db.s179144.gridserver.com');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '9oh:{&Gh]lYzNhaCJo(GID?JunaB*FWwnrWl*KM+-Do8Q[2yx*DVUz>o:5mSHq>2');define('SECURE_AUTH_KEY',  'um{~=FZSC%QGh%`tFgs+<TIw%tjvKB&mzwP50Yk;t6S_y7Bdp}QPy7x1YYV06M`]');define('LOGGED_IN_KEY',    ') wzxV>4c)Y!ZMcIpLd}$a+^aF2L:7=I#an;Ru0}-Z3{gv$ 3~pp&h]q0[$-vsXk');define('NONCE_KEY',        'Zn/r$6y9E(.X0g~)@Xd1I(*KzIPXTeHT&^*.QFJa1|m(m+Y*|8%797_g>1.a1+aP');define('AUTH_SALT',        'p{>m$<+oV2aH4}@TU`oTmW ?t~>Z#?(-E,%N%Y=vPPi,DK@hk){9>HFm*U#B-6J|');define('SECURE_AUTH_SALT', '1c n?9p/XJh,h~mSEC4gp5xDb.zY$($W<;<G(sO,S^(x!A5+ckuyec?gnv_2[9#b');define('LOGGED_IN_SALT',   '~60B@aH~k#@(iXpmeU%bgzF^fb:sBv)ewjz7)~6k4BC-]%j?U2Mt@Ddb=4M&@F}>');define('NONCE_SALT',       'w-*q7|JE@cn<PMt8rD-$lx_D^uUl}2<;i[@S5=n+LiSfj;Eor,RlBt_vgL&]g,hF');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';
/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
