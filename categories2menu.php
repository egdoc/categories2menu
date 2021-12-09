<?php
/**
 * Plugin Name: Categories2menu
 * Description: Creates a menu based on existing Woocommerce categories
 * Version: 1.0
 * Author: Egidio Docile <egdoc.dev@gmail.com>
 * Author URI: https://github.com/egdoc
 * License: GPLv2 or later
 */

// Define constants
defined('ABSPATH') || exit;
defined('C2M_PLUGIN_DIR')  || define('C2M_PLUGIN_DIR', plugin_dir_path(__FILE__));
defined('CAT2MENU_MENU_NAME') || define('CAT2MENU_MENU_NAME', 'categories2menu');

function register_session() {
	if ( ! session_id() ) {
		session_start();
	}
}
add_action( 'init', 'register_session' );


// Register and enqueue javascript
function enqueue_scripts() {
	wp_enqueue_script(
		'cat2menu',
		plugins_url( '/assets/js/categories.js', __FILE__ )
	);
}
add_action( 'admin_init', 'enqueue_scripts' );


// Creating plugin page
add_action( 'admin_menu', 'categories2menu_register_page' );
function categories2menu_register_page() {
	add_menu_page(
		'Categories2Menu',
		'Categories2Menu',
		'manage_options',
		'categories2menu',
		'categories2menu_page',
    );
}

// This function is called by the add_options_page and displays the page content
function categories2menu_page() {
    $product_categories = get_categories(
		array(
			'taxonomy' => 'product_cat',
			'orderby' => 'id',
			'parent' => 0
		)
	);

	ob_start();
	require_once  'templates/form.php';
	ob_end_flush();
}
