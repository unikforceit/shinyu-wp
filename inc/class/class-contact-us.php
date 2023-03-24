<?php

class Mimo_Contact {

  protected static $instance = null;

  private $line_api;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Contact();
    }
    return self::$instance;

  }

	public function __construct() {

    $this->hooks();
    $this->line_api = 'https://notify-api.line.me/api/notify';

	}

	public function hooks() {

    add_action( 'init', array( $this, 'register_post_type' ) );


    add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );
    
    add_action( 'acf/init', array( $this, 'setting' ) );
    add_action( 'acf/init', array( $this, 'settings_fields' ) );

    add_filter( 'manage_contact_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_contact_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );
	}

	public function register_post_type(){
		$labels = array(
			'name' => __('Contact', THEME_SLUG),
			'menu_name' => __('Contact', THEME_SLUG),
			'all_items' => __('All Contact', THEME_SLUG),
			'singular_name' => __('Contact', THEME_SLUG),
			'add_new' => __('Add Contact', THEME_SLUG),
			'add_new_item' => __('Add Contact', THEME_SLUG),
			'edit_item' => __('Edit Contact', THEME_SLUG),
			'new_item' => __('Add Contact', THEME_SLUG),
			'view_item' => __('View Contact', THEME_SLUG),
			'search_items' => __('Search Contact', THEME_SLUG),
			'not_found' => __('No Contact found.', THEME_SLUG),
			'not_found_in_trash' => __('No Contact found.', THEME_SLUG),
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

		register_post_type( 'contact', $args );

	}

  public function settings_fields() {

    $prefix = 'contact_detail_';



    $prefix = 'contact_';

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
            'value' => 'contact_setting',
          ),
        ),
      ),
    ));
  }

  public function setting() {
  
    // add sub page
    acf_add_options_sub_page(array(
      'page_title' 	=> __( 'Contact Settings', THEME_SLUG ),
      'menu_title' 	=> __( 'Settings', THEME_SLUG ),
      'menu_slug' 	=> 'contact_setting',
      'parent_slug' => 'edit.php?post_type=contact',
    ));
    
  }

  public function post_states( $post_states, $post ) {

    if ( get_field('contact_page', 'option' ) == $post->ID && 'page' == get_post_type( $post->ID ) ) {
      $post_states[] = __( 'Contact Us Page', THEME_SLUG );
    }

    return $post_states;

  }

  public function columns( $columns ) {

    unset( $columns['date'] );

    $columns['title'] = __( 'Name', THEME_SLUG );
    $columns['phone'] = __( 'Phone', THEME_SLUG );
    $columns['email'] = __( 'Email', THEME_SLUG );
    $columns['subject'] = __( 'Subject', THEME_SLUG );
    $columns['message'] = __( 'Message', THEME_SLUG );
    $columns['date'] = __( 'Date');

    return $columns;

  }

  public function columns_display( $column, $post_id ) {

    switch ( $column ) {

      case 'phone' :
        echo get_post_meta( $post_id, 'contact_phone', true );
      break;

      case 'email' :
        echo get_post_meta( $post_id, 'contact_email', true );
      break;

      case 'subject' :
        echo get_post_meta( $post_id, 'contact_subject', true );
      break;

      case 'message' :
        echo get_post_meta( $post_id, 'contact_message', true );
      break;

    }

  }

}

Mimo_Contact::get_instance();
