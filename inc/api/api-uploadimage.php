<?php
namespace EasyWatermark\Watermark;


use EasyWatermark\Traits\Hookable;
use EasyWatermark\Metaboxes\Attachment\Watermarks;
use EasyWatermark\Watermark\Handler;

class Shinyu_Upload_Image_API {
  use Hookable;

  protected static $instance = null;

  private $watermark_handler;
  
  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Upload_Image_API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();
  }

  public function hooks() {

    add_action('rest_api_init', array($this , 'rest_api_init'));
    
  }
  
  public function rest_api_init() {

    register_rest_route('shinyu', '/uploadimage', [
      'methods' => 'POST',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);

  }

  public function api($request) {
    if (!function_exists('wp_generate_attachment_metadata')) {
      require_once(ABSPATH . "wp-admin" . '/includes/image.php');
      require_once(ABSPATH . "wp-admin" . '/includes/file.php');
      require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    }
  
    $attachment_id = media_handle_upload('image', 0);


    pll_set_post_language($attachment_id, $request['lang']);
  
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
      $url      = wp_get_attachment_image_url($attachment_id, 'thumbnail');
      $filetype = wp_check_filetype($url);

      require_once(ABSPATH . 'wp-content/plugins/easy-watermark/src/classes/Watermark/Handler.php');
      $handler = new Handler();
      $result = $handler->apply_single_watermark($attachment_id, 36104);

      return [
        'data' => [
          'id'   => $attachment_id,
          'url'  => $url,
          'name' => html_entity_decode(get_the_title($attachment_id) . '.' . $filetype['ext']),
        ],
        'success' => true,
      ];
  
    }
  }

}

Shinyu_Upload_Image_API::get_instance();
