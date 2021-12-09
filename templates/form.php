<div>
	<h1>Categories2menu</h1>

	<?php if ( array_key_exists( 'cat2menu_result', $_SESSION ) ): ?>
		<?php if ( $_SESSION['cat2menu_result']['message'] == 'ok' ) : ?>

			<div class="notice notice-success is-dismissible">
				<p>Menu generated successfully!</p>
				<p><a href="<?php echo admin_url( "nav-menus.php?action=edit&menu={$_SESSION['cat2menu_result']['menu_id']}" ); ?>">Go to menu</a></p>
			</div>

		<?php else: ?>

			<div class="notice notice-error is-dismissible">
				<p><?php echo $_SESSION['cat2menu_result']['message']; ?></p>
			</div>

		<?php endif; unset( $_SESSION['cat2menu_result'] ); ?>

	<?php endif ?>

	<form id="cat2menu_form" method="post" action="<?php echo plugins_url('categories2menu/action.php'); ?>">
		<div>

		<?php if ( !empty( $product_categories ) ) :?>

			<div>
				<p>Select the categories you want to include in the menu:</p>
			</div>
			<div>
				<ul>
					<li>
						<div>
							<input type="checkbox" id="cat2menu_checkall">
							<label for="cat2menu_checkall">Check all</label>
						</div>
					</li>

					<?php foreach ($product_categories as $category): ?>

						<li>
							<div>
								<input type="checkbox" id="<?php echo esc_attr( $category->term_id ); ?>" name="categories[]" value="<?php echo esc_attr( $category->term_id ); ?>">
								<label for="<?php echo esc_attr( $category->term_id ); ?>"><?php echo $category->name; ?></label>
							</div>
						</li>

					<?php endforeach ?>

				</ul>
			</div>

		<?php else: ?>

			<h3>No product categories found</h3>

		<?php endif ?>

		</div>

		<?php submit_button( 'Generate menu' ); ?>

	</form>
</div>
