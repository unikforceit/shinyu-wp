<?php
class Shinyu_Reset_Password_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Reset_Password_API();
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
    register_rest_route('shinyu', '/user/reset-password', [
      'methods'  => 'POST',
      'callback' => [$this , 'get'],
      'permission_callback' => function() { return true; },
    ]);
  }

  public function get($request) {

    if (empty($request['email']) || $request['email'] === '') {
      return new WP_Error('no_email' , pll__('You must provide an email address.') , array( 'status' => 400));
    }

    $user_id = email_exists($request['email']);

    if (!$user_id) {
      return new WP_Error('bad_email' , pll__('No user found with this email address.' , 'bdvs-password-reset') , array('status' => 500));
    }
    
    try {
      $user = new WP_User(intval($user_id)); 
      $reset_key = get_password_reset_key($user);
      $wc_emails = WC()->mailer()->get_emails();
      $wc_emails['WC_Email_Customer_Reset_Password']->trigger($user->user_login, $reset_key);
    }
    
    catch(Exception $e) {
      return new WP_Error('bad_request' , $e->getMessage() , array('status' => 500));
    }

    return array(
      'data' => $user_id,
      'success' => true,
      'message' => pll__('A password reset email has been sent to your email address.'),
    );
  }
}

Shinyu_Reset_Password_API::get_instance();