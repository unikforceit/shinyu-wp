<?php

class Mimo_Room {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Room();
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
    //add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );
    add_action( 'acf/init', array( $this, 'fields' ) );

    add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );

    add_filter( 'manage_room_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_room_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );

    add_filter('manage_edit-room_facility_columns', array( $this, 'facility_columns' )); 
    add_filter('manage_room_facility_custom_column', array( $this, 'manage_facility_columns' ), 10, 3);


	}


  public function scripts() {}

	public function register_post_type(){

		$labels = array(
			'name'                  => __('Room', THEME_SLUG),
			'menu_name'             => __('Room', THEME_SLUG),
			'all_items'             => __('All Rooms', THEME_SLUG),
			'singular_name'         => __('Room', THEME_SLUG),
			'add_new'               => __('Add New', THEME_SLUG),
			'add_new_item'          => __('Add Room', THEME_SLUG),
			'edit_item'             => __('Edit Room', THEME_SLUG),
			'new_item'              => __('Add Room', THEME_SLUG),
			'view_item'             => __('View Room', THEME_SLUG),
			'search_items'          => __('Search Room', THEME_SLUG),
			'not_found'             => __('No Room found.', THEME_SLUG),
			'not_found_in_trash'    => __('No Room found.', THEME_SLUG),
      'parent_item_colon'     => '',
      'view_items'            => __( 'View Room', THEME_SLUG ),
      'featured_image'        => __( 'Featured Image', THEME_SLUG ),
      'set_featured_image'    => __( 'Set featured image', THEME_SLUG ),
      'remove_featured_image' => __( 'Remove featured image', THEME_SLUG ),
      'use_featured_image'    => __( 'Use as featured image', THEME_SLUG ),
      'insert_into_item'      => __( 'Insert into item', THEME_SLUG ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', THEME_SLUG ),
      'items_list'            => __( 'Room list', THEME_SLUG ),
      'items_list_navigation' => __( 'Room list navigation', THEME_SLUG ),
      'filter_items_list'     => __( 'Filter items list', THEME_SLUG ),
    );
    
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'hierarchical' => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-grid-view',
      //'show_in_menu'  => 'edit.php?post_type=project',
			'supports'  => array( 'title', 'editor')
		);

    register_post_type( 'room', $args );
    
	}

  public function register_taxonomy() {

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
      'show_admin_column'          => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    );
    register_taxonomy( 'room_facility', array( 'room' ), $args );

  }

  public function add_submenu_page() {
    add_submenu_page(
      'edit.php?post_type=project',
      __( 'Add New', THEME_SLUG ),
      __( 'Add New', THEME_SLUG ),
      'manage_options',
      'post-new.php?post_type=room'
    );
  }

	public function fields() {

		$prefix = 'room_';

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
          'key' => $prefix . 'project',
          'label' => __('Project', THEME_SLUG ),
          'name' => $prefix . 'project',
          'type' => 'post_object',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'wrapper' => array(),
          'post_type' => array(
            0 => 'project',
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'return_format' => 'id',
          'ui' => 1,
          'wrapper' => array( 'width' => 50 )
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
          'wrapper' => array( 'width' => 50 )
        ),
        array(
          'key' => $prefix . 'condition',
          'label' => __('Condition', THEME_SLUG ),
          'name' => $prefix . 'condition',
          'type' => 'checkbox',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'choices' => field_transaction(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
        array(
          'key' => $prefix . 'sell_price',
          'label' => __('Price for sell', THEME_SLUG ),
          'name' => $prefix . 'sell_price',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
        ),
        array(
          'key' => $prefix . 'rent_price',
          'label' => __('Price for rent', THEME_SLUG ),
          'name' => $prefix . 'rent_price',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
        ),
        array(
          'key' => $prefix . 'unit_no',
          'label' => __('Unit No.', THEME_SLUG ),
          'name' => $prefix . 'unit_no',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
        ),
        array(
          'key' => $prefix . 'levels',
          'label' => __('Levels', THEME_SLUG ),
          'name' => $prefix . 'levels',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
        ),
        array(
          'key' => $prefix . 'area_sqm',
          'label' => __('Room Area (SQM)', THEME_SLUG ),
          'name' => $prefix . 'area_sqm',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
        ),
        array(
          'key' => $prefix . 'view',
          'label' => __('View', THEME_SLUG ),
          'name' => $prefix . 'view',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_view(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 )
        ),
        array(
          'key' => $prefix . 'direction',
          'label' => __('Direction', THEME_SLUG ),
          'name' => $prefix . 'direction',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_direction(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 )
        ),
        array(
          'key' => $prefix . 'type',
          'label' => __('Room Type', THEME_SLUG ),
          'name' => $prefix . 'type',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_room_type(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 )
        ),
        array(
          'key' => $prefix . 'bedrooms',
          'label' => __('Bedrooms', THEME_SLUG ),
          'name' => $prefix . 'bedrooms',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_bedrooms(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 )
        ),
        array(
          'key' => $prefix . 'bathrooms',
          'label' => __('Bathrooms', THEME_SLUG ),
          'name' => $prefix . 'bathrooms',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_bathrooms(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 )
        ),
        array(
          'key' => $prefix.'facility',
          'label' => __( 'Facility', THEME_SLUG ),
          'name' => $prefix.'facility',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'taxonomy' => 'room_facility',
          'field_type' => 'checkbox',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 1,
          'allow_null' => 0,
          // 'wrapper' => array( 'width' => 50 )
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
          'key' => $prefix.'cover',
          'label' => __( 'Cover', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
          'instructions' => 'Reccomment image size 1024px X 885px',
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
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'room',
          ),
        ),
      ),
    ));

    $prefix = 'room_facility_';

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
            'value' => 'room_facility',
          ),
        ),
      ),
    ));

	}


  public function post_states( $post_states, $post ) {

    if ( get_field('room_recommend', $post->ID == 1) && 'room' == get_post_type( $post->ID ) ) {
      $post_states[] = __( 'Recommend', THEME_SLUG );
    }

    return $post_states;

  }
  public function columns( $columns ) {

    unset( $columns['title'] );
    unset( $columns['date'] );
    unset( $columns['taxonomy-room_facility'] );

    $columns['mimo_thumbnail']              = '<span class="dashicons-format-image"></span>';
    $columns['title']                       = __( 'Name', THEME_SLUG );
    $columns['room_project']                = __( 'Project', THEME_SLUG );
    $columns['room_condition']                   = __( 'Type', THEME_SLUG );
    $columns['taxonomy-room_facility']      = __( 'Facility', THEME_SLUG );

    return $columns;

  }

  public function columns_display( $column, $post_id ) {

    switch ( $column ) {
      case 'mimo_thumbnail' :
        if ( has_post_thumbnail($post_id ) ) {
          echo '<a href="'. get_edit_post_link( $post_id ) .'">' . get_the_post_thumbnail( $post_id, 'thumbnail' ) . '</a>';
        }else{}
      break;
      case 'room_condition' :
        if( $condition = get_field('room_condition', $post_id) ) echo implode(', ', $condition);
      break;
      case 'room_project' :
        if( $project_id = get_field('room_project', $post_id) ) echo get_the_title($project_id);
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
    $icon = get_field('room_facility_icon', 'term_'. $term_id); 
  
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

    if ( 'room' != get_post_type( $post_id ) )

      return;

  }

}

Mimo_Room::get_instance();