<?php
class Mimo_Job_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Job_API();
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

    register_rest_route( 'sy', 'job', array(
      'methods'  => 'POST',
      'callback' => array( $this, 'job_register' ),
      'args'     => array( 'id', 'firstname', 'lastname', 'email', 'phone', 'date', 'sex', 'cv', 'agree', 'lang'),
      // 'permission_callback' => function() {
      //   return current_user_can( 'edit_others_posts' );
      // }
    ) );

    register_rest_route( 'sy', '/job/single', array(
      'methods'  => 'GET',
      'args'     => array('slug', 'lang'),
      'callback' => array( $this, 'single' )
    ) );

    register_rest_route( 'sy', 'job', array(
      'methods'  => 'GET',
      'callback' => array( $this, 'archive' ),
      'args'     => array( 'lang')
    ) );

  }
  
  public function job_register($data){

    $sad = '';

    $email_subject = "ต้องการให้ทีมงานติดต่อกลับ";

    $firstname  = sanitize_text_field( $data['firstname'] );
    $lastname   = sanitize_text_field( $data['lastname'] );
    $phone      = sanitize_text_field( $data['phone'] );
    $email      = sanitize_email( $data['email'] );
    $date       = sanitize_text_field( $data['date'] );
    $cv         = sanitize_text_field( $data['date'] );
    $recive     = sanitize_text_field( $data['agree'] );
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
        'post_type'         => 'job_register',
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

  public function single($data) {

    $sad = '';

    $slug = urlencode( $data['slug'] );
    $post = get_page_by_path( $slug, OBJECT, 'job' );

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

    return array(
      'head'            => $head,
      'breadcrumb'      => $breadcrumb,
      'title'           => $post->post_title,
      'page_title'      => $post->post_title,
      'id'              => $post->ID,
      'count'           => get_field('job_count', $post->ID),
      'description'     => 'Ther sales Operations Analyst will be part of the strategic Growth team and perform a blend of long-term projects and daily operational activites. This person will be charged with contributing to projecte and running analayses to drive top-line growth and provide insight to drive efficiency and producation from our strategic Growth tem. Thia includes opportunities to own and manage specific projects.',
      'content'         => apply_filters( 'the_content', $post->post_content ),
    );

  }

  public function archive($data) {

    $news = array();

    $sad = '';

    $post = get_page_by_path( 'job', OBJECT, 'page' );
    
    $head = array(
      'title'   => __('Join US', THEME_SLUG) . ' - ' . get_bloginfo('name'),
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
        'title'  => __('Join US', THEME_SLUG),
        'name'   => '',
      )
    );

    if ( $category ) {
      $breadcrumb[] = array(
          'title'  => $category,
          'name'   => '',
      );
    }

    $args = array(
      'post_type'          => 'job',
      'posts_per_page'     => -1,
      'post_status'        => 'publish',
      // 'orderby'            => 'Date',
      // 'order'              => 'ASC'
    );

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $terms = get_the_terms( get_the_ID(), 'news_cat' );
        unset($categories);
        if ( $terms && ! is_wp_error( $terms ) ) {
          foreach ( $terms as $term ) {
            $categories[] = $term->name;
          }
        }
        $job[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(get_post_field( 'post_name', get_the_ID() )),
          'title'     => html_entity_decode(get_the_title()),
          'count'     => get_field('job_count'),
        );
      endwhile;
      wp_reset_postdata();
    endif;
  
    $description = 'We believe in the power of entrepreneurial thinking. We’re looking for people who move fast, dream big, and want to shape the direction of their own careers while reimaging the real state experience. the future of estast is inpired by reality, powered by technology, and built by you.';
    
    $pages = array(
      'title'          => 'Join US',
      'page_title'     => 'Design your place',
      'page_sub_title' => 'at shinyu',
      'content'        => array(
        'description'  => array(
          'text'  => $description,
          'image' => get_the_post_thumbnail_url($post->ID, 'full'),
        ),
        'intro' => array(
          'title'     => 'find the future of real estate for',
          'sub_title' => 'the future of your career',
          'content'   => $post->post_content,
        ),
        'items' => $job,
      ),
      'head'           => $head,
      'breadcrumb'     => $breadcrumb
    );
    
    return $pages;

  }

}

Mimo_Job_API::get_instance();