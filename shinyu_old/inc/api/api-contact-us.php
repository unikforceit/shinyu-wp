<?php
class Mimo_Contact_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Contact_API();
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

    register_rest_route( 'sy', '/pages/contact', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'rest_api' ),
      'args'     => array( 'firstname', 'lastname', 'email', 'phone', 'subject', 'message', 'lang'),
      // 'permission_callback' => function() {
      //   return current_user_can( 'edit_others_posts' );
      // }
    ) );

    register_rest_route( 'sy', '/pages/contact/', array(
      'methods' => 'GET',
      'callback' => array( $this , 'callback_api' ),
      'args'     => array( 'lang')
    ) );

  }

  public function rest_api($data){

    $sad = '';

    $email_subject = "ต้องการให้ทีมงานติดต่อกลับ";

    $firstname  = sanitize_text_field( $data['firstname'] );
    $lastname   = sanitize_text_field( $data['lastname'] );
    $phone      = sanitize_text_field( $data['phone'] );
    $email      = sanitize_email( $data['email'] );
    $subject    = sanitize_text_field( $data['subject'] );
    $message    = esc_textarea( $data['message'] );
    $recive     = sanitize_text_field( $data['recive'] );
    $agree      = sanitize_text_field( $data['agree'] );
    
    
    $response = $error_message = array();
    $errors = false;
    $line_message = '';

    if ( empty( $firstname ) ) { 
      $error_message['firstname'] = __('Firstname is required.', THEME_SLUG);
      $errors = true;
    }

    if ( empty( $lastname ) ) { 
      $error_message['lastname'] = __('Lastname is required.', THEME_SLUG);
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

    if ( $errors === false ) {

      $post_id = wp_insert_post( array(
        'post_type'         => 'contact',
        'post_title'        => $firstname . ' ' . $lastname,
        'post_status'       => 'publish',
        'post_author'       => '1',
      ) );

      update_post_meta( $post_id, 'contact_phone', $phone );
      update_post_meta( $post_id, 'contact_email', $email );
      update_post_meta( $post_id, 'contact_subject', $subject );
      update_post_meta( $post_id, 'contact_message', $message );
      update_post_meta( $post_id, 'contact_recive', $recive );
      update_post_meta( $post_id, 'contact_agree', $agree );

      $email_class = new Mimo_Email();

      $email_subject = 'ต้องการติดต่อ #'. $post_id;

      $recipients = explode( PHP_EOL, get_field('contact_recipient', 'option') );

      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: '. get_bloginfo( 'name' ) .' <surakrai@mimoproject.co.th>' . "\r\n";
      $headers[] = 'Reply-To:' . $email;

      $emai_message = $email_class->header( $email_subject );
      $emai_message .= $line_message =  '
<strong>ชื่อ : </strong>' . $name . '<br/>
<strong>เบอร์โทร : </strong>' . $phone . '<br/>
<strong>อีเมล : </strong>' . $email . '<br/>
<strong>เรื่อง : </strong>' . $subject . '<br/>
<strong>รายละเอียด : </strong>' . $message . '<br/><br/>
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

  public function callback_api($data) {

    $lang = $data['lang'];
    global $post;

    $post = get_page_by_path( 'contact-us', OBJECT, 'page' );
    
    $page_id = pll_get_post($post->ID, $lang);
    $post = get_post( $page_id );

    $head  = $breadcrumb = array();

    $head = array(
      'title'   => $post->post_title . ' - ' . get_bloginfo('name'),
      'meta'    => array(
        'hid' => '',
        'name' => '',
        'content' => ''
      )
    );

    $breadcrumb = array(
      array(
        'title' => pll_translate_string('Home', $lang),
        'name'  => ''
      ),
      array(
        'title' => $post->post_title,
        'name'  => ''
      )
    );

    $location = get_field( 'contact_detail_google_map', $post->ID );
      
    $google_map = array(
      'lat'     =>  13.722553,
      'lng'     =>  100.580582 
    );

    return array(
      'head'            => $head,
      'breadcrumb'      => $breadcrumb,
      'title'           => $post->post_title,
      'page_title'     => "LET'S TALK",
      'page_sub_title' => '& KEEP IN TOUCH',
      'content'         => array(
        'address'     => apply_filters( 'the_content', $post->post_content ),
        'google_map'  => $google_map,
        'form'        => array(
          'keeping_in_touch' => array(
            'title'       => __('Keeping in touch', THEME_SLUG),
            'description' => __('we went to make sure you’re kept up to date with the latest news from Urban splash and our partners. For maore information, including how we use your personal detail, please see our Privacy Policy.', THEME_SLUG)
          ),
          'label' => array(
            'firstname' => __('Firstname', THEME_SLUG),
            'lastname'  => __('Lastname', THEME_SLUG),
            'email'     => __('Email', THEME_SLUG),
            'phone'     => __('Phone number', THEME_SLUG),
            'subject'   => __('Subject', THEME_SLUG),
            'message'   => __('Message', THEME_SLUG),
            'recive'    => __('I would like to recive update from Shinyu', THEME_SLUG),
            'agree'     => __('By clicking download, you agree with Privacy Policy and Term & Condition', THEME_SLUG)
          )   
        )
      )
    );

  }

}

Mimo_Contact_API::get_instance();