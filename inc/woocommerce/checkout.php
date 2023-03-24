<?php remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

add_filter( 'wc_add_to_cart_message_html', function() {
  return ''; 
});

add_action('woocommerce_before_thankyou', function(){
  echo '<div class="woocommerce-order-inner">';
});

add_action('woocommerce_thankyou', function(){
  echo '</div>';
});

add_filter('query_vars', function($qvars){
  $qvars[] = 'status';
  return $qvars;
});

add_filter('woocommerce_order_button_html', function($html){
  $order_button_text = pll__('Place order');
  return '<button type="submit" class="button is-primary alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '"><span>' . esc_html( $order_button_text ) . '</span><div class="rippleJS"></div></button>';
}, 10, 1);

add_action( 'woocommerce_before_order_received', 'checkout_step' );
add_action( 'woocommerce_before_checkout_form_cart_notices', 'checkout_step', 5 );
add_action( 'woocommerce_before_cart', 'checkout_step', 5 );
add_action( 'woocommerce_cart_is_empty', 'checkout_step', 0 );

function checkout_step(){ ?>

  <div class="checkout-menu">
    <div class="container">
      <div class="columns d-flex">
        <a 
          href="<?php echo esc_url( wc_get_cart_url() ); ?>" 
          class="column is-4 checkout-step-item<?php if( is_cart() || is_checkout() || is_wc_endpoint_url( 'order-received' ) ) echo ' is-active'; ?>">
          <span class="checkout-step-number">1</span> <?php pll_e('My Cart'); ?>
        <a 
          href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
          class="column is-4 checkout-step-item<?php if( is_checkout() || is_wc_endpoint_url( 'order-received' ) ) echo ' is-active'; ?>">
          <span class="checkout-step-number">2</span> <?php pll_e('Checkout details'); ?>
        </a>
        <a href="#" class="column is-4 checkout-step-item no-click<?php if( is_wc_endpoint_url( 'order-received' ) ) echo ' is-active'; ?>">
          <span class="checkout-step-number">3</span> <?php pll_e('Order complete'); ?>
        </a>
      </div>
    </div>
  </div>
<?php }

add_action('woocommerce_checkout_billing', function(){
  echo '<h2>'. pll__('Customer Information') .'</h2>';
});


add_action('woocommerce_review_order_before_submit', function(){
  if (cart_has_room_deposit()) message_room_deposit();
});


// add_action('woocommerce_thankyou', function(){
//   echo 'https://shinyurealestate.com/wp-content/uploads/2021/07/48604.jpg';
// });

add_action('woocommerce_order_status_changed', function($order_id){
  global $product;
  $order = wc_get_order($order_id);
  
  if ($order->get_status() === 'processing') {
    $order->update_status('completed');
  }
});
