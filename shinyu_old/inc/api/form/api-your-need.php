<?php 
class Mimo_Form_Your_Need_API {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Form_Your_Need_API();
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

    register_rest_route( 'sy', '/form/your-need', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'create' ),
      'args'     => array( 
        'firstname',
        'lastname',
        'email',
        'phone',
        'want',
        'sell_property_for',
        'sell_property_type',
        'sell_size',
        'sell_bedroom',
        'sell_bathroom',
        'sell_selling_price',
        'sell_rental_price',
        'sell_additional_details',
        'sell_images',
        'buy_location',
        'buy_min_floor_area',
        'buy_max_floor_area',
        'buy_approx_people',
        'buy_other_requirements',
        'recive',
        'agree',
      ),
    ) );
  }


  public function create($data){

    $sad = '';

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

      $email_subject = 'ต้องการ ซื้อ / ฝากขาย #'. $post_id;

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





      line_notify( PHP_EOL . wp_strip_all_tags( $line_message ), '9SV9DXweUWJ1sEJh1YR84e8WTqWvQQ5UzkZB0gZwNsn' );
      
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

Mimo_Form_Your_Need_API::get_instance();