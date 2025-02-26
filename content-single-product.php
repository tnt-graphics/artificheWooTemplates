<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$homeclass = '';
if ( ! is_front_page() ) {
	$homeclass = 'otherpage-cls';
}
?>
<div class="entry-content <?php echo $homeclass; ?>">



<?php
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
// do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<!-- <div id="product-<?php // the_ID(); ?>" <?php // wc_product_class( '', $product ); ?>> -->

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	// do_action( 'woocommerce_before_single_product_summary' );
	?>

	<!-- <div class="summary entry-summary"> -->
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		// do_action( 'woocommerce_single_product_summary' );
		?>
<!-- 	</div> -->

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	// do_action( 'woocommerce_after_single_product_summary' );

	$poster_id              = get_post_meta( $post->ID, 'plakatnummer', true );
	$new_flag               = get_post_meta( $post->ID, 'neu_flag', true );
	$collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true );
	$sale_flag = get_post_meta( $post->ID, 'sale_flag', true );
	$sale_discount = get_post_meta( $post->ID, 'sale_discount', true );
	$jahr                   = get_post_meta( $post->ID, 'jahr', true );
	$breite_cm              = get_post_meta( $post->ID, 'breite_cm', true );
	$auftraggeber           = get_post_meta( $post->ID, 'auftraggeber', true );
	$druckerei              = get_post_meta( $post->ID, 'druckerei', true );
	$land                   = get_post_meta( $post->ID, 'land', true );
	$breite_inch            = get_post_meta( $post->ID, 'breite_inch', true );
	$hohe_cm                = get_post_meta( $post->ID, 'hohe_cm', true );
	$hohe_inch              = get_post_meta( $post->ID, 'hohe_inch', true );
	$zustand                = get_post_meta( $post->ID, 'zustand', true );
	$zustand_text           = get_post_meta( $post->ID, 'zustand_text', true );


	$product            = wc_get_product( $post->ID );
	$regular_price      = $product->get_regular_price();
	$regular_price      = get_post_meta( $post->ID, 'preiskategorie_chf', true );
	$sale_price         = $product->get_sale_price();
	$internetpreis_flag = get_post_meta( $post->ID, 'internetpreis_flag', true );
	$stock_status       = $product->get_stock_status();
	$currency           = get_woocommerce_currency_symbol();
	$purchase_limit     = get_field( 'purchase_limit', 'option' );
	$purchase_upper     = $purchase_limit + 1;

	switch ( $currency ) {
		case 'CHF':
			$price_chk_val = 1001;
			break;
		case 'EUR':
			$price_chk_val = 924.02;
			break;
		case 'CHF':
			$price_chk_val = 1093.69;
			break;
		default:
			// code...
			break;
	}

	// $price                  = $product->get_price_html();
	$price               = get_dynamic_price_html( 'normal' );
	$price_list_label    = '';
	$sale_discount_label    = '';
	$sale_discount_price = '';
	$labels              = '';
	$jahr_list_label     = '';
	$size_list_label     = '';
	$poster_number       = '';
	$auftraggeber_v      = '';
	$marke               = '';
	$size_list_label_top = '';
	$size_list_label_bt  = '';
	$drucktechnik        = '';
	$künstler_vorname    = '';
	$künstle_lastname    = '';
	$künstler_label      = '';

	if ( ! empty( $poster_id ) ) {
		$poster_number = '<li><strong class="list-title">' . __( 'Plakat Nr.:', 'artifiche' ) . '</strong>
		<span class="list-info">' . $poster_id . '</span></li>';
	}
	if ( ! empty( $auftraggeber ) ) {
		$auftraggeber_v = '<li><strong class="list-title">' . __( 'Auftraggeber:', 'artifiche' ) . '</strong>
		<span class="list-info">' . $auftraggeber . '</span></li>';
	}
	if ( ! empty( $druckerei ) ) {
		$druckerei = '<li><strong class="list-title">' . __( 'Druckerei:', 'artifiche' ) . '</strong>
		<span class="list-info">' . $druckerei . '</span></li>';
	}



	if ( ! empty( $zustand ) && ! empty( $zustand_text ) ) {
		$zustand_text = '<li><strong class="list-title">' . __( 'Zustand:', 'artifiche' ) . '</strong>
		<span class="list-info"><b>' . $zustand . '</b><br/>' . $zustand_text . '</span></li>';
	}

	if ( $price != '' ) {
		$price_list_label = '<strong>' . __( 'Preisklasse:', 'artifiche' ) . '</strong>
		' . $price . '<br/>';

		$price_bt = '<li><strong class="list-title">' . __( 'Preisklasse:', 'artifiche' ) . '</strong>
		' . $price . '<br/></li>';

	}

	$sale_option = get_field( 'sale_option', 'option' );
	if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'normal', true ) == true 
	&& $sale_flag == 1 ) {
		// var_dump($sale_option);
		$sale_discount_label = '<strong>' . __( 'Sale Discount:', 'artifiche' ) . '</strong>
		' . $sale_discount . '%'.'<br/>';

		$discount_price = ($sale_discount / 100) * $sale_price;
		$discount_price = $sale_price - $discount_price;
		// $currency_symbol = $currency;
		// switch ( $currency ) {
		// 	case 'CHF':
		// 		$currency_symbol = $currency;
		// 		break;
		// 	case 'EUR':
		// 		$currency_symbol = '€';
		// 		break;
		// 	case 'USD':
		// 		$currency_symbol = '$';
		// 		break;
		// 	default:
		// 		# code...
		// 		break;
		// }
			$currency_sym = get_client_currency_();
		$sale_discount_price = '<strong>' . __( 'Sale Price:', 'artifiche' ) . '</strong>
		' .$currency_sym.' '. $discount_price .'<br/>';

	}


	if ( ! empty( $new_flag ) && $new_flag == 1 ) {
		$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';
	}
	if ( ! empty( $collectors_choice_flag ) && $collectors_choice_flag == 1 ) {
		$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';
	}

	if ( $stock_status == 'outofstock' ) {

		$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';

	}
	if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'normal', true ) == true && $sale_flag == 1 ) {
		$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';
	}
	
	if ( ! empty( $jahr ) ) {
		$jahr_list_label .= '<strong>' . __( 'Jahr:', 'artifiche' ) . ' </strong>' . $jahr . '<br>';
	}
	if ( ! empty( $breite_cm ) || ! empty( $breite_inch ) || ! empty( $hohe_cm ) || ! empty( $hohe_inch ) ) {

		$grosse               = get_post_meta( $post->ID, 'grosse', true );
		$size_list_label_top .= '<strong>' . __( 'Grösse:', 'artifiche' ) . ' </strong>';

		 $size_list_label .= $grosse . '<br/>';
		// if ( ! empty( $breite_inch ) && ! empty( $hohe_inch ) ) {
		// $size_list_label .= ' / ' . $breite_inch . ' x ' . $hohe_inch.'″<br>';
		// }
	}

	$size_list_label_bt .= '<strong class="list-title">' . __( 'Grösse:', 'artifiche' ) . ' </strong>';
	$grosse              = '<li>' . $size_list_label_bt . $size_list_label . '</li>';
	$category_detail     = get_the_terms( $post->ID, 'kunstler' );
	$künstler_name       = '';
	if ( ! empty( $category_detail ) ) {


		$künstler_name = '<li><strong class="list-title">' . __( 'Künstler:', 'artifiche' ) . '</strong><div class="tag-list">';

		foreach ( $category_detail as $cd ) {


			$künstler_vorname = get_field( 'gestalter_vorname', $cd );
			$künstle_lastname = get_field( 'gestalter_name', $cd );
			// echo sanitize_title( 'Künstler' );
			if ( $künstler_vorname != '' || $künstle_lastname != '' ) {
				$gestler = $künstler_vorname . ' ' . $künstle_lastname;
			} else {
				$gestler = explode( '(', $cd->name )[0];
			}

			$künstler_link = get_term_link( $cd );

			$künstler_name .= '<span><a href="' . $künstler_link . '">' . $gestler . '</a></span>';
			$künstler_bio   = get_field( 'bio_lang', $cd );
			$künstler_id    = $cd->slug;

			$künstler_label .= '<strong> ' . __( 'Künstler:', 'artifiche' ) . ' </strong>' . $gestler . '<br>';
		}
		$künstler_name .= '</div></li>';

	}

	// if ( ! empty( $category_detail ) ) {
	// $künstler_vorname = get_field( 'gestalter_vorname', $cd );
	// $künstle_lastname = get_field( 'gestalter_name', $cd );
	// $künstler = get_field( 'gestalter', $cd );

	// if( $künstler_vorname != '' && $künstle_lastname != '' ){

	// $künstler_label .= '<strong> '. __( 'Künstler:', 'artifiche' ) .' </strong>'.$künstler_vorname.' '. $künstle_lastname .'<br>';
	// }

	   // }

	$marke_detail = get_the_terms( $post->ID, 'marke' );

	if ( ! empty( $marke_detail ) ) {

		$i      = 0;
		$count  = count( $marke_detail );
		 $marke = '<li><strong class="list-title">' . __( 'Marke:', 'artifiche' ) . '</strong><span class="list-info">';
		foreach ( $marke_detail as $cd ) {


				$marke .= '<a class="common-link" href="' . get_term_link( $cd ) . '">' . $cd->name . '</a>';

		}
		$marke .= '</span></li>';

	}
	$drucktechnik_detail = get_the_terms( $post->ID, 'drucktechnik' );

	if ( ! empty( $drucktechnik_detail ) ) {

		$i            = 0;
		$count        = count( $drucktechnik_detail );
		$drucktechnik = '<li><strong class="list-title">' . __( 'Drucktechnik:', 'artifiche' ) . '</strong><div class="">';
		foreach ( $drucktechnik_detail as $cd ) {


				$drucktechnik .= '<span class="">' . $cd->name . '</span>';

		}
		$drucktechnik .= '</div></li>';
	}
	 $product_array = get_the_terms( $post->ID, 'product_cat' );
	$product_cat    = '';
	$parent_cat     = '';
	$child_cat      = '';
	if ( ! empty( $product_array ) ) {
				  $product_cat = '<li><strong class="list-title">' . __( 'Kategorie:', 'artifiche' ) . '</strong><div class="tag-list">';
		foreach ( $product_array as $cat ) {
			// $product_cat .= "saa";
			if ( $cat->parent == 0 ) {
						  $parent_cat   = $cat->slug;
						  $product_cat .= '<span><a href="' . get_term_link( $cat ) . '">' . $cat->name . '</a></span>';
			}
		}
		foreach ( $product_array as $cat ) {
			// $product_cat .= "saa";
			if ( $cat->parent != 0 ) {
						  $child_cat    = $cat->slug;
						  $product_cat .= '<span><a href="' . get_term_link( $cat ) . '">' . $cat->name . '</a></span>';
			}
		}
				  $product_cat .= '</div></li>';
	}

	$stilrichtung = $product->get_attribute( 'stilrichtung' );

	// $schlagworter = array('Niklaus STOECKLIN', 'Binaca', 'Zahnpflege', 'Zahnpasta', 'Zahnbürste', 'gelbe', 'Tube Ciba AG Basel');

	$pa_stilrichtung = get_the_terms( $post->ID, 'pa_stilrichtung' );
	if ( ! empty( $pa_stilrichtung ) ) {
		$stilrichtung_v = '<li><strong class="list-title">' . __( 'Stilrichtung:', 'artifiche' ) . '</strong><div class="tag-list">';
		foreach ( $pa_stilrichtung as $taxonomy ) {
			if ( $taxonomy->name == $stilrichtung ) {


				$stilrichtung_v .= '<span class="list-info"><a href="' . get_term_link( $taxonomy ) . '">' . $stilrichtung . '</a></span>';

			}
		}
		$stilrichtung_v .= '</div></li>';
	}

	/*
	if( $post->ID != 17517  &&  $post->ID != 19881){
	$schlagworter = wp_get_post_terms( $post->ID, 'product_tag' );

	if( count($schlagworter) > 0 ){
	$schlagworter_v = '';
		   $schlagworter_v .= '<li><strong class="list-title">'.__( 'Stichwörter:','artifiche' ).'</strong><div class="tag-list p-tag">';
	foreach($schlagworter as $term){
		$term_id = $term->term_id; // Product tag Id
		$term_name = $term->name; // Product tag Name
		$term_slug = $term->slug; // Product tag slug
		$term_link = get_term_link( $term, 'product_tag' ); // Product tag link

		// Set the product tag names in an array
		$schlagworter_v .= '<span><a href="'.$term_link.'">'.$term_name.'</a></span>';

	}
	$schlagworter_v .= '</div></li>';
	// Set the array in a coma separated string of product tags for example

	}
	}else{ */

	$schlagworter = get_post_meta( $post->ID, 'schlagworter', true );
	$tags         = explode( ';', $schlagworter );

	if ( count( $tags ) > 0 ) {
		$schlagworter_v  = '';
		$schlagworter_v .= '<li><strong class="list-title">' . __( 'Stichwörter:', 'artifiche' ) . '</strong><div class="tag-list p-tag">';
		foreach ( $tags as $term ) {
			if ( $term != '' ) {

				$term_name1 = str_replace( '-', '_', $term );
				$term_name  = str_replace( ' ', '-', $term_name1 );


				$tag_page_link = get_permalink( get_field( 'set_tag_page', 'option' ) );
				$term_link     = $tag_page_link . $term_name . '/' . $post->ID; // Product tag link
				// Set the product tag names in an array
				$schlagworter_v .= '<span><a href="' . $term_link . '">' . $term . '</a></span>';
			}
		}
		$schlagworter_v .= '</div></li>';
		// Set the array in a coma separated string of product tags for example

	}

	// }


	$land_val = $product->get_attribute( 'land' );
	$pa_land  = get_the_terms( $post->ID, 'pa_land' );
	if ( ! empty( $land ) ) {
		$land = '<li><strong class="list-title">' . __( 'Land:', 'artifiche' ) . '</strong><div class="tag-list">';
		foreach ( $pa_land as $taxonomy ) {
			if ( $taxonomy->name == $land_val ) {


				$land .= '<span class="list-info"><a href="' . get_term_link( $taxonomy ) . '">' . $land_val . '</a></span>';

			}
		}
		$land .= '</div></li>';

	}

	// if( ! empty( $schlagworter ) ){
	// $schlagworter_v = '';
	// $schlagworter_v .= '<li><strong class="list-title">'.__( 'Stichwörter:','artifiche' ).'</strong><div class="tag-list">';
	// foreach( $schlagworter as $cat ){

			// $schlagworter_v .= '<span>'. $cat .'</span>';
	// }
	// $schlagworter_v .= '</div></li>';
	// }
	$publikationen_detail = get_the_terms( $post->ID, 'publikationen' );

	if ( ! empty( $publikationen_detail ) ) {
		$publikationen_name  = '';
		$i                   = 0;
		$count               = count( $publikationen_detail );
		$publikationen_name .= '<li><strong class="list-title">' . __( 'Publikationen:', 'artifiche' ) . '</strong><span class="list-info">';
		foreach ( $publikationen_detail as $cd ) {
			$i++;
			$publikationen = get_field( 'buch', $cd );
			if ( $i >= 1 && $count > 1 && $i < $count ) {
				$space = ' ';
			} else {
				$space = '';
			}


			$publikationen_name .= '<a class=" common-link" href="' . get_term_link( $cd ) . '">' . $publikationen . '</a><br>';

		}
		$publikationen_name .= '</span></li>';

	}
				// The Product attribute to be displayed
	$alt_text = artf_get_alt_text( $post->ID );


	?>
