<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
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
do_action( 'woocommerce_email_header', $email_heading, $email ); 

$order_items = $order->get_items();

foreach ($order_items as $item) {
	$product_id  = $item->get_product_id();
}

$link = get_field('_product_courses_study_link', $product_id);
$product_slug = get_post_field('post_name', $product_id);
?>


<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
<!-- <p><?php esc_html_e( 'We have finished processing your order.', 'woocommerce' ); ?></p> -->
<?php if (pll_current_language() === 'th'): ?>
	<?php if ($link) : ?>
	<p>ขอบคุณสำหรับความไว้วางใจเลือกซื้อคอร์สเรียนกับเรา. <br>
เราได้รับชำระเงินค่าบริการจากท่านเรียบร้อยแล้ว. <br>
หวังว่าคอร์สของเราจะทำให้ท่านได้รับความรู้ และ ประสบการณ์สำหรับการเป็นนายหน้ามืออาชีพ โปรดติดต่อขอรับเอกสารการเรียน และเอกสารการทำงาน ได้จาก Line OA จากลิงค์ด้านล่าง</p>
	<?php else : ?>
	<p>ขอบคุณสำหรับความไว้วางใจเลือกใช้บริการของเรา. <br> เราได้รับชำระเงินค่าบริการจากท่านเรียบร้อยแล้ว. <br> ทางทีมงานจะรีบประสานงานและดูแลให้ท่านได้รับบริการที่ดีที่สุดค่ะ</p>
	<?php endif; ?>
<?php else: ?>
<p>Thank you for your order. We would like to confirm you that we already recieved your payment. Here's a reminder of what you ordered.</p>
<?php endif; ?>
<?php

// switch ($product_slug) {
// 	case 'management-service':
// 		echo "Thank you for your order. We would like to confirm you that we already recieved your payment. Here's a reminder of what you ordered.";
// 		break;

// 	case 'room-deposit':
// 		echo "Thank you for your order. We would like to confirm you that we already recieved your payment. Here's a reminder of what you ordered.";
// 		break;

// 	case 'inspection-service':
// 		echo "Thank you for your order. We would like to confirm you that we already recieved your payment. Here's a reminder of what you ordered.";
// 		break;
// 	default:
// 		break;
// }


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

	switch ($product_slug) {
		case 'management-service':
			if (pll_current_language() !== 'th') {
				echo "Contract Period<br><br>
			
				By the subscribing you authorize us ti charge you the subscription cost (as described above)<br>
				automatically, Charged yearly to the payment method provided until canceled. <br><br>
				
				You're subscribed with you account (Customer user name)<br><br>
				
				If you have any questions please do not hesitate to contact us via marketing@shinyurealestate.com or Line OA  https://lin.ee/536xXCX <br><br>
				
				Best Regards<br>
				Shinyu Real Estate";
			}
			break;

		case 'room-deposit':
			if (pll_current_language() !== 'th') {
				echo "Our team will contact you back for the further process.<br><br>
				Best Regards <br>
				Shinyu Real Estate";
			}

			break;

		case 'inspection-service':
			if (pll_current_language() !== 'th') {
				echo "Best Regards <br>
				Shinyu Real Estate";
			}
			break;
		default:
			break;
	}

	if ($link) : ?>
		<?php if (pll_current_language() === 'th') : ?>
		<h3>ลิงค์กลุ่มเรียน</h3>
		<p><?php echo get_the_title($product_id) . ' : ' . $link; ?></p><br>
		<p>ติดตามข่าวสารและโปรโมชั่นได้ทาง https://www.facebook.com/ShinyuAcademy</p>
		<p>ช่องทางติดต่อสอบถามทีมงานและรับเอกสารการเรียน https://lin.ee/rgphTCC</p>
		<?php else : ?>
			<p>Here are the course detail<br>
			<h3>Link (Facebook Group)</h3>
<p><?php echo get_the_title($product_id) . ' : ' . $link; ?><br>
Please join the group, we would accept you within 24 hours</p>

<p>You can get the news and all update from us at https://www.facebook.com/ShinyuAcademy
If you have any questions or you would like to contact the Academy team for the course's materials please add our Line OA https://lin.ee/rgphTCC</p>


	<p>Best Regards<br>
Shinyu Real Estate </p>
		<?php endif ?>
	<?php endif; 

	// pll_get_post(get_page_by_path('product')->ID)

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
