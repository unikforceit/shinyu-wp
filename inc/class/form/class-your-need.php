<?php

class Mimo_Form_Your_Need {

  protected static $instance = null;

  private $line_api;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Form_Your_Need();
    }
    return self::$instance;

  }

	public function __construct() {

    $this->hooks();
    $this->line_api = 'https://notify-api.line.me/api/notify';

	}

	public function hooks() {

    add_action( 'init', array( $this, 'register_post_type' ) );
    
    add_action( 'acf/init', array( $this, 'setting' ) );
    add_action( 'acf/init', array( $this, 'settings_fields' ) );

    add_filter( 'manage_request_posts_columns', array( $this, 'request_columns' ) );
    add_action( 'manage_request_posts_custom_column', array( $this, 'request_columns_display' ), 10, 2  );
	}

	public function register_post_type(){
		$labels = array(
			'name' => __('Request View', THEME_SLUG),
			'menu_name' => __('Request View', THEME_SLUG),
			'all_items' => __('All Request', THEME_SLUG),
			'singular_name' => __('Request', THEME_SLUG),
			'add_new' => __('Add Request', THEME_SLUG),
			'add_new_item' => __('Add Request', THEME_SLUG),
			'edit_item' => __('Edit Request', THEME_SLUG),
			'new_item' => __('Add Request', THEME_SLUG),
			'view_item' => __('View Request', THEME_SLUG),
			'search_items' => __('Search Request', THEME_SLUG),
			'not_found' => __('No Request found.', THEME_SLUG),
			'not_found_in_trash' => __('No Request found.', THEME_SLUG),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'query_var' => false,
      'capability_type' => 'post',
      'capabilities' => array(
        'create_posts' => 'do_not_allow',
        'delete_post'  => 'do_not_allow',
        'delete_posts' => 'do_not_allow',
      ),
			'hierarchical' => false,
			'menu_position' => 57,
			'menu_icon' => 'dashicons-email',
			'supports'  => array( 'title' )
		);

		register_post_type( 'request', $args );

	}

  public function settings_fields() {

    $prefix = 'request_view_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array (
          'key' => $prefix.'recipient',
          'label' => __( 'Email recipient', THEME_SLUG ),
          'name' => $prefix.'recipient',
          'type' => 'textarea',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
        ),
        array (
          'key'   => $prefix.'line_token',
          'label' => __( 'Line token', THEME_SLUG ),
          'name'  => $prefix.'line_token',
          'type'  => 'text',
        )
      ),
      'style' => 'seamless',
      'label_placement' => 'left  ',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'request_view_setting',
          ),
        ),
      ),
    ));

  }

  public function setting() {
  
    // add sub page
    acf_add_options_sub_page(array(
      'page_title' 	=> __( 'Form Settings', THEME_SLUG ),
      'menu_title' 	=> __( 'Settings', THEME_SLUG ),
      'menu_slug' 	=> 'request_view_setting',
      'parent_slug' => 'edit.php?post_type=request',
    ));
    
  }

  public function request_columns( $columns ) {

    unset( $columns['date'] );

    $columns['title'] = __( 'Name', THEME_SLUG );
    $columns['request_from']  = __( 'from', THEME_SLUG );
    $columns['request_phone'] = __( 'Phone', THEME_SLUG );
    $columns['request_email'] = __( 'Email', THEME_SLUG );
    $columns['request_date']  = __( 'Date', THEME_SLUG );

    return $columns;

  }

  public function request_columns_display( $column, $post_id ) {

    switch ( $column ) {

      case 'request_from' :
        $request_id = get_post_meta( $post_id, 'request_id', true );
        echo get_post_type($request_id). ' ' .get_the_title($request_id);
      break;

      case 'request_phone' :
        echo get_post_meta( $post_id, 'request_phone', true );
      break;

      case 'request_email' :
        echo get_post_meta( $post_id, 'request_email', true );
      break;

      case 'request_date' :
        $date = get_post_meta( $post_id, 'request_date', true );
        echo date_i18n( get_option('date_format') . ' ' . get_option('time_format'), strtotime( $date ) );

      break;


    }

  }

}

Mimo_Form_Your_Need::get_instance();
