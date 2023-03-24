<?php
class Mimo_Home_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Home_API();
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

    register_rest_route( 'sy', '/pages/home/', array(
      'methods' => 'GET',
      'callback' => array( $this , 'api' ),
      'args'     => array('lang', 'currency')
    ) );

    register_rest_route('sy', '/pages/home/room/', array(
      'methods' => 'GET',
      'callback' => array($this , 'filter_room_api' ),
      'args'     => array('condition', 'lang', 'currency')
    ) );

  }

  public function filter_room_api($data) {

    $condition = $data['condition'];
    $lang      = $data['lang'];
    $currency  = $data['currency'];
    
    $args = array(
      'post_type'      => array( 'room' ),
      'post_status'    => array( 'publish' ),
      'posts_per_page' => -1,
    );
    
    if ( $condition ) {
      $args['meta_query'] = array(
        array(
          'key'     => 'room_condition',
          'value'   => $condition,
          'compare' => 'LIKE'
        )       
      );
    }

    $query = new WP_Query( $args );

    return $this->room_item($query, $lang);

  }
  public function api($data) {

    $lang = $data['lang'];

    global $post;
    $post = get_page_by_path( 'home', OBJECT, 'page' );
    $page_id = pll_get_post($post->ID, $lang);
    
    $head  = $breadcrumb = array();
    
    $post = get_post( $page_id );

    $head = array(
      'title'   => get_bloginfo('name') . ' - ' . get_bloginfo('description'),
      'meta'    => array(
        'hid' => '',
        'name' => '',
        'content' => ''
      )
    );

    $about = array(
      'content'   => apply_filters('the_content', get_post($page_id)->post_content),
      'image_url' => get_the_post_thumbnail_url( $page_id, 'full')
    );

    $args = array(
      'post_type'      => array( 'promotion' ),
      'post_status'    => array( 'publish' ),
      'posts_per_page' => 3,
    );
    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
        $query->the_post();
        $special_deal[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
        );
      }
    }
    wp_reset_postdata();

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
        $projects[] = array(
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

    if( have_rows('home_menu',$page_id) ): 
      while( have_rows('home_menu',$page_id) ): the_row(); 
        $menus[] = array(
          'title'        => get_sub_field('title'),
          'description'  => get_sub_field('description'),
          'image_url'    => wp_get_attachment_image_url(get_sub_field('image'), 'full'),
          'link'         => get_sub_field('link')
        );        
      endwhile; 
    endif;

    if( have_rows('home_banner',$page_id) ): 
      while( have_rows('home_banner',$page_id) ): the_row(); 
        $banners[] = array(
          'image_url'    => wp_get_attachment_image_url(get_sub_field('image'), 'full'),
          'link'         => get_sub_field('link')
        );        
      endwhile; 
    endif;

    $args = array(
      'post_type'      => array( 'room' ),
      'post_status'    => array( 'publish' ),
      'posts_per_page' => 10,
      'meta_query' => array(
        array(
          'key'     => 'room_condition',
          'value'   => 'sell',
          'compare' => 'LIKE'
        )
      )
    );
    $room_query = new WP_Query( $args );

    $args = array(
      'post_type'      => array( 'testimonial' ),
      'post_status'    => array( 'publish' ),
      'posts_per_page' => 2,
    );
    $query = new WP_Query( $args );

    $args = array(
      'post_type'          => 'news',
      'posts_per_page'     => 4,
      'post_status'        => 'publish',
      // 'orderby'            => 'Date',
      // 'order'              => 'ASC'
    );

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $terms = get_the_terms( get_the_ID(), 'news_cat' );
        unset($categories);
        if ( $terms && ! is_wp_error( $terms ) ) {
          foreach ( $terms as $term ) {
            $categories[] = $term->name;
          }
        }
        $news[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(get_post_field( 'post_name', get_the_ID() )),
          'title'     => html_entity_decode(get_the_title()),
          'excerpt'   => get_short_excerpt( get_the_excerpt(), 110 ),
          'date'      => get_the_date(),
          'category'  => $categories,
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-news' ),
        );
      endwhile;
      wp_reset_postdata();
    endif;

    if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
        $query->the_post();
        $testimonial[] = array(
          'id'           => get_the_ID(),
          'name'         => get_the_title(),
          'description'  => get_field('testimonial_description'),
          'thumbnail'    => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
        );
      }
    }
    wp_reset_query();

    global $post;
    $post = get_page_by_path( 'about-us', OBJECT, 'page' );
    $about_id = pll_get_post($post->ID, $lang);

    $logo = [];
    if ( $images = get_field( 'about_building_owners_logo', $about_id ) ) {
      foreach( $images as $image ):
        $logo[] = wp_get_attachment_image_url( $image['ID'], 'full');
      endforeach;
    }

    $partners = array(
      'title'      => 'Partnership',
      'sub_title'  => 'The best developer',
      'items'      => $logo
    );


    $locations = array();
    $count = 0;

    $terms = get_terms( 'project_location', array(
      'hide_empty' => true,
    ));

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      foreach ( $terms as $term ) {
        if ($count < 10) {
          $locations[] = array(
            'title' =>  $term->name,
            'value' => number_format(rand(10000,90000)),
            'percent' => rand(1,9) * 10
          );
        }
        $count++;
      }
    }


    return array(
      'head'          => $head,
      'title'         => $post->post_title,
      'content'       => array(
        'banners'      => $banners,
        'special_deal' => array(
          'title'     => __('Special Deal', THEME_SLUG),
          'sub_title' => '',          
          'items'     => $special_deal,
        ),
        'statistic' => array(
          'items' => array(
            'customers' => array(
              'title' => 'Years <br/> experiences',
              'count' => get_field('home_state_customer', $page_id)
            ),
            'sqm' => array(
              'title' => 'Total unit sold <br/> and leased',
              'count' => get_field('home_state_total', $page_id)
            ),
            'room' => array(
              'title' => 'Available room <br/> for sale/rent',
              'count' => get_field('home_state_room', $page_id)
            ),
            'project' => array(
              'title' => 'Total projects',
              'count' => get_field('home_state_project', $page_id)
            ),      
          ),
          'description' => 'Transaction data since Shinyu establishment in 2014.'
        ),
        'video'       => array(
          'title'       => get_field('home_video_title', $page_id),
          'sub_title'   => get_field('home_video_sub_title', $page_id),
          'description' => wpautop( get_field('home_video_description', $page_id) ),
          'background'  => wp_get_attachment_image_url( get_field('home_video_cover', $page_id), 'full'),
          'url'         => get_youtube_video_ID(get_field('home_video_url', $page_id)),
        ),
        'project'     => array(
          'title'     => 'Pre-sale',
          'sub_title' => 'Project',
          'items'     => $projects,
        ),
        'menus'       => $menus,
        'room'      => array(
          'title'     => __('Hot deal', THEME_SLUG),
          'sub_title' => __('For', THEME_SLUG),
          'items'     => $this->room_item($room_query, $lang),
        ),
        'testimonial'  => array(
          'title'     => __('Customer voices', THEME_SLUG),
          'sub_title' => __('Testimonial', THEME_SLUG),
          'items'     => $testimonial,
        ),
        'news'         => array(
          'title'     => __('Insights', THEME_SLUG),
          'sub_title' => __('And News', THEME_SLUG),
          'items'     => $news,
        ),
        'statistics'  => array(
          'title'     => __('Market', THEME_SLUG),
          'sub_title' => __('statistics', THEME_SLUG),
          'items'     => $locations,
        ),
        'partners' => $partners
      )
    );

  }
  public function room_item($query, $lang = 'th') {

    $rooms = array();

    $bedrooms = field_bedrooms('', $lang);
    $bathrooms = field_bathrooms('', $lang);
    $condition = field_transaction('', $lang);    

    if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
        $query->the_post();
        $developer = wp_get_post_terms( get_field( 'room_project', get_the_ID() ), 'project_developer' );
        $location = wp_get_post_terms( get_field( 'room_project', get_the_ID() ), 'project_location' );
        $rooms[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(basename(get_permalink())),
          'title'     => get_the_title(),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-room' ),
          'condition' => get_field('room_condition'),
          'by'        => $developer ? $developer[0]->name : '-',
          'info'      => array(
            'bedroom'     => $bedrooms[get_field('room_bedrooms')],
            'bathroom'    => $bathrooms[get_field('room_bathrooms')],
            'area'        => get_field('room_area_sqm'),
            'bts_station' => $location ? $location[0]->name : '-',
          )
        );
      }
    }

    wp_reset_postdata();
    
    return $rooms;

  }
}

Mimo_Home_API::get_instance();