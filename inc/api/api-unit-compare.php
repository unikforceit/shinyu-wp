<?php
class Shinyu_Unit_Compare_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Unit_Compare_API();
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

    register_rest_route('shinyu', '/compare', [
      'methods' => 'GET',
      'callback' => [$this , 'api'],
      'permission_callback' => function() { return true; },
    ]);

  }

  public function api($request) {
    $data = [];
    $project = $image = $id = $price = $link = $bedroom = $bathroom = $facilities = [];
    $unit = $request['unit'];
    $units = [];

    if ($unit) {
      foreach ($unit as $value) {
        $units[] = pll_get_post($value, $request['lang']);
      }
    }
  
    $args = array(
      'post_type'          => 'room',
      'posts_per_page'     => 4,
      'post__in'           => $units,
      'orderby'            => 'post__in' 
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts() && $request['unit']) :
      while ($the_query->have_posts()) : $the_query->the_post();

        $facility = [];

        $project_id       = get_field('room_project');
        $tags             = wp_get_post_terms(get_the_ID(), 'room_tag');
        $areas            = wp_get_post_terms($project_id, 'project_area');
        $room_facility    = wp_get_post_terms(get_the_ID(), 'room_facility');
        $project_facility = wp_get_post_terms($project_id, 'project_facility');

        $facilities_room_project = $room_facility + $project_facility;

        if ($areas) {
          foreach ($areas as $item) {
            $area[] = $item->name;
          }
        }

        if ($facilities_room_project) {
          foreach ($facilities_room_project as $item) {
            $facility[] = $item->name;
          }
        }

        $project[]    = html_entity_decode(get_the_title(get_field('room_project')));
        $image[]      = get_the_post_thumbnail_url(get_the_ID(), 'thumb-room');
        $id[]         = get_the_ID();
        $sqm[]        = get_field('room_area_sqm');
        $link[]       = get_permalink();
        $bedroom[]    = get_field('room_bedrooms');
        $bathroom[]   = get_field('room_bathrooms');
        $facilities[] = $facility;

        $price[]   = [
          'sell' => price(get_field('room_sell_price'), CURRENCY),
          'rent' => price(get_field('room_rent_price'), CURRENCY)
        ];

        $data[] = [
          'id'             => get_the_ID(),
          'for'            => get_field('room_condition'),
          'slug'           => get_post_field('post_name', get_the_ID()),
          'link'           => get_permalink(),
          'title'          => html_entity_decode(get_the_title()),
          'project'        => html_entity_decode(get_field('room_unit_no')),
          'area'           => implode(' / ', $area),
          'image_url'      => get_the_post_thumbnail_url(get_the_ID(), 'thumb-room'),
          'price' => [
            'sell' => price(get_field('room_sell_price'), CURRENCY),
            'rent' => price(get_field('room_rent_price'), CURRENCY)
          ],
          'info'           => [
            'bedrooms'  => get_field('room_bedrooms'),
            'bathrooms' => get_field('room_bathrooms'),
            'area_sqm'  => get_field('room_area_sqm'),
          ],
        ];
      endwhile;
      wp_reset_postdata();
    endif;

    return [
      'data'   => [
        'id' => $id,
        'project'  => $project,
        'image'    => $image,
        'price'    => $price,
        'sqm'      => $sqm,
        'link'     => $link,
        'bedroom'  => $bedroom,
        'bathroom' => $bathroom,
        'facility' => $facilities,
      ],
      'status' => 200
    ];
  } 
}

Shinyu_Unit_Compare_API::get_instance();