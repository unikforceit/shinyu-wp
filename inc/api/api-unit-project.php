<?php
class Shinyu_Unit_Project_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Unit_Project_API();
    }
    return self::$instance;

  }

  public function __construct() {
    $this->hooks();
  }

  public function hooks() {
    add_action('rest_api_init', [$this , 'rest_api_init']);
  }

  public function rest_api_init() {
    register_rest_route('shinyu', '/unit/project', [
      'methods'  => 'GET',
      'callback' => [$this, 'api'],
      'permission_callback' => function() { return true; },
    ]);

  }

  public function api($request) {
    $data = [];

    $projects = [];
    $project = $request['project'];

    $args = [
      'post_type'          => 'room',
      'posts_per_page'     => -1,
      'post_status'        => 'publish',
      // 'orderby'            => 'rand',
      // 'order'              => 'ASC',
      'meta_query'         => [
        [
          'key'     => 'room_project',
          'value'   => $project,
          'compare' => 'IN'
        ],
      ],
    ];

    $the_query = new WP_Query($args);
    
    return [
      'data' => unit_item($the_query),
      'status' => 200,
      'test' => $projects,
    ];
  }
}

Shinyu_Unit_Project_API::get_instance();