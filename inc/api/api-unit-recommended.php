<?php
class Shinyu_Unit_Recommended_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Unit_Recommended_API();
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
    register_rest_route('shinyu', '/unit/recommended', [
      'methods'  => 'GET',
      'callback' => [$this, 'api'],
      'permission_callback' => function() { return true; },
    ]);

  }

  public function api($request) {
    $data = [];

    $projects = [];
    $project = $request['project'];
    $location = $request['location'];
    $unit = $request['unit'];
    $transaction = $request['transaction'];    
    $bedroom = $request['bedrooms'];    

    $args = [
      'post_type'          => 'project',
      'post_status'        => 'publish',
      'posts_per_page'     => -1,
      'tax_query'          => [
        'relation'   => 'AND',
        [
          'taxonomy' => 'project_location',
          'field'    => 'id',
          'terms'    => explode(',', $location),
          'operator' => 'IN'
        ],
        // [
        //   'taxonomy' => 'project_area',
        //   'field'    => 'id',
        //   'terms'    => [$area_id],
        //   'operator' => ($area_id) ? 'IN' : 'NOT IN'
        // ],
      ],
    ];

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();
        $projects[] = get_the_ID(); 
      endwhile;
      wp_reset_postdata();
    endif;

    $args = [
      'post_type'          => 'room',
      'posts_per_page'     => 6,
      'post_status'        => 'publish',
      'orderby'            => 'rand',
      'order'              => 'ASC',
      'post__not_in'       => [$unit],
      'meta_query'         => [
        'relation'   => 'AND',
        [
          'key'     => 'room_project',
          'value'   => $projects,
          'compare' => 'IN'
        ],
        [
          'key'     => 'room_condition',
          'value'   => $transaction,
          'compare' => 'LIKE'
        ],
        [
          'key'     => 'room_bedrooms',
          'value'   => $bedroom,
          'compare' => ($bedroom) ? '=' : '!='
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

Shinyu_Unit_Recommended_API::get_instance();