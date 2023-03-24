<?php

class Shinyu_Product_Custom {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Product_Custom();
    }
    return self::$instance;

  }

	public function __construct() {

    $this->hooks();

	}

	public function hooks() {

    // add_filter('woocommerce_add_cart_item_data', [$this, 'woocommerce_add_cart_item_data'], 10, 3);
    add_filter('woocommerce_get_item_data', [$this, 'woocommerce_get_item_data'], 10, 2);
    add_action('woocommerce_checkout_create_order_line_item', [$this, 'woocommerce_checkout_create_order_line_item'], 10, 4);
    add_filter('woocommerce_order_item_name', [$this, 'woocommerce_order_item_name'], 10, 2);
    add_filter('woocommerce_cart_item_thumbnail', [$this, 'woocommerce_cart_item_thumbnail'], 10, 3);
    add_filter('woocommerce_cart_item_permalink', [$this, 'woocommerce_cart_item_permalink'], 10, 3);
    add_action('woocommerce_before_calculate_totals', [$this, 'woocommerce_before_calculate_totals']);
    add_action('woocommerce_available_payment_gateways', [$this, 'woocommerce_available_payment_gateways']); 
    add_action('woocommerce_cart_calculate_fees', [$this, 'woocommerce_cart_calculate_fees']);
  }

  public function woocommerce_add_cart_item_data($cart_item_data, $product_id, $variation_id) {

    if (isset( $_POST['product_price'])) {
      $cart_item_data['product_price'] = sanitize_text_field( $_POST['product_price'] );
    }

    return $cart_item_data;
  }


  public function woocommerce_get_item_data($item_data, $cart_item_data) {
    if (isset( $cart_item_data['project_name'])) {
      $project_name = $cart_item_data['project_name'];
      $item_data[] = [
        'key' => pll__( 'Project name' ),
        'value' => $project_name,
      ];	
    }

    if (isset($cart_item_data['unit_no'])){
      $unit_no = $cart_item_data['unit_no'];
      $item_data[] = [
        'key' => pll__( 'Room No.' ),
        'value' => $unit_no,
      ];	
    }

    if (isset($cart_item_data['floor'])) {
      $floor = $cart_item_data['floor'];
      $item_data[] = [
        'key' => pll__('Floor'),
        'value' => $floor,
      ];	
    }
  
    if (isset($cart_item_data['unit_type'])) {
      $unit_type = $cart_item_data['unit_type'];
      $item_data[] = [
        'key' => pll__('Room Type'),
        'value' => $unit_type,
      ];	
    }
   
    if (isset($cart_item_data['consultant'])) {
      $consultant = $cart_item_data['consultant'];
      $item_data[] = [
        'key' => pll__('Property Consultant'),
        'value' => $consultant,
      ];	
    }


    if (isset($cart_item_data['unit_id'])) {
      $unit_id = $cart_item_data['unit_id'];
      $unit_value = get_the_title($unit_id);
      $unit_no = get_field('room_unit_no', $unit_id);
      if ($unit_no) $unit_value = $unit_value . ' - ' . $unit_no;
      $item_data[] = [
        'key' => pll__('Unit'),
        'value' => $unit_value,
      ];
    }
    
    if (isset($cart_item_data['transaction'])) {
      $transaction = $cart_item_data['transaction'];
      $item_data[] = [
        'key' => pll__('Transaction'),
        'value' => $transaction,
      ];
    }

    return $item_data;
  }

  public function woocommerce_checkout_create_order_line_item($item, $cart_item_key, $values, $order) {
    if (isset($values['project_name'])) {
      $item->add_meta_data(
        pll__('Project name'),
        $values['project_name'],
        true
      );
    }

    if (isset($values['unit_no'])) {
      $item->add_meta_data(
        pll__('Room No.'),
        $values['unit_no'],
        true
      );
    }

    if (isset($values['floor'])) {
      $item->add_meta_data(
        pll__('Floor'),
        $values['floor'],
        true
      );
    }

    if (isset($values['unit_type'])) {
      $item->add_meta_data(
        pll__('Room Type'),
        $values['unit_type'],
        true
      );
    }

    if (isset($values['unit_id'])) {

      $unit_id = $values['unit_id'];
      $unit_value = get_the_title($unit_id);
      $unit_no = get_field('room_unit_no', $unit_id);
      if ($unit_no) $unit_value = $unit_value . ' - ' . $unit_no;

      $item->add_meta_data(
        pll__('Unit'),
        '<a href="'. get_permalink($unit_id) .'">'. $unit_value .'</a>',
        true
      );

      $item->add_meta_data(
        'unit_id',
        $unit_id,
        true
      );
    }

    if (isset($values['consultant'])) {
      $item->add_meta_data(
        pll__('Property Consultant'),
        $values['consultant'],
        true
      );
    }

    // if (isset( $values['unit_id'])) {
    //   $item->add_meta_data(
    //     __( 'Unit', THEME_SLUG ),
    //     get_the_title($values['unit_id']),
    //     true
    //   );
    // }

    if (isset($values['transaction'])) {
      $item->add_meta_data(
        pll__('Transaction'),
        $values['transaction'],
        true
      );
    }
  }

  function woocommerce_cart_calculate_fees($cart) {

    if (!WC()->session->__isset('reload_checkout')) {
      foreach ($cart->get_cart() as $key => $value ) {
        $attributes = $value['data']->get_attributes();
        if (isset($attributes['pa_months']) && $value['unit_type']) {
          $deposit = [
            '3-months' => [
              1 => 4500,
              2 => 10000
            ],
  
            '6-months' => [
              1 => 7500,
              2 => 14000
            ],
  
            '1-year' => [
              1 => 15000,
              2 => 28000
            ],
          ];
          $additionalPrice = $deposit[$attributes['pa_months']][$value['unit_type']];
          // $orgPrice = floatval($value['data']->get_price());
          // $discPrice = $orgPrice + $additionalPrice;
          // $value['data']->set_price($discPrice);
          if ($additionalPrice) WC()->cart->add_fee(pll__('Deposit'), $additionalPrice, true, 'standard');
        }
      }
    }
  }

  public function woocommerce_before_calculate_totals($cart) {

    $cart_items = $cart->get_cart();

    if (!WC()->session->__isset('reload_checkout')) {

      // foreach ($cart_items as $key => $value ) {
      //   $cart->set_quantity($key, 1);
      // }
    
      if (count($cart_items) > 1 ){
        $cart_item_keys = array_keys($cart_items);
        $cart->remove_cart_item(reset($cart_item_keys));
      }

      foreach ($cart_items as $key => $value ) {
        if (isset($value['unit_id']) && $value['unit_id'] && isset($value['transaction']) && $value['transaction']) {
          $price = 0;
          $unit_id          = $value['unit_id'];
          $transaction      = $value['transaction'];
          if ($transaction === 'buy') {
            $price = get_post_meta($unit_id, 'room_deposit_price', true);
          } else {
            $price = get_post_meta($unit_id, 'room_rent_price', true);
          }
          if ($price) $value['data']->set_price($price);
        }
      }
    }
  }

  // public function woocommerce_before_calculate_totals($cart) {

  //   if (!WC()->session->__isset('reload_checkout')) {
  //     foreach ($cart->get_cart() as $key => $value ) {
  //       $attributes = $value['data']->get_attributes();
  //       if (isset($attributes['pa_months']) && $value['unit_type']) {
  //         $deposit = [
  //           '3-months' => [
  //             1 => 4500,
  //             2 => 10000
  //           ],
  
  //           '6-months' => [
  //             1 => 7500,
  //             2 => 14000
  //           ],
  
  //           '1-year' => [
  //             1 => 15000,
  //             2 => 28000
  //           ],
  //         ];
  //         $additionalPrice = $deposit[$attributes['pa_months']][$value['unit_type']];
  //         $orgPrice = floatval($value['data']->get_price());
  //         $discPrice = $orgPrice + $additionalPrice;
  //         $value['data']->set_price($discPrice);
  //       }
  //     }
  //   }
  // }
  
  public function woocommerce_available_payment_gateways($available_gateways) {
    if (is_admin()) return $available_gateways;
    if (!is_checkout()) return $available_gateways;

    $subscribtion = false;
    $courses = false;

    foreach (WC()->cart->get_cart_contents() as $key => $values) {
      if (isset($values['variation']['attribute_pa_subscription']) && $values['variation']['attribute_pa_subscription'] == 'subscription') $subscribtion = true;

      $product_id = $values['product_id'];
      $cat = wp_get_post_terms($product_id, 'product_cat');
      if ($cat[0]->slug === 'courses') $courses = true;
    }

    if ($subscribtion == true) {
      unset($available_gateways['bbl_credit_card']);
      unset($available_gateways['bacs']);
    } else {
      unset($available_gateways['bbl_credit_card_recurring']);
    }

    if ($courses === false) unset($available_gateways['bbl_credit_card_installment']);

    return $available_gateways;
  }

  public function woocommerce_order_item_name($product_name, $item) {
    if( isset($item['unit_id']) ) {
      $product_name = ' <a href="'. get_permalink($item['unit_id']) .'">'. $product_name .'</a>';
    }
    
    return $product_name;
  }

  public function woocommerce_cart_item_thumbnail($product_get_image, $cart_item, $cart_item_key) {
    if (isset($cart_item['unit_id']) && $unit_id = $cart_item['unit_id'] ) $product_get_image = get_the_post_thumbnail($unit_id, 'woocommerce_thumbnail');
    return $product_get_image; 
  }
  
  public function woocommerce_cart_item_permalink($product_permalink_cart_item, $cart_item, $cart_item_key) {
    if (isset($cart_item['unit_id']) && $unit_id = $cart_item['unit_id']) $product_permalink_cart_item = get_permalink($unit_id);

    return $product_permalink_cart_item; 
  }
}

Shinyu_Product_Custom::get_instance();