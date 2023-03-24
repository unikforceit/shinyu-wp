<?php
class Shinyu_Special_Room_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Special_Room_API();
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
    register_rest_route('shinyu', '/unit-special', [
      'methods' => 'GET',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);
  }

  public function api($request) {

    $data = [];
    $link = '';

    if ($request['type'] === 'unit') {
      $args = [
        'post_type'          => 'room',
        'posts_per_page'     => 6,
        'post_status'        => 'publish',
        'orderby'            => 'date',
        'order'              => 'DESC',
        'tax_query'          => [
          [
            'taxonomy' => 'room_tag',
            'field'    => 'id',
            'terms'    => $request['id'],
          ]
        ],
      ];

      $the_query = new WP_Query($args);
      $data = unit_item($the_query);

    } else {

      $args = [
        'post_type'          => 'project',
        'posts_per_page'     => 6,
        'post_status'        => 'publish',
        'orderby'            => 'date',
        'order'              => 'DESC',
        'meta_query' => [
          [
            'key'     => 'project_recommend',
            'value'   => 1,
            'compare' => '='
          ]
        ]
      ];

      $the_query = new WP_Query( $args );
  
      if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();
  
          $developer = wp_get_post_terms(get_the_ID(), 'project_developer');
          $data[] = [
            'type'           => $request['type'],
            'id'             => get_the_ID(),
            'slug'           => get_post_field('post_name', get_the_ID()),
            'link'           => get_permalink(),
            'title'          => html_entity_decode(get_the_title()),
            'developer'      => $developer[0]->name,
            'image_url'      => get_the_post_thumbnail_url(get_the_ID(), 'thumb-news'),
          ];
  
        endwhile;
        wp_reset_postdata();
      endif;
    }

    if ($request['id'] && $the_query->found_posts > 6) {
      $term = get_term_by('id', $request['id'], 'room_tag');
      $link = get_permalink(PAGE_ID_SEARCH);
      $link = add_query_arg([
        'transaction' => 'rent',
        'tag_id' => $term->term_id,
        'q' => $term->name,
      ], $link);
    }
    
    return [
      'data' => $data,
      'link' => $link,
      'status' => 200
    ];
  } 
}

Shinyu_Special_Room_API::get_instance();