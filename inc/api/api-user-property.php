<?php
class Shinyu_User_Property_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_User_Property_API();
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

    register_rest_route('shinyu', '/user/property', [
      'methods'  => 'GET',
      'callback' => [$this , 'fetch'],
      'permission_callback' => 'is_user_logged_in',
    ]);

    register_rest_route('shinyu', '/user/property/(?P<id>[\\d]+)', [
      'methods'  => 'GET',
      'callback' => [$this , 'get'],
      'permission_callback' => 'is_user_logged_in',
    ]);

    register_rest_route('shinyu', '/user/property/(?P<id>[\\d]+)', [
      'methods'  => 'PUT',
      'callback' => [$this , 'edit'],
      'permission_callback' => 'is_user_logged_in',
    ]);
  }

  public function get($request) {
    global $post;
    $post = get_post($request['id']);

    setup_postdata($post);

    $images[] = [
      'id' => get_post_thumbnail_id(),
      'name' => wp_get_attachment_metadata(get_post_thumbnail_id())['sizes']['thumbnail']['file'],
      'url' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
      'upload' => true,
    ];

    $gallery = get_field('room_gallery');

    if ($gallery) {
      foreach ($gallery as $image) {
        $images[] = [
          'id' => $image['ID'],
          'name' => $image['filename'],
          'url' => $image['sizes']['thumbnail'],
          'upload' => true,
        ];
      }
    }



//     id: 42224
// name: "V.png"
// url: "http://localhost:9050/wp-content/uploads/2022/01/V-9-150x150.png"

    return [
      'data'      => [
        'id'             => get_the_ID(),
        'author'         => get_field('room_author'),
        'transaction'    => implode('_', get_field('room_condition')),
        'slug'           => get_post_field('post_name', get_the_ID()),
        'link'           => get_permalink(),
        'title'          => html_entity_decode(get_the_title()),
        'size'           => get_field('room_area_sqm'),
        'floor'          => get_field('room_levels'),
        'project'        => html_entity_decode(get_field('room_unit_no')),
        // 'area'           => implode(' / ', $area),
        'image_url'      => get_the_post_thumbnail_url(get_the_ID(), 'thumb-room'),
        // 'images'         => $images,
        'price_sell'         => get_field('room_sell_price'),
        'price_rent'         => get_field('room_rent_price'),
        'include_commission' => get_field('room_include_commission') ? 1 : 0,
        'images' => $images,
        'info'               => [
          'bedrooms'  => get_field('room_bedrooms'),
          'bathrooms' => get_field('room_bathrooms'),
          'area_sqm'  => get_field('room_area_sqm'),
        ],
      ]
    ];
  }

  public function edit($request) {
    $post_id = $request['id'];
    $galleries    = [];
    $lang         = $request['lang'];
    $name         = $request['name'];
    $phone        = $request['phone'];
    $line         = $request['line'];
    $email        = $request['email'];

    $transaction      = $request['transaction'];
    $project_name     = $request['project_name'];
    $project_id       = $request['project_id'];
    $project_type     = $request['property_type'];
    
    $bedroom        = $request['bedroom'];
    $bathroom       = $request['bathroom'];
    $facility       = $request['facility'];
    $images         = $request['images'];
    $price_sell     = $request['price_sell'];
    $price_rent     = $request['price_rent'];
    $include_commission = $request['include_commission'];
    $size           = $request['size'];
    $floor          = $request['floor'];
    $note           = $request['note'];


    if ($images) {
      foreach ($images as $image) {
        $galleries[] = $image['id'];
      }
      set_post_thumbnail($post_id, $galleries[0]);
      unset($galleries[0]);
    }

    update_field('room_sell_price', $price_sell, $post_id); 
    update_field('room_rent_price', $price_rent, $post_id); 
    update_field('room_include_commission', $include_commission, $post_id);
    update_field('room_area_sqm', $size, $post_id);
    update_field('room_levels', $floor, $post_id);
    update_field('room_gallery', $galleries, $post_id);
    
    return array(
      'data'      => $request['id']
    );
  }

  public function fetch($request) {
    $page = $request['pagenum'];
    $args = [
      'post_type'          => 'room',
      'post_status'        => ['publish', 'draft'],
      'paged'              => max(1, $page),
      'meta_query'         => [
        [
          'key'     => 'room_author',
          'value'   => get_current_user_id(),
          'compare' => '=',
          // 'type'    => 'numeric'
        ],
      ],
      'posts_per_page'     => ($posts_per_page) ? $posts_per_page : 12,
    ];

    $the_query = new WP_Query($args);

    return array(
      'data'      => unit_item($the_query),
      'meta'      => [
        'total'       => $the_query->found_posts,
        'total_pages' => $the_query->max_num_pages
      ],
    );
  } 
}

Shinyu_User_Property_API::get_instance();