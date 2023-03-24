<?php 
class Mimo_Form_Post_Property_API {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Form_Post_Property_API();
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
        'room_type',
        'room_number',
        'project_name',
        'floor',
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

    $firstname               = sanitize_text_field( $data['firstname'] );
    $lastname                = sanitize_text_field( $data['lastname'] );
    $email                   = sanitize_email( $data['email'] );
    $phone                   = sanitize_text_field( $data['phone'] );
    $want                    = sanitize_text_field( $data['want'] );
    $property_for            = sanitize_text_field( $data['sell_property_for'] );
    $property_type           = sanitize_text_field( $data['sell_property_type'] );
    $property_size           = sanitize_text_field( $data['sell_size'] );
    $selling_price           = sanitize_text_field( $data['sell_selling_price'] );    
    $rental_price            = sanitize_text_field( $data['sell_rental_price'] );
    $property_additional     = sanitize_text_field( $data['sell_additional_details'] );
    $property_images         = $data['sell_images'];
    $recive                  = sanitize_text_field( $data['recive'] );
    $agree                   = sanitize_text_field( $data['agree'] );

    $room_type              = sanitize_text_field( $data['room_type'] );
    $room_number            = sanitize_text_field( $data['room_number'] );
    $project_name           = sanitize_text_field( $data['project_name'] );
    $floor                  = sanitize_text_field( $data['floor'] );    

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

    if ( $errors === false ) {

      $post_id = wp_insert_post( array(
        'post_type'         => 'post_property',
        'post_title'        => $firstname . ' ' . $lastname,
        'post_status'       => 'publish',
        'post_author'       => '1',
      ));

      update_post_meta( $post_id, 'post_property_phone', $phone );
      update_post_meta( $post_id, 'post_property_email', $email );
      update_post_meta( $post_id, 'post_property_for', $property_for );
      update_post_meta( $post_id, 'post_property_type', $property_type );
      update_post_meta( $post_id, 'post_property_size', $property_size );      
      update_post_meta( $post_id, 'post_property_sell_price', $selling_price ); 
      update_post_meta( $post_id, 'post_property_rental_price', $rental_price );
      update_post_meta( $post_id, 'post_property_additional', $property_additional );
      update_post_meta( $post_id, 'post_property_images', $property_images ); 

      update_post_meta( $post_id, 'post_property_room_type', $agree );
      update_post_meta( $post_id, 'post_property_room_number', $agree );
      update_post_meta( $post_id, 'post_property_project_name', $agree );
      update_post_meta( $post_id, 'post_property_floor', $agree );

      update_post_meta( $post_id, 'post_property_recive', $recive );
      update_post_meta( $post_id, 'post_property_agree', $agree );

      $email_class = new Mimo_Email();

      $email_subject = 'ต้องการ ซื้อ / ฝากขาย #'. $post_id;

      $recipients = explode( PHP_EOL, get_field('post_property_recipient', 'option') );

      //$recipients = array('info@shinyurealestate.com');

      $recipients = array('surakraisam@gmail.com');

      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: '. get_bloginfo( 'name' ) .' <contact@shinyurealestate.com>' . "\r\n";
      $headers[] = 'Reply-To:' . $email;

      $fields = array(
        'name' => array(
          'label' => 'ชื่อ',
          'value' => $firstname
        ),
        'phone' => array(
          'label' => 'เบอร์โทร',
          'value' => $phone
        ),      
        'email' => array(
          'label' => 'อีเมล',
          'value' => $email
        ),
        'property_for' => array(
          'label' => 'Property For',
          'value' => $property_for
        ),
        'property_type' => array(
          'label' => 'Property Type',
          'value' => $property_type
        ),
        'room_type' => array(
          'label' => 'Room Type',
          'value' => $room_type
        ),
        'project_name' => array(
          'label' => 'Project Name',
          'value' => $project_name
        ),
        'floor' => array(
          'label' => 'Floor',
          'value' => $floor
        ),
        'room_number' => array(
          'label' => 'Room No.',
          'value' => $room_number
        ),
        'property_size' => array(
          'label' => 'Property Size',
          'value' => $property_size
        ),
        'property_sell_price' => array(
          'label' => 'Selling Price',
          'value' => $selling_price
        ),
        'sell_price' => array(
          'label' => 'Rental Price',
          'value' => $rental_price
        ),
        'additional' => array(
          'label' => 'Additional Details',
          'value' => $property_additional
        ),
      );




      $email_message = $email_class->header( $email_subject );

      foreach ( $fields as $field ) {
        $email_message .= '<strong>' . $field['label'] . ' : </strong>' . $field['value'] . '</br>';
        $line_message .= $field['label'] . ' : ' . $field['value'] . PHP_EOL;
      }

      $email_message .= $email_class->footer();

      line_notify( PHP_EOL . $line_message, get_field('post_property_line_token', 'option') );
      
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
      'property_for'   => render_fields(field_transaction('', $lang)),
      'property_type'  => render_fields($project_type),
      'bedroom'        => field_bedrooms('', $lang),
      'bathroom'       => render_fields(field_bathrooms('', $lang)),
      'room_type'      => render_fields(field_room_type('', $lang)),      
    );

  }

}

Mimo_Form_Post_Property_API::get_instance();