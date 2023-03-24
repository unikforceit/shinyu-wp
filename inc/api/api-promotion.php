<?php
class Shinyu_Promotion_API {
  protected static $instance = null;

  public static function get_instance() {
    if ( !self::$instance ) {
      self::$instance = new Shinyu_Promotion_API();
    }
    return self::$instance;
  }

  public function __construct() {
    $this->hooks();
    // $this->line_token = 'MIVZRTjvjHmB16IsGL9807Aoeh8tYckaUcaZn5vIZaQ';
  }

  public function hooks() {
    add_action('rest_api_init', [$this , 'rest_api_init']);
  }
  
  public function rest_api_init() {
    register_rest_route('shinyu', '/promotion', [
      'methods'  => 'POST',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);
  }

  public function api($request) {
    $lang           = $request['lang'];
    $promotion_name = $request['promotion_name'];
    $name           = $request['name'];
    $phone          = $request['phone'];
    $email          = $request['email'];

    
    $post_id = wp_insert_post([
      'post_type'         => 'promotion-register',
      'post_title'        => wp_strip_all_tags($name),
      'post_status'       => 'publish',
      'post_author'       => 1,
    ]);

    if (is_wp_error($post_id)){
      return new WP_REST_Response(
        [
          'code'    => 'rest_forbidden',
          'message' => $post_id->get_error_message(),
          'data'    => ['status' => 403],
          'success' => false
        ],
        403
      );
    }
  
    // pll_set_post_language
    // pll_current_language

    $line_message .= 'Promotion Name : ' . $promotion_name . PHP_EOL;
    $line_message .= 'Name : ' . $name . PHP_EOL;
    $line_message .= 'Phone: ' . $phone . PHP_EOL;
    $line_message .= 'Email: ' . $email . PHP_EOL;

    // line_notify(PHP_EOL . $line_message, '', '', $this->line_token);

    update_field('promotion_promotion_name', $promotion_name, $post_id);   
    update_field('promotion_name', $name, $post_id); 
    update_field('promotion_phone', $phone, $post_id);
    update_field('promotion_email', $email, $post_id);
    update_field('promotion_message', $message, $post_id);

    $email_class = WC()->mailer();
    $recipient = 'marketing@shinyurealestate.com';
    // $recipient = 'surakraisam@gmail.com';
    ob_start(); ?>
    <?php do_action('woocommerce_email_header', 'Register for privileges #' . $post_id, $recipient);

      echo email_message_item('Promotion Name', $promotion_name);
      echo email_message_item('Name', $name);
      echo email_message_item('Phone', $phone);
      echo email_message_item('Email', $email);

    do_action('woocommerce_email_footer', $recipient); ?>
    <?php $message = ob_get_contents();
    ob_end_clean();
    $email_class->send($recipient, 'Register for privileges #' . $post_id, $message, '', '');

    return [
      'data'   => $line_message,
      'status' => 200
    ];
  } 
}

Shinyu_Promotion_API::get_instance();