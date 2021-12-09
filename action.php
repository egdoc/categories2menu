<?php
require_once '../../../wp-load.php';
require_once C2M_PLUGIN_DIR . 'includes/functions.php';


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if ( is_array( $_POST['categories']) && !empty( $_POST['categories'] ) ) {
		$valid_categories = filter_valid_categories( $_POST['categories'] );

		if ( ! empty( $valid_categories ) ) {
			wp_delete_nav_menu( CAT2MENU_MENU_NAME );
			$menu_id = wp_create_nav_menu( CAT2MENU_MENU_NAME );

			if ( ! is_wp_error( $menu_id ) ) {
				foreach ( $valid_categories as $valid_category ) {
					recursive_category_tree( $menu_id, $valid_category );
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


	$_SESSION['cat2menu_result'] = array(
		'status'  => isset( $error ) ? 'error' : 'ok',
		'message' => isset( $error ) ? $error : 'ok',
		'menu_id' => isset( $error ) ? null : $menu_id,
	);
}

wp_redirect( admin_url( "admin.php?page=categories2menu" ) );
exit;
