<?php
class Shinyu_Login_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Login_API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();

  }

  public function hooks() {

    add_action('rest_api_init', [$this , 'rest_api_init']);
    
  }
  
  public function rest_api_init() {
    register_rest_route('shinyu', '/user/me', [
      'methods'  => 'GET',
      'callback' => [$this , 'get'],
      'permission_callback' => 'is_user_logged_in',
    ]);

    register_rest_route('shinyu', '/user/me', [
      'methods'  => 'PUT',
      'callback' => [$this , 'edit'],
      'permission_callback' => 'is_user_logged_in',
    ]);
  }

  public function get($request) {
    return [
      'data' => get_usersdata(),
      'success' => true,
    ];
  } 

  public function edit($request) {

    $user_id = get_current_user_id();

    update_user_meta($user_id, 'billing_first_name', $request['data']['first_name']);
    update_user_meta($user_id, 'billing_last_name', $request['data']['last_name']);
    update_user_meta($user_id, 'billing_phone', $request['data']['phone']);

    return [
      'data' => get_usersdata(),
      'success' => true,
    ];
  } 
}

Shinyu_Login_API::get_instance();