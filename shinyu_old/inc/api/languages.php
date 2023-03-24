<?php
function get_all_languages() {

  $languages = '';

  if(!empty($languages)){
    foreach($languages as $l){
      $value[] = array(
        'code'        => $l['language_code'],
        'title'       => $l['native_name'],
        'flag_url'    => IMG_URI . '/' . $l['language_code'] . '.svg'
      );
    }
  }

  $value[] = array(
    'code'        => 'th',
    'title'       => 'ไทย',
    'flag_url'    => IMG_URI . '/' . 'th' . '.svg'
  );

  $value[] = array(
    'code'        => 'en',
    'title'       => 'English',
    'flag_url'    => IMG_URI . '/' . 'en' . '.svg'
  );

  return $value;

}

add_action('rest_api_init', function() {
  register_rest_route( 'sy', '/languages', array(
    'methods' => 'GET',
    'callback' => 'get_all_languages',
  ));
});


function get_all_currencies() {

  return array(
    array(
      'currency' => get_field('_currency_thb_title', 'option'),
      'unit'     => get_field('_currency_thb_unit', 'option'),
      'rate'     => get_field('_currency_thb_rate', 'option'),
      'code'     => get_field('_currency_thb_code', 'option')
    ),
    array(
      'currency' => get_field('_currency_usd_title', 'option'),
      'unit'     => get_field('_currency_usd_unit', 'option'),
      'rate'     => get_field('_currency_usd_rate', 'option'),
      'code'     => get_field('_currency_usd_code', 'option')
    ),
    array(
      'currency' => get_field('_currency_jpy_title', 'option'),
      'unit'     => get_field('_currency_jpy_unit', 'option'),
      'rate'     => get_field('_currency_jpy_rate', 'option'),
      'code'     => get_field('_currency_jpy_code', 'option')
    ),
    array(
      'currency' => get_field('_currency_cny_title', 'option'),
      'unit'     => get_field('_currency_cny_unit', 'option'),
      'rate'     => get_field('_currency_cny_rate', 'option'),
      'code'     => get_field('_currency_cny_code', 'option')
    )
  );

}

add_action('rest_api_init', function() {
  register_rest_route( 'sy', '/currencies', array(
    'methods' => 'GET',
    'callback' => 'get_all_currencies',
  ));
});

