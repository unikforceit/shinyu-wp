<?php
class Mimo_Room_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Room_API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();

  }

  public function hooks() {

    add_action( 'rest_api_init', array( $this , 'rest_api_init' ) );
    
  }

  public function rest_api_init() {

    register_rest_route( 'sy', '/search', array(
      'methods' => 'GET',
      'callback' => array( $this, 'search' ),
      'args'     => array(
        'project_name',
        'condition',
        'location_bts_mrt',
        'bedrooms',
        'bathrooms',
        'year_built',
        'keyword',
        'developer',
        'property_type',
        'country',
        'yield',
        'order_by',
        'facility',
        'lang'
      ),
    ));

    register_rest_route( 'sy', '/search/fields', array(
      'methods' => 'GET',
      'callback' => array( $this, 'fields' ),
      'args'     => array('lang'),
    ));

    register_rest_route( 'sy', '/room/single', array(
      'methods'  => 'GET',
      'args'     => array('slug', 'lang', 'currency'),
      'callback' => array( $this, 'single' )
    ) );

  }

  public function search($data) {

    $project_name     = $data['project_name'];
    $condition        = $data['condition'] ? $data['condition'] : 'sell';
    $location         = $data['location_bts_mrt'];
    $bedrooms         = $data['bedrooms'];
    $bathrooms        = $data['bathrooms'];
    $year             = $data['year_built'];
    $keyword          = $data['keyword'];
    $developer        = $data['developer'];
    $project_type     = $data['property_type'];
    $country          = $data['country'];
    $yield            = $data['yield'];
    $order_by         = $data['order_by'];
    $facility         = $data['facility'];
    $posts_per_page   = $data['posts_per_page'];
    $page             = $data['page']; 
    $lang             = $data['lang'];

    $head = array(
      'title'   => __('SELL / RENT', THEME_SLUG) . ' - ' . get_bloginfo('name'),
    );

    $args = array(
      'post_type'          => 'project',
      'post_status'        => 'publish',
      'posts_per_page'     => -1,
      's'                  => $project_name,
      'tax_query'          => array(
        'relation'   => 'AND',
        array(
          'taxonomy' => 'project_type',
          'field'    => 'slug',
          'terms'    => $project_type,
          'operator' => ( $project_type ) ? "IN" : "NOT IN",
        ),
        array(
          'taxonomy' => 'project_country',
          'field'    => 'slug',
          'terms'    => $country,
          'operator' => ( $country ) ? "IN" : "NOT IN"
        ),
        array(
          'taxonomy' => 'project_developer',
          'field'    => 'slug',
          'terms'    => $developer,
          'operator' => ( $developer ) ? "IN" : "NOT IN"
        ),
        array(
          'taxonomy' => 'project_location',
          'field'    => 'slug',
          'terms'    => $location,
          'operator' => ( $location ) ? "IN" : "NOT IN"
        ),
        array(
          'taxonomy' => 'project_facility',
          'field'    => 'slug',
          'terms'    => explode(',', $facility),
          'operator' => ( $facility ) ? "IN" : "NOT IN"
        ),
      ),
      'meta_query'         => array(
        'relation'   => 'AND',
        array(
          'key'     => 'project_year_built',
          'value'   => $year,
          'compare' => ($year) ? '=' : '!='
        )      
      ),
    );
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();
        $projects[] = get_the_ID(); 
      endwhile;
    endif;
    wp_reset_query();

    $args = array(
      'post_type'          => 'room',
      'post_status'        => 'publish',
      'paged'              => max( 1, $page ),
      'meta_query'         => array(
        'relation'   => 'AND',
        array(
          'key'     => 'room_project',
          'value'   => $projects,
          'compare' => 'IN'
        ),
        array(
          'key'     => 'room_condition',
          'value'   => $condition,
          'compare' => 'LIKE'
        ),
        array(
          'key'     => 'room_bedrooms',
          'value'   => $bedrooms,
          'compare' => ($bedrooms) ? '=' : '!='
        ),
        array(
          'key'     => 'room_bathrooms',
          'value'   => $bathrooms,
          'compare' => ($bathrooms) ? '=' : '!='
        )     
      ),
      'posts_per_page'     => ($posts_per_page) ? $posts_per_page : 6,
      // 'orderby'            => 'rand',
      // 'order'              => 'ASC'
    );
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $bedrooms = field_bedrooms('', $lang);
        $bathrooms = field_bathrooms('', $lang);
        $condition = field_condition('', $lang);    

        $project_id = get_field( 'room_project', get_the_ID());
  
        $developer    = wp_get_post_terms($project_id, 'project_developer');
        $bts_mrt      = wp_get_post_terms($project_id, 'project_location');
        $location_lat = get_field('project_location_lat', $project_id);
        $location_lng = get_field('project_location_lng', $project_id);
        
        $rooms[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-room' ),
          'condition' => get_field('room_condition', get_the_ID()),
          'by'        => $developer[0]->name,
          'info'      => array(
            'bedroom'     => $bedrooms[get_field('room_bedrooms')],
            'bathroom'    => $bathrooms[get_field('room_bathrooms')],
            'area'        => get_field('room_area_sqm'),
            'bts_station' => $bts_mrt[0]->name,
            'location'    => array(
              'lat' => $location_lat,
              'lng' => $location_lng,
            )
          )
        );
  
      endwhile;
      wp_reset_query();
    endif;

    return array(
      'head'        => $head,
      'result'      => $rooms,
      'total'       => $the_query->found_posts,
      'total_pages' => $the_query->max_num_pages
    );

  }

  public function fields($data) {

    $lang = $data['lang'];

    return array(
      'condition'         => render_fields(field_condition('', $lang)),
      'location_bts_mrt'  => render_fields($this->get_terms('project_location', '', $lang)),
      'price_range'       => render_fields(field_price_range(pll_translate_string('Any', $lang), $lang)),
      'bedrooms'          => render_fields(field_bedrooms(pll_translate_string('Any', $lang), $lang)),
      'bathrooms'         => render_fields(field_bathrooms($lang)),
      'year_built'        => render_fields(field_year_built(pll_translate_string('Any', $lang))),
      'developer'         => render_fields($this->get_terms('project_developer', '', $lang)),
      'property_type'     => render_fields($this->get_terms('project_type', '', $lang)),
      'country'           => render_fields($this->get_terms('project_country', '', $lang)),
      'yield'             => render_fields(field_yield(pll_translate_string('Any', $lang), $lang)),
      'order_by'          => render_fields(field_sort_by()),   
      'facility'          => render_fields($this->get_terms('project_facility', '', $lang)),
    );

    
  }
  public function single($data) {

    $currency = $data['currency'];
    $lang     = $data['lang'];
    $slug     = urlencode( $data['slug'] );

    $post = get_page_by_path( $slug, OBJECT, 'room' );

    if ( ! $post ) {
      $post = get_post( $data['slug'] ); 
    }
    

    $facilities = $floor = $available_rooms = array();
    $project_id = get_field('room_project', $post->ID);

    $head = array(
      'title'   => $post->post_title . ' - ' . get_bloginfo('name'),
    );

    $breadcrumb = array(
      array(
        'title' => pll_translate_string('Home', $lang),
        'name'  => ''
      ),
      array(
        'title'  => __('Room', THEME_SLUG),
        'name'   => 'search',
      ),
      array(
        'title'  => $post->post_title,
        'name'   => '',
      )
    );


    $room_facility    = wp_get_post_terms( $post->ID, 'room_facility' );
    $project_facility = wp_get_post_terms( $project_id, 'project_facility' );

    if ($room_facility) {
      foreach ($room_facility as $facility) {
        $facilities[] = array(
          'title' => $facility->name,
          'icon'  => get_field('room_facility_icon', 'room_facility_' . $facility->term_id)
        );
      }
    }

    if ($project_facility) {
      foreach ($project_facility as $facility) {
        $facilities[] = array(
          'title' => $facility->name,
          'icon'  => get_field('project_facility_icon', 'project_facility_' . $facility->term_id)
        );
      }
    }

    $room_type = field_room_type('', $lang);    
    $bedrooms  = field_bedrooms('', $lang);
    $bathrooms = field_bathrooms('', $lang);
    $condition = field_condition('', $lang);    

    $developer    = wp_get_post_terms($project_id, 'project_developer');
    $info = array(
      'price' => array(
        'sell' => price(get_field('room_sell_price', $post->ID), $currency),
        'rent' => price(get_field('room_rent_price', $post->ID), $currency),
      ),
      'unit_no'         => get_field('room_unit_no', $post->ID),
      'year'            => get_field('project_year_built', $project_id),
      'total_units'     => get_field('project_total_units', $project_id),      
      'levels'          => get_field('room_levels', $post->ID),
      'room_type'       => $room_type[get_field('room_type', $post->ID)],
      'area_sqm'        => get_field('room_area_sqm', $post->ID),
      'bedrooms'        => $bedrooms[get_field('room_bedrooms', $post->ID)],
      'bathrooms'       => $bathrooms[get_field('room_bathrooms', $post->ID)],
      'view'            => get_field('room_view', $post->ID),
      'celling'         => '2.75',
      'parking_space'   => get_field('project_parking_space', $project_id),
      'pricing_per_sqm' => get_field('project_pricing_per_sqm', $project_id),       
      'direction'       => get_field('room_direction', $post->ID),
      'developer'       => $developer[0]->name,
      'facility'        => $facilities
    );
  
    $args = array(
      'post_type'          => 'room',
      'posts_per_page'     => 2,
      'post_status'        => 'publish',
      'orderby'            => 'rand',
      'post__not_in'       => array( $post->ID )
      // 'order'              => 'ASC'
    );
    $the_query = new WP_Query( $args );
  
    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();
      
        $project_id = get_field( 'room_project', get_the_ID());
    
        $developer    = wp_get_post_terms($project_id, 'project_developer');
        $bts_mrt      = wp_get_post_terms($project_id, 'project_location');
        
        $other_rooms[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-room' ),
          'condition' => get_field('room_condition', get_the_ID()),
          'by'        => $developer[0]->name,
          'price' => array(
            'sell' => price(get_field('room_sell_price'), $currency),
            'rent' => price(get_field('room_rent_price'), $currency)
          ),
          'info'      => array(
            'type'        => get_field('room_type'),
            'floor'       => get_field('project_floors', $project_id),
            'bedroom'     => get_field('room_bedrooms'),
            'bathroom'    => get_field('room_bathrooms'),
            'area'        => get_field('room_area_sqm'),
            'bts_station' => $bts_mrt[0]->name
          )
        );

      endwhile;
      wp_reset_query();
    endif;
    
    if( has_post_thumbnail($post->ID) ) {
      $gallery[] = [
        'thumbnail' => get_the_post_thumbnail_url( $post->ID, 'thumb-gallery' ),
        'large'     => get_the_post_thumbnail_url( $post->ID, 'large-gallery')
      ];
    }

    if ( $images = get_field( 'room_gallery', $post->ID ) ) {
      foreach( $images as $image ):
  
        $gallery[] = array(
          'thumbnail' => wp_get_attachment_image_url( $image['ID'], 'thumb-gallery'),
          'large'     => wp_get_attachment_image_url( $image['ID'], 'large-gallery')
        );
  
      endforeach;
    }

    if( have_rows('room_floor_item', $post->ID) ): 
      while( have_rows('room_floor_item', $post->ID) ): the_row(); 
        $floor[] = array(
          'title'        => get_sub_field('title'),
          'image_url'    => wp_get_attachment_image_url(get_sub_field('image'), 'large'),
        );        
      endwhile; 
    endif;

    $location_lat = get_field('project_location_lat', $project_id);
    $location_lng = get_field('project_location_lng', $project_id);

    $page = array(
      'id'              => $post->ID,
      'slug'            => $post->post_name,
      'status'          => get_post_status($post->ID),
      'title'           => $post->post_title,
      'about'    => array(
        'title'     => 'About',
        'sub_title' => 'the room',
        'content'   => $post->post_content
      ),
      'info'            => $info,
      'location'        => array(
        'title'     => 'Location & Surrounding',
        'sub_title' => 'highlights',
        'lat'       => $location_lat,
        'lng'       => $location_lng,
      ),
      'floor'           => array(
        'title'     => 'Building floor',
        'sub_title' => 'layout',
        'items'     => $floor
      ),
      'gallery'     => $gallery,
      'youtube_id'  =>  get_youtube_video_ID(get_field('room_video', $post->ID, false)),
      'other_rooms'  => array(
        'title'     => 'You may like',
        'sub_title' => 'other rooms',
        'items'     => $other_rooms,
      ),
      'market_stat'     => array(
        'title'     => 'Market stat',
        'sub_title' => 'For',
        'items'   => array(
          array(
            'title' => __('Current asking price per sqm.', THEME_SLUG ),
            'value' => get_field('room_stat_1', $post->ID)
          ),
          array(
            'title' => __('Asking price change from last year', THEME_SLUG ),
            'value' => get_field('room_stat_2', $post->ID)
          ),
          array(
            'title' => __('Average rental price per sq.m.', THEME_SLUG ),
            'value' => get_field('room_stat_3', $post->ID)
          ),
          array(
            'title' => __('Rent price change from last year', THEME_SLUG ),
            'value' => get_field('room_stat_5', $post->ID)
          ),
          array(
            'title' => __('Achievable gross rental yield', THEME_SLUG ),
            'value' => get_field('room_stat_4', $post->ID)
          ),
        )
      ),
      'head'            => $head,
      'breadcrumb'      => $breadcrumb,
      // 'related'    => array(
      //   'title'     => 'Related',
      //   'sub_title' => 'Articles',        
      //   'itmes'     => $related
      // )
    );
  
    return $page;
  
  }
  public function get_terms($name = '', $args = array(), $lang = 'th') {

    $terms = get_terms($name, $args);

    if ( 'project_facility' != $name ) $fields[''] = pll_translate_string('Any', $lang);
    
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      foreach ( $terms as $term ) {
        $fields[$term->slug] = $term->name;
      }
    }
  
    return $fields;
  
  }
}
Mimo_Room_API::get_instance();