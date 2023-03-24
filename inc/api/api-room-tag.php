<?php
class Shinyu_Room_Tag_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Room_Tag_API();
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

    register_rest_route('shinyu', '/unit-tags', [
      'methods'  => 'GET',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);

  }

  public function api($request) {

    $terms = get_terms('room_tag', array(
      'hide_empty' => true,
      'orderby'    => 'menu_order',
      'order'      => 'DESC',
      'meta_query' => array(
        array(
          'key'       => 'room_tag_display_tab',
          'value'     => 1,
          'compare'   => '='
        )
      )
    ));
  
    if (!empty($terms) && !is_wp_error($terms)){
      foreach ($terms as $term) {
        $tags[] = [
          'id'    => $term->term_id,
          'title' => $term->name,
          'type'  => 'unit'
        ];
      }
    }

    $tags[] = [
      'id'    => 0,
      'title' => 'โครงการที่น่าสนใจ',
      'type'  => 'project'
    ];

    return [
      'data'   => $tags,
      'status' => 200
    ];
  } 
}

Shinyu_Room_Tag_API::get_instance();