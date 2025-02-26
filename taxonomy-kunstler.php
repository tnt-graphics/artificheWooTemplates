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

			'taxonomy' => array( 'kunstler' ), // taxonomy name

			'field'    => 'term_id',

			'orderby'  => 'include',

		);

		$posters      = '';

		$labels       = '';

		$poster_title = '';

		

		$termslists   = get_terms( $termargs );// print_r($terms);

		$i            = 1;

		$term_options = '';

		foreach ( $termslists as $termone ) :

			if( $current_term == $termone->term_id ){

				$selected = 'selected="selected"';

				//echo $termone->term_id;

			}else{

				$selected     = '';

			}

			$term_options .= '<option value="' . get_term_link( $termone ) . '" '. $selected .'>' . $termone->name . '</option>';

		endforeach;

		wp_reset_postdata();



		$term_list = '<div class="cat-filter spacer-2">

			<label for="name">' . __( 'Künstler:', 'artifiche' ) . '</label>

			<select onchange="javascript:location.href = this.value;" class="custom-select js_select">' . $term_options . '</select>

		</div>';

		$size_list_label = "";
		$sub_cat_list_label = "";
		$main_cat_list_label = "";
		$price_list_label = "";

	if ( have_posts() ):	

			/* Start the Loop */ 

    $poster_single = ''; 

   // $j = 1;

    while ( have_posts() ) :

                the_post(); 



                $labels = '';

                $image_id = get_post_meta( $post->ID, 'plakatnummer', true);

                $new_flag = get_post_meta( $post->ID, 'neu_flag', true);

                $collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true);

				$sale_flag = get_post_meta( $post->ID, 'sale_flag', true );

                $jahr        = get_post_meta( $post->ID, 'jahr', true );

                $breite_cm   = get_post_meta( $post->ID, 'breite_cm', true );

                $breite_inch = get_post_meta( $post->ID, 'breite_inch', true );

                $hohe_cm     = get_post_meta( $post->ID, 'hohe_cm', true );

                $hohe_inch   = get_post_meta( $post->ID, 'hohe_inch', true );

               // $price       = get_post_meta( $post->ID, 'unit_price', true );

				$product     = wc_get_product( $post->ID );

				$regular_price      = $product->get_regular_price();

				$regular_price      = get_post_meta( $post->ID, 'preiskategorie_chf', true );

				$sale_price         = $product->get_sale_price();

				$internetpreis_flag = get_post_meta( $post->ID, 'internetpreis_flag', true );

				$stock_status       = $product->get_stock_status();

				$purchase_limit     = get_field( 'purchase_limit', 'option' );

				$purchase_upper     = $purchase_limit + 1;

				$price       = $product->get_price_html();



				$product_cat = get_the_terms( $post->ID, 'product_cat');

				$labels = '';

              //  $labels .= '<div class="poster-label">';

               

                 $poster_title = '<b class="bold-txt">'.get_the_title().'</b>';

                  if( $new_flag != '' && $new_flag == 1 ){

                    $labels .='<span class="poster-l-yellow">'.__( 'NEU','artifiche' ).'</span>';

                }

                if( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ){

                	// if( $new_flag != '' && $new_flag == 1 ) $labels .='<span>/</span>';





                    $labels .='<span class="poster-l-red">'.__( 'Collector’s Choice','artifiche' ).'</span>';

                }

                if ( $stock_status == 'outofstock' ) {

				$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';

				}

				

                $collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true);

                if( get_the_title( $post->ID ) ){

                 	$poster_title = '<b class="bold-txt">'.get_the_title( $post->ID ).'</b>';



                }

				$sale_option = get_field( 'sale_option', 'option' );

			if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'normal', true ) == true && $sale_flag == 1 ) {

					$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';

				}

                 $category_detail = get_the_terms( $post->ID, 'kunstler');



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

                

                if( $jahr != '' )

			    	$jahr_list_label = '<span class="list_jahr">'.__( 'Jahr','artifiche' ).':</span><span class="jahr">'.$jahr.'</span><span>/</span>';

			    if( get_the_title( $post->ID ) ){

			    	$poster_title_list = '<h2>'.get_the_title( $post->ID ).'</h2>';



			    }

			    if( $künstler_name != '' )

			    	$kunstler_list_label = '<span class="list_kunstler">'.__( 'Künstler','artifiche' ).':</span>'.$künstler_name.'<span>/</span>';

			    

			    if( $breite_cm != '' || $breite_inch != '' || $hohe_cm != '' || $hohe_inch != '' ){



			    	$size_list_label .= '<span class="list_size">'.__( 'Grösse','artifiche' ).':</span>';



			    	$size_list_label .= '<span class="cm">'.$breite_cm.' x '. $hohe_cm .'cm</span>';

			    	if( $breite_inch != '' && $hohe_inch != '' ){



			    		$size_list_label .= '/<span class="inch">'.$breite_inch.' x '. $hohe_inch .'"</span>';



			    	}

			    }



			     if( $price != '')

			    	$price_list_label = '<span class="list_price">'.__( 'Preisklasse','artifiche' ).':</span>'.$price.' '.__( '(unverbindliche Preisempfehlung)','artifiche' );

			    

			    if( ! empty( $product_cat ) ){



			    	foreach( $product_cat as $cat ){

			    			

			    		 if( $cat->parent == 0) $main_cat_list_label .= '<span class="main_cat">'. $cat->name .'</span>';

			    			

			    		else $sub_cat_list_label .= '<span class="sub_cat">'. $cat->name .'</span>';

			    	}

			    }

			   $alt_text = artf_get_alt_text( $post->ID );

              //  $labels .='</div>';

                

			// if( $j % 4 == 1)

			//         $posters .= '<div class="poster-row">';

			    

			       $posters .='<div class="poster-single">

			       <a href="'. get_permalink( $post->ID ).'">

			            <div class="poster">

			                <img  src="' . site_url() . '/artifiche-images/posters_large/'. $image_id .'.jpg" alt="'. $alt_text .'" />

			            </div>

			        </a>

			            <div class="caption">

			                '. $labels .'

			               <a href="'. get_permalink( $post->ID ).'">'. $poster_title .'</a>

			                '. $künstler_name .'

			            </div>

			             <div class="poster_list_caption" style="display: none;">

			            	'. $labels .'

			               '. $poster_title_list .'

			               '. $jahr_list_label .'

			               '. $kunstler_list_label .'

			               '. $size_list_label .'

			               <br/>

			               '. $price_list_label .'

			               <br/>

			               	<span class="catLabel">

			                '. $künstler_name .'

			                '.$main_cat_list_label.'

			                '.$sub_cat_list_label.'

			                </span>

			            </div>

			        </div>';

			      

			    ?>

			    <!-- poster-row repeats -->

			   <?php /*$j++;

			                      

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



            

            $html = '<div class="container"><div class="home-collection-list">' . $term_list .'<div class="posters tax-all-list poster_grid">'

            . $posters .

			'</div></div>

			<input type="hidden" name="tax-readmore-name" id="tax-readmore-name" value="kunstler">

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