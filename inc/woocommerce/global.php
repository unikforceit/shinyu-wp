<?php

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
//remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar', 10 );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

add_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// add_filter( 'wc_add_to_cart_message_html', '__return_null' );
// add_filter( 'wc_add_to_cart_message', '__return_empty_string' );

function woocommerce_output_content_wrapper_start()
{ ?>
  <div class="page-header<?php if (is_product()) echo ' page-header-small' ?>">
    <div class="container">
      <?php if (is_product()) : ?>
        <h1 class="page-title"><?php the_title() ?></h1>
      <?php else : ?>
        <h1 class="page-title"><?php woocommerce_page_title() ?></h1>
      <?php endif; ?>
      <?php woocommerce_breadcrumb(); ?>
    </div>
  </div>
  <?php //if(is_shop() && get_current_user_id() !== 2) echo ' d-none' ?>
  <div class="main-content page-product">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class='product-content'>
<?php }

function woocommerce_output_content_wrapper_end() { ?>
  </div></div></div></div></div>

<?php }

//add_action( 'woocommerce_review_order_after_order_total', 'woocommerce_order_total', 10 );
//add_action( 'woocommerce_cart_totals_after_order_total', 'woocommerce_order_total', 10 );
function woocommerce_order_total()
{?>
  <tr class="order-total mimo-order-total">
    <th><?php _e( 'Totals', THEME_SLUG ); ?><span>(รวมภาษีมูลค่าเพิ่ม)</span></th>
    <td data-title="<?php esc_attr_e( 'Totals', THEME_SLUG ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
  </tr>
<?php }



add_filter( 'woocommerce_show_page_title', '__return_false' );


add_filter( 'woocommerce_breadcrumb_defaults', function(){
  return array(
    'delimiter'   => '<span class="delimiter"> › </span>',
    'wrap_before' => '<nav class="breadcrumb" itemprop="breadcrumb">',
    'wrap_after'  => '</nav>',
    'before'      => '<span>',
    'after'       => '</span>',
    'home'        => pll__('Home'),
  );
});


add_filter( 'woocommerce_product_tabs', function(){

  unset( $tabs['description'] );
  unset( $tabs['reviews'] );
  unset( $tabs['additional_information'] );

  return $tabs;

}, 98);


add_action('wp_print_scripts', function(){
  wp_dequeue_script( 'wc-password-strength-meter' );
}, 10);

add_filter('woocommerce_account_menu_items', function(){
  unset($items['downloads']);
  return $items;
});

// add_filter('woocommerce_countries', function($countries){
//   return ['TH' => pll__('Thailand'),  'JP' => pll__('Japan')];
// });

add_filter('gettext', 'mimo_translate', 20, 3);

function mimo_translate( $translated_text , $untranslated_text, $domain ) {

  if ( $domain == 'woocommerce') {

    switch( $untranslated_text ) {
      // case 'Apply coupon':
      //   $translated_text = __( 'Apply', THEME_SLUG );
      //   break;
      // case 'Coupon code':
      //   $translated_text = __( 'Promo code', THEME_SLUG );
      //   break;
      // case 'Coupon:':
      //   $translated_text = __( 'Promo code', THEME_SLUG );
      //   break;
      // case 'Coupon code applied successfully.':
      //   $translated_text = __( 'Promo code applied successfully.', THEME_SLUG );
      //   break;
      // case 'Please enter a coupon code.':
      //   $translated_text = __( 'Please enter a promo code.', THEME_SLUG );
      //   break;
      // case 'Coupon code already applied!':
      //   $translated_text = __( 'Promo code already applied!', THEME_SLUG );
      //   break;
      // case 'Coupon "%s" does not exist!':
      //   $translated_text = __( 'Promo "%s" does not exist!', THEME_SLUG );
      //   break;

      // case 'Place order':
      //   $translated_text = 'สมัคร / Register';
      //   break;

      // case 'Proceed to checkout':
      //   $translated_text = 'สมัคร / Register';
      //   break;

      case 'House number and street name':
        $translated_text = 'บ้านเลขที่ หมู่ที่ หมู่บ้าน ซอย ถนน';
        break;

      case 'Select an option&hellip;':
        $translated_text = '';
        break;
        
      case 'Ship to a different address?':
        $translated_text = '3. ใบเสร็จ ส่งไปที่อยู่อื่น ?';
        break;
      // case 'Product':
      //   $translated_text = 'Package';
      //   break;

      case 'Billing':
        $translated_text = '';
        break;

      // case '%s is a required field.':
      //   $translated_text = '';
      //   break;
    }

  }else{

    switch( $untranslated_text ) {
      case 'WooCommerce Multilingual':
        $translated_text = __( 'Translate language', THEME_SLUG );
        break;
    }

  }



  return $translated_text;

}