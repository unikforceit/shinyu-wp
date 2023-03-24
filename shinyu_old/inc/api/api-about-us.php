<?php
class Mimo_About_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_About_API();
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

    register_rest_route( 'sy', '/pages/about-us/', array(
      'methods' => 'GET',
      'callback' => array( $this , 'callback_api' ),
      'args'     => array( 'lang')
    ) );

  }

  public function callback_api($data) {

    $lang = $data['lang'];

    global $post;
    $post = get_page_by_path( 'about-us', OBJECT, 'page' );
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
      'slug' => 'overview',
      'content'   => wpautop(get_field('about_overview_content', $page_id)),
      'image_url' => get_the_post_thumbnail_url( $page_id, 'full')
    );

    if( have_rows('about_invest_in_trust_item',$page_id) ): 
      while( have_rows('about_invest_in_trust_item',$page_id) ): the_row(); 
        $content[] = array(
          'icon'        => get_sub_field('icon'),
          'title'       => get_sub_field('title'),
          'description' => get_sub_field('description')
        );        
      endwhile; 
    endif;
  
    $invest_in_trust = array(
      'slug'       => 'invest_in_trust',
      'title'      => 'Shinyu Value',
      'sub_title'  => '',
      'content'    => $content,
      'background' =>  wp_get_attachment_image_url( get_field( 'about_invest_in_trust_background', $page_id ), 'full')
    );

    if( have_rows('about_people_item',$page_id) ): 
      while( have_rows('about_people_item',$page_id) ): the_row(); 
        $items[] = array(
          'name'       => get_sub_field('name'),
          'position'   => get_sub_field('position'),
          'profile'    =>  wp_get_attachment_image_url( get_sub_field( 'profile', $page_id ), 'full')
        );        
      endwhile; 
    endif;

    $people = array(
      'slug'       => 'people',
      'title'      => 'Shinyu Team',
      'sub_title'  => '',
      'content'    => get_field('about_people_content', $page_id),
      'items'      => $items
    );

    if ( $images = get_field( 'about_building_owners_logo', $page_id ) ) {
      foreach( $images as $image ):
        $logo[] = wp_get_attachment_image_url( $image['ID'], 'full');
      endforeach;
    }

    $building_owners = array(
      'slug'       => 'building-owners',
      'title'      => 'Partnership',
      'sub_title'  => 'The best developer',
      'logo'       => $logo
    );
    $logo = [];
    if ( $images = get_field( 'about_partners_logo', $page_id ) ) {
      foreach( $images as $image ):
        $logo[] = wp_get_attachment_image_url( $image['ID'], 'full');
      endforeach;
    }

    $partners = array(
      'slug'       => 'partners',
      'title'      => 'Strategic Partners',
      'sub_title'  => 'Around the wold',
      'logo'       => $logo
    );

    $logo = [];
    if ( $images = get_field( 'about_corporate_logo', $page_id ) ) {
      foreach( $images as $image ):
        $logo[] = wp_get_attachment_image_url( $image['ID'], 'full');
      endforeach;
    }

    $corporate = array(
      'slug'       => 'corporate',
      'title'      => 'Corporate Leasing',
      'sub_title'  => 'Trust on leasing',
      'logo'       => $logo
    );

    return array(
      'head'       => $head,
      'breadcrumb' => $breadcrumb,
      'title'      => $post->post_title,
      'page_title'     => 'shinyu real estate',
      'page_sub_title' => 'invest in trust',
      'content'    => array(
        'overview'         => $overview,
        'invest_in_trust'  => $invest_in_trust,
        'people'           => $people,
        'building_owners'  => $building_owners,
        'partners'         => $partners,
        'corporate'        => $corporate,   
      ),
      'navigation'     => array( 
        array(
          'slug'  => 'overview',
          'title' => pll_translate_string('Overview', $lang),
        ),
        array(
          'slug'  => 'invest_in_trust',
          'title' => pll_translate_string('Shinyu Value', $lang),
        ),
        array(
          'slug'  => 'people',
          'title' => pll_translate_string('Our Team', $lang),
        ),
        array(
          'slug'  => 'building-owners',
          'title' => pll_translate_string('The Developer', $lang),
        ),
        array(
          'slug'  => 'partners',
          'title' => pll_translate_string('Our Partners', $lang),
        )   
      )
    );

  }
}

Mimo_About_API::get_instance();