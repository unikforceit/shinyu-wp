<?php
class Mimo_Service_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Service_API();
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

    register_rest_route( 'sy', '/pages/service/', array(
      'methods' => 'GET',
      'callback' => array( $this , 'callback_api' ),
      'args'     => array( 'lang')
    ) );

  }

  public function callback_api($data) {

    $lang = $data['lang'];

    global $post;
    $post = get_page_by_path( 'service', OBJECT, 'page' );
    $page_id = pll_get_post($post->ID, $lang);

    $head  = $breadcrumb = array();
    
    $post = get_post( $page_id );
  
    $head = array(
      'title'   => $post->post_title . ' - ' . get_bloginfo('name'),
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
        'title' => $post->post_title,
        'name'  => ''
      )
    );

    $overview = array(
      'slug'      => 'overview',
      'content'   => wpautop(get_field('service_overview_content', $page_id)),
      'image_url' => get_the_post_thumbnail_url( $page_id, 'full')
    );

    $buy_sell_rent = array(
      'slug'           => 'buy-sell-rent',
      'title'          => 'Buy / Sell / Rent',
      'sub_title'      => 'Find Everything in one place',
      'content'        => array(
        'buy'            => array(
          'title'       => pll_translate_string('Buy', $lang),
          'description' => wpautop( get_field('service_buy_description', $page_id) )
        ),
        'sell'           => array(
          'title'       => pll_translate_string('Sell', $lang),
          'description' => wpautop( get_field('service_sell_description', $page_id) )
        ),
        'rent'           => array(
          'title'       => pll_translate_string('Rent', $lang),
          'description' => wpautop( get_field('service_rent_description', $page_id) )
        ),
      ),
      'image_url'      => wp_get_attachment_image_url( get_field('service_buy_sell_rent_image', $page_id), 'full'),
      'background_url' => wp_get_attachment_image_url( get_field('service_buy_sell_rent_background', $page_id), 'full')
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
        $project[] = array(
          'id'        => get_the_ID(),
          'slug'      => basename( get_permalink() ),
          'title'     => get_the_title(),
          'excerpt'   => get_short_excerpt(get_the_excerpt(), 100),
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
          'by'        => 'BY AP PROPERTY'
        );
      }
    }
    wp_reset_postdata();

    $investment = array(
      'slug'      => 'investment',
      'title'     => 'Investment',
      'sub_title' => 'in trust real estate',
      'content'   => wpautop(get_field('service_investment_content', $page_id)),
      'project'   => $project
    );

    $interior_design = array(
      'slug'        => 'interior-design',
      'title'       => 'Interior Design',
      'sub_title'   => 'make it your way',
      'content'     => wpautop(get_field('service_interior_design_content', $page_id)),
      'image_url_1' => wp_get_attachment_image_url( get_field('service_interior_design_image_1', $page_id), 'full'),
      'image_url_2' => wp_get_attachment_image_url( get_field('service_interior_design_image_2', $page_id), 'full'),
    );

    $management = array(
      'slug'        => 'management',
      'title'       => 'Manage your property',
      'sub_title'   => 'With professional team',
      'content'     => wpautop(get_field('service_management_content', $page_id)),
      'image_url'   => wp_get_attachment_image_url( get_field('service_management_image', $page_id), 'full'),
    );

    return array(
      'head'           => $head,
      'breadcrumb'     => $breadcrumb,
      'title'          => $post->post_title,
      'page_title'     => 'ONE-STOP-SERVICE',
      'page_sub_title' => 'real estate',
      'content'        => array(
        'overview'        => $overview,
        'buy_sell_rent'   => $buy_sell_rent,
        'investment'      => $investment,
        'interior_design' => $interior_design,      
        'management'      => $management
      ),
      'navigation'     => array( 
        array(
          'slug'  => 'overview',
          'title' => pll_translate_string('Overview', $lang),
        ),
        array(
          'slug'  => 'buy-sell-rent',
          'title' => pll_translate_string('Buy/Sell/Rent', $lang),
        ),
        array(
          'slug'  => 'investment',
          'title' => pll_translate_string('Investment', $lang),
        ),
        array(
          'slug'  => 'interior-design',
          'title' => pll_translate_string('Interior Design', $lang),
        ),
        array(
          'slug'  => 'management',
          'title' => pll_translate_string('Management', $lang),
        )
      )
    );

  }
}

Mimo_Service_API::get_instance();