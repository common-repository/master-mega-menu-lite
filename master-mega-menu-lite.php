<?php
/**
 * Plugin Name: Master Mega Menu
 * Plugin URI:  https://master-addons.com/megamenu
 * Description: Mega Menu for Elementor by Master Addons
 * Version:     1.0.3
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: master-mega-menu-lite
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package master-mega-menu-lite
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'master-mega-menu-lite' ) );
}

$jltelmm_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTELMM' ) ) {
	define( 'JLTELMM', $jltelmm_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTELMM_VER' ) ) {
	define( 'JLTELMM_VER', $jltelmm_plugin_data['Version'] );
}

if ( ! defined( 'JLTELMM_AUTHOR' ) ) {
	define( 'JLTELMM_AUTHOR', $jltelmm_plugin_data['Author'] );
}

if ( ! defined( 'JLTELMM_DESC' ) ) {
	define( 'JLTELMM_DESC', $jltelmm_plugin_data['Author'] );
}

if ( ! defined( 'JLTELMM_URI' ) ) {
	define( 'JLTELMM_URI', $jltelmm_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTELMM_DIR' ) ) {
	define( 'JLTELMM_DIR', __DIR__ );
}

if ( ! defined( 'JLTELMM_FILE' ) ) {
	define( 'JLTELMM_FILE', __FILE__ );
}

if ( ! defined( 'JLTELMM_SLUG' ) ) {
	define( 'JLTELMM_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTELMM_BASE' ) ) {
	define( 'JLTELMM_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTELMM_PATH' ) ) {
	define( 'JLTELMM_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTELMM_URL' ) ) {
	define( 'JLTELMM_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTELMM_INC' ) ) {
	define( 'JLTELMM_INC', JLTELMM_PATH . '/Inc/' );
}

if ( ! defined( 'JLTELMM_LIBS' ) ) {
	define( 'JLTELMM_LIBS', JLTELMM_PATH . 'Libs' );
}

if ( ! defined( 'JLTELMM_ASSETS' ) ) {
	define( 'JLTELMM_ASSETS', JLTELMM_URL . 'assets/' );
}

if ( ! defined( 'JLTELMM_IMAGES' ) ) {
	define( 'JLTELMM_IMAGES', JLTELMM_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTELMM\\JLE_Elementor_Mega_Menu' ) ) {
	// Autoload Files.
	include_once JLTELMM_DIR . '/vendor/autoload.php';
	// Instantiate JLE_Elementor_Mega_Menu Class.
	include_once JLTELMM_DIR . '/class-master-mega-menu-lite.php';
}



/* Re-write flus */
register_activation_hook  ( __FILE__, 'jltelmm_flush_rewrites' );
register_deactivation_hook( __FILE__, 'jltelmm_flush_rewrites' );
if( !function_exists('jltelmm_flush_rewrites')){
    function jltelmm_flush_rewrites() {
        flush_rewrite_rules();
    }
}