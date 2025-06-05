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
define( 'DB_NAME', 'pathproc_wp145' );

/** Database username */
define( 'DB_USER', 'pathproc_wp145' );

/** Database password */
define( 'DB_PASSWORD', 'pKS19O.7)Y' );

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
define( 'AUTH_KEY',         'r2yqv3vpnsgioje5kgxfo6x9gsvu2l8jw5yt0dzukfqsvrbf9vszt7ekexkrhnkr' );
define( 'SECURE_AUTH_KEY',  'tuhzfv2bkjhji6nbzyuaggcbfcwvhtf9ruvto2fl8u2gqjhpvdkuriejvmya0xni' );
define( 'LOGGED_IN_KEY',    'tevoswe92nqlskk2kqtflj9mfhbqon9pngjz1sansbpk5moohlfxbxrcsrxos7w4' );
define( 'NONCE_KEY',        'lxgfc8fkx8ft1svw2xdu5zoqtgnpeqa7srdt4sttje8euueqecuvbdd2ximc4pmc' );
define( 'AUTH_SALT',        'ple71rqvhhpeesqmqfvjzps6lovjgb0wi4tzcryap09ja2c9ipmfck0lh0vfrpin' );
define( 'SECURE_AUTH_SALT', 'n09tai3jzffopqvbubpeu96jbtaolf9fmwjcnb25ekhhheoi0fyxenul6g5dfaoa' );
define( 'LOGGED_IN_SALT',   'nmvjish9i2pwkwwqrzasldlcmuip757gddoyqaocos5tq8etts4gbnwie5gbqyh8' );
define( 'NONCE_SALT',       'dgnljpu6kwvay2qlw6oo1zla1pa4srtq34qdhfkkaejcmlnvpktz1yfeazghgaob' );

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
$table_prefix = 'wpxs_';

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
