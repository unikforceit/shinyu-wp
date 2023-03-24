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

    // add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );

    add_filter( 'manage_project_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_project_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );

    // add_filter('manage_edit-project_facility_columns', array( $this, 'facility_columns' )); 
    // add_filter('manage_project_facility_custom_column', array( $this, 'manage_facility_columns' ), 10, 3);

    add_filter('manage_edit-project_location_columns', array( $this, 'location_columns' )); 
    add_filter('manage_project_location_custom_column', array( $this, 'manage_location_columns' ), 10, 3);

    add_filter('manage_edit-project_developer_columns', array( $this, 'developer_columns' )); 
    add_filter('manage_project_developer_custom_column', array( $this, 'manage_developer_columns' ), 10, 3);
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

    $labels = [
      'name'                       => __('Tags', THEME_SLUG),
      'singular_name'              => __('Tags', THEME_SLUG),
      'menu_name'                  => __('Tags', THEME_SLUG),
      'all_items'                  => __('All tags', THEME_SLUG),
      'parent_item'                => __('Parent tag', THEME_SLUG),
      'parent_item_colon'          => __('Parent tag:', THEME_SLUG),
      'new_item_name'              => __('New tag', THEME_SLUG),
      'add_new_item'               => __('Add new tag', THEME_SLUG),
      'edit_item'                  => __('Edit tag', THEME_SLUG),
      'update_item'                => __('Update tag', THEME_SLUG),
      'view_item'                  => __('View tag', THEME_SLUG),
    ];

    $args = [
      'labels'         => $labels,
      'hierarchical'   => false,
      // 'rewrite'        => [
      //   'slug'         => 'project/tag',
      //   'with_front'   => false,
      //   'hierarchical' => true,
      // ],
      'public'                     => true,
      'show_ui'                    => true,
      // 'show_admin_column'          => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    ];

    register_taxonomy('project_tag',  ['project'], $args);

    $labels = array(
      'name'                       => __('Types', THEME_SLUG),
      'singular_name'              => __('Type', THEME_SLUG),
      'menu_name'                  => __('Types', THEME_SLUG),
      'all_items'                  => __('All Type', THEME_SLUG),
      'parent_item'                => __('Parent Type', THEME_SLUG),
      'parent_item_colon'          => __('Parent Type:', THEME_SLUG),
      'new_item_name'              => __('New Type', THEME_SLUG),
      'add_new_item'               => __('Add Type', THEME_SLUG),
      'edit_item'                  => __('Edit Type', THEME_SLUG),
      'update_item'                => __('Update Type', THEME_SLUG),
      'view_item'                  => __('View Type', THEME_SLUG),
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
    register_taxonomy( 'project_type', ['project'], $args );

    $labels = array(
      'name'                       => __('Country', THEME_SLUG),
      'singular_name'              => __('Country', THEME_SLUG),
      'menu_name'                  => __('Countries', THEME_SLUG),
      'all_items'                  => __('All Country', THEME_SLUG),
      'parent_item'                => __('Parent Country', THEME_SLUG),
      'parent_item_colon'          => __('Parent Country:', THEME_SLUG),
      'new_item_name'              => __('New Country', THEME_SLUG),
      'add_new_item'               => __('Add Country', THEME_SLUG),
      'edit_item'                  => __('Edit Country', THEME_SLUG),
      'update_item'                => __('Update Country', THEME_SLUG),
      'view_item'                  => __('View Country', THEME_SLUG),
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
    register_taxonomy( 'project_country', ['project'], $args );
    
    $labels = array(
      'name'                       => __('Developer', THEME_SLUG),
      'singular_name'              => __('Country', THEME_SLUG),
      'menu_name'                  => __('Developers', THEME_SLUG),
      'all_items'                  => __('All Developer', THEME_SLUG),
      'parent_item'                => __('Parent Developer', THEME_SLUG),
      'parent_item_colon'          => __('Parent Developer:', THEME_SLUG),
      'new_item_name'              => __('New Developer', THEME_SLUG),
      'add_new_item'               => __('Add Developer', THEME_SLUG),
      'edit_item'                  => __('Edit Developer', THEME_SLUG),
      'update_item'                => __('Update Developer', THEME_SLUG),
      'view_item'                  => __('View Developer', THEME_SLUG),
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
    register_taxonomy( 'project_developer', ['project'], $args );

    $labels = array(
      'name'                       => __('BTS / MRT', THEME_SLUG),
      'singular_name'              => __('BTS / MRT', THEME_SLUG),
      'menu_name'                  => __('BTS / MRT', THEME_SLUG),
      'all_items'                  => __('All BTS / MRT', THEME_SLUG),
      'parent_item'                => __('Parent BTS / MRT', THEME_SLUG),
      'parent_item_colon'          => __('Parent BTS / MRT:', THEME_SLUG),
      'new_item_name'              => __('New BTS / MRT', THEME_SLUG),
      'add_new_item'               => __('Add BTS / MRT', THEME_SLUG),
      'edit_item'                  => __('Edit BTS / MRT', THEME_SLUG),
      'update_item'                => __('Update BTS / MRT', THEME_SLUG),
      'view_item'                  => __('View BTS / MRT', THEME_SLUG),
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
    register_taxonomy( 'project_location', ['project'], $args );

    $labels = array(
      'name'                       => __('Area', THEME_SLUG),
      'singular_name'              => __('Area', THEME_SLUG),
      'menu_name'                  => __('Areas', THEME_SLUG),
      'all_items'                  => __('All Area', THEME_SLUG),
      'parent_item'                => __('Parent Area', THEME_SLUG),
      'parent_item_colon'          => __('Parent Area:', THEME_SLUG),
      'new_item_name'              => __('New Area', THEME_SLUG),
      'add_new_item'               => __('Add Area', THEME_SLUG),
      'edit_item'                  => __('Edit Area', THEME_SLUG),
      'update_item'                => __('Update Area', THEME_SLUG),
      'view_item'                  => __('View Area', THEME_SLUG),
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
    register_taxonomy( 'project_area', ['project'], $args );
  
    $labels = array(
      'name'                       => __('Facility', THEME_SLUG),
      'singular_name'              => __('Facility', THEME_SLUG),
      'menu_name'                  => __('Facilities', THEME_SLUG),
      'all_items'                  => __('All Facility', THEME_SLUG),
      'parent_item'                => __('Parent Facility', THEME_SLUG),
      'parent_item_colon'          => __('Parent Facility:', THEME_SLUG),
      'new_item_name'              => __('New Facility', THEME_SLUG),
      'add_new_item'               => __('Add Facility', THEME_SLUG),
      'edit_item'                  => __('Edit Facility', THEME_SLUG),
      'update_item'                => __('Update Facility', THEME_SLUG),
      'view_item'                  => __('View Facility', THEME_SLUG),
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
    register_taxonomy( 'project_facility', ['project'], $args );

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
          'translations' => 'sync',
        ),
        // array(
        //   'key' => $prefix . 'name_th',
        //   'label' => __( 'Project Name (Thai)', THEME_SLUG ),
        //   'name' => $prefix . 'name_th',
        //   'type' => 'text',
        // ),
        array(
          'key' => $prefix.'tag',
          'label' => __( 'Tags', THEME_SLUG ),
          'name' => $prefix.'tag',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'taxonomy' => 'project_tag',
          'field_type' => 'checkbox',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 1,
          'allow_null' => 0,
          'translations' => 'sync',
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
          'wrapper' => array( 'width' => 100 ),
          'translations' => 'sync',
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
          'wrapper' => array( 'width' => 50 ),
          'translations' => 'sync',
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
          'wrapper' => array( 'width' => 50 ),
          'translations' => 'sync',
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
          'wrapper' => array( 'width' => 25 ),
          'translations' => 'sync',
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
          'wrapper' => array( 'width' => 25 ),
          'translations' => 'sync',
        ),        
        array(
          'key' => $prefix.'location_lat ',
          'label' => __( 'Latitude', THEME_SLUG ),
          'name' => $prefix.'location_lat',
          'type' => 'text',
          'wrapper' => array( 'width' => 25 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix.'location_lng ',
          'label' => __( 'Longitude', THEME_SLUG ),
          'name' => $prefix.'location_lng',
          'type' => 'text',
          'wrapper' => array( 'width' => 25 ),
          'translations' => 'sync',
        ),        
        array(
          'key' => $prefix . 'area',
          'label' => __('Area', THEME_SLUG ),
          'name' => $prefix . 'area',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),        
        array(
          'key' => $prefix . 'towers',
          'label' => 'จำนวนตึก',
          'name' => $prefix . 'towers',
          'type' => 'text',
          'default_value' => '1',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),        
        array(
          'key' => $prefix . 'floors',
          'label' => 'จำนวนชั้น',
          'name' => $prefix . 'floors',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'total_units',
          'label' => 'จำนวนห้องพัก',
          'name' => $prefix . 'total_units',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'room_type',
          'label' => __('ประเภทห้องพักอาศัย', THEME_SLUG ),
          'name' => $prefix . 'room_type',
          'type' => 'text',
          'default_value' => '1',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 100 ),
          'translations' => 'sync',
        ),
        array (
          'key' => $prefix.'room_type_item',
          'label' => '',
          'name' => $prefix.'room_type_item',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'table',
          'button_label' => __( 'Add Room', THEME_SLUG ),
          'sub_fields' => array (
            array (
              'key'           => $prefix . 'room_type_title',
              'label'         => __('Room type', THEME_SLUG ),
              'name'          => 'label',
              'type'          => 'text',
            ),
            array (
              'key'           => $prefix . 'room_type_area',
              'label'         => __('Area', THEME_SLUG ),
              'name'          => 'value',
              'type'          => 'text',
              'append'        => 'SQM'
            ),
          ),
        ),
        array(
          'key' => $prefix . 'parking_space',
          'label' => __('จำนวนที่จอดรถ', THEME_SLUG ),
          'name' => $prefix . 'parking_space',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'year_sell',
          'label' => 'ปีที่เริ่มขาย',
          'name' => $prefix . 'year_sell',
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
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'year_built',
          'label' => 'ปีที่สร้างเสร็จ',
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
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'start_price',
          'label' => 'ราคาเริ่มต้น',
          'name' => $prefix . 'start_price',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
          'append' => 'บาท',
        ),
        array(
          'key' => $prefix . 'pricing_per_sqm',
          'label' => 'ราคาเริ่มต้นต่อตารางเมตร',
          'name' => $prefix . 'pricing_per_sqm',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
          'append' => 'บาทต่อตารางเมตร',
        ),

        array(
          'key' => $prefix . 'fee',
          'label' => 'ค่าธรรมเนียมส่วนกลาง',
          'name' => $prefix . 'fee',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
          'append' => 'บาท',
        ),
        
        array(
          'key' => $prefix . 'est_rental_price',
          'label' => __('Est. Rental price', THEME_SLUG ),
          'name' => $prefix . 'est_rental_price',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
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
          // 'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix.'area2',
          'label' => __( 'Area', THEME_SLUG ),
          'name' => $prefix.'area2',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'taxonomy' => 'project_area',
          'field_type' => 'checkbox',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 1,
          'allow_null' => 0,
          'layout' => 'horizontal',
          // 'wrapper' => array( 'width' => 33.3333 ),
          'translations' => 'sync',
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
          'translations' => 'sync',
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
          'translations' => 'sync',
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
          'translations' => 'sync',
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
          'translations' => 'sync',
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
          'key' => $prefix . 'stat_tab',
          'label' => __( 'Market Stat', THEME_SLUG ),
          'name' => $prefix . 'stat_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        [
          'key' => $prefix.'stat',
          'label' => '',
          'name' => $prefix.'stat',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'table',
          'button_label' => __( 'Add Stat', THEME_SLUG ),
          'translations' => 'sync',
          'sub_fields' => [
            [
              'key'           => $prefix . 'stat_year',
              'label'         => 'ปี',
              'name'          => 'year',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'stat_sell_price',
              'label'         => 'ขาย',
              'name'          => 'sell_price',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'stat_rent_price',
              'label'         => 'เช่า',
              'name'          => 'rent_price',
              'type'          => 'text',
            ],
            // [
            //   'key'           => $prefix . 'stat_price_sell_title',
            //   'label'         => 'ขาย',
            //   'name'          => $prefix . 'stat_price_sell_title',
            //   'type'          => 'title',
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_sell_q1',
            //   'label'         => __('Q1', THEME_SLUG ),
            //   'name'          => 'sell_q1',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_sell_q2',
            //   'label'         => __('Q2', THEME_SLUG ),
            //   'name'          => 'sell_q2',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_sell_q3',
            //   'label'         => __('Q3', THEME_SLUG ),
            //   'name'          => 'sell_q3',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_sell_q4',
            //   'label'         => __('Q4', THEME_SLUG ),
            //   'name'          => 'sell_q4',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_rent_title',
            //   'label'         => 'เช่า',
            //   'name'          => $prefix . 'stat_price_rent_title',
            //   'type'          => 'title',
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_rent_q1',
            //   'label'         => __('Q1', THEME_SLUG ),
            //   'name'          => 'rent_q1',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_rent_q2',
            //   'label'         => __('Q2', THEME_SLUG ),
            //   'name'          => 'rent_q2',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_rent_q3',
            //   'label'         => __('Q3', THEME_SLUG ),
            //   'name'          => 'rent_q3',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
            // [
            //   'key'           => $prefix . 'stat_price_rent_q4',
            //   'label'         => __('Q4', THEME_SLUG ),
            //   'name'          => 'rent_q4',
            //   'type'          => 'text',
            //   'wrapper'       => ['width' => 25]
            // ],
          ],
        ],
        // array(
        //   'key' => $prefix . 'stat_1',
        //   'label' => __('Current asking price per sqm.', THEME_SLUG ),
        //   'name' => $prefix . 'stat_1',
        //   'type' => 'text',
        //   'translations' => 'sync',
        // ),
        // array(
        //   'key' => $prefix . 'stat_2',
        //   'label' => __('Asking price change from last quarter', THEME_SLUG ),
        //   'name' => $prefix . 'stat_2',
        //   'type' => 'text',
        //   'translations' => 'sync',
        // ),
        // array(
        //   'key' => $prefix . 'stat_3',
        //   'label' => __('Asking price chang from last year', THEME_SLUG ),
        //   'name' => $prefix . 'stat_3',
        //   'type' => 'text',
        //   'translations' => 'sync',
        // ),
        // array(
        //   'key' => $prefix . 'stat_4',
        //   'label' => __('Achievable gross rental yield', THEME_SLUG ),
        //   'name' => $prefix . 'stat_4',
        //   'type' => 'text',
        //   'translations' => 'sync',
        // ),
        // array(
        //   'key' => $prefix . 'stat_5',
        //   'label' => __('Rent price change from last year', THEME_SLUG ),
        //   'name' => $prefix . 'stat_5',
        //   'type' => 'text',
        //   'translations' => 'sync',
        // ),
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
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'recommend',
          'label' => __('Recommend', THEME_SLUG ),
          'name' => $prefix . 'recommend',
          'type' => 'true_false',
          'instructions' => '',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
          'translations' => 'sync',
        ),
        // array(
        //   'key' => $prefix . 'price_for_sale',
        //   'label' => __('Price for Sale', THEME_SLUG ),
        //   'name' => $prefix . 'price_for_sale',
        //   'type' => 'number',
        // ),
        // array(
        //   'key' => $prefix . 'price_for_rent',
        //   'label' => __('Price for Rent', THEME_SLUG ),
        //   'name' => $prefix . 'price_for_rent',
        //   'type' => 'number',
        // ),
      ),
      'style' => 'seamless',
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

    $prefix = 'project_developer_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix . 'recommend',
          'label' => __('Recommend', THEME_SLUG ),
          'name' => $prefix . 'recommend',
          'type' => 'true_false',
          'instructions' => '',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
          'translations' => 'sync',
        ),
      ),
      'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'taxonomy',
            'operator' => '==',
            'value' => 'project_developer',
          ),
        ),
      ),
    ));


    $prefix = 'project_facility_';

    // acf_add_local_field_group(array(
    //   'key' => $prefix . 'setting',
    //   'title' => '',
    //   'fields' => array (
    //     array(
    //       'key' => $prefix . 'icon',
    //       'label' => __('Icon', THEME_SLUG ),
    //       'name' => $prefix . 'icon',
    //       'type' => 'text',
    //       'wrapper' => array('class' => 'shinyu-icon'),
    //     ),
    //   ),
    //   // 'style' => 'seamless',
    //   'label_placement' => 'top',
    //   'instruction_placement' => 'label',
    //   'location' => array (
    //     array (
    //       array (
    //         'param' => 'taxonomy',
    //         'operator' => '==',
    //         'value' => 'project_facility',
    //       ),
    //     ),
    //   ),
    // ));
    
  }

  public function post_states( $post_states, $post ) {

    if ( get_field('project_recommend', $post->ID == 1) && 'project' == get_post_type( $post->ID ) ) {
      $post_states[] = __( 'Recommend', THEME_SLUG );
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
    unset( $columns['taxonomy-project_area'] );    

    $columns['mimo_thumbnail']               = '<span class="dashicons-format-image"></span>';
    $columns['title']                        = __( 'Name', THEME_SLUG );
    $columns['taxonomy-project_type']        = __( 'Type', THEME_SLUG );
    $columns['taxonomy-project_country']     = __( 'Country', THEME_SLUG );
    $columns['taxonomy-project_developer']   = __( 'Developer', THEME_SLUG );
    $columns['taxonomy-project_location']    = __( 'Location (BTS/MRT)', THEME_SLUG );
    $columns['taxonomy-project_area']        = __( 'Area', THEME_SLUG );    
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

  public function location_columns($columns) {
    $new_columns = array(
      'cb'                 => '<input type="checkbox" />',
      'name'               => __('Name'),
      'location_type'      => __('Type'),
      'location_recommend' => __('Recommend'),      
      'posts'              => __('Count'),
    );
    return $new_columns;
  }
  
  public function manage_location_columns($out, $column_name, $term_id) {
    $type = get_field('project_location_type', 'term_'. $term_id); 
    $recommend = get_field('project_location_recommend', 'term_'. $term_id); 
  
    switch ($column_name) {
      case 'location_type': 
        echo $type;
        break;
      case 'location_recommend': 
        echo $recommend ? '<span class="dashicons dashicons-yes"></span>' : '';
        break;        
      default:
        break;
    }
    return $out;
  }

  public function developer_columns($columns) {
    $new_columns = array(
      'cb'                  => '<input type="checkbox" />',
      'name'                => __('Name'),
      'developer_recommend' => __('Recommend'),      
      'posts'               => __('Count'),
    );
    return $new_columns;
  }
  
  public function manage_developer_columns($out, $column_name, $term_id) {
    $recommend = get_field('project_developer_recommend', 'term_'. $term_id); 
    switch ($column_name) {
      case 'developer_recommend': 
        echo $recommend ? '<span class="dashicons dashicons-yes"></span>' : '';
        break;        
      default:
        break;
    }
    return $out;
  }

  public function facility_columns($columns) {
    $new_columns = array(
      'cb'                 => '<input type="checkbox" />',
      'name'               => __('Name'),
      // 'facility_icon'      => __('Icon'),
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