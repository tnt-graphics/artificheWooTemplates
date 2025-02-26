<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
$homeclass = '';
if (!is_front_page()) {
	$homeclass = "otherpage-cls";
}

?>
<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content <?php echo $homeclass; ?>">
	<div class="">
		<div class=" col-list-outer">
		<div class="single-column min-col">
			
			<?php //do_action( 'woocommerce_before_main_content' ); ?>
			<div class="breadcrumbs ">
			<div id="crumbs">
				<?php echo get_breadcrumb(); ?>
			</div>
		</div>
	<header class="entry-header">
	<?php //if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="page-title"><?php echo woocommerce_page_title(); ?></h1>
	<?php //endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	
	?>
</header>
</div>
<?php
	$shop_page_id = wc_get_page_id( 'shop' );
	if ( $shop_page_id ) {
		$shop_page = get_post( $shop_page_id );
		echo '<div class="shop-description">' . apply_filters( 'the_content', $shop_page->post_content ) . '</div>';
	}
?>
</div>
</div><!--container-->
	</div>
	</article><!-- #post-<?php the_ID(); ?> -->
</main>
<?php
get_footer();
