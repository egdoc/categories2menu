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

require_once( C2M_PLUGIN_DIR . '/includes/functions.php' );

// Register and enqueue javascript
function categories2menu_enqueue_scripts() {
	wp_enqueue_script(
		'cat2menu',
		plugins_url( '/assets/js/categories.js', __FILE__ )
	);
}
add_action( 'admin_init', 'categories2menu_enqueue_scripts' );


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


// Handle form submission
function categories2menu_action_hook() {

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

		if ( ! empty( $_POST['cat2menu_nonce'] ) && wp_verify_nonce( $_POST['cat2menu_nonce'], 'submit_action' ) ) {

			if ( is_array( $_POST['categories']) && ! empty( $_POST['categories'] ) ) {
				$valid_categories = categories2menu_filter_valid_categories( $_POST['categories'] );

				if ( ! empty( $valid_categories ) ) {
					wp_delete_nav_menu( CAT2MENU_MENU_NAME );
					$menu_id = wp_create_nav_menu( CAT2MENU_MENU_NAME );

					if ( ! is_wp_error( $menu_id ) ) {
						foreach ( $valid_categories as $valid_category ) {
							categories2menu_recursive_category_tree( $menu_id, $valid_category );
						}
					} else {
						$error = "Failed to generate the menu";
					}

				}  else {
					$error = "No valid category selected";
				}

			} else {
				$error = "No category selected";
			}

		} else {
			$error = "Invalid token";
		}

		set_transient( 'form-report', array(
				'status'  => isset( $error ) ? 'error' : 'success',
				'message' => isset( $error ) ? $error : $menu_id
			)
		);
	}

	wp_redirect( wp_get_referer() );
}

add_action( 'admin_post_categories2menu_action_hook', 'categories2menu_action_hook');
