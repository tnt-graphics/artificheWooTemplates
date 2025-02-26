<?php
/**
 * Wishlist page template - Standard Layout
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 3.0.11
 */

/**
 * Template variables:
 *
 * @var $wishlist                      \YITH_WCWL_Wishlist Current wishlist
 * @var $wishlist_items                array Array of items to show for current page
 * @var $wishlist_token                string Current wishlist token
 * @var $wishlist_id                   int Current wishlist id
 * @var $users_wishlists               array Array of current user wishlists
 * @var $pagination                    string yes/no
 * @var $per_page                      int Items per page
 * @var $current_page                  int Current page
 * @var $page_links                    array Array of page links
 * @var $is_user_owner                 bool Whether current user is wishlist owner
 * @var $show_price                    bool Whether to show price column
 * @var $show_dateadded                bool Whether to show item date of addition
 * @var $show_stock_status             bool Whether to show product stock status
 * @var $show_add_to_cart              bool Whether to show Add to Cart button
 * @var $show_remove_product           bool Whether to show Remove button
 * @var $show_price_variations         bool Whether to show price variation over time
 * @var $show_variation                bool Whether to show variation attributes when possible
 * @var $show_cb                       bool Whether to show checkbox column
 * @var $show_quantity                 bool Whether to show input quantity or not
 * @var $show_ask_estimate_button      bool Whether to show Ask an Estimate form
 * @var $show_last_column              bool Whether to show last column (calculated basing on previous flags)
 * @var $move_to_another_wishlist      bool Whether to show Move to another wishlist select
 * @var $move_to_another_wishlist_type string Whether to show a select or a popup for wishlist change
 * @var $additional_info               bool Whether to show Additional info textarea in Ask an estimate form
 * @var $price_excl_tax                bool Whether to show price excluding taxes
 * @var $enable_drag_n_drop            bool Whether to enable drag n drop feature
 * @var $repeat_remove_button          bool Whether to repeat remove button in last column
 * @var $available_multi_wishlist      bool Whether multi wishlist is enabled and available
 * @var $no_interactions               bool
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<!-- WISHLIST MOBILE -->
<ul
	class="shop_table cart wishlist_table wishlist_view responsive mobile <?php echo $show_cb ? 'with-checkbox' : ''; ?> <?php echo $no_interactions ? 'no-interactions' : ''; ?>"
	data-pagination="<?php echo esc_attr( $pagination ); ?>" data-per-page="<?php echo esc_attr( $per_page ); ?>" data-page="<?php echo esc_attr( $current_page ); ?>"
	data-id="<?php echo esc_attr( $wishlist_id ); ?>" data-token="<?php echo esc_attr( $wishlist_token ); ?>">

	<?php
	if ( $wishlist && $wishlist->has_items() ) :
		foreach ( $wishlist_items as $item ) :
			/**
			 * Each of wishlist items
			 *
			 * @var $item \YITH_WCWL_Wishlist_Item
			 */
			global $product;

			$product      = $item->get_product();
			$availability = $product->get_availability();
			$stock_status = isset( $availability['class'] ) ? $availability['class'] : false;

			if ( $product && $product->exists() ) :
				?>
				<li id="yith-wcwl-row-<?php echo esc_attr( $item->get_product_id() ); ?>" data-row-id="<?php echo esc_attr( $item->get_product_id() ); ?>">
					<?php if ( $show_cb ) : ?>
						<div class="product-checkbox">
							<input type="checkbox" value="yes" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][cb]"/>
						</div>
					<?php endif ?>
					<?php
							  $image_id = get_post_meta( $item->get_product_id(), 'plakatnummer', true );
							  $alt_text = artf_get_alt_text( $item->get_product_id() );
					?>
					<div class="item-wrapper">
						<div class="product-thumbnail">
						<img src="<?php echo site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg'; ?>" alt="<?php echo $alt_text; ?>" />
						</div>

						<div class="item-details">
							<div class="product-name">
								<h3>
									<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
										<?php echo wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ); ?>
									</a>
								</h3>
								<?php do_action( 'yith_wcwl_table_after_product_name', $item ); ?>
							</div>

							<?php if ( $show_variation || $show_dateadded || $show_price ) : ?>
								<table class="item-details-table">

									<?php if ( $show_variation && $product->is_type( 'variation' ) ) : ?>
										<?php
										/**
										 * Product object representing variation for current item
										 *
										 * @var $product \WC_Product_Variation
										 */
										$attributes = $product->get_attributes();

										if ( ! empty( $attributes ) ) :
											foreach ( $attributes as $name => $value ) :
												if ( ! taxonomy_exists( $name ) ) {
													continue;
												}

												$attribute = get_term_by( 'slug', $value, $name );

												if ( ! is_wp_error( $attribute ) && ! empty( $attribute->name ) ) {
													$value = $attribute->name;
												}
												?>
												<tr>
													<td class="label">
														<?php echo esc_attr( wc_attribute_label( $name, $product ) ); ?>:
													</td>
													<td class="value">
														<?php echo esc_attr( rawurldecode( $value ) ); ?>
													</td>
												</tr>
												<?php
											endforeach;
										endif;
										?>
									<?php endif; ?>

									<?php if ( $show_dateadded && $item->get_date_added() ) : ?>
										<tr>
											<td class="label">
												<?php esc_html_e( 'Added on:', 'yith-woocommerce-wishlist' ); ?>
											</td>
											<td class="value">
												<?php echo esc_html( $item->get_date_added_formatted() ); ?>
											</td>
										</tr>
									<?php endif; ?>

									<?php if ( $show_price || $show_price_variations ) : ?>
										<tr>
											<td class="label">
												<?php esc_html_e( 'Preis', 'artifiche' ) . ':'; ?>
											</td>
											<td class="value">
											<?php echo get_dynamic_price_html( 'normal' ); ?>
												<?php
												// if ( $show_price ) {
												// echo $item->get_formatted_product_price(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												// }

												// if ( $show_price_variations ) {
												// echo $item->get_price_variation(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												// }
												?>
											</td>
										</tr>
									<?php endif ?>

								</table>
							<?php endif; ?>
						</div>
					</div>

					<div class="additional-info-wrapper">
						<?php if ( $show_quantity || $show_stock_status ) : ?>
							<table class="additional-info">
								<?php if ( $show_quantity ) : ?>
									<tr>
										<td class="label">
											<?php esc_html_e( 'Quantity:', 'yith-woocommerce-wishlist' ); ?>
										</td>
										<td class="value">
											<?php if ( ! $no_interactions && $wishlist->current_user_can( 'update_quantity' ) ) : ?>
												<input type="number" min="1" step="1" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][quantity]" value="<?php echo esc_attr( $item->get_quantity() ); ?>"/>
											<?php else : ?>
												<?php echo esc_html( $item->get_quantity() ); ?>
											<?php endif; ?>
										</td>
									</tr>
								<?php endif; ?>

								<?php if ( $show_stock_status ) : ?>
									<tr>
										<td class="label">
											<?php esc_html_e( 'Stock:', 'yith-woocommerce-wishlist' ); ?>
										</td>
										<td class="value">
											<?php echo 'out-of-stock' === $stock_status ? '<span class="wishlist-out-of-stock">' . esc_html__( 'Out of stock', 'yith-woocommerce-wishlist' ) . '</span>' : '<span class="wishlist-in-stock">' . esc_html__( 'In Stock', 'yith-woocommerce-wishlist' ) . '</span>'; ?>
										</td>
									</tr>
								<?php endif ?>
							</table>
						<?php endif; ?>

						<!-- Add to cart button -->
						<?php
						$stock_status       = $product->get_stock_status();
						$regular_price      = get_post_meta( $item->get_product_id(), 'preiskategorie_chf', true );
						$internetpreis_flag = get_post_meta( $item->get_product_id(), 'internetpreis_flag', true );
						$purchase_limit     = get_field( 'purchase_limit', 'option' );
						$purchase_upper     = $purchase_limit + 1;
						$order_wrap_cls     = '';
						if ( ( ( $regular_price <= $purchase_limit ) || $internetpreis_flag == 1 ) && $stock_status == 'instock' ) {
							$order_wrap_cls = ' order-wrap';
						}
						?>
						<td class="product-add-to-cart">

						<?php $outer_class = ( $stock_status == 'outofstock' ) ? 'out-stock' : ''; ?>
						  <div class="prd-links <?php echo $outer_class . $order_wrap_cls; ?>">
						<?php if ( ( ( $regular_price >= $purchase_upper ) && $internetpreis_flag == 0 ) || $stock_status == 'outofstock' ) { ?>

							<?php $kontakt_url = get_permalink( get_field( 'set_contact_page', 'option' ) ); ?>
							<button class="btn-blue"><a class="btn-link" href="<?php echo $kontakt_url . '?pid=' . $item->get_product_id(); ?>"><i class="icon-arrow_big"></i> <?php echo __( 'Anfrage', 'artifiche' ); ?></a></button>

							<?php
						}
						if ( ( ( $regular_price <= $purchase_limit ) || $internetpreis_flag == 1 ) && $stock_status == 'instock' ) {

							$product_id = $item->get_product_id();
							// echo do_shortcode( '[add_to_cart id=' . $product_id . ']' );
							echo '<a href="?add-to-cart=' . $product_id . '&amp;remove_from_wishlist_after_add_to_cart=' . $product_id . '&amp;wishlist_id=1&amp;wishlist_token=' . esc_attr( $wishlist_token ) . '" 
							data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart button add_to_cart alt atc_wish btn-blue btn-link artf_atc" 
							data-product_id="' . $product_id . '"  aria-label="' . $product->get_title() . '" rel="nofollow"><i class="icon-shopping"></i>' . __( 'Bestellung', 'artifiche' ) . '</a>';

						}
						if ( $stock_status == 'outofstock' ) {
							?>
							<button class="btn-grey"><?php echo __( 'Plakat verkauft', 'artifiche' ); ?></button>
								<?php
						}

						/*
						if ( $show_add_to_cart && isset( $stock_status ) && 'out-of-stock' !== $stock_status ) : ?>
							<div class="product-add-to-cart">
								<?php woocommerce_template_loop_add_to_cart( array( 'quantity' => $show_quantity ? $item->get_quantity() : 1 ) ); ?>
							</div>
						<?php endif */
						?>

						<!-- Change wishlist -->
						<?php if ( $move_to_another_wishlist && $available_multi_wishlist && count( $users_wishlists ) > 1 ) : ?>
							<div class="move-to-another-wishlist">
								<?php if ( 'select' == $move_to_another_wishlist_type ) : ?>
									<select class="change-wishlist selectBox">
										<option value=""><?php esc_html_e( 'Move', 'yith-woocommerce-wishlist' ); ?></option>
										<?php
										foreach ( $users_wishlists as $wl ) :
											/**
											 * Each of customer wishlists
											 *
											 * @var $wl \YITH_WCWL_Wishlist
											 */
											if ( $wl->get_token() === $wishlist_token ) {
												continue;
											}
											?>
											<option value="<?php echo esc_attr( $wl->get_token() ); ?>">
												<?php echo esc_html( sprintf( '%s - %s', $wl->get_formatted_name(), $wl->get_formatted_privacy() ) ); ?>
											</option>
											<?php
										endforeach;
										?>
									</select>
								<?php else : ?>
									<a href="#move_to_another_wishlist" class="move-to-another-wishlist-button" data-rel="prettyPhoto[move_to_another_wishlist]">
										<?php echo esc_html( apply_filters( 'yith_wcwl_move_to_another_list_label', __( 'Move to another list &rsaquo;', 'yith-woocommerce-wishlist' ) ) ); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( $show_remove_product || $repeat_remove_button ) : ?>
							<div class="product-remove">
								<a href="<?php echo esc_url( add_query_arg( 'remove_from_wishlist', $item->get_product_id() ) ); ?>" class="remove_from_wishlist" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>"><i class="fa fa-trash"></i></a>
							</div>
						<?php endif; ?>
					</div>
				</li>
				<?php
			endif;
		endforeach;
	else :
		?>
		<p class="wishlist-empty">
			<?php echo esc_html( apply_filters( 'yith_wcwl_no_product_to_remove_message', __( 'No products added to the wish list', 'yith-woocommerce-wishlist' ) ) ); ?>
		</p>
		<?php
	endif;

	if ( ! empty( $page_links ) ) :
		?>
		<p class="pagination-row">
			<?php echo $page_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</p>
	<?php endif; ?>

</ul>

<?php if ( ! empty( $page_links ) ) : ?>
	<nav class="wishlist-pagination">
		<?php echo $page_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</nav>
<?php endif; ?>
