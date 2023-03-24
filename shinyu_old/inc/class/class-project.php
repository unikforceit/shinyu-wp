<?php

class Mimo_Project {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Project();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    //add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

    add_action( 'save_post', array( $this, 'save' ), 13, 2 );

    add_action( 'init', array( $this, 'register_post_type' ), 0 );
    add_action( 'init', array( $this, 'register_taxonomy' ), 0 );
    add_action( 'acf/init', array( $this, 'fields' ) );

    add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );

    add_filter( 'manage_project_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_project_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );

    add_filter('manage_edit-project_facility_columns', array( $this, 'facility_columns' )); 
    add_filter('manage_project_facility_custom_column', array( $this, 'manage_facility_columns' ), 10, 3);

	}


  public function scripts() {}

	public function register_post_type(){
		$labels = array(
			'name'                  => __('Projects', THEME_SLUG),
			'menu_name'             => __('Projects', THEME_SLUG),
			'all_items'             => __('All Projects', THEME_SLUG),
			'singular_name'         => __('Project', THEME_SLUG),
			'add_new'               => __('Add New', THEME_SLUG),
			'add_new_item'          => __('Add Project', THEME_SLUG),
			'edit_item'             => __('Edit Project', THEME_SLUG),
			'new_item'              => __('Add Project', THEME_SLUG),
			'view_item'             => __('View Project', THEME_SLUG),
			'search_items'          => __('Search Project', THEME_SLUG),
			'not_found'             => __('No Project found.', THEME_SLUG),
			'not_found_in_trash'    => __('No Project found.', THEME_SLUG),
      'parent_item_colon'     => '',
      'view_items'            => __( 'View Project', THEME_SLUG ),
      'featured_image'        => __( 'Featured Image', THEME_SLUG ),
      'set_featured_image'    => __( 'Set featured image', THEME_SLUG ),
      'remove_featured_image' => __( 'Remove featured image', THEME_SLUG ),
      'use_featured_image'    => __( 'Use as featured image', THEME_SLUG ),
      'insert_into_item'      => __( 'Insert into item', THEME_SLUG ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', THEME_SLUG ),
      'items_list'            => __( 'Projects list', THEME_SLUG ),
      'items_list_navigation' => __( 'Projects list navigation', THEME_SLUG ),
      'filter_items_list'     => __( 'Filter items list', THEME_SLUG ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
      'has_archive'        => true,
      'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-building',
			'supports'           => array( 'title', 'editor' )
		);

		register_post_type( 'project', $args );
    
	}
  public function register_taxonomy() {
    
    $labels = array(
      'name'                       => _x( 'Types', 'Location General Name', THEME_SLUG ),
      'singular_name'              => _x( 'Type', 'Location Singular Name', THEME_SLUG ),
      'menu_name'                  => __( 'Type', THEME_SLUG ),
      'all_items'                  => __( 'All Items', THEME_SLUG ),
      'parent_item'                => __( 'Parent Item', THEME_SLUG ),
      'parent_item_colon'          => __( 'Parent Item:', THEME_SLUG ),
      'new_item_name'              => __( 'New Item Name', THEME_SLUG ),
      'add_new_item'               => __( 'Add New Item', THEME_SLUG ),
      'edit_item'                  => __( 'Edit Item', THEME_SLUG ),
      'update_item'                => __( 'Update Item', THEME_SLUG ),
      'view_item'                  => __( 'View Item', THEME_SLUG ),
      'separate_items_with_commas' => __( 'Separate items with commas', THEME_SLUG ),
      'add_or_remove_items'        => __( 'Add or remove items', THEME_SLUG ),
      'choose_from_most_used'      => __( 'Choose from the most used', THEME_SLUG ),
      'popular_items'              => __( 'Popular Items', THEME_SLUG ),
      'search_items'               => __( 'Search Items', THEME_SLUG ),
      'not_found'                  => __( 'Not Found', THEME_SLUG ),
      'no_terms'                   => __( 'No items', THEME_SLUG ),
      'items_list'                 => __( 'Items list', THEME_SLUG ),
      'items_list_navigation'      => __( 'Items list navigation', THEME_SLUG ),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => false,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    );
    register_taxonomy( 'project_type', array( 'project' ), $args );

    $labels = array(
      'name'                       => _x( 'Countries', 'Country General Name', THEME_SLUG ),
      'singular_name'              => _x( 'Country', 'Country Singular Name', THEME_SLUG ),
      'menu_name'                  => __( 'Country', THEME_SLUG ),
      'all_items'                  => __( 'All Items', THEME_SLUG ),
      'parent_item'                => __( 'Parent Item', THEME_SLUG ),
      'parent_item_colon'          => __( 'Parent Item:', THEME_SLUG ),
      'new_item_name'              => __( 'New Item Name', THEME_SLUG ),
      'add_new_item'               => __( 'Add New Item', THEME_SLUG ),
      'edit_item'                  => __( 'Edit Item', THEME_SLUG ),
      'update_item'                => __( 'Update Item', THEME_SLUG ),
      'view_item'                  => __( 'View Item', THEME_SLUG ),
      'separate_items_with_commas' => __( 'Separate items with commas', THEME_SLUG ),
      'add_or_remove_items'        => __( 'Add or remove items', THEME_SLUG ),
      'choose_from_most_used'      => __( 'Choose from the most used', THEME_SLUG ),
      'popular_items'              => __( 'Popular Items', THEME_SLUG ),
      'search_items'               => __( 'Search Items', THEME_SLUG ),
      'not_found'                  => __( 'Not Found', THEME_SLUG ),
      'no_terms'                   => __( 'No items', THEME_SLUG ),
      'items_list'                 => __( 'Items list', THEME_SLUG ),
      'items_list_navigation'      => __( 'Items list navigation', THEME_SLUG ),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    );
    register_taxonomy( 'project_country', array( 'project' ), $args );
    
    $labels = array(
      'name'                       => _x( 'Developers', 'Developer General Name', THEME_SLUG ),
      'singular_name'              => _x( 'Developer', 'Developer Singular Name', THEME_SLUG ),
      'menu_name'                  => __( 'Developer', THEME_SLUG ),
      'all_items'                  => __( 'All Items', THEME_SLUG ),
      'parent_item'                => __( 'Parent Item', THEME_SLUG ),
      'parent_item_colon'          => __( 'Parent Item:', THEME_SLUG ),
      'new_item_name'              => __( 'New Item Name', THEME_SLUG ),
      'add_new_item'               => __( 'Add New Item', THEME_SLUG ),
      'edit_item'                  => __( 'Edit Item', THEME_SLUG ),
      'update_item'                => __( 'Update Item', THEME_SLUG ),
      'view_item'                  => __( 'View Item', THEME_SLUG ),
      'separate_items_with_commas' => __( 'Separate items with commas', THEME_SLUG ),
      'add_or_remove_items'        => __( 'Add or remove items', THEME_SLUG ),
      'choose_from_most_used'      => __( 'Choose from the most used', THEME_SLUG ),
      'popular_items'              => __( 'Popular Items', THEME_SLUG ),
      'search_items'               => __( 'Search Items', THEME_SLUG ),
      'not_found'                  => __( 'Not Found', THEME_SLUG ),
      'no_terms'                   => __( 'No items', THEME_SLUG ),
      'items_list'                 => __( 'Items list', THEME_SLUG ),
      'items_list_navigation'      => __( 'Items list navigation', THEME_SLUG ),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => false,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    );
    register_taxonomy( 'project_developer', array( 'project' ), $args );

    $labels = array(
      'name'                       => _x( 'Locations', 'Location General Name', THEME_SLUG ),
      'singular_name'              => _x( 'Location', 'Location Singular Name', THEME_SLUG ),
      'menu_name'                  => __( 'Location', THEME_SLUG ),
      'all_items'                  => __( 'All Items', THEME_SLUG ),
      'parent_item'                => __( 'Parent Item', THEME_SLUG ),
      'parent_item_colon'          => __( 'Parent Item:', THEME_SLUG ),
      'new_item_name'              => __( 'New Item Name', THEME_SLUG ),
      'add_new_item'               => __( 'Add New Item', THEME_SLUG ),
      'edit_item'                  => __( 'Edit Item', THEME_SLUG ),
      'update_item'                => __( 'Update Item', THEME_SLUG ),
      'view_item'                  => __( 'View Item', THEME_SLUG ),
      'separate_items_with_commas' => __( 'Separate items with commas', THEME_SLUG ),
      'add_or_remove_items'        => __( 'Add or remove items', THEME_SLUG ),
      'choose_from_most_used'      => __( 'Choose from the most used', THEME_SLUG ),
      'popular_items'              => __( 'Popular Items', THEME_SLUG ),
      'search_items'               => __( 'Search Items', THEME_SLUG ),
      'not_found'                  => __( 'Not Found', THEME_SLUG ),
      'no_terms'                   => __( 'No items', THEME_SLUG ),
      'items_list'                 => __( 'Items list', THEME_SLUG ),
      'items_list_navigation'      => __( 'Items list navigation', THEME_SLUG ),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => false,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    );
    register_taxonomy( 'project_location', array( 'project' ), $args );

    $labels = array(
      'name'                       => _x( 'Facilities', 'Facility General Name', THEME_SLUG ),
      'singular_name'              => _x( 'Facility', 'Facility Singular Name', THEME_SLUG ),
      'menu_name'                  => __( 'Facility', THEME_SLUG ),
      'all_items'                  => __( 'All Items', THEME_SLUG ),
      'parent_item'                => __( 'Parent Item', THEME_SLUG ),
      'parent_item_colon'          => __( 'Parent Item:', THEME_SLUG ),
      'new_item_name'              => __( 'New Item Name', THEME_SLUG ),
      'add_new_item'               => __( 'Add New Item', THEME_SLUG ),
      'edit_item'                  => __( 'Edit Item', THEME_SLUG ),
      'update_item'                => __( 'Update Item', THEME_SLUG ),
      'view_item'                  => __( 'View Item', THEME_SLUG ),
      'separate_items_with_commas' => __( 'Separate items with commas', THEME_SLUG ),
      'add_or_remove_items'        => __( 'Add or remove items', THEME_SLUG ),
      'choose_from_most_used'      => __( 'Choose from the most used', THEME_SLUG ),
      'popular_items'              => __( 'Popular Items', THEME_SLUG ),
      'search_items'               => __( 'Search Items', THEME_SLUG ),
      'not_found'                  => __( 'Not Found', THEME_SLUG ),
      'no_terms'                   => __( 'No items', THEME_SLUG ),
      'items_list'                 => __( 'Items list', THEME_SLUG ),
      'items_list_navigation'      => __( 'Items list navigation', THEME_SLUG ),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => false,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    );
    register_taxonomy( 'project_facility', array( 'project' ), $args );

  }
	public function fields() {

		$prefix = 'project_';

    $choice = array();

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix . 'general',
          'label' => __( 'General', THEME_SLUG ),
          'name' => $prefix . 'general',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'recommend',
          'label' => __('Recommend project', THEME_SLUG ),
          'name' => $prefix . 'recommend',
          'type' => 'true_false',
          'instructions' => '',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
        ),
        array(
          'key' => $prefix.'developer',
          'label' => __( 'Developer', THEME_SLUG ),
          'name' => $prefix.'developer',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'taxonomy' => 'project_developer',
          'field_type' => 'select',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 0,
          'allow_null' => 0,
          'wrapper' => array( 'width' => 100 )
        ),
        array(
          'key' => $prefix.'type',
          'label' => __( 'Project Type', THEME_SLUG ),
          'name' => $prefix.'type',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'taxonomy' => 'project_type',
          'field_type' => 'radio',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 0,
          'allow_null' => 0,
          'wrapper' => array( 'width' => 50 )
        ),
        array(
          'key' => $prefix.'country',
          'label' => __( 'Country', THEME_SLUG ),
          'name' => $prefix.'country',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'taxonomy' => 'project_country',
          'field_type' => 'radio',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 0,
          'allow_null' => 0,
          'wrapper' => array( 'width' => 50 )
        ),
        array(
          'key' => $prefix.'location_title',
          'label' => __( 'Location', THEME_SLUG ),
          'name' => $prefix.'location_title',
          'type' => 'title',
        ),
        array(
          'key' => $prefix.'location_bts',
          'label' => __( 'BTS', THEME_SLUG ),
          'name' => $prefix.'location_bts',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_bts(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 25 )
        ),
        array(
          'key' => $prefix.'location_mrt',
          'label' => __( 'MRT', THEME_SLUG ),
          'name' => $prefix.'location_mrt',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_mrt(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 25 )
        ),        
        array(
          'key' => $prefix.'location_lat ',
          'label' => __( 'Latitude', THEME_SLUG ),
          'name' => $prefix.'location_lat',
          'type' => 'text',
          'wrapper' => array( 'width' => 25 )
        ),
        array(
          'key' => $prefix.'location_lng ',
          'label' => __( 'Longitude', THEME_SLUG ),
          'name' => $prefix.'location_lng',
          'type' => 'text',
          'wrapper' => array( 'width' => 25 )
        ),        
        array(
          'key' => $prefix . 'year_built',
          'label' => __('Year Built', THEME_SLUG ),
          'name' => $prefix . 'year_built',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_year_built(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix . 'area',
          'label' => __('Area', THEME_SLUG ),
          'name' => $prefix . 'area',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),        
        array(
          'key' => $prefix . 'total_units',
          'label' => __('Total Units', THEME_SLUG ),
          'name' => $prefix . 'total_units',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix . 'towers',
          'label' => __('Towers', THEME_SLUG ),
          'name' => $prefix . 'towers',
          'type' => 'text',
          'default_value' => '1',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),        
        array(
          'key' => $prefix . 'floors',
          'label' => __('Floors', THEME_SLUG ),
          'name' => $prefix . 'floors',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix . 'room_type',
          'label' => __('Room type', THEME_SLUG ),
          'name' => $prefix . 'room_type',
          'type' => 'text',
          'default_value' => '1',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix . 'pricing_per_sqm',
          'label' => __('Pricing per SQM', THEME_SLUG ),
          'name' => $prefix . 'pricing_per_sqm',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix . 'est_rental_price',
          'label' => __('Est. Rental price', THEME_SLUG ),
          'name' => $prefix . 'est_rental_price',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix . 'parking_space',
          'label' => __('Parking Space', THEME_SLUG ),
          'name' => $prefix . 'parking_space',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix.'facility',
          'label' => __( 'Facility', THEME_SLUG ),
          'name' => $prefix.'facility',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'taxonomy' => 'project_facility',
          'field_type' => 'checkbox',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 1,
          'allow_null' => 0,
          'layout' => 'horizontal',
          // 'wrapper' => array( 'width' => 33.3333 )
        ),
        array(
          'key' => $prefix . 'image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => $prefix . 'image',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'logo',
          'label' => __( 'Project logo', THEME_SLUG ),
          'name' => $prefix.'logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
          'instructions' => 'Reccomment image size 300px X 300px',
        ),
        array (
          'key' => $prefix.'cover',
          'label' => __( 'Cover', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
          'instructions' => 'Reccomment image size 810px X 580px',
        ),
        array (
          'key' => $prefix . 'gallery',
          'label' => __('Gallery', THEME_SLUG ),
          'name' => $prefix . 'gallery',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
          // 'instructions' => '600px X 600px',
        ),
        array(
          'key' => $prefix . 'video_tab',
          'label' => __( 'Video', THEME_SLUG ),
          'name' => $prefix . 'video_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'video',
          'label' => '',
          'name' => $prefix.'video',
          'type' => 'oembed',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'width' => '800',
          'height' => '600',
        ),
        array(
          'key' => $prefix . 'floor',
          'label' => __( 'Floor', THEME_SLUG ),
          'name' => $prefix . 'floor',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'floor_item',
          'label' => '',
          'name' => $prefix.'floor_item',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Floor', THEME_SLUG ),
          'sub_fields' => array (
            array (
              'key'           => $prefix . 'floor_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
            ),
            array (
              'key'           => $prefix . 'floor_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'meduim',
              'library'       => 'all',
            ),
          ),
        ),
        array(
          'key' => $prefix . 'stat',
          'label' => __( 'Market Stat', THEME_SLUG ),
          'name' => $prefix . 'stat',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'stat_1',
          'label' => __('Current asking price per sqm.', THEME_SLUG ),
          'name' => $prefix . 'stat_1',
          'type' => 'text',
        ),
        array(
          'key' => $prefix . 'stat_2',
          'label' => __('Asking price change from last quarter', THEME_SLUG ),
          'name' => $prefix . 'stat_2',
          'type' => 'text',
        ),
        array(
          'key' => $prefix . 'stat_3',
          'label' => __('Asking price chang from last year', THEME_SLUG ),
          'name' => $prefix . 'stat_3',
          'type' => 'text',
        ),
        array(
          'key' => $prefix . 'stat_4',
          'label' => __('Achievable gross rental yield', THEME_SLUG ),
          'name' => $prefix . 'stat_4',
          'type' => 'text',
        ),
        array(
          'key' => $prefix . 'stat_5',
          'label' => __('Rent price change from last year', THEME_SLUG ),
          'name' => $prefix . 'stat_5',
          'type' => 'text',
        ),
        // array(
        //   'key' => $prefix . 'room',
        //   'label' => __( 'Room', THEME_SLUG ),
        //   'name' => $prefix . 'room',
        //   'type' => 'tab',
        //   'placement' => 'top',
        //   'endpoint' => 0,
        // ),
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'project',
          ),
        ),
      ),
    ));

    $prefix = 'project_location_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix . 'type',
          'label' => __('Type', THEME_SLUG ),
          'name' => $prefix . 'type',
          'type' => 'radio',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => array(
            'bts' => 'BTS',
            'mrt' => 'MRT'
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
        array(
          'key' => $prefix . 'price_for_sale',
          'label' => __('Price for Sale', THEME_SLUG ),
          'name' => $prefix . 'price_for_sale',
          'type' => 'number',
        ),
        array(
          'key' => $prefix . 'price_for_rent',
          'label' => __('Price for Rent', THEME_SLUG ),
          'name' => $prefix . 'price_for_rent',
          'type' => 'number',
        ),
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'taxonomy',
            'operator' => '==',
            'value' => 'project_location',
          ),
        ),
      ),
    ));

    $prefix = 'project_facility_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => '',
      'fields' => array (
        array(
          'key' => $prefix . 'icon',
          'label' => __('Icon', THEME_SLUG ),
          'name' => $prefix . 'icon',
          'type' => 'text',
          'wrapper' => array('class' => 'shinyu-icon'),
        ),
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'taxonomy',
            'operator' => '==',
            'value' => 'project_facility',
          ),
        ),
      ),
    ));
    
  }

  public function post_states( $post_states, $post ) {

    if ( get_field('project_recommend', $post->ID == 1) && 'project' == get_post_type( $post->ID ) ) {
      $post_states[] = __( 'Recommend project', THEME_SLUG );
    }

    return $post_states;

  }
  public function columns( $columns ) {

    unset( $columns['title'] );
    unset( $columns['date'] );
    unset( $columns['taxonomy-project_type'] );
    unset( $columns['taxonomy-project_country'] );
    unset( $columns['taxonomy-project_developer'] );
    unset( $columns['taxonomy-project_location'] );

    $columns['mimo_thumbnail']               = '<span class="dashicons-format-image"></span>';
    $columns['title']                        = __( 'Name', THEME_SLUG );
    $columns['taxonomy-project_type']        = __( 'Type', THEME_SLUG );
    $columns['taxonomy-project_country']     = __( 'Country', THEME_SLUG );
    $columns['taxonomy-project_developer']   = __( 'Developer', THEME_SLUG );
    $columns['taxonomy-project_location']    = __( 'Location (BTS/MRT)', THEME_SLUG );
    $columns['date']                         = __( 'Date', THEME_SLUG );

    return $columns;

  }

  public function columns_display( $column, $post_id ) {

    switch ( $column ) {
      case 'mimo_thumbnail' :
        if ( has_post_thumbnail($post_id ) ) {
          echo '<a href="'. get_edit_post_link( $post_id ) .'">' . get_the_post_thumbnail( $post_id, 'thumbnail' ) . '</a>';
        }else{}
      break;
    }
  }

  public function facility_columns($columns) {
    $new_columns = array(
      'cb'                 => '<input type="checkbox" />',
      'name'               => __('Name'),
      'facility_icon'      => __('Icon'),
      'posts'              => __('Count'),
    );
    return $new_columns;
  }
  
  public function manage_facility_columns($out, $column_name, $term_id) {
    $icon = get_field('project_facility_icon', 'term_'. $term_id); 
  
    switch ($column_name) {
      case 'facility_icon': 
        echo "<i class='".  $icon ."'></i>" ;
        break;
      default:
        break;
    }
    return $out;
  }

  public function save( $post_id ) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
      return;

    if ( wp_is_post_revision( $post_id ) )
      return;

    if ( 'project' != get_post_type( $post_id ) )
      return;

      $tag = array();

      if( $bts = get_field('project_location_bts', $post_id) ){
        $tag[] = intval($bts);
      }
      if( $mrt = get_field('project_location_mrt', $post_id) ){
        $tag[] = intval($mrt);
      }

      if ( !empty($tag) ) {
        wp_set_post_terms( $post_id, $tag, 'project_location' );
      }
  }

}

Mimo_Project::get_instance();