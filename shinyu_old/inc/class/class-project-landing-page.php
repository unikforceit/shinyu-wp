<?php

class Mimo_Project_Landing_Page {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Project_Landing_Page();
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
    // add_action( 'init', array( $this, 'register_taxonomy' ), 0 );
    add_action( 'acf/init', array( $this, 'fields' ) );

    // add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );

    add_filter( 'manage_project-register_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_project-register_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );

	}


  public function scripts() {}

	public function register_post_type(){

		$labels = array(
			'name'                  => __('Landing Page', THEME_SLUG),
			'menu_name'             => __('Landing Page', THEME_SLUG),
			'all_items'             => __('Landing Page', THEME_SLUG),
			'singular_name'         => __('Landing Page', THEME_SLUG),
			'add_new'               => __('Add New', THEME_SLUG),
			'add_new_item'          => __('Add Landing Page', THEME_SLUG),
			'edit_item'             => __('Edit Landing Page', THEME_SLUG),
			'new_item'              => __('Add Landing Page', THEME_SLUG),
			'view_item'             => __('View Landing Page', THEME_SLUG),
			'search_items'          => __('Search Project', THEME_SLUG),
			'not_found'             => __('No Landing Page found.', THEME_SLUG),
			'not_found_in_trash'    => __('No Landing Page found.', THEME_SLUG),
      'parent_item_colon'     => '',
      'view_items'            => __( 'View Landing Page', THEME_SLUG ),
      'featured_image'        => __( 'Featured Image', THEME_SLUG ),
      'set_featured_image'    => __( 'Set featured image', THEME_SLUG ),
      'remove_featured_image' => __( 'Remove featured image', THEME_SLUG ),
      'use_featured_image'    => __( 'Use as featured image', THEME_SLUG ),
      'insert_into_item'      => __( 'Insert into item', THEME_SLUG ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', THEME_SLUG ),
      'items_list'            => __( 'Landing Page list', THEME_SLUG ),
      'items_list_navigation' => __( 'Landing Page list navigation', THEME_SLUG ),
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
      'rewrite' => array(
        'slug' => 'project/landing-page',
        'with_front' => false,
        'hierarchical' => true,
      ),
      'menu_position'      => 16,
      'menu_icon'          => 'dashicons-feedback',
			// 'show_in_menu'       => 'edit.php?post_type=project',
			'supports'           => array( 'title', 'editor' )
		);

    register_post_type( 'project-landing-page', $args );
    
		$labels = array(
			'name'                  => __('Register', THEME_SLUG),
			'menu_name'             => __('Register', THEME_SLUG),
			'all_items'             => __('All Register', THEME_SLUG),
			'singular_name'         => __('Register', THEME_SLUG),
			'add_new'               => __('Add New', THEME_SLUG),
			'add_new_item'          => __('Add Register', THEME_SLUG),
			'edit_item'             => __('Edit Register', THEME_SLUG),
			'new_item'              => __('Add Register', THEME_SLUG),
			'view_item'             => __('View Register', THEME_SLUG),
			'search_items'          => __('Search Project', THEME_SLUG),
			'not_found'             => __('No Register found.', THEME_SLUG),
			'not_found_in_trash'    => __('No Register found.', THEME_SLUG),
      'parent_item_colon'     => '',
      'view_items'            => __( 'View Register', THEME_SLUG ),
      'featured_image'        => __( 'Featured Image', THEME_SLUG ),
      'set_featured_image'    => __( 'Set featured image', THEME_SLUG ),
      'remove_featured_image' => __( 'Remove featured image', THEME_SLUG ),
      'use_featured_image'    => __( 'Use as featured image', THEME_SLUG ),
      'insert_into_item'      => __( 'Insert into item', THEME_SLUG ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', THEME_SLUG ),
      'items_list'            => __( 'Register list', THEME_SLUG ),
      'items_list_navigation' => __( 'Register list navigation', THEME_SLUG ),
      'filter_items_list'     => __( 'Filter items list', THEME_SLUG ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'query_var'          => false,
      'has_archive'        => false,
      'capability_type'    => 'post',
      'capabilities' => array(
        'create_posts' => 'do_not_allow',
        'delete_post'  => 'do_not_allow',
        'delete_posts' => 'do_not_allow',
      ),
      'hierarchical'       => false,
      // 'menu_position'      => 16,
      // 'menu_icon'          => 'dashicons-feedback',
			'show_in_menu'       => 'edit.php?post_type=project-landing-page',
			'supports'           => array( 'title', 'editor' )
		);

		register_post_type( 'project-register', $args );
    
	}
	public function fields() {

		$prefix = 'project_landing_page_';

    $choice = array();

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix . 'intro_tab',
          'label' => __( 'Intro', THEME_SLUG ),
          'name' => $prefix . 'intro_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix.'logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array (
          'key' => $prefix.'register_background',
          'label' => __( 'Background', THEME_SLUG ),
          'name' => $prefix.'register_background',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array(
          'key' => $prefix . 'information_tab',
          'label' => __( 'Information', THEME_SLUG ),
          'name' => $prefix . 'information_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'information_intro',
          'label' => __( 'Intro', THEME_SLUG ),
          'name' => $prefix . 'information_intro',
          'type' => 'wysiwyg',
          'tabs' => 'all',
          'toolbar' => 'full',
          'media_upload' => 0,
        ),
        array (
          'key' => $prefix.'information_promotion',
          'label' => __( 'Promotion', THEME_SLUG ),
          'name' => $prefix.'information_promotion',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array (
          'key' => $prefix.'information_image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => $prefix.'information_image',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array (
          'key' => $prefix.'information_feature',
          'label' => __( 'Feature', THEME_SLUG ),
          'name' => $prefix.'information_feature',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'table',
          'button_label' => __( 'Add feature', THEME_SLUG ),
          'sub_fields' => array (
            array (
              'key'           => $prefix . 'information_feature_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
              'wrapper'       => array('width' => 30)
            ),
            array(
              'key' => $prefix . 'information_feature_content',
              'label' => __( 'content', THEME_SLUG ),
              'name' => 'content',
              'type' => 'wysiwyg',
              'tabs' => 'visual',
              'toolbar' => 'full',
              'media_upload' => 0,
              'wrapper'       => array('width' => 70)
            )
          ),
        ),
        array(
          'key' => $prefix . 'plan_tab',
          'label' => __( 'Plan', THEME_SLUG ),
          'name' => $prefix . 'plan_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'plan',
          'label' => '',
          'name' => $prefix.'plan',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array(
          'key' => $prefix . 'gallery_tab',
          'label' => __( 'Gallery', THEME_SLUG ),
          'name' => $prefix . 'gallery_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix . 'gallery_interior',
          'label' => __( 'Interior', THEME_SLUG ),
          'name' => $prefix . 'gallery',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
          // 'instructions' => '600px X 600px',
        ),
        array (
          'key' => $prefix . 'gallery_exterior',
          'label' => __( 'Exterior', THEME_SLUG ),
          'name' => $prefix . 'gallery_exterior',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
          // 'instructions' => '600px X 600px',
        ),
        array (
          'key' => $prefix.'gallery_background',
          'label' => __( 'Background', THEME_SLUG ),
          'name' => $prefix.'gallery_background',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array(
          'key' => $prefix . 'location_tab',
          'label' => __( 'Location', THEME_SLUG ),
          'name' => $prefix . 'location_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix.'location_name',
          'label' => __( 'name', THEME_SLUG ),
          'name' => $prefix.'location_name',
          'type' => 'text',
        ),
        array(
          'key' => $prefix.'location_lat',
          'label' => __( 'Latitude', THEME_SLUG ),
          'name' => $prefix.'location_lat',
          'type' => 'text',
          'wrapper' => array( 'width' => 50 )
        ),
        array(
          'key' => $prefix.'location_lng',
          'label' => __( 'Longitude', THEME_SLUG ),
          'name' => $prefix.'location_lng',
          'type' => 'text',
          'wrapper' => array( 'width' => 50 )
        ),
        array(
          'key' => $prefix . 'contact_tab',
          'label' => __( 'Contact', THEME_SLUG ),
          'name' => $prefix . 'contact_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'contact_address',
          'label' => __( 'Address', THEME_SLUG ),
          'name' => $prefix . 'contact_address',
          'type' => 'wysiwyg',
          'tabs' => 'visual',
          'toolbar' => 'full',
          'media_upload' => 0,
        ),
        array(
          'key' => $prefix . 'contact_info',
          'label' => __( 'Contact Info', THEME_SLUG ),
          'name' => $prefix . 'contact_info',
          'type' => 'wysiwyg',
          'tabs' => 'visual',
          'toolbar' => 'full',
          'media_upload' => 0,
        )
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'project-landing-page',
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

    $columns['title']                        = __( 'Name', THEME_SLUG );
    $columns['project_register_phone']       = __( 'Phone', THEME_SLUG );
    $columns['project_register_email']       = __( 'Email', THEME_SLUG );
    $columns['project_register_budget']      = __( 'budget', THEME_SLUG );
    $columns['project_register_date']        = __( 'Appointment date', THEME_SLUG );
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

      case 'project_register_phone' :
        echo get_post_meta( $post_id, 'project_register_phone', true );
      break;

      case 'project_register_email' :
        echo get_post_meta( $post_id, 'project_register_email', true );
      break;

      case 'project_register_budget' :
        echo get_post_meta( $post_id, 'project_register_budget', true );
      break;

      case 'project_register_date' :
        $date = get_post_meta( $post_id, 'project_register_date', true );
        echo date_i18n( get_option('date_format'), strtotime( $date ) );
      break;

    }
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

Mimo_Project_Landing_Page::get_instance();