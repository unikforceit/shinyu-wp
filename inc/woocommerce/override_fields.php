<?php

add_filter( 'woocommerce_checkout_fields' , 'override_woocommerce_checkout_fields' );

function override_woocommerce_checkout_fields( $fields ) {
  // $fields['billing']['billing_first_name']['custom_attributes'] = [
  //   'data-pristine-required-message' => 'กรุณากรอกชื่อจริง',
  //   'required' => true
  // ];

  // $fields['billing']['billing_city']['class'] = ['form-row form-row-first address-field validate-required'];
  // $fields['billing']['billing_state']['class'] = ['form-row form-row-last address-field validate-required'];
  // $fields['billing']['billing_postcode']['class'] = ['form-row form-row-first address-field validate-required'];
  // $fields['billing']['billing_email']['class'] = ['form-row form-row-first address-field validate-email validate-required'];
  // $fields['billing']['billing_phone']['class'] = ['form-row form-row-last address-field validate-phone validate-required'];

  $fields['billing']['billing_road'] = [
    'label'             => pll__('Road'),
    // 'placeholder'       => pll__('Road'),
    'type'              => 'text',
    'required'          => false,
    'class'             => ['form-row form-row-first road-field validate-required'],
    'clear'             => true,
    'priority'          => 50
  ];

  $fields['billing']['billing_building'] = [
    'label'             => pll__('Building'),
    // 'placeholder'       => pll__('Building'),
    'type'              => 'text',
    'required'          => false,
    'class'             => ['form-row form-row-last road-building validate-required'],
    'clear'             => true,
    'priority'          => 50
  ];
  
  return $fields;
}


// add_filter('woocommerce_default_address_fields', function($fields) {
 
//    // default priorities: 
//    // 'first_name' - 10
//    // 'last_name' - 20
//    // 'company' - 30
//    // 'country' - 40
//    // 'address_1' - 50
//    // 'address_2' - 60
//    // 'city' - 70
//    // 'state' - 80
//    // 'postcode' - 90
  
//   // e.g. move 'company' above 'first_name':
//   // just assign priority less than 10

//   // $fields['country']['priority'] = 100;
//   // $fields['address_1']['priority'] = 120;
//   // $fields['postcode']['priority'] = 130;
//   // $fields['city']['priority'] = 140;
//   // $fields['state']['priority'] = 150;

//   // return $fields;
// });

// add_filter( 'default_checkout_billing_country', function() {
//   return 'TH';
// });

// add_filter( 'default_checkout_shipping_country', function() {
//   return 'TH';
// });

// add_filter( 'default_checkout_billing_state', function() {
//   return '';
// });

// add_filter( 'default_checkout_shipping_state', function() {
//   return '';
// });
