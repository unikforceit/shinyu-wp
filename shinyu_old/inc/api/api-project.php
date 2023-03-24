<?php
class Mimo_Project_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Project_API();
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

    register_rest_route( 'sy', '/project', array(
      'methods'  => 'GET',
      'args'     => array('lang'),
      'callback' => array( $this, 'archive' )
    ) );

    register_rest_route( 'sy', '/project/single', array(
      'methods'  => 'GET',
      'args'     => array('slug', 'lang', 'currency'),
      'callback' => array($this, 'single')
    ) );
    
    register_rest_route( 'sy', '/project/loadmore', array(
      'methods'  => 'GET',
      'args'     => array('developer_slug', 'page', 'lang'),
      'callback' => array( $this, 'loadmore_project' )
    ) );
    
    register_rest_route( 'sy', '/project/room', array(
      'methods'  => 'GET',
      'args'     => array('project_id', 'page', 'lang', 'currency'),
      'callback' => array( $this, 'loadmore_room' )
    ) );

  }

  public function archive($data) {

    $lang = $data['lang'];

    $projects = array();
    
    $head = array(
      'title'   => __('Project', THEME_SLUG) . ' - ' . get_bloginfo('name'),
      'meta'    => array(
        'hid' => '',
        'name' => '',
        'content' => ''
      )
    );
  
    $breadcrumb = array(
      array(
        'title' => pll_translate_string('Home', $lang),
        'name'  => ''
      ),
      array(
        'title'  => __('Project Development', THEME_SLUG),
        'name'   => '',
      )
    );
    
    $args = array(
      'post_type'      => array( 'project' ),
      'post_status'    => array( 'publish' ),
      'posts_per_page' => -1,
      'meta_query' => array(
        array(
          'key'     => 'project_recommend',
          'value'   => 1,
          'compare' => '='
        )
      )
    );
    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
        $query->the_post();

        $developer = wp_get_post_terms( get_the_ID(), 'project_developer' );
        $recommend[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'excerpt'   => get_short_excerpt(get_the_excerpt(), 100),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
          'logo'      => wp_get_attachment_image_url( get_field('project_logo',  get_the_ID()), 'medium' ),
          'by'        => $developer[0]->name,
        );
      }
    }
    wp_reset_query();

    $developer_slug = $data['developer_slug'];

    $args = array(
      'post_type'          => 'project',
      'posts_per_page'     => 4,
      'post_status'        => 'publish',
      'tax_query'          => array(
        array(
          'taxonomy' => 'project_developer',
          'field'    => 'slug',
          'terms'    => $developer_slug,
          'operator' => ( $developer_slug ) ? "IN" : "NOT IN",
        )
      ),
      // 'orderby'            => 'Date',
      // 'order'              => 'ASC'
    );

    $project_query = new WP_Query( $args );

    if ( $project_query->have_posts() ) :
      while ( $project_query->have_posts() ) : $project_query->the_post();

        $developer = wp_get_post_terms( get_the_ID(), 'project_developer' );
        $projects[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
          'by'        => $developer[0]->name,
        );

      endwhile;
      wp_reset_query();
    endif;

    $developer = array();
    $terms = get_terms('project_developer');
    $developer[''] = __('All Development', THEME_SLUG);
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      foreach ( $terms as $term ) {
        $developer[$term->slug] = $term->name;
      }
    }

    $project = array();

    $description = pll_translate_string('Shinyu has determination to be as a middle-man between customers and worth real estate for both investing and living terms which must pass our strict conditions such as developers’ reputation, location, qualification, price and environment to fulfill customers’ satisfactions.', $lang);

    $pages = array(
      'title'               => __('Project Development', THEME_SLUG),
      'page_title'          => 'Discover our',
      'page_sub_title'      => 'new development',
      'content'             => array(
        'description'       => $description,
        'project_recommend' => $recommend,
        'developer'         => render_fields($developer),
        'project'           => array(
          'items'       => $projects,
          'total'       => $project_query->found_posts,
          'total_pages' => $project_query->max_num_pages
        ),
      ),
      'head'                => $head,
      'breadcrumb'          => $breadcrumb
    );
    
    return $pages;

  }

  public function single($data) {

    $lang = $data['lang'];
    $slug = urlencode( $data['slug'] );

    $post = get_page_by_path( $slug, OBJECT, 'project' );

    $facilities = $floor = $available_projects = array();

    $head = array(
      'title'   => $post->post_title . ' - ' . get_bloginfo('name'),
    );

    $breadcrumb = array(
      array(
        'title' => pll_translate_string('Home', $lang),
        'name'  => ''
      ),
      array(
        'title'  => __('Project', THEME_SLUG),
        'name'   => 'project',
      ),
      array(
        'title'  => $post->post_title,
        'name'   => '',
      )
    );


    $project_facility    = wp_get_post_terms( $post->ID, 'project_facility' );

    if ($project_facility) {
      foreach ($project_facility as $facility) {
        $facilities[] = array(
          'title' => $facility->name,
          'icon'  => get_field('project_facility_icon', 'project_facility_' . $facility->term_id)
        );
      }
    }

    $developer    = wp_get_post_terms($post->ID, 'project_developer');
    $bts_mrt      = wp_get_post_terms($post->ID, 'project_location');

    $info = array(
      'year'             => get_field('project_year_built', $post->ID),
      'area'             => get_field('project_area', $post->ID),
      'total_units'      => get_field('project_total_units', $post->ID),
      'towers'           => get_field('project_towers', $post->ID),
      'room_type'        => get_field('project_room_type', $post->ID),
      'pricing_per_sqm'  => get_field('project_pricing_per_sqm', $post->ID),
      'est_rental_price' => get_field('project_est_rental_price', $post->ID),      
      'parking_space'    => get_field('project_parking_space', $post->ID),
      'bts_station'      => $bts_mrt[0]->name,
      'developer'        => $developer[0]->name,
      'facility'         => $facilities,  
    );
  
    $args = array(
      'post_type'          => 'room',
      'posts_per_page'     => 4,
      'post_status'        => 'publish',
      'orderby'            => 'rand',
      // 'post__not_in'       => array($post->ID),
      'meta_query'         => array(
        array(
          'key'     => 'room_project',
          'value'   => $post->ID,
          'compare' => '=='
        )
      ),
      // 'order'              => 'ASC'
    );
    $room_query = new WP_Query( $args );
  
    if ( $room_query->have_posts() ) :
      while ( $room_query->have_posts() ) : $room_query->the_post();
      
        $project_id = get_field( 'room_project', get_the_ID());
      
        $developer    = wp_get_post_terms($project_id, 'project_developer');
        $bts_mrt      = wp_get_post_terms($project_id, 'project_location');
        
        $available_rooms[] = array(
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

    if ( $images = get_field( 'project_gallery', $post->ID ) ) {
      foreach( $images as $image ):
  
        $gallery[] = array(
          'thumbnail' => wp_get_attachment_image_url( $image['ID'], 'thumb-gallery'),
          'large'     => wp_get_attachment_image_url( $image['ID'], 'large-gallery')
        );
  
      endforeach;
    }

    if( have_rows('project_floor_item', $post->ID) ): 
      while( have_rows('project_floor_item', $post->ID) ): the_row(); 
        $floor[] = array(
          'title'        => get_sub_field('title'),
          'image_url'    => wp_get_attachment_image_url(get_sub_field('image'), 'large'),
        );        
      endwhile; 
    endif;

    $args = array(
      'post_type'          => 'project',
      'posts_per_page'     => 3,
      'post_status'        => 'publish',
      'meta_query'         => array(
        array(
          'key'     => 'project_developer',
          'value'   => $developer[0]->term_id,
          'compare' => '=='
        )
      ),
      // 'orderby'            => 'Date',
      // 'order'              => 'ASC'
    );

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $developer = wp_get_post_terms( get_the_ID(), 'project_developer' );
        $other_project[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-news' ),
          'by'        => html_entity_decode($developer[0]->name),
        );

      endwhile;
      wp_reset_query();
    endif;

    $location_lat = get_field('project_location_lat', $post->ID);
    $location_lng = get_field('project_location_lng', $post->ID);
    $developer_history = wp_strip_all_tags(term_description( $developer[0]->term_id, 'project_developer' ));
    $page = array(
      'id'              => $post->ID,
      'title'           => $post->post_title,
      'about'    => array(
        'title'     => 'About',
        'sub_title' => 'the project',
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
      'gallery'         => $gallery,
      'youtube_id'      =>  get_youtube_video_ID(get_field('project_video', $post->ID, false)),
      'available_rooms' => array(
        'title'       => 'Available Rooms',
        'sub_title'   => '& pre-sell rooms',
        'items'       => $available_rooms,
        'total'       => $room_query->found_posts,
        'total_pages' => $room_query->max_num_pages
      ),
      'market_stat'     => array(
        'title'     => 'Market stat',
        'sub_title' => 'For',
        'items'   => array(
          array(
            'title' => __('Current asking price per sqm.', THEME_SLUG ),
            'value' => get_field('project_stat_1', $post->ID)
          ),
          array(
            'title' => __('Asking price change from last year', THEME_SLUG ),
            'value' => get_field('project_stat_2', $post->ID)
          ),
          array(
            'title' => __('Average rental price per sq.m.', THEME_SLUG ),
            'value' => get_field('project_stat_3', $post->ID)
          ),
          array(
            'title' => __('Rent price change from last year', THEME_SLUG ),
            'value' => get_field('project_stat_5', $post->ID)
          ),
          array(
            'title' => __('Achievable gross rental yield', THEME_SLUG ),
            'value' => get_field('project_stat_4', $post->ID)
          ),
        )
      ),
      'developer' => array(
        'title' => 'Developer',
        'sub_title' => 'history',
        'description' => html_entity_decode($developer_history)
      ),
      'other_project'   => $other_project,
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
  public function loadmore_project($data) {

    $sad = '';

    $developer_slug = $data['developer_slug'];
    
    $args = array(
      'post_type'          => 'project',
      'posts_per_page'     => 4,
      'paged'              => max( 1, $data['page'] ),
      'post_status'        => 'publish',
      'tax_query'          => array(
        array(
          'taxonomy' => 'project_developer',
          'field'    => 'slug',
          'terms'    => $developer_slug,
          'operator' => ( $developer_slug ) ? "IN" : "NOT IN",
        )
      ),
      // 'order'              => 'ASC'
    );

    $the_query = new WP_Query( $args );
  
    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();
      
        $developer = wp_get_post_terms( get_the_ID(), 'project_developer' );
        $projects[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
          'by'        => html_entity_decode($developer[0]->name),
        );

      endwhile;
      wp_reset_query();
    endif;

    return array(
      'items'       => $projects,
      'total'       => $the_query->found_posts,
      'total_pages' => $the_query->max_num_pages
    );

  }
  public function loadmore_room($data) {

    // project_slug

    $args = array(
      'post_type'          => 'room',
      'posts_per_page'     => 4,
      'paged'              => max( 1, $data['page'] ),
      'post_status'        => 'publish'
      // 'order'              => 'ASC'
    );
    
    $the_query = new WP_Query( $args );
  
    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();
      
        $project_id = get_field( 'room_project', get_the_ID());
      
        $developer    = wp_get_post_terms($project_id, 'project_developer');
        $bts_mrt      = wp_get_post_terms($project_id, 'project_location');
        
        $available_rooms[] = array(
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

    return $available_rooms;

  }

}
Mimo_Project_API::get_instance();