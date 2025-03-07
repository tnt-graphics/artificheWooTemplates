<?php
/**
 * Admin failed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-failed-order.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %1$s: Order number. %2$s: Customer full name. */ ?>
<p><?php printf( esc_html__( 'Payment for order #%1$s from %2$s has failed. The order was as follows:', 'woocommerce' ), esc_html( $order->get_order_number() ), esc_html( $order->get_formatted_billing_full_name() ) ); ?></p>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */

 if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * add poster details
 */
$items = $order->get_items();
foreach ( $items as $item ) {
    $product_name 		= $item->get_name();
    $product_id 		= $item->get_product_id();
	$poster_id      	= get_post_meta( $product_id, 'plakat_id', true );
	$poster_number 		= get_post_meta( $product_id, 'plakatnummer', true );
?>
	<p><?php printf( esc_html( wp_strip_all_tags( wptexturize( 'Poster-Nummer: '.$poster_number ) ) ));?></p>
	<p><?php printf( esc_html( wp_strip_all_tags( wptexturize( 'Poster-ID: '.$poster_id ) ) )); ?></p>
<?php
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
*/
do_action( 'woocommerce_email_footer', $email );
