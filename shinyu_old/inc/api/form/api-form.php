<?php
class Mimo_Form_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Form_API();
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

    register_rest_route( 'sy', '/form/upload-image', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'upload_image' ),
      'args'     => array( 'image'),
    ) );

    register_rest_route( 'sy', '/form/join-agent/field', array(
      'methods'  => 'get',
      'callback' => array( $this, 'join_agent_field' ),
      'args'     => array( 'lang'),
    ) );

    register_rest_route( 'sy', '/form/send-enquiry/field', array(
      'methods'  => 'get',
      'callback' => array( $this, 'send_enquiry_field' ),
      'args'     => array( 'lang'),
    ) );

    register_rest_route( 'sy', '/form/send-enquiry', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'send_enquiry' ),
      'args'     => array( 
        'firstname',
        'lastname',
        'email',
        'phone',
        'property_for',
        'property_type',
        'bts',
        'mrt',
        'min_price',
        'max_price',
        'description',
        'recive',
        'agree',
      ),
    ) );   
 
    register_rest_route( 'sy', '/form/join-agent', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'join_agent' ),
      'args'     => array( 
        'firstname',
        'lastname',
        'email',
        'phone',
        'company',
        'position',
        'website',
        'market_area',
        'market_area_other',
        'company_profile',
        'what',
        'tell_us',
        'recive',
        'agree',
      ),
    ) );

  }

  public function join_agent_field($data){

    $position = array(
      ''        => 'Select your position',
      'sdfsdewf' => 'dasdasd',
      'sdfsdfef' => 'dasdasd',
      'sdfsdfsh' => 'dasdasd',
      'dasdassd' => 'dasdasd'
    );

    $market_area = array(
      'Thai market'    => 'Thai market',
      'Japan market'   => 'Japan market',
      'Chinese market' => 'Chinese market',
      'Other'          => 'Other',
    );

    $what = array(
      'thai_market'  => 'We would like to be your global real estate partner',
    );    

    return array(
      'position'    => render_fields($position),
      'market_area' => render_fields($market_area),
      'what'        => render_fields($what),
    );

  }

  public function join_agent($data){

    $sad = '';

    $email_subject = "ต้องการให้ทีมงานติดต่อกลับ";

    $firstname               = sanitize_text_field( $data['firstname'] );
    $lastname                = sanitize_text_field( $data['lastname'] );
    $email                   = sanitize_email( $data['email'] );
    $phone                   = sanitize_text_field( $data['phone'] );
    $company                 = sanitize_text_field( $data['company'] );


    $response = $error_message = array();
    $errors = false;
    $line_message = '';

    if ( empty( $firstname ) ) { 
      $error_message['firstname'] = __('Firstname is required.', THEME_SLUG);
      $errors = true;
    }

    if ( empty( $data['phone'] ) ) {
      $error_message['phone'] = __('Phone number is required.', THEME_SLUG);
      $errors = true;
    }

    if ( ! is_email( $email )) {
      $error_message['email'] = __('Email is required.', THEME_SLUG);
      $errors = true;
    }

    if ( empty( $company ) ) { 
      $error_message['company'] = __('Company is required.', THEME_SLUG);
      $errors = true;
    }

    if ( $errors === false ) {

      $post_id = wp_insert_post( array(
        'post_type'         => 'register_agent',
        'post_title'        => $firstname . ' ' . $lastname,
        'post_status'       => 'publish',
        'post_author'       => '1',
      ) );

      update_post_meta( $post_id, 'your_need_phone', $phone );
      update_post_meta( $post_id, 'your_need_email', $email );
      update_post_meta( $post_id, 'your_need_subject', $subject );
      update_post_meta( $post_id, 'your_need_message', $message );
      update_post_meta( $post_id, 'your_need_recive', $recive );
      update_post_meta( $post_id, 'your_need_agree', $agree );

      $email_class = new Mimo_Email();

      $email_subject = 'ต้องการติดต่อ #'. $post_id;

      // $recipients = explode( PHP_EOL, get_field('contact_recipient', 'option') );
      $recipients = array('info@shinyurealestate.com');

      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: '. get_bloginfo( 'name' ) .' <contact@shinyurealestate.com>' . "\r\n";
      $headers[] = 'Reply-To:' . $email;

      $emai_message = $email_class->header( $email_subject );
      $emai_message .= $line_message =  '
<strong>ชื่อ : </strong>' . $name . '<br/>
<strong>เบอร์โทร : </strong>' . $phone . '<br/>
<strong>อีเมล : </strong>' . $email . '<br/>
อีเมล์นี้ถูกส่งจาก ' . site_url();
      $emai_message .= $email_class->footer();

      line_notify( PHP_EOL . wp_strip_all_tags( $line_message ), get_field( 'contact_line_token', 'option' ) );
      
      wp_mail( array_filter( $recipients ), $email_subject, $emai_message, $headers );

      $msg = 'ส่งข้อมูลเรียบร้อย';
      $msg_desc = 'ขอบคุณที่สนใจ... เจ้าหน้าที่จะติดต่อกลับไปค่ะ';

    }else{
      $msg = 'ผิดพลาด';
    }

    $response = array(
      'error'           => $errors,
      'error_message'   => $error_message,      
      'msg'             => $msg,
      'msg_desc'        => $msg_desc,
    );

    return $response;

  }

  public function send_enquiry($data){

    $msg_desc = '';

    $email_subject = "ต้องการให้ทีมงานติดต่อกลับ";

    $firstname               = sanitize_text_field( $data['firstname'] );
    $lastname                = sanitize_text_field( $data['lastname'] );
    $email                   = sanitize_email( $data['email'] );
    $phone                   = sanitize_text_field( $data['phone'] );
    $want                    = sanitize_text_field( $data['want'] );
    $sell_property_for       = sanitize_text_field( $data['sell_property_for'] );
    $sell_property_type      = sanitize_text_field( $data['sell_property_type'] );
    $sell_selling_price      = sanitize_text_field( $data['sell_size'] );
    $sell_additional_details = sanitize_text_field( $data['sell_rental_price'] );
    $sell_images             = sanitize_text_field( $data['sell_images'] );
    $buy_min_floor_area      = sanitize_text_field( $data['buy_location'] );
    $buy_max_floor_area      = sanitize_text_field( $data['buy_max_floor_area'] );
    $buy_approx_people       = sanitize_text_field( $data['buy_approx_people'] );
    $buy_other_requirements  = sanitize_text_field( $data['buy_other_requirements'] );
    $recive                  = sanitize_text_field( $data['recive'] );
    $agree                   = sanitize_text_field( $data['agree'] );


    $response = $error_message = array();
    $errors = false;
    $line_message = '';

    if ( empty( $firstname ) ) { 
      $error_message['firstname'] = __('Firstname is required.', THEME_SLUG);
      $errors = true;
    }

    // if ( empty( $lastname ) ) { 
    //   $error_message['lastname'] = __('Lastname is required.', THEME_SLUG);
    //   $errors = true;
    // }

    if ( empty( $data['phone'] ) ) {
      $error_message['phone'] = __('Phone number is required.', THEME_SLUG);
      $errors = true;
    }

    if ( ! is_email( $email )) {
      $error_message['email'] = __('Email is required.', THEME_SLUG);
      $errors = true;
    }

    if ( $errors === false ) {

      $post_id = wp_insert_post( array(
        'post_type'         => 'request',
        'post_title'        => $firstname . ' ' . $lastname,
        'post_status'       => 'publish',
        'post_author'       => '1',
      ) );

      update_post_meta( $post_id, 'your_need_phone', $phone );
      update_post_meta( $post_id, 'your_need_email', $email );
      // update_post_meta( $post_id, 'your_need_subject', $subject );
      // update_post_meta( $post_id, 'your_need_message', $message );
      update_post_meta( $post_id, 'your_need_recive', $recive );
      update_post_meta( $post_id, 'your_need_agree', $agree );

      $email_class = new Mimo_Email();

      $email_subject = 'ต้องการติดต่อ #'. $post_id;

      // $recipients = explode( PHP_EOL, get_field('contact_recipient', 'option') );

      $recipients = array('info@shinyurealestate.com');

      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: '. get_bloginfo( 'name' ) .' <contact@shinyurealestate.com>' . "\r\n";
      $headers[] = 'Reply-To:' . $email;

      $emai_message = $email_class->header( $email_subject );
      $emai_message .= $line_message =  '
<strong>ชื่อ : </strong>' . $firstname . '<br/>
<strong>เบอร์โทร : </strong>' . $phone . '<br/>
<strong>อีเมล : </strong>' . $email . '<br/>
อีเมล์นี้ถูกส่งจาก ' . site_url();
      $emai_message .= $email_class->footer();

      line_notify( PHP_EOL . wp_strip_all_tags( $line_message ), get_field( 'contact_line_token', 'option' ) );
      
      wp_mail( array_filter( $recipients ), $email_subject, $emai_message, $headers );

      $msg = 'ส่งข้อมูลเรียบร้อย';
      $msg_desc = 'ขอบคุณที่สนใจ... เจ้าหน้าที่จะติดต่อกลับไปค่ะ';

    }else{
      $msg = 'ผิดพลาด';
    }

    $response = array(
      'error'           => $errors,
      'error_message'   => $error_message,      
      'msg'             => $msg,
      'msg_desc'        => $msg_desc,
    );

    return $response;

  }
  
  public function send_enquiry_field($data){

    $lang = $data['lang'];

    $terms = get_terms( 'project_type', array(
      'hide_empty' => false,
    ) );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      foreach ( $terms as $term ) {
        $project_type[$term->slug] = $term->name;
      }
    }

    return array(
      'property_for'   => render_fields(field_transaction('', $lang)),
      'property_type'  => render_fields($project_type),
      'bts'            => render_fields(field_bts()),
      'mrt'            => render_fields(field_mrt()),
    );

  }

  public function upload_image($data){

    if (!function_exists('wp_generate_attachment_metadata')) {
      require_once(ABSPATH . "wp-admin" . '/includes/image.php');
      require_once(ABSPATH . "wp-admin" . '/includes/file.php');
      require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    }

    $attachment_id = media_handle_upload( 'image', 0 );

    if (is_wp_error($attachment_id)) {

      return new WP_REST_Response(
        [
          'code'    => 'rest_forbidden',
          'message' => $attachment_id->get_error_message(),
          'data'    => ['status' => 403],
          'success' => false
        ],
        403
      );

    } else {
      $url      = wp_get_attachment_url($attachment_id);
      $filetype = wp_check_filetype($url);
      return [
        'id'   => $attachment_id,
        'url'  => $url,
        'name' => html_entity_decode(get_the_title($attachment_id) . '.' . $filetype['ext']),
      ];

    }

  }
  
}

Mimo_Form_API::get_instance();