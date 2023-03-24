<?php
class Shinyu_Service_Interior_API {
  protected static $instance = null;

  public static function get_instance() {
    if ( !self::$instance ) {
      self::$instance = new Shinyu_Service_Interior_API();
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
    register_rest_route('shinyu', '/service_interior', [
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
    $address      = $request['address'];
    $project_name = $request['project_name']; 
    $room_no      = $request['room_no']; 
    $floor        = $request['floor']; 
    $room_size    = $request['room_size']; 

    
    $post_id = wp_insert_post([
      'post_type'         => 'service-interior',
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

    $line_message  = 'Name : ' . $name . PHP_EOL;
    $line_message .= 'Phone: ' . $phone . PHP_EOL;
    $line_message .= 'Email: ' . $email . PHP_EOL;
    $line_message .= 'Address: ' . $address . PHP_EOL;
    $line_message .= 'Project name: ' . $project_name . PHP_EOL;
    $line_message .= 'Room No.: ' . $room_no . PHP_EOL;
    $line_message .= 'Floor: ' . $floor . PHP_EOL;
    $line_message .= 'Room size: ' . $room_size . PHP_EOL;

    $email_message  = email_message_item('Name', $name);
    $email_message .= email_message_item('Phone', $phone);
    $email_message .= email_message_item('Email', $email);
    $email_message .= email_message_item('Address', $address);
    $email_message .= '<h3>Project information for interior services</h3>';
    $email_message .= email_message_item('Project name', $project_name);    
    $email_message .= email_message_item('Room No.', $room_no);  
    $email_message .= email_message_item('Floor', $floor);  
    $email_message .= email_message_item('Room size', $room_size);    

    // line_notify(PHP_EOL . $line_message, '', '', $this->line_token);

    update_field('service_name', $name, $post_id);
    update_field('service_phone', $phone, $post_id);
    update_field('service_email', $email, $post_id);
    update_field('service_address', $address, $post_id);
    update_field('service_project_name', $project_name, $post_id);
    update_field('service_room_no', $room_no, $post_id);
    update_field('service_floor', $floor, $post_id);
    update_field('service_room_size', $room_size, $post_id);

    $email_class = WC()->mailer();
    $recipient = 'marketing@shinyurealestate.com';
    // $recipient = 'surakraisam@gmail.com';
    ob_start();
    do_action('woocommerce_email_header', 'Interior Services #' . $post_id, $recipient);

    echo $email_message;
    do_action('woocommerce_email_footer', $recipient);
    $message = ob_get_contents();
    ob_end_clean();
    $email_class->send($recipient, 'Interior Services #' . $post_id, $message, '', '');


    ob_start();
    do_action('woocommerce_email_header', 'Interior Services #' . $post_id, $email);
    echo '<p>'. pll_translate_string('Hi', $lang) . ' ' . $name . '</p>';
    if ($lang === 'th')  {
      echo '<p>ขอบคุณสำหรับความไว้วางใจเลือกใช้บริการของเรา <br>. 
      เราได้รับชำระเงินค่าบริการจากท่านเรียบร้อยแล้ว<br>. 
      ทางทีมงานจะรีบประสานงานและดูแลให้ท่านได้รับบริการที่ดีที่สุดค่ะ</p>';
    } else {
      echo "<p>Thank you for your order. We would like to confirm you that we already recieved your payment. Here's a reminder of what you ordered.</p>";
    }
    echo $email_message;
    do_action('woocommerce_email_footer', $email);
    $message = ob_get_contents();
    ob_end_clean();
    $email_class->send($email, 'Interior Services #' . $post_id, $message, '', '');

    return [
      'data'   => $line_message,
      'status' => 200
    ];
  } 
}

Shinyu_Service_Interior_API::get_instance();