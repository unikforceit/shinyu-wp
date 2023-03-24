<?php
class Shinyu_Project_Search_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Project_Search_API();
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

    register_rest_route('shinyu', '/search/project', [
      'methods' => 'GET',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);

  }

  public function api($request) {
    $args = array(
      'post_type'          => 'project',
      'posts_per_page'     => $request['per_page'],
      'paged'              => max(1, $request['page']),
      'post_status'        => 'publish',
      's'                  => $request['keyword'],
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
      while ($the_query->have_posts()) : $the_query->the_post();

        $project_type = wp_get_post_terms(get_the_ID(), 'project_type');

        $data[] = [
          'id'        => get_the_ID(),
          'title'     => html_entity_decode(get_the_title()),
          'type'      => $project_type[0]->slug,
          'image_url' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
        ];
      endwhile;
      wp_reset_postdata();
    endif;

    return [
      'data'   => $data,
      'meta'      => [
        'total'       => $the_query->found_posts,
        'total_pages' => $the_query->max_num_pages
      ],
      'status' => 200
    ];
  } 
}

Shinyu_Project_Search_API::get_instance();