<?php
class Mimo_Compare_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Compare_API();
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

    register_rest_route( 'sy', '/compare', array(
      'methods' => 'GET',
      'callback' => array( $this, 'result' ),
      'args'     => array('room', 'lang', 'currency'),
    ));

    register_rest_route( 'sy', '/compare/item', array(
      'methods' => 'GET',
      'callback' => array( $this, 'mini_result' ),
      'args'     => array('room', 'lang', 'currency'),
    ));

    register_rest_route( 'sy', '/compare/facility', array(
      'methods' => 'GET',
      'callback' => array( $this, 'facility' ),
      'args'     => array('lang', 'currency'),
    ));

  }
  public function facility($data) {

    $facilities       = array();

    $terms = get_terms( array(
      'taxonomy' => array('room_facility', 'project_facility'),
      'hide_empty' => false,
    ) );

    if ($terms) {
      foreach ($terms as $term) {
        $facilities[] = array(
          'label'  => $term->name,
          'value'  => $term->slug
        );
      }
    }

    return $facilities;

  }

  public function mini_result($data) {

    $room_ids         = $result = array();

    $rooms            = explode(',', $data['room']);
    $lang             = $data['lang'];

    if ($rooms) {
      foreach ($rooms as $room) {
        $post = get_page_by_path( $room, OBJECT, 'room' );
        $room_ids[] = $post->ID;
      }
    }

    $the_query = new WP_Query( $args );

    $args = array(
      'post_type'          => 'room',
      'post_status'        => 'publish',
      'posts_per_page'     => 3,
      'post__in'           => $room_ids,
      'orderby'            => 'post__in',
      // 'order'              => 'ASC'
    );
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $result[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-room' ),
        );
  
      endwhile;
      wp_reset_postdata();
    endif;

    return $result;

  }

  public function result($data) {

    $room_ids         = $result = array();

    $rooms            = explode(',', $data['slug']);
    $lang             = $data['lang'];
    $currency         = $data['currency'];    

    if ($rooms) {
      foreach ($rooms as $room) {
        $post = get_page_by_path( $room, OBJECT, 'room' );
        $room_ids[] = $post->ID;
      }
    }

    $the_query = new WP_Query( $args );

    $args = array(
      'post_type'          => 'room',
      'post_status'        => 'publish',
      'posts_per_page'     => 3,
      'post__in'           => $room_ids,
      'orderby'            => 'post__in',
      // 'order'              => 'ASC'
    );
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $facilities = $output_facility = $floor = $available_rooms = array();
        $project_id = get_field('room_project', get_the_ID());

        $room_facility    = wp_get_post_terms( get_the_ID(), 'room_facility' );
        $project_facility = wp_get_post_terms( $project_id, 'project_facility' );
    
        if ($room_facility) {
          foreach ($room_facility as $facility) {
            $facilities[] = $facility->slug;
          }
        }
    
        if ($project_facility) {
          foreach ($project_facility as $facility) {
            $facilities[] = $facility->slug;
          }
        }

        $terms = get_terms( array(
          'taxonomy' => array('room_facility', 'project_facility'),
          'hide_empty' => false,
        ) );
    
        if ($terms) {
          foreach ($terms as $term) {
            if( in_array($term->slug, $facilities) ) {
              $output_facility[] = 1;
            }else {
              $output_facility[] = 0;
            }
          }
        }

        $developer    = wp_get_post_terms($project_id, 'project_developer');

        $bts_mrt      = wp_get_post_terms($project_id, 'project_location');

        $info = array(
          'price' => array(
            'sell' => price(get_field('room_sell_price'), $currency),
            'rent' => price(get_field('room_rent_price'), $currency)
          ),
          'unit_no'         => get_field('room_unit_no'),
          'year'            => get_field('project_year_built'),
          'total_units'     => get_field('project_total_units'),      
          'levels'          => get_field('room_levels'),
          'room_type'       => get_field('room_type'),
          'area_sqm'        => get_field('room_area_sqm'),
          'bedrooms'        => get_field('room_bedrooms'),
          'bathrooms'       => get_field('room_bathrooms'),
          'view'            => get_field('room_view'),
          'direction'       => get_field('room_direction'),
          'celling'         => '2.75',
          'parking_space'   => get_field('project_parking_space', $project_id),
          // 'pricing_per_sqm' => get_field('project_pricing_per_sqm', $project_id),  
          'bts_station'     => $bts_mrt[0]->name,
          'developer'       => $developer[0]->name,
        );

        $result[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-room' ),
          'condition' => get_field('room_condition', get_the_ID()),
          'info'      => $info,
          'facility'  => $output_facility
        );
  
      endwhile;
      wp_reset_postdata();
    endif;

    return $result;

  }

}
Mimo_Compare_API::get_instance();