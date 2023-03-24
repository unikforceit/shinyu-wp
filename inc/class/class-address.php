<?php

class TOT_Address{

  protected static $instance = null;


  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new TOT_Address();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {
    // add_action('rest_api_init', [$this, 'api_routes']);
    add_action('wp_ajax_fetch_address', [$this, 'address']);
    add_action('wp_ajax_nopriv_fetch_address', [$this, 'address']);
	}


  public function api_routes() {
    register_rest_route('v1', '/provinceList', [
      'methods'             => 'GET',
      'args'                => ['lat', 'lng'],
      'callback'            => [$this, 'check_address']
    ]);
  }

  public function address() {

    $provinces = file_get_contents(STATIC_URI . '/data/address/provinces.json', true); 
    $provinces = json_decode($provinces);

    $districts = file_get_contents(STATIC_URI . '/data/address/districts.json', true); 
    $districts = json_decode($districts);

    $subdistricts = file_get_contents(STATIC_URI . '/data/address/subdistricts.json', true); 
    $subdistricts = json_decode($subdistricts);

    $data = [
      'provinces' => $provinces,
      'districts' => $districts,
      'subdistricts' => $subdistricts,
    ];

    wp_send_json($data);

  }
}

TOT_Address::get_instance();