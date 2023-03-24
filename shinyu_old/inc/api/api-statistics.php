<?php
class Mimo_Statistic_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Statistic_API();
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

    register_rest_route( 'sy', '/social', array(
      'methods'  => 'get',
      'callback' => array( $this, 'rest_api' ),
      'args'     => array( 'lang'),
    ) );

  }

  public function rest_api($data){

    $response = array(
      array(
        'title'  => 'Facebook',
        'url'    => get_field('social_facebook_url', 'option'),
        'logo'   => wp_get_attachment_image_url(get_field('social_facebook_logo', 'option')),
      ),
      array(
        'title'  => 'Instagram',
        'url'    => get_field('social_instagram_url', 'option'),
        'logo'   => wp_get_attachment_image_url(get_field('social_instagram_logo', 'option')),
      ),
      array(
        'title'  => 'WeChat',
        'url'    => get_field('social_wechat_url', 'option'),
        'logo'   => wp_get_attachment_image_url(get_field('social_wechat_logo', 'option')),
      ),
      array(
        'title'  => 'WhatsApp',
        'url'    => get_field('social_whatsapp_url', 'option'),
        'logo'   => wp_get_attachment_image_url(get_field('social_whatsapp_logo', 'option')),
      ),
      array(
        'title'  => 'Facebook Messenger',
        'url'    => get_field('social_messenger_url', 'option'),
        'logo'   => wp_get_attachment_image_url(get_field('social_messenger_logo', 'option')),
      ),
      array(
        'title'  => 'Line',
        'url'    => get_field('social_line_url', 'option'),
        'logo'   => wp_get_attachment_image_url(get_field('social_line_logo', 'option')),
      ),
      array(
        'title'  => 'Youtube',
        'url'    => get_field('social_youtube_url', 'option'),
        'logo'   => wp_get_attachment_image_url(get_field('social_youtube_logo', 'option')),
      ),
    );

    return $response;

  }

}

Mimo_Statistic_API::get_instance();