<?php
class Shinyu_Project_Area_Search_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Project_Area_Search_API();
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

    register_rest_route('shinyu', '/search/project-area', [
      'methods' => 'GET',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);

  }

  public function api($request) {

    $areas = get_terms('project_area', [
      'hide_empty' => false,
      'orderby'    => 'date',
      'order'      => 'DESC',
      'name__like' => $request['keyword'],
    ]);

    $tags = get_terms('room_tag', [
      'hide_empty' => false,
      'orderby'    => 'date',
      'order'      => 'DESC',
      'name__like' => $request['keyword'],
    ]);

    $data = [];
  
    if (!empty($areas) && !is_wp_error($areas)){
      foreach ($areas as $area) {
        $data[] = [
          'id'       => $area->term_id,
          'title'    => html_entity_decode($area->name),
          'type'     => 'area'
        ];
      }
    }

    if (!empty($tags) && !is_wp_error($tags)){
      foreach ($tags as $tag) {
        $data[] = [
          'id'       => $tag->term_id,
          'title'    => html_entity_decode($tag->name),
          'type'     => 'tag'
        ];
      }
    }

    $args = array(
      'post_type'          => 'project',
      'posts_per_page'     => $request['per_page'],
      'paged'              => max(1, $request['page']),
      'post_status'        => 'publish',
      's'                  => $request['keyword'],
      // 's_meta_keys'        => ['project_name_th'],
      // 'meta_query'         => [
      //   [
      //     'key'     => 'project_name_th',
      //     'value'   => $request['keyword'],
      //     'compare' => 'LIKE'
      //   ] 
      // ],
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
      while ($the_query->have_posts()) : $the_query->the_post();
        $data[] = [
          'id'        => get_the_ID(),
          'title'     => html_entity_decode(get_the_title()),
          'title_th'  => html_entity_decode(get_field('project_name_th')),
          'type'      => 'project',
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

Shinyu_Project_Area_Search_API::get_instance();