<?php
class Shinyu_Contact_API {
  protected static $instance = null;

  public static function get_instance() {
    if ( !self::$instance ) {
      self::$instance = new Shinyu_Contact_API();
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
    register_rest_route('shinyu', '/contact', [
      'methods'  => 'POST',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);
  }

  public function api($request) {
    $lang         = $request['lang'];
    $name         = $request['name'];
    $phone        = $request['phone'];
    $email        = $request['email'];
    $message      = $request['message'];

    
    $post_id = wp_insert_post([
      'post_type'         => 'contact',
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

    $line_message = 'Name : ' . $name . PHP_EOL;
    $line_message .= 'Phone: ' . $phone . PHP_EOL;
    $line_message .= 'Email: ' . $email . PHP_EOL;
    $line_message .= 'Message: ' . $message . PHP_EOL;
 
    $email_message = email_message_item(pll_translate_string('Full name', $lang), $name);
    $email_message .= email_message_item(pll_translate_string('Phone', $lang), $phone);
    $email_message .= email_message_item(pll_translate_string('Email', $lang), $email);
    $email_message .= email_message_item(pll_translate_string('Message', $lang), $message);

    // line_notify(PHP_EOL . $line_message, '', '', $this->line_token);

    update_field('contact_name', $name, $post_id);
    update_field('contact_phone', $phone, $post_id);
    update_field('contact_email', $email, $post_id);
    update_field('contact_message', $message, $post_id);

    $email_class = WC()->mailer();
    $recipient = 'marketing@shinyurealestate.com';
    // $recipient = 'surakraisam@gmail.com';
    ob_start();
    do_action('woocommerce_email_header', 'Contact form #' . $post_id, $recipient);
    echo $email_message;
    do_action('woocommerce_email_footer', $recipient);
    $message = ob_get_contents();
    ob_end_clean();
    $email_class->send($recipient, 'Contact form #' . $post_id, $message, '', '');

    ob_start();
    do_action('woocommerce_email_header', 'Contact form #' . $post_id, $email);
    echo '<p>'. pll__('Hi') . ' ' . $name . '</p>';

    if ($lang === 'th')  {
      echo '<p>ขอบคุณที่ให้ความสนใจในบริการของเรา ทางทีมงานจะรีบติดต่อไปเพื่อให้ข้อมูลเพิ่มเติมกับท่านให้เร็วที่สุด ตามช่องทางการติดต่อที่ท่านได้ระบุไว้</p>';
    } else {
      echo '<p>Thank you for your interest in our service. Our team will contact you to provide more information as soon as possible. <br>  according to the contact that you have gave us.</p>';
    }

    echo $email_message;
    do_action('woocommerce_email_footer', $email);
    $message = ob_get_contents();
    ob_end_clean();
    $email_class->send($email, 'Contact form #' . $post_id, $message, '', '');

    return [
      'data'   => [],
      'status' => 200
    ];
  } 
}

Shinyu_Contact_API::get_instance();