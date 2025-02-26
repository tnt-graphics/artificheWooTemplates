<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="container">
<div class="filter-view">
   <div class="list_grid_div">
	  <button data-type="grid" class="woo_grid selected list_grid"><i class="icon-gridview"></i></button>
	<button data-type="list" class="woo_list list_grid"><i class="icon-listview"></i></button>
	 <p class="woocommerce-result-count">
	<?php

		echo __( '0 Einträge gefunden', 'artifiche' );


	?>
	 

</p>
   </div>
  <div class="shop-menu">
	  <div class="shop-sort">
   <span><?php echo __( 'Sortieren nach', 'artifiche' ); ?></span>
	<input type="hidden" name="shop_url"  class="shop_url" value="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
	<a class="price-sort" ><?php echo __( 'Preis', 'artifiche' ); ?></a>
	<a class="jahr-sort" ><?php echo __( 'Jahr', 'artifiche' ); ?></a>
	<a class="cc-choice-sort"><?php echo __( 'Collector’s Choice', 'artifiche' ); ?></a>
	<?php
	$sale_option = get_field( 'sale_option', 'option' );
	if ( ! empty( $sale_option ) && $sale_option[0] == 'true' ) {
		?>
	<a class="sale-sort"><?php echo __( 'Sale', 'artifiche' ); ?></a>
	<?php } ?>
	</div>
  </div>
</div>
<p class="woocommerce-info"><?php esc_html_e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
</div>

