<?php
class Mimo_Subscribe_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Subscribe_API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();

  }

  public function hooks() {

    add_action( 'rest_api_init', array( $this , 'rest_api_init' ) );
    
  }
  
  public function rest_api_init() {

    register_rest_route( 'sy', '/subscribe', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'rest_api' ),
      'args'     => array( 'email', 'lang'),
      // 'permission_callback' => function() {
      //   return current_user_can( 'edit_others_posts' );
      // }
    ) );

  }

  public function rest_api($data){

    $sad = '';

    $email      = sanitize_email( $data['email'] );
    
    $response = $error_message = array();
    $success = true;

    if ( !is_email( $email ) ) {
      $success = false;
      $msg = __('Email is required.', THEME_SLUG);
    }else{

      if ( $emails = get_option('sy_subscribe') ) {
    
        if (in_array($email, $emails)) {
          $success = false;
          $msg = __('อีเมลนี้รับสมัครข่าวสารแล้ว', THEME_SLUG);
        } else {
          array_push($emails, $email);
          update_option('sy_subscribe', $emails );
        }
    
      } else {
        add_option('sy_subscribe', array($email));
      }
    }

    $response = array(
      'success' => $success,
      'msg'     => $msg,
    );

    return $response;

  }

}

Mimo_Subscribe_API::get_instance();