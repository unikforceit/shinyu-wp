<?php

class TOT_Coverage{

  protected static $instance = null;


  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new TOT_Coverage();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {
    add_action('rest_api_init', [$this, 'api_routes']);
    // add_action('wp_ajax_save_location', [$this, 'save_location']);
    // add_action('wp_ajax_nopriv_save_location', [$this, 'save_location']);
	}


  public function api_routes() {
    register_rest_route('v1', '/coverage', [
      'methods'             => 'GET',
      'args'                => ['lat', 'lng'],
      'callback'            => [$this, 'check_coverage']
    ]);
  }

  public function save_location() {

    $location = [
      'address'  => $_POST['address'],
      'position' => [
        'lat' => floatval($_POST['lat']),
        'lng' => floatval($_POST['lng'])
      ]
    ];

    WC()->session->set('location', $location);

    wp_die();

  }

  public function check_coverage($request) {

    $lat = $request['lat'];
    $lng = $request['lng'];

    $resp = wp_remote_post('https://api.totwbs.com/o/areas/g_coveragem?lat='. $lat .'&lon='. $lng, [
      'headers' => [
        'Authorization' => 'Basic Rzg2aEt1TGNPSnJkVjV0dTpXeGxRSFIqQ1I5T3d0NlR0Vg==',
        'x-api-key'     => 'ded457ec635916852J9DQEXbrCR9Owt6TtV'
      ],
    ]);

    $resp = json_decode($resp['body']);

    return [
      'success' => true,
      'available' => is_array($resp->package_result),
      'distance' => isset($resp->response->distance) ? number_format((float)$resp->response->distance, 2, '.', '') : null
    ];
  }
}

TOT_Coverage::get_instance();