<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Artifiche
 */

get_header();
$current_term = get_queried_object()->term_id;
$publikationen = get_field( 'buch', get_queried_object() );
$publikationen_jahr = get_field( 'jahr', get_queried_object() );

$homeclass = '';
if (!is_front_page()) {
	$homeclass = "otherpage-cls";
}

?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- .entry-header -->

	<div class="entry-content <?php echo $homeclass; ?>">
	<div class="container">
		<div class="single-column">
			<div class="breadcrumbs ">
			<div id="crumbs">
				<?php echo get_breadcrumb(); ?>
			</div>
		</div>
		<header class="entry-header">


	<?php echo '<h1 class="page-title">'. $publikationen .'</h1>'; ?>
	
</header>
	<?php

		the_archive_description( '<div class="archive-description">', '</div>' );
	?>
	</div>
	<?php
		
		$termargs     = array(
			'taxonomy'   => array( 'publikationen' ), // taxonomy name
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
			$publikationen = get_field( 'buch', $termone );
			$more = "";
			if( substr( $publikationen, 76 ) ){
				$more = "...";
			}
			$term_options .= '<option value="' . get_term_link( $termone ) . '" ' . $selected . '>' . substr( $publikationen, 0, 75 ) .$more. '</option>';
		endforeach;
		wp_reset_postdata();

		$term_list = '<div class="cat-filter">
			<label for="name">' . __( 'Publikationen:', 'artifiche' ) . '</label>
			<select onchange="javascript:location.href = this.value;" class="custom-select js_select">' . $term_options . '</select>
		</div>';


			/* Start the Loop */
		$poster_single = '';
		// $j = 1;
	

		// 	$html = '<div class="home-collection-list">' . $term_list . '<div class="posters tax-all-list poster_grid">'
		// 	. $posters .
		// 	'</div></div>
		// 	<input type="hidden" name="tax-readmore-name" id="tax-readmore-name" value="publikationen">
		// 	<input type="hidden" id="current-tax" name="current-tax" value="'. $current_term .'">
		// 	<div class="artifiche-readmore tax-loadmore">
		
		// 	<a href="javascript:void(0);" id="tax-loadmore" class="outline-btn loadmore"><i class="icon-plus"></i>
		// 	' . __('Weitere') . '</a>
		// 	</div>';

		// echo $html;
			$id = get_queried_object();
			$publikationen = get_field( 'buch', $id ); 
			$publikationen_jahr = get_field( 'jahr', $id );
			$coma = '';
			if( $publikationen != '' && $publikationen_jahr != '' ){

				$coma = ', ';
			}
			$alt_text = $publikationen.$coma.$publikationen_jahr;

			  // $slug = make_slug( $publikationen );
			  // $img = $slug.'-'.$publikationen_jahr;
			$img = get_field( 'id', $id ); 

			$image_file = $_SERVER['DOCUMENT_ROOT'] . '/artifiche-images/publications/' . $img . '.jpg';
			$alt_text = '';
			$noimg_title = '';
			if ( ! file_exists( $image_file )){
				$alt_text = __("No image available",'artifiche');
				$noimg_title = 'title="'.__("No image available",'artifiche').'"';
				$image_path = site_url() . '/artifiche-images/blank.png';
				
			}else{
				$image_path = site_url() . '/artifiche-images/publications/' . $img . '.jpg';
			}

$autor_detail = get_field( 'autor', $id);
	$autor_name = '';
                if( ! empty( $autor_detail ) ){
               
                    $autor_name = '<li><strong class="list-title">'.__( 'Author:','artifiche' ).'</strong>';
                    
                       
                        
					$autor_name .= '<span>'. $autor_detail .'</span>';  
					
                    $autor_name .= '</li>';
                    
                }
$herausgeber_detail = get_field( 'herausgeber', $id);
	$herausgeber = '';
                if( ! empty( $herausgeber_detail ) ){
               
                    $herausgeber = '<li><strong class="list-title">'.__( 'Publisher:','artifiche' ).'</strong>';
                    
                       
                        
					$herausgeber .= '<span>'. $herausgeber_detail .'</span>';  
					
                    $herausgeber .= '</li>';
                    
                }

	$jahr = '';
                if( ! empty( $publikationen_jahr ) ){
               
                    $jahr = '<li><strong class="list-title">'.__( 'Year:','artifiche' ).'</strong>';
                    
                       
                        
					$jahr .= '<span>'. $publikationen_jahr .'</span>';  
					
                    $jahr .= '</li>';
                    
                }
$weblink = get_field( 'weblink', $id ); 
$weblink_text = get_field( 'weblink_text', $id ); 
?>
<div class="white-bg">
	<div class="single-column">
		<div class="publication-wrap">
			<?php if( $autor_name != '' || $herausgeber != '' || $jahr != '' ){?>

			<h2><?php echo __( 'Details:','artifiche' );?></h2>
			<?php } ?>
			<div>
				<div class="publication">
					<img  src="<?php echo $image_path; ?>" alt="<?php echo $alt_text;?>" <?php echo $noimg_title; ?> />
				</div>

				<div class="detail-list pub-list">
					<ul >
							
							<?php if( $autor_name != '' ) echo $autor_name;?>
							<?php if( $herausgeber != '' ) echo $herausgeber;?>
							<?php if( $jahr != '' ) echo $jahr;?>
							</ul>
					</div>
				</div>
			</div>
			<?php if( $weblink != '' && $weblink_text != '' ){?>
			<a href="<?php echo $weblink;?>" class="common-link" target="_blank"><?php echo $weblink_text; ?></a><br> 
			<?php } ?>


		<button class="outline-btn mt-6" onclick="history.back();"><i class="icon-arrow_big"></i><?php echo __( 'Back', 'artifiche' );?></button>

		</div>
	</div>
	
</div>





	</div>
	</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->
</main><!-- #main -->
<?php
get_footer(); ?>
