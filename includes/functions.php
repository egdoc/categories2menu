<?php
require_once '../../../wp-load.php';

function filter_valid_categories($categories) {
	$valid_categories = array();

	$parent_product_categories = get_categories(
		array(
			'taxonomy' => 'product_cat',
			'orderby' => 'id',
			'hide_empty' => 0,
			'parent' => 0,
		)
	);

	foreach ( $parent_product_categories as $parent_product_category ) {
		if ( in_array( $parent_product_category->cat_ID, $categories ) ) {
			$valid_categories[] = $parent_product_category;
		}
	}

	return $valid_categories;
}


function recursive_category_tree( $menu_id, $category, $menu_item_parent_id = 0 ) {
	$item_db_id = wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title' => $category->name,
			'menu-item-db-id' => 0,
			'menu-item-object-id' => $category->term_id,
			'menu-item-object' => 'product_cat',
			'menu-item-parent-id' => $menu_item_parent_id,
			'menu-item-type' => 'taxonomy',
			'menu-item-depth' => 1,
			'menu-item-url' => get_category_link( $category->term_id ),
			'menu-item-status' => 'publish',
		)
	);

	$children = get_categories(
		array(
			'taxonomy' => 'product_cat',
			'hide_empty' => 0,
			'orderby' => 'id',
			'parent' => $category->term_id,
		)
	);

	foreach ( $children as $child ) {
		recursive_category_tree( $menu_id, $child, $item_db_id );
	}
}
