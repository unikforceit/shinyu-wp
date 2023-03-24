<?php
// use \Firebase\JWT\JWT;

class API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();

  }

  public function hooks() {
  }

  public function error_403($message) {
    return new WP_REST_Response(
      [
        'code'    => 'rest_forbidden',
        'message' => $message,
        'data'    => ['status' => 403],
        'success' => false
      ],
      403
    );
  }
  
  // public function get_user_by_token($token) {

  //   if (!empty($token)) {
  //     if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
  //       $decoded_token = JWT::decode($matches[1], JWT_AUTH_SECRET_KEY, ['HS256']);
  //       return $decoded_token->data->user->id; 
  //     }
  //   }
  
  //   return null;
  
  // }
}

API::get_instance();