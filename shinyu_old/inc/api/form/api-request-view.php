<?php 
class Mimo_Form_Request_View_API {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Form_Request_View_API();
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
    register_rest_route( 'sy', '/form/your-need/field', array(
      'methods'  => 'get',
      'callback' => array( $this, 'field' ),
      'args'     => array( 'lang'),
    ));

    register_rest_route( 'sy', '/form/request-viewing', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'create' ),
      'args'     => array( 'id', 'firstname', 'lastname', 'email', 'phone', 'date', 'time', 'recive', 'lang'),
    ) );

  }
  public function create($data){

    $form_id    = sanitize_text_field( $data['id'] );
    $firstname  = sanitize_text_field( $data['firstname'] );
    $lastname   = sanitize_text_field( $data['lastname'] );
    $email      = sanitize_email( $data['email'] );
    $phone      = sanitize_text_field( $data['phone'] );
    $date       = sanitize_text_field( $data['date'] );
    $time       = sanitize_text_field( $data['time'] );    
    $recive     = sanitize_text_field( $data['recive'] );
    $date       = date_i18n( 'Y-m-d H:i', strtotime( str_replace( '/', '-', $date . ' ' . $time ) ) );
    
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

      update_post_meta( $post_id, 'request_id', $form_id );
      update_post_meta( $post_id, 'request_phone', $phone );
      update_post_meta( $post_id, 'request_email', $email );
      update_post_meta( $post_id, 'request_subject', $subject );
      update_post_meta( $post_id, 'request_message', $message );
      update_post_meta( $post_id, 'request_recive', $recive );
      update_post_meta( $post_id, 'request_agree', $agree );
      update_post_meta( $post_id, 'request_date', $date );

      $email_class = new Mimo_Email();

      $email_subject = 'ต้องการติดต่อ #'. $post_id;

      $recipients = explode( PHP_EOL, get_field('request_view_recipient', 'option') );

      // $recipients = array('info@shinyurealestate.com');

      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: '. get_bloginfo( 'name' ) .' <contact@shinyurealestate.com>' . "\r\n";
      $headers[] = 'Reply-To:' . $email;

      $fields = array(
        'name' => array(
          'label' => 'ชื่อ',
          'value' => $firstname . '  ' . $lastname
        ),
        'phone' => array(
          'label' => 'เบอร์โทร',
          'value' => $phone
        ),      
        'email' => array(
          'label' => 'อีเมล',
          'value' => $email
        ),
        'project_room' => array(
          'label' => 'Project / Room',
          'value' => html_entity_decode(get_the_title($form_id))
        ),
        'date' => array(
          'label' => 'Appointment date',
          'value' => $date
        ),
      );

      $email_message = $email_class->header( $email_subject );

      foreach ( $fields as $field ) {
        $email_message .= '<strong>' . $field['label'] . ' : </strong>' . $field['value'] . '<br>';
        $line_message .= $field['label'] . ' : ' . $field['value'] . PHP_EOL;
      }

      $email_message .= $email_class->footer();

      line_notify( PHP_EOL . $line_message, get_field( 'request_view_line_token', 'option' ) );
      
      wp_mail( array_filter( $recipients ), $email_subject, $email_message, $headers );

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

  public function field($data){

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
      'want'           => field_what_can_we_help(),
      'property_for'   => field_transaction('', $lang),
      'property_type'  => $project_type,
      'bedroom'        => field_bedrooms('', $lang),
      'bathroom'       => field_bathrooms('', $lang)
    );

  }

}

Mimo_Form_Request_View_API::get_instance();