<?php 

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );

add_action('woocommerce_before_cart', function(){
  echo '<div class="columns is-variable is-0 is-multiline"><div class="column is-8-fullhd is-12">';
});

add_action('woocommerce_before_cart_collaterals', function(){
  echo '</div><div class="column is-4-fullhd is-12">';
});


add_action('woocommerce_after_cart', function(){
  echo '</div></div>'; 
});

add_action('woocommerce_cart_collaterals', function(){
  echo '<h3>'. pll__('Order Summary') .'</h3>';
  echo '<p>'. pll__('This price is already inclusive of vat.') .'</p>'; 
}, 5);


add_action('woocommerce_after_cart_table', function(){
  if (cart_has_room_deposit()) message_room_deposit();
});

