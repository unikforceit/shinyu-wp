<?php

class Mimo_Form_Post_Property {

  protected static $instance = null;

  private $line_api;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Form_Post_Property();
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

    add_filter( 'manage_post_property_posts_columns', array( $this, 'post_property_columns' ) );
    add_action( 'manage_post_property_posts_custom_column', array( $this, 'post_property_columns_display' ), 10, 2  );
	}

	public function register_post_type(){
		$labels = array(
			'name' => __('Post Property', THEME_SLUG),
			'menu_name' => __('Post Property', THEME_SLUG),
			'all_items' => __('All Post', THEME_SLUG),
			'singular_name' => __('Post', THEME_SLUG),
			'add_new' => __('Add Post', THEME_SLUG),
			'add_new_item' => __('Add Post', THEME_SLUG),
			'edit_item' => __('Edit Post', THEME_SLUG),
			'new_item' => __('Add Post', THEME_SLUG),
			'view_item' => __('View Post', THEME_SLUG),
			'search_items' => __('Search Post', THEME_SLUG),
			'not_found' => __('No Post found.', THEME_SLUG),
			'not_found_in_trash' => __('No Post found.', THEME_SLUG),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'query_var' => false,
      'capability_type' => 'post',
      // 'capabilities' => array(
      //   'create_posts' => 'do_not_allow',
      //   'delete_post'  => 'do_not_allow',
      //   'delete_posts' => 'do_not_allow',
      // ),
			'hierarchical' => false,
			'menu_position' => 50,
			'menu_icon' => 'dashicons-email',
			'supports'  => array( 'title' )
		);

		register_post_type( 'post_property', $args );

	}

  public function settings_fields() {

    $prefix = 'post_property_';

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
            'value' => 'post_property_setting',
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
      'menu_slug' 	=> 'post_property_setting',
      'parent_slug' => 'edit.php?post_type=post_property',
    ));
    
  }

  public function post_property_columns( $columns ) {

    unset( $columns['date'] );

    $columns['title'] = __( 'Name', THEME_SLUG );
    $columns['post_property_phone'] = __( 'Phone', THEME_SLUG );
    $columns['post_property_email'] = __( 'Email', THEME_SLUG );
    $columns['post_property_for'] = __( 'Property For', THEME_SLUG );
    $columns['post_property_type'] = __( 'Property Type', THEME_SLUG );
    $columns['post_property_size'] = __( 'Property Size', THEME_SLUG );
    $columns['post_property_sell_price'] = __( 'Sell price', THEME_SLUG );
    $columns['post_property_rental_price'] = __( 'Rental price', THEME_SLUG );
    $columns['post_property_additional'] = __( 'Additional Details', THEME_SLUG );
    $columns['post_property_images'] = __( 'Images', THEME_SLUG );

    $columns['post_property_date']  = __( 'Date', THEME_SLUG );

    return $columns;

  }

  public function post_property_columns_display( $column, $post_id ) {

    switch ( $column ) {

      case 'post_property_phone' :
        echo get_post_meta( $post_id, 'post_property_phone', true );
      break;

      case 'post_property_email' :
        echo get_post_meta( $post_id, 'post_property_email', true );
      break;

      case 'post_property_for' :
        echo get_post_meta( $post_id, 'post_property_for', true );
      break;

      case 'post_property_type' :
        echo get_post_meta( $post_id, 'post_property_type', true );
      break;

      case 'post_property_size' :
        echo get_post_meta( $post_id, 'post_property_size', true );
      break;

      case 'post_property_sell_price' :
        echo get_post_meta( $post_id, 'post_property_sell_price', true );
      break;

      case 'post_property_rental_price' :
        echo get_post_meta( $post_id, 'post_property_rental_price', true );
      break;

      case 'post_property_additional' :
        echo get_post_meta( $post_id, 'post_property_additional', true );
      break;
      
      case 'post_property_images' :
        $images =  get_post_meta( $post_id, 'post_property_images', true );
        if( $images ) {
          echo '<ul>';
          foreach ($images as $key => $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            echo '<li><a href="'. $image_url .'" target="_blank">' . get_the_title($image_id) . '</a> <br></li>';
          }
          echo '</ul>';
        }
      break;

      case 'post_property_date' :
        $date = get_post_meta( $post_id, 'post_property_date', true );
        echo date_i18n( get_option('date_format') . ' ' . get_option('time_format'), strtotime( $date ) );

      break;


    }

  }

}

Mimo_Form_Post_Property::get_instance();
