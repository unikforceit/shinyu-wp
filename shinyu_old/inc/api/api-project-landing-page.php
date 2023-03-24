<?php
class Mimo_Project_Landing_Page_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Project_Landing_Page_API();
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

    register_rest_route( 'sy', '/project/landingpage', array(
      'methods'  => 'GET',
      'args'     => array('slug', 'lang'),
      'callback' => array( $this, 'single' )
    ) );

    register_rest_route( 'sy', '/project/landingpage', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'register' ),
      'args'     => array( 
        'firstname',
        'lastname',
        'email',
        'phone',
        'budget',
        'date'
      ),
    ) );

  }

  public function register($data){

    $sad = '';

    $email_subject = "ลงทะเบียน";

    $firstname               = sanitize_text_field( $data['firstname'] );
    $lastname                = sanitize_text_field( $data['lastname'] );
    $email                   = sanitize_email( $data['email'] );
    $phone                   = sanitize_text_field( $data['phone'] );
    $budget                  = sanitize_text_field( $data['budget'] );
    $date                    = sanitize_text_field( $data['date'] );

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
        'post_type'         => 'project-register',
        'post_title'        => $firstname . ' ' . $lastname,
        'post_status'       => 'publish',
        'post_author'       => '1',
      ) );

      update_post_meta( $post_id, 'project_register_phone', $phone );
      update_post_meta( $post_id, 'project_register_email', $email );
      update_post_meta( $post_id, 'project_register_budget', $budget );
      update_post_meta( $post_id, 'project_register_date', date_i18n( 'Y-m-d', strtotime( str_replace( '/', '-', $date ) ) ) );
    
      $email_class = new Mimo_Email();

      $email_subject = 'ต้องการติดต่อ #'. $post_id;

      // $recipients = explode( PHP_EOL, get_field('contact_recipient', 'option') );

      $recipients = array('info@shinyurealestate.com');

      // $recipients = array('surakraisam@gmail.com');

      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = 'From: '. get_bloginfo( 'name' ) .' <surakrai@mimoproject.co.th>' . "\r\n";
      $headers[] = 'Reply-To:' . $email;

      $emai_message = $email_class->header( $email_subject );
      $emai_message .= $line_message =  '
        <strong>ชื่อ : </strong>' . $firstname .' '. $lastname. '<br/>
        <strong>เบอร์โทร : </strong>' . $phone . '<br/>
        <strong>อีเมล : </strong>' . $email . '<br/>
        <strong>งบประมาณ : </strong>' . $budget . '<br/>
        <strong>วันที่สะดวกชมห้องตัวอย่าง : </strong>' . date_i18n( get_option('date_format'), strtotime( $date ) ) . '<br/>
        ข้อความนี้ถูกส่งจาก www.shinyurealestate.com';
      $emai_message .= $email_class->footer();

      line_notify( PHP_EOL . wp_strip_all_tags( $line_message ), '7aXbBLGA92sc1RlpoNexyreFwxn4DW0U25Efnmt9k8Z' );

      wp_mail( array_filter( $recipients ), $email_subject, $emai_message, $headers );

    }else{
      $msg = 'ผิดพลาด';
    }

    $response = array(
      'error'           => $errors,
      'error_message'   => $error_message,      
      'msg'             => $msg
    );

    return $response;

  }

  public function single($data) {

    $lang = $data['lang'];
    $slug = urlencode( $data['slug'] );

    $post = get_page_by_path( $slug, OBJECT, 'project-landing-page' );


    $head = array(
      'title'   => $post->post_title . ' - ' . get_bloginfo('name'),
    );

    $breadcrumb = array(
      array(
        'title' => pll_translate_string('Home', $lang),
        'name'  => ''
      ),
      array(
        'title'  => __('Project', THEME_SLUG),
        'name'   => 'project',
      ),
      array(
        'title'  => $post->post_title,
        'name'   => '',
      )
    );


    $intro = array(
      'content'     => apply_filters( 'the_content', $post->post_content ),
      'logo'        => wp_get_attachment_image_url(get_field('project_landing_page_logo', $post->ID), 'full'),
      'background'  => wp_get_attachment_image_url(get_field('project_landing_page_register_background', $post->ID), 'full')
    );

    if( have_rows('project_landing_page_information_feature', $post->ID) ): 
      while( have_rows('project_landing_page_information_feature', $post->ID) ): the_row(); 
        $information_feature[] = array(
          'title'       => get_sub_field('title'),
          'content'     => get_sub_field('content')
        );        
      endwhile; 
    endif;

    $information = array(
      'intro'     => get_field('project_landing_page_information_intro', $post->ID),
      'promotion' => wp_get_attachment_image_url(get_field('project_landing_page_information_promotion', $post->ID), 'full'),
      'image'     => wp_get_attachment_image_url(get_field('project_landing_page_information_image', $post->ID), 'full'),
      'feature'   => $information_feature,
    );

    if ( $images = get_field( 'project_landing_page_gallery_interior', $post->ID ) ) {
      foreach( $images as $image ):
        $interior[] = array(
          'thumb' => wp_get_attachment_image_url( $image['ID'], 'thumb-room'),
          'src'  => wp_get_attachment_image_url( $image['ID'], 'full')
        );
      endforeach;
    }
    if ( $images = get_field( 'project_landing_page_gallery_exterior', $post->ID ) ) {
      foreach( $images as $image ):
        $exterior[] = array(
          'thumb' => wp_get_attachment_image_url( $image['ID'], 'thumb-room'),
          'src'  => wp_get_attachment_image_url( $image['ID'], 'full')
        );
      endforeach;
    }

    $gallery = array(
      'items'      => array_merge($interior, $exterior),
      'background' => wp_get_attachment_image_url(get_field('project_landing_page_gallery_background', $post->ID), 'full'),
    );

    $location = array(
      'gps' => array(
        'lat' => get_field('project_landing_page_location_lat', $post->ID),
        'lng' => get_field('project_landing_page_location_lng', $post->ID)
      ),
      'name' => get_field('project_landing_page_location_name', $post->ID)
    );

    $page = array(
      'id'              => $post->ID,
      'title'           => $post->post_title,
      'head'            => $head,
      'breadcrumb'      => $breadcrumb,
      'content'         => array(
        'intro'        => $intro,
        'information'  => $information,
        'plan'         => wp_get_attachment_image_url(get_field('project_landing_page_plan', $post->ID), 'full'),
        'gallery'      => $gallery,
        'location'     => $location,
        'contact'      => array(
          'address' => get_field('project_landing_page_contact_address', $post->ID),
          'info'    => get_field('project_landing_page_contact_info', $post->ID),
        )
      )
    );
  
    return $page;
  
  }

}
Mimo_Project_Landing_Page_API::get_instance();