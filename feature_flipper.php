<?php
/**
 * Plugin Name: WP Feature Flags
 * Plugin URI:  https://github.com/rdeeb/wp_feature_flags
 * Description: A feature flag solution for Wordpress Developers.
 * Version:     0.0.1
 * Author:      Ramy Deeb
 * Author URI:  https://ramydeeb.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp_ff
 * Domain Path: /languages
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( "FF_PATH", plugin_dir_path( __FILE__ ) );
define( "FF_URL", plugin_dir_url( __FILE__ ) );
define( "FF_VERSION", "0.0.1");

require_once( FF_PATH . "includes/core/Singleton.php" );
require_once( FF_PATH . "includes/core/FeatureFlag.php" );
require_once( FF_PATH . "includes/core/FeatureFlags.php" );
require_once( FF_PATH . "includes/helpers.php" );

if (is_admin()) {
	require_once( FF_PATH . "includes/admin-page.php" );
}
