<div>
	<h1>Categories2menu</h1>

	<?php if ( ( $form_report = get_transient( 'form-report' ) ) ): ?>
		<?php if ( ! empty( $form_report['status'] ) && ! empty( $form_report['message'] ) ): ?>
			<?php if ( $form_report['status'] == 'error' ) : ?>
				<div class="notice notice-error is-dismissible">
					<p><?php echo esc_html( $form_report['message'] ); ?></p>
				</div>
			<?php else: ?>
				<div class="notice notice-success is-dismissible">
					<p>
						<a href="<?php echo esc_attr( admin_url( "nav-menus.php?action=edit&menu={$form_report['message']}" ) ); ?>">Menu</a> generated successfully!
					</p>
				</div>
			<?php endif ?>
		<?php endif ?>

		<?php delete_transient( 'form-report' ); ?>

	<?php endif ?>

    <?php if ( ! empty( $product_categories ) ) :?>
        <form id="cat2menu_form" method="post" action="<?php echo admin_url( "admin-post.php" ) ;?>">
			<div>
				<p>Select the categories you want to include in the menu:</p>
			</div>
			<input type="hidden" name="action" value="categories2menu_action_hook">

			<?php wp_nonce_field( "submit_action", "cat2menu_nonce" ); ?>

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
								<label for="<?php echo esc_attr( $category->term_id ); ?>"><?php echo esc_html( $category->name ); ?></label>
							</div>
						</li>

					<?php endforeach ?>

				</ul>
			</div>

			<?php submit_button( 'Generate menu' ); ?>

		</form>

	<?php else: ?>

		<div>
			<h3>No product categories found</h3>
		</div>

	<?php endif ?>

</div>