<!-- </div> -->

<div class="blue-bg">
	<div class="product-detail-wrap">
		<div class="product">
			<a class="image-link product-modal" href="<?php echo site_url(); ?>/artifiche-images/posters_extralarge/<?php echo $poster_id; ?>.jpg">
			<img  src="<?php echo site_url(); ?>/artifiche-images/posters_extralarge/<?php echo $poster_id; ?>.jpg" alt="<?php echo $alt_text; ?>" />
		</a>
			<div class="enlarge-icon">
				<a class="image-link" href="<?php echo site_url(); ?>/artifiche-images/posters_extralarge/<?php echo $poster_id; ?>.jpg">
				<img  class="hidden-poster" src="<?php echo site_url(); ?>/artifiche-images/posters_extralarge/<?php echo $poster_id; ?>.jpg" alt="<?php echo $alt_text; ?>" />
					<i class="icon-enlarge"></i>
					<span><?php _e( 'Vergrössern', 'artifiche' ); ?></span>
				</a>
				<div id="scroll-btn">
					<i class="icon-dropdown"></i>
					<span><?php _e( 'Details', 'artifiche' ); ?></span>
				</div>
			</div>
		</div>
		<div class="product-detail">
			<?php if ( $labels != '' ) { ?>
			<div class="product-tags">
				<?php echo $labels; ?>
			</div>
			<?php } ?>
			<?php
			$order_wrap_cls = '';
			if ( ( ( $regular_price <= $purchase_limit ) || $internetpreis_flag == 1 ) && $stock_status == 'instock' ) {
				$order_wrap_cls = ' order-wrap';
			}
			?>
			<h1><?php echo get_the_title( $post->ID ); ?></h1>
			<p>
				<?php
				if ( isset( $künstler_label ) ) {
					echo $künstler_label;}
				?>
				<?php echo $jahr_list_label; ?>
				<?php echo $size_list_label_top . $size_list_label; ?>
				<?php echo $price_list_label.$sale_discount_label.$sale_discount_price; ?>
				
				<?php
				// $regular_price != 999999
				if ( $regular_price <= 2000 && $price != '' ) {
					echo do_shortcode( '[currency_switcher]' ); }
				?>
			</p>
			<?php $outer_class = ( $stock_status == 'outofstock' ) ? 'out-stock' : ''; ?>
			<div class="prd-links <?php echo $outer_class . $order_wrap_cls; ?>">
				<?php if ( ( ( $regular_price >= $purchase_upper ) && $internetpreis_flag == 0 ) || $stock_status == 'outofstock' ) { ?>
					
					<?php $kontakt_url = get_permalink( get_field( 'set_contact_page', 'option' ) ); ?>
				<button class="btn-blue"><a class="btn-link" href="<?php echo $kontakt_url . '?pid=' . $post->ID; ?>"><i class="icon-arrow_big"></i> <?php echo __( 'Anfrage', 'artifiche' ); ?></a></button>
					
					<?php
				}
				if ( ( ( $regular_price <= $purchase_limit ) || $internetpreis_flag == 1 ) && $stock_status == 'instock' ) {
					?>
					<?php
					global $product;
					 $product_id = $product->get_id();
					 echo do_shortcode( '[add_to_cart id=' . $product_id . ']' );
				}
				
				?>
	<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]');?>

				<!-- <button class="btn-blue"><i class="icon-shopping"></i>Bestellung</button> -->
				<?php if ( $stock_status == 'outofstock' ) { ?>
				<button class="btn-grey"><?php echo __( 'Plakat verkauft', 'artifiche' ); ?></button>
					<?php } ?>
					<?php
					if ( $parent_cat != '' ) {
						$similar_poster_link = get_permalink( get_field( 'similar_poster_page', 'option' ) );
						?>
				<input type="hidden" name="pcls-btn" class="pcls-btn" value="<?php echo __( 'Zurück zur Detailansicht', 'artifiche' ); ?>">
				<input type="hidden" name="pclr-code" class="pclr-code" value="<?php echo __( 'Hintergrund wählen', 'artifiche' ); ?>">

				<a href="<?php echo $similar_poster_link . $post->ID; ?>" class="common-link ahnliche-plakate"><?php echo __( 'Ähnliche Plakate', 'artifiche' ); ?></a>
					<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="white-bg"> 
	<div class="single-column">
		<div class="product-info-wrap">
			<?php
			$des_exist = false;
			$des_class = '';
			if ( ! empty( trim( strip_tags( str_replace( '&nbsp;', '', get_post_field( 'post_content', $post->ID ) ) ) ) ) ) {
				$des_exist = true;

			}
			?>
			
		<?php
		$product_desc_title = get_field( 'product_detail_page', 'option' );
		$product_desc_title = $product_desc_title['product_description_title'];
		if ( empty( $product_desc_title ) ) {
			$product_desc_title = __( 'Über dieses Plakat', 'artifiche' );
		}

		if ( $des_exist || $künstler_bio != '' ) {
			$des_class = 'prdt-dec';
			?>
		<div class="<?php echo $des_class; ?>">
			<?php if ( $des_exist ) { ?>
		<h2><?php echo $product_desc_title; ?></h2>			
		<p><?php echo strip_tags( get_post_field( 'post_content', $post->ID ) ); ?></p>
		<?php } ?>
			<?php if ( $künstler_bio != '' ) { ?>
		<h2><?php _e( 'Künstler:', 'artifiche' ); ?> <?php echo $künstler_vorname . ' ' . $künstle_lastname; ?></h2>
		<p>
				<?php
					$kunstler_det = '';
					$kunstler_bio = '';
					$length       = strlen( $künstler_bio );
				if ( $length > 420 ) {
					$kunstler_detail_page = get_permalink( get_field( 'kunstler_detail_page', 'option' ) );
					$kunstler_det        .= substr( $künstler_bio, 0, 420 ) . '... <a href="' . $kunstler_detail_page . $künstler_id . '" class="common-link read-more">' . __( 'mehr', 'artifiche' ) . '</a>';
					$kunstler_bio = $kunstler_det;
				} else {
					$kunstler_det .= $künstler_bio;
				}


				?>
		 </p>
				<?php
				$ismobile  = (int) wp_is_mobile();
				$mob_class = '';
				if ( $ismobile == 1 ) {
					$mob_class = 'kunstler-mob';
				}
				$kunstler_detail_page = get_permalink( get_field( 'kunstler_detail_page', 'option' ) );

				$kunstler_det .= '<div class="mt-2">
   			<a href="' . $kunstler_detail_page . $künstler_id . ' ">
		<button class="outline-btn mr-3"><i class="icon-arrow_big"></i>' . __( 'Biografie lesen', 'artifiche' ) . '</button></a>
		<a href="' . $künstler_link . '">
		<button class="outline-btn ' . $mob_class . '"><i class="icon-arrow_big"></i>' . __( 'Plakate von', 'artifiche' ) . ' ' . $künstler_vorname . ' ' . $künstle_lastname . '</button>
		</a>
		</div>';
				echo '<div class="desktop-only">
					<p>' . $kunstler_det . '</p>
					</div>
					<div class="mobile-only">
					<div class="brief-txt">

					' . substr( $kunstler_det, 0, 160 ) . '
					<span class="ellipsis">...</span>
					</div>
					<div class="moretext">
					' . substr( $kunstler_det, 160 ) . '

					</div>
					<a class="moreless-button">' . __( 'mehr', 'artifiche' ) . '</a>
					</div>';
				?>
		<?php } ?>
		</div>
		<?php } ?>
		<div class="detail-list">
			<h2><?php _e( 'Plakatdetails', 'artifiche' ); ?></h2>
			<ul >
				<?php
				if ( isset( $poster_number ) ) {
					echo $poster_number;}
				?>
				<?php
				if ( $künstler_name != '' ) {
					echo $künstler_name;}
				?>
				<?php
				if ( isset( $auftraggeber_v ) ) {
					echo $auftraggeber_v;}
				?>
				<?php
				if ( isset( $marke ) ) {
					echo $marke;}
				?>
				<?php
				if ( isset( $druckerei ) ) {
					echo $druckerei;}
				?>
				<?php
				if ( isset( $land ) ) {
					echo $land;}
				?>
				<?php
				if ( isset( $grosse ) ) {
					echo $grosse;}
				?>
				<?php
				if ( isset( $drucktechnik ) ) {
					echo $drucktechnik;}
				?>
				<?php
				if ( isset( $zustand_text ) ) {
					echo $zustand_text;}
				?>
				<?php
				if ( isset( $product_cat ) ) {
					echo $product_cat;}
				?>
				<?php
				if ( isset( $stilrichtung_v ) ) {
					echo $stilrichtung_v;}
				?>
				<?php
				if ( isset( $schlagworter_v ) ) {
					echo $schlagworter_v;}
				?>
				<?php
				if ( isset( $publikationen_name ) ) {
					echo $publikationen_name;}
				?>
				<?php
				if ( isset( $price_bt ) ) {
					echo $price_bt;}
				?>
				
				</ul>
				<div class="btn-wrap">
			<?php if ( ( ( $regular_price >= $purchase_upper ) && $internetpreis_flag == 0 ) || $stock_status == 'outofstock' ) { ?>
					<?php $kontakt_url = get_permalink( get_field( 'set_contact_page', 'option' ) ); ?>
					<a href="<?php echo $kontakt_url . '?pid=' . $post->ID; ?>">
				<button class="btn-blue"><i class="icon-arrow_big"></i> <?php echo __( 'Anfrage', 'artifiche' ); ?></button>
					</a>
				<?php
			}
			if ( ( ( $regular_price <= $purchase_limit ) || $internetpreis_flag == 1 ) && $stock_status == 'instock' ) {
				?>
				<?php
				global $product;
				 $product_id = $product->get_id();
				 echo do_shortcode( '[add_to_cart id=' . $product_id . ']' );
			}
			?>
			<button class="outline-btn" onclick="history.back();"><i class="icon-arrow_big"></i><?php echo __( 'Zurück zur Übersicht', 'artifiche' ); ?></button>
		</div>
		</div>
	</div>
	</div>
	<!-- Related posters -->
		<?php get_template_part( 'template-parts/related', 'products' ); ?>
</div>


<?php // do_action( 'woocommerce_after_single_product' ); ?>
</div>
