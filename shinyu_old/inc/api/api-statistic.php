<?php
class Mimo_Statistic_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Statistic_API();
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

    register_rest_route( 'sy', '/pages/statistic/', array(
      'methods' => 'GET',
      'callback' => array( $this , 'callback_api' ),
      'args'     => array( 'lang')
    ) );

  }

  public function callback_api($data) {

    $lang = $data['lang'];

    $head = array(
      'title'   => pll_translate_string('Statistic', $lang) . ' - ' . get_bloginfo('name'),
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
        'title' => pll_translate_string('Statistic', $lang),
        'name'  => ''
      )
    );


    $bts = array();
  
    $terms = get_terms('project_location', array(
      'hide_empty' => false,
      'meta_query' => array(
        array(
          'key'       => 'project_location_type',
          'value'     => 'bts',
          'compare'   => '='
        )
      )
    ));

  
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      foreach ( $terms as $term ) {
        $bts[$term->term_id] = $term->name;
      }
    }


    $terms = get_terms('project_location', array(
      'hide_empty' => false,
      'meta_query' => array(
        array(
          'key'       => 'project_location_type',
          'value'     => 'mrt',
          'compare'   => '='
        )
      )
    ));
  

  
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
      foreach ( $terms as $term ) {
        $mrt[$term->term_id] = $term->name;
      }
    }

    return array(
      'head'       => $head,
      'breadcrumb' => $breadcrumb,
      'title'      => pll_translate_string('Statistic', $lang),
      'page_title'     => 'Real estate statistic',
      'page_sub_title' => 'by shinyu realestate',
    );

  }
}

Mimo_Statistic_API::get_instance();