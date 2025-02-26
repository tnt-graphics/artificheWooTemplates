<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container">
<div class="filter-view">
   <div class="list_grid_div">
	  <button data-type="grid" class="woo_grid selected list_grid"><i class="icon-gridview"></i></button>
	<button data-type="list" class="woo_list list_grid"><i class="icon-listview"></i></button>
	 <p class="woocommerce-result-count">

	<?php
	if ( 1 === $total ) {
		_e( 'Showing the single result', 'woocommerce' );
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		/* translators: %d: total results */
		printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'woocommerce' ), $total );
	} else {
		 $first = ( $per_page * $current ) - $per_page + 1;
		 $last  = min( $total, $per_page * $current );
		/*
		 translators: 1: first result 2: last result 3: total results */
		// %1$d&ndash;%2$d
		// printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce' ), $first, $last, $total );

		// printf( _nx( 'Die ersten %2$d von %3$d Plakaten', 'Die ersten %2$d von %3$d Plakaten', $total, 'with first and last result', 'woocommerce' ), $first, $last, $total );
		// Die ersten 20 Ergebnisse von XXXX Plakaten


		echo __( 'Die ersten', 'artifiche' ) . ' <span class="cnt_poster">' . $last . '</span>' . __( ' Ergebnisse von', 'artifiche' ) . ' <span class="tot_poster">' . $total . '</span> ' . __( 'Plakaten', 'artifiche' );
	}
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
<?php
// if ( isset( $_GET['sold_posters'] ) ) {
// 	$sold_posters    = ( $_GET['sold_posters'] == 1 ) ? 'checked="checked"' : '';
// 	$sold_poster_val = ( $_GET['sold_posters'] == 1 ) ? 1 : 0;
// } else {
// 	$sold_posters    = '';
// 	$sold_poster_val = 0;
// }
if ( isset( $_COOKIE['sold_posters'] )  && $_COOKIE['sold_posters'] == true ) {
	$sold_posters    = ( $_COOKIE['sold_posters'] == true ) ? 'checked="checked"' : '';
	$sold_poster_val = ( $_COOKIE['sold_posters'] == true ) ? 1 : 0;
} else {
	$sold_posters    = '';
	$sold_poster_val = 0;
}
?>
<div class="check-outer">

		<label class="custom-checkbox checkbox-light">
		<span class="check-label"><?php echo esc_html__( 'Verkaufte Plakate ausblenden', 'artifiche' ); ?></span>
		
		<input name="csold_posters" class="reload" <?php echo $sold_posters; ?> type="checkbox" value="<?php echo $sold_poster_val; ?>"> <span class="checkmark"></span>
		</label>
		
			</div>
			</div>
