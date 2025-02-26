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
if (!is_front_page()) {
	$homeclass = "otherpage-cls";
}
?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- .entry-header -->

	<div class="entry-content <?php echo $homeclass; ?>">
	
		<div class="single-column">
			<div class="breadcrumbs ">
			<div id="crumbs">
				<?php echo get_breadcrumb(); ?>
			</div>
		</div>
		<header class="entry-header">


	<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
	
</header>
	<?php

		the_archive_description( '<div class="archive-description">', '</div>' );
	?>
	</div>
	<?php
		$current_term = get_queried_object()->term_id;
		$termargs     = array(
			'taxonomy'   => array( 'pa_stilrichtung' ), // taxonomy name
			'field'      => 'term_id',
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => true,
		);
		$posters      = '';
		$labels       = '';
		$poster_title = '';

		$termslists   = get_terms( $termargs );// print_r($terms);
		$i            = 1;
		$term_options = '';
		foreach ( $termslists as $termone ) :
			if ( $current_term == $termone->term_id ) {
				$selected = 'selected="selected"';
				// echo $termone->term_id;
			} else {
				$selected = '';
			}
			$term_options .= '<option value="' . get_term_link( $termone ) . '" ' . $selected . '>' . $termone->name . '</option>';
		endforeach;
		wp_reset_postdata();

		$term_list = '<div class="cat-filter spacer-2">
			<label for="name">' . __( 'Stilrichtung:', 'artifiche' ) . '</label>
			<select onchange="javascript:location.href = this.value;" class="custom-select js_select">' . $term_options . '</select>
		</div>';

		if ( have_posts() ):
			/* Start the Loop */
		$poster_single = '';
		// $j = 1;
		while ( have_posts() ) :
				the_post();

				$labels                 = '';
				$image_id               = get_post_meta( $post->ID, 'plakatnummer', true );
				$new_flag               = get_post_meta( $post->ID, 'neu_flag', true );
				$collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true );
				$jahr = get_post_meta( $post->ID, 'jahr', true );
				$sale_flag = get_post_meta( $post->ID, 'sale_flag', true );
			  // $labels .= '<div class="poster-label">';
			  	$product = wc_get_product( $post->ID );
				$regular_price      = $product->get_regular_price();
				$regular_price      = get_post_meta( $post->ID, 'preiskategorie_chf', true );
				$sale_price         = $product->get_sale_price();
				$internetpreis_flag = get_post_meta( $post->ID, 'internetpreis_flag', true );
				$stock_status       = $product->get_stock_status();
				$purchase_limit     = get_field( 'purchase_limit', 'option' );
				$purchase_upper     = $purchase_limit + 1;
			if ( $new_flag != '' && $new_flag == 1 ) {
				$labels .= '<span class="poster-l-yellow">' . __( 'NEU', 'artifiche' ) . '</span>';
			}
			if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {

				 if( $new_flag != '' && $new_flag == 1 ) $labels .='<span class="separator">/</span>';
				 
				$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';
			}
			if ( $stock_status == 'outofstock' ) {
				$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';
			}
			$sale_option = get_field( 'sale_option', 'option' );
			if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'normal', true ) == true && $sale_flag == 1 ) {
				$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';
			}
				$collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true );
				 $poster_title          = '<b class="bold-txt">' . get_the_title() . '</b>';
				 $category_detail       = get_the_terms( $post->ID, 'kunstler' );

			$k_flag = false;
                if( ! empty( $category_detail ) ){
                    
                    $i = 0;
                    $count = count( $category_detail );
                    foreach( $category_detail as $cd ){
                       

                      $künstler_vorname = get_field( 'gestalter_vorname', $cd );
                      	$künstle_lastname = get_field( 'gestalter_name', $cd );
                    // echo sanitize_title( 'Künstler' );
                      	if( $künstler_vorname != '' || $künstle_lastname != '')
                      		$gestler = $künstler_vorname.' '. $künstle_lastname;
                      	else
                      		$gestler = explode("(", $cd->name)[0];


					  if ($gestler != '' ) {         

                      	$coma = ( $gestler != '') ? ',' : '';

                        $künstler_name = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler.$coma.$jahr.'</span></a>';    
                        $künstler_woy = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler.'</span></a>';
                     
					  }else{
					  	$k_flag = true;
					  	
					  }
                      	
                    }                    
                }else{
                	$k_flag = true;
                }
                
                if( $k_flag ) $künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';
			$alt_text = artf_get_alt_text( $post->ID );
			  // $labels .='</div>';

			// if( $j % 4 == 1)
			// $posters .= '<div class="poster-row">';

				   $posters .= '<div class="poster-single">
				   		<a href="'. get_permalink( $post->ID ).'">
			            <div class="poster">
			                <img   src="' . site_url() . '/artifiche-images/posters_large/' . $image_id . '.jpg" alt="'. $alt_text .'" />
			            </div>
			            </a>
			            <div class="caption">
			                ' . $labels . '
			               <a href="'. get_permalink( $post->ID ).'">' . $poster_title . '</a>
			                ' . $künstler_name . '
			            </div>
			        </div>';

			?>
				<!-- poster-row repeats -->
			   <?php
				/*
				$j++;

					   if( $j > 4 ){
						$j = 1;
						$posters .= '</div>';
					 }*/
			endwhile;

			wp_reset_postdata();
			else :
				$posters .= '<p class="no-poster">
								'. __( 'No posters found.', 'artifiche' ) .'
							 </p>';

			endif;

			$html = '<div class="container"><div class="home-collection-list">' . $term_list . '<div class="posters tax-all-list poster_grid">'
			. $posters .
			'</div></div>
			<input type="hidden" name="tax-readmore-name" id="tax-readmore-name" value="pa_stilrichtung">
			<input type="hidden" id="current-tax" name="current-tax" value="'. $current_term .'">
			<div class="artifiche-readmore tax-loadmore">
		
			<a href="javascript:void(0);" id="tax-loadmore" class="outline-btn loadmore"><i class="icon-plus"></i>
			' . __('Weitere') . '</a>
			</div></div>';

		echo $html;
		?>



	</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->
</main><!-- #main -->
<?php
get_footer(); ?>
