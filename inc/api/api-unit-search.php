<?php
class Mimo_Unit_Search_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Unit_Search_API();
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
    register_rest_route('shinyu', '/search', [
      'methods' => 'GET',
      'callback' => [$this, 'api'],
      'permission_callback' => function() { return true; },
    ]);
  }

  public function api($request) {

    $q                = $request['q'];
    $transaction      = $request['transaction'] ? $request['transaction'] : 'sell';
    $location         = $request['location'];
    $bedrooms         = $request['bedrooms'];
    $bathrooms        = $request['bathrooms'];
    $year             = $request['year_built'];
    $keyword          = $request['keyword'];
    $developer        = $request['developer'];
    $project_type     = $request['property_type'];
    $country          = $request['country'];
    $yield            = $request['yield'];
    $sort             = $request['sort'] ? $request['sort'] : 'date';
    $facility         = $request['facility'];
    $price            = $request['price'];
    $project_id       = $request['project_id'];
    $area_id          = $request['area_id'];
    $tag_id           = $request['tag_id'];
    $posts_per_page   = $request['per_page'];
    $page             = $request['pagenum'];
    $lang             = $request['lang'];

    // $area_ids         = [];

    if (!$project_id) {

      // if (!$area_id) {
      //   $areas = get_terms('project_area', array(
      //     'hide_empty' => false,
      //     'orderby'    => 'date',
      //     'order'      => 'DESC',
      //     'name__like' => $q,
      //   ));
      //   if ($areas) {
      //     foreach ($areas as $area) {
      //       $area_ids[] = $area->term_id;
      //     }
      //   }
      // } else {
      //   $area_ids = [$area_id];
      // }

      $args = [
        'post_type'          => 'project',
        'post_status'        => 'publish',
        'posts_per_page'     => -1,
        's'                  => !$area_id && !$tag_id  ? $q : '',
        'tax_query'          => [
          'relation'   => 'AND',
          // [
          //   'taxonomy' => 'project_type',
          //   'field'    => 'slug',
          //   'terms'    => $project_type,
          //   'operator' => ($project_type) ? 'IN' : 'NOT IN',
          // ],
          // [
          //   'taxonomy' => 'project_country',
          //   'field'    => 'slug',
          //   'terms'    => $country,
          //   'operator' => ($country) ? 'IN' : 'NOT IN'
          // ],
          [
            'taxonomy' => 'project_developer',
            'field'    => 'slug',
            'terms'    => $developer,
            'operator' => ($developer) ? 'IN' : 'NOT IN'
          ],
          [
            'taxonomy' => 'project_location',
            'field'    => 'slug',
            'terms'    => $location,
            'operator' => ($location) ? 'IN' : 'NOT IN'
          ],
          // [
          //   'taxonomy' => 'project_facility',
          //   'field'    => 'slug',
          //   'terms'    => explode(',', $facility),
          //   'operator' => ($facility) ? 'IN' : 'NOT IN'
          // ],
          [
            'taxonomy' => 'project_area',
            'field'    => 'id',
            'terms'    => [$area_id],
            'operator' => ($area_id) ? 'IN' : 'NOT IN'
          ],
        ],
        // 'meta_query'         => [
        //   'relation'   => 'AND',
        //   [
        //     'key'     => 'project_year_built',
        //     'value'   => $year,
        //     'compare' => ($year) ? '=' : '!='
        //   ]    
        // ],
      ];
  
      $the_query = new WP_Query( $args );
  
      if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
          $projects[] = get_the_ID(); 
        endwhile;
        wp_reset_postdata();
      endif;
    } else {
      $projects[] = $project_id;
    }

    $args = [
      'post_type'          => 'room',
      'post_status'        => 'publish',
      'paged'              => max(1, $page),
      'tax_query'          => [
        [
          'taxonomy' => 'room_tag',
          'field'    => 'id',
          'terms'    => [$tag_id],
          'operator' => ($tag_id) ? 'IN' : 'NOT IN'
        ],
      ],
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
          'value'   => $bedrooms,
          'compare' => ($bedrooms) ? '=' : '!='
        ],
        [
          'key'     => 'room_bathrooms',
          'value'   => $bathrooms,
          'compare' => ($bathrooms) ? '=' : '!='
        ],
      ],
      'posts_per_page'     => ($posts_per_page) ? $posts_per_page : 12,
      // 'orderby'            => 'rand',
      // 'order'              => 'ASC'
    ];

    if ($sort !== 'date') {
      $args['orderby'] = 'meta_value_num';
      $args['meta_key'] = 'room_'. $transaction .'_price';
      $args['order'] = $sort === 'price_asc' ?  'ASC' : 'DESC';
    }

    if ($price) {
      $price = explode('-', $price);
      if (count($price) === 2) {
        $args['meta_query'][] = [
          'key'     => 'room_'. $transaction .'_price',
          'value'   => $price,
          'type'    => 'NUMERIC',
          'compare' => 'BETWEEN'
        ];
      } else {
        $args['meta_query'][] = [
          'key'     => 'room_'. $transaction .'_price',
          'value'   => $price[0],
          'type'    => 'NUMERIC',
          'compare' => '>='
        ];
      }
    }

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
Mimo_Unit_Search_API::get_instance();