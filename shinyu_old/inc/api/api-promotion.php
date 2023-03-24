<?php
class Mimo_Promotion_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Promotion_API();
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

    register_rest_route( 'sy', '/promotion', array(
      'methods'  => 'GET',
      'callback' => array( $this, 'archive' ),
      'args'     => array( 'lang')
    ) );

    register_rest_route( 'sy', '/promotion/register', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'register' ),
      'args'     => array( 'id', 'firstname', 'lastname', 'email', 'phone', 'budget', 'interest_room', 'budget', 'recive', 'agree', 'lang'),
    ) );

    register_rest_route( 'sy', '/promotion/register/field', array(
      'methods'  => 'GET',
      'callback' => array( $this, 'field' ),
      'args'     => array( 'lang'),
    ) );    

    register_rest_route( 'sy', '/promotion/single', array(
      'methods'  => 'GET',
      'args'     => array('slug', 'lang'),
      'callback' => array( $this, 'single' )
    ) );

  }


  public function field($data){

    return array(
      'budget'           => render_fields(field_price_range()),
      'interest_room'    => render_fields(field_room_type()),
    );

  }

  public function register($data){

    $sad = '';

    $email_subject = "ต้องการให้ทีมงานติดต่อกลับ";

    $firstname  = sanitize_text_field( $data['firstname'] );
    $lastname   = sanitize_text_field( $data['lastname'] );
    $phone      = sanitize_text_field( $data['phone'] );
    $email      = sanitize_email( $data['email'] );
    $date       = sanitize_text_field( $data['date'] );
    $cv         = sanitize_text_field( $data['date'] );
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
        'post_type'         => 'job',
        'post_title'        => $firstname . ' ' . $lastname,
        'post_status'       => 'publish',
        'post_author'       => '1',
      ) );

      update_post_meta( $post_id, 'job_phone', $phone );
      update_post_meta( $post_id, 'job_email', $email );
      update_post_meta( $post_id, 'job_subject', $subject );
      update_post_meta( $post_id, 'job_message', $message );
      update_post_meta( $post_id, 'job_recive', $recive );
      update_post_meta( $post_id, 'job_agree', $agree );

      $email_class = new Mimo_Email();

      $email_subject = 'ต้องการติดต่อ #'. $post_id;

      $recipients = explode( PHP_EOL, get_field('job_recipient', 'option') );

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

      line_notify( PHP_EOL . wp_strip_all_tags( $line_message ), get_field( 'job_line_token', 'option' ) );
      
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


  public function archive($data) {

    $sad = '';
    
    $head = array(
      'title'   => __('Promotion', THEME_SLUG) . ' - ' . get_bloginfo('name'),
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
        'title'  => __('Promotion', THEME_SLUG),
        'name'   => $category ? 'promotion' : '',
      )
    );

    $args = array(
      'post_type'          => 'promotion',
      'posts_per_page'     => -1,
      'post_status'        => 'publish',
      // 'orderby'            => 'Date',
      // 'order'              => 'ASC'
    );

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $promotion[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
        );
        
      endwhile;
      wp_reset_postdata();
    endif;
  
    $pages = array(
      // 'title'          => 'Promotion',
      // 'page_title'     => 'INSIGHT AND',
      // 'page_sub_title' => 'NEWS',
      'content'        => $promotion,
      'head'           => $head,
      'breadcrumb'     => $breadcrumb
    );
    
    return $pages;

  }
  
  public function single($data) {

    $sad = '';

    $slug = urlencode( $data['slug'] );
    $post = get_page_by_path( $slug, OBJECT, 'promotion' );

    $project_id = get_field('promotion_project', $post->ID);

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
        'title'  => __('Promotion', THEME_SLUG),
        'name'   => 'promotion',
      ),
      array(
        'title'  => $post->post_title,
        'name'   => '',
      )
    );
  
    $args = array(
      'post_type'          => 'promotion',
      'posts_per_page'     => 3,
      'post_status'        => 'publish',
      'orderby'            => 'rand',
      'post__not_in'       => array( $post->ID )
      // 'order'              => 'ASC'
    );
    $the_query = new WP_Query( $args );
  
    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $related[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
        );
  
      endwhile;
      wp_reset_postdata();
    endif;
    
    $page = array(
      'id'         => $post->ID,
      'title'      => $post->post_title,
      'sub_title'  => 'BY ' . get_the_title($project_id),
      'background_title' => get_the_post_thumbnail_url($project_id, 'large'),
      'content'    => apply_filters( 'the_content', $post->post_content ),
      'thumbnail'  => get_the_post_thumbnail_url( $post->ID, 'large' ),
      'head'       => $head,
      'breadcrumb' => $breadcrumb,
    );
  
    return $page;
  
  }

}

Mimo_Promotion_API::get_instance();