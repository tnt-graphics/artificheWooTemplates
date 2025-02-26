<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Artifiche
 */

get_header();
$homeclass = '';
if ( ! is_front_page() ) {
	$homeclass = 'otherpage-cls';
}
?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- .entry-header -->

	<div class="entry-content <?php echo $homeclass; ?>">
	<div class="">
		<div class="single-column min-col">
			<div class="breadcrumbs ">
			<div id="crumbs">
				<?php echo get_breadcrumb(); ?>
			</div>
		</div>
		<header class="entry-header">


	<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
	
</header>

	<?php

		the_archive_description( '<div class="archive-description desktop-only">', '</div>' );
	?>
	<div class="archive-description mobile-only">
		<div class="brief-txt">
			<?php
			$des = get_the_archive_description();
			echo strip_tags( substr( $des, 0, 177 ) );
			?>
			<span class="ellipsis">...</span>
		</div>
		<div class="moretext">
		<?php echo strip_tags( substr( $des, 177 ) ); ?>		
		</div>
		<a class="moreless-button"><?php echo __( 'mehr', 'artifiche' ); ?></a>
	</div>


	</div>
	<?php
		$current_term = get_queried_object()->term_id;
		$termargs     = array(
			'taxonomy' => array( 'Kollektionen' ), // taxonomy name
			'field'    => 'term_id',
			'orderby'  => 'include',
		);
		$posters      = '';
		$labels       = '';
		$poster_title = '';

		$termslists              = get_terms( $termargs );// print_r($terms);
		$i                       = 1;
		$plakatkollektionen_link = get_permalink( get_field( 'set_plakatkollektionen_page', 'option' ) );
		$term_options            = '<option selected="selected" value="' . $plakatkollektionen_link . '">' . __( 'Alle Kollektionen' ) . '</option>';
		$current_term_id         = '';
		foreach ( $termslists as $termone ) :
			if ( $current_term == $termone->term_id ) {
				$selected        = 'selected="selected"';
				$current_term_id = $termone;
			} else {
				$selected = '';
			}
			$term_options .= '<option value="' . get_term_link( $termone ) . '" ' . $selected . '>' . $termone->name . '</option>';
		endforeach;
		wp_reset_postdata();
		if ( isset( $_COOKIE['sold_posters'] ) && $_COOKIE['sold_posters'] == true ) {
			$sold_posters    = ( $_COOKIE['sold_posters'] == true ) ? 'checked="checked"' : '';
			$sold_poster_val = ( $_COOKIE['sold_posters'] == true ) ? 1 : 0;
		} else {
			$sold_posters    = '';
			$sold_poster_val = 0;
		}
		$term_list = '<div class="cat-filter spacer-2">
			<label for="name">' . __( 'Unsere Kollektionen:', 'artifiche' ) . '</label>
			<select onchange="javascript:location.href = this.value;" class="js_select">' . $term_options . '</select>
		    </div><div class="check-outer spacer-1">
			<label class="custom-checkbox checkbox-light">
			<span class="check-label">' . esc_html__( 'Verkaufte Plakate ausblenden', 'artifiche' ) . '</span>
			
			<input name="csold_posters" class="reload" ' . $sold_posters . ' type="checkbox" value="' . $sold_poster_val . '"> <span class="checkmark"></span>
			</label></div>';

		if ( ! empty( $termslists ) ) {
			/* Start the Loop */
			$poster_single     = '';
			$ct                = get_term_by( 'term_id', $current_term, 'Kollektionen' );
			$plakatzuweisungen = get_field( 'plakatzuweisungen', $ct );
			if ( $plakatzuweisungen != '' ) {
				$poster_array = explode( ';', $plakatzuweisungen );
				// print_r( $poster_array );
				if ( isset( $_COOKIE['sold_posters'] ) && $_COOKIE['sold_posters'] == true ) {
					$sold_posters = 1;
				} else {
					$sold_posters = 0;
				}
				$metaquery[] = array(
					'key' => 'neu_flag',
				);
				$orderby       = array(
					'meta_value' => 'DESC',
					'date'       => 'ASC',
				);
				if ( $sold_posters == 1 ) {
					$metaquery[] = array(
						'key'     => '_stock_status',
						'value'   => array( 'instock' ),
						'compare' => 'IN',
					);

				} else {
					$metaquery[] = array(
						'key'     => '_stock_status',
						'value'   => array( 'outofstock', 'instock' ),
						'compare' => 'IN',
					);
				}

				$poster_args               = array(
					'post_type'      => 'product',
					'posts_per_page' => 20,
					'post_status'      => 'publish',
					'orderby'          => $orderby,
					'suppress_filters' => false,
				);
				$metaquery[] = array(
					'key'     => 'plakatnummer',
					'value'   => array_filter($poster_array),
					'compare' => 'IN',
				);

				$poster_args['meta_query'] = $metaquery;
				$args['meta_query']['relation'] = 'AND';
				// print_r( $poster_args );
				$poster_array = get_posts( $poster_args );
				foreach ( $poster_array as $cpost ) {

					$labels                 = '';
					$image_id               = get_post_meta( $cpost->ID, 'plakatnummer', true );
					$new_flag               = get_post_meta( $cpost->ID, 'neu_flag', true );
					$collectors_choice_flag = get_post_meta( $cpost->ID, 'collectors_choice_flag', true );
					$sale_flag              = get_post_meta( $cpost->ID, 'sale_flag', true );
					$product                = wc_get_product( $cpost->ID );
					$regular_price          = $product->get_regular_price();
					$regular_price          = get_post_meta( $cpost->ID, 'preiskategorie_chf', true );
					$sale_price             = $product->get_sale_price();
					$internetpreis_flag     = get_post_meta( $cpost->ID, 'internetpreis_flag', true );
					$stock_status           = $product->get_stock_status();
					$purchase_limit         = get_field( 'purchase_limit', 'option' );
					$purchase_upper         = $purchase_limit + 1;
					// $labels .= '<div class="poster-label">';
					if ( $new_flag != 0 && $new_flag == 1 ) {
						$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';
						if ( $collectors_choice_flag == 0 ) {
							$labels .= '<span class="separator">:</span>';
						}
					}
					if ( $collectors_choice_flag != 0 && $collectors_choice_flag == 1 ) {
						if ( $new_flag != 0 && $new_flag == 1 ) {
							$labels .= '<span class="separator">/</span>';
						}


						$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';
						if ( $new_flag == 0 ) {
							$labels .= '<span class="separator">:</span>';
						}
					}
					if ( $stock_status == 'outofstock' ) {
						$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';
					}
					$sale_option = get_field( 'sale_option', 'option' );
					if ( ! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'normal', true ) == true && $sale_flag == 1 ) {
						$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';
					}
					$collectors_choice_flag = get_post_meta( $cpost->ID, 'collectors_choice_flag', true );
					$poster_title           = '<b class="bold-txt">' . $cpost->post_title . '</b>';
					$category_detail        = get_the_terms( $cpost->ID, 'kunstler' );
					$jahr                   = get_post_meta( $cpost->ID, 'jahr', true );
					$k_flag                 = false;
					if ( ! empty( $category_detail ) ) {

						$i     = 0;
						$count = count( $category_detail );
						foreach ( $category_detail as $cd ) {


							$künstler_vorname = get_field( 'gestalter_vorname', $cd );
							$künstle_lastname = get_field( 'gestalter_name', $cd );
							// echo sanitize_title( 'Künstler' );
							if ( $künstler_vorname != '' || $künstle_lastname != '' ) {
								$gestler = $künstler_vorname . ' ' . $künstle_lastname;
							} else {
								$gestler = explode( '(', $cd->name )[0];
							}


							if ( $gestler != '' ) {

								$coma = ( $gestler != '' ) ? ',' : '';

								$künstler_name = '<a href="' . get_term_link( $cd ) . '"><span class="kunstler_name">' . $gestler . $coma . $jahr . '</span></a>';
								$künstler_woy  = '<a href="' . get_term_link( $cd ) . '"><span class="kunstler_name">' . $gestler . '</span></a>';

							} else {
								$k_flag = true;

							}
						}
					} else {
						$k_flag = true;
					}

					if ( $k_flag ) {
						$künstler_name = '<span class="kunstler_name">' . $jahr . '</span>';
					}
					$alt_text = artf_get_alt_text( $cpost->ID );
					// $labels .='</div>';

					// if( $j % 4 == 1)
					// $posters .= '<div class="poster-row">';

					$posters .= '<div class="poster-single">
			       		<a href="' . get_permalink( $cpost->ID ) . '">
			            <div class="poster">
			                <img  src="' . site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="' . $alt_text . '" />
			            </div>
			            </a>
			            <div class="caption">
			                ' . $labels . '
			               <a href="' . get_permalink( $cpost->ID ) . '">' . $poster_title . '</a>
			                ' . $künstler_name . '
			            </div>
			        </div>';

					?>
				<!-- poster-row repeats -->
					<?php


					wp_reset_postdata();
				}
			}
		} else {
			$posters .= '<p class="no-poster">
				' . __( 'No posters found.', 'artifiche' ) . '
			 </p>';

		}
			$html = '<div class="container"><div class="home-collection-list">' . $term_list . '<div class="posters poster_grid tax-all-list poster_grid tax-coll">'
			. $posters .
			'</div></div>
			<input type="hidden" name="tax-readmore-name" id="tax-readmore-name" value="Kollektionen">
			<input type="hidden" id="current-tax" name="current-tax" value="' . $current_term . '">
			<div class="artifiche-readmore tax-loadmore">
		
			<a href="javascript:void(0);" id="tax-loadmore" class="outline-btn loadmore"><i class="icon-plus"></i>
			' . __( 'Weitere', 'artifiche' ) . '</a>
			</div></div>';

			echo $html;
		?>



	</div>
	</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->
</main><!-- #main -->
<?php
get_footer(); ?>
