<?php

class Mimo_Job {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Job();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    //add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

    add_action( 'save_post', array( $this, 'save' ), 13, 2 );

    add_action( 'init', array( $this, 'register_post_type' ) );
    // add_action( 'init', array( $this, 'register_taxonomy' ), 0 );
    add_action( 'acf/init', array( $this, 'fields' ) );

    // add_action('init', array( $this, 'rewrite') );
    // add_filter('post_type_link', array( $this, 'permalink' ), 1, 3 );

    add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );

    add_filter( 'manage_job_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_job_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );
	}

	public function register_post_type(){

    $labels = array(
      'name'                  => _x( 'Job', 'Post Type General Name', THEME_SLUG ),
      'singular_name'         => _x( 'Job', 'Post Type Singular Name', THEME_SLUG ),
      'menu_name'             => __( 'Job', THEME_SLUG ),
      'name_admin_bar'        => __( 'Post Type', THEME_SLUG ),
      'archives'              => __( 'Job Archives', THEME_SLUG ),
      'attributes'            => __( 'Job Attributes', THEME_SLUG ),
      'parent_item_colon'     => __( 'Parent Item:', THEME_SLUG ),
      'all_items'             => __( 'All Job', THEME_SLUG ),
      'add_new_item'          => __( 'Add New Item', THEME_SLUG ),
      'add_new'               => __( 'Add New', THEME_SLUG ),
      'new_item'              => __( 'New Item', THEME_SLUG ),
      'edit_item'             => __( 'Edit Item', THEME_SLUG ),
      'update_item'           => __( 'Update Item', THEME_SLUG ),
      'view_item'             => __( 'View Item', THEME_SLUG ),
      'view_items'            => __( 'View Items', THEME_SLUG ),
      'search_items'          => __( 'Search Item', THEME_SLUG ),
      'not_found'             => __( 'Not found', THEME_SLUG ),
      'not_found_in_trash'    => __( 'Not found in Trash', THEME_SLUG ),
      'featured_image'        => __( 'Featured Image', THEME_SLUG ),
      'set_featured_image'    => __( 'Set featured image', THEME_SLUG ),
      'remove_featured_image' => __( 'Remove featured image', THEME_SLUG ),
      'use_featured_image'    => __( 'Use as featured image', THEME_SLUG ),
      'insert_into_item'      => __( 'Insert into item', THEME_SLUG ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', THEME_SLUG ),
      'items_list'            => __( 'Items list', THEME_SLUG ),
      'items_list_navigation' => __( 'Items list navigation', THEME_SLUG ),
      'filter_items_list'     => __( 'Filter items list', THEME_SLUG ),
    );
    $args = array(
      'label'                 => __( 'Job', THEME_SLUG ),
      'description'           => __( 'Post Type Description', THEME_SLUG ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'editor' ),
      'taxonomies'            => array( 'job_cat' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
      'show_in_rest'          => false,
      'menu_icon'             => 'dashicons-businessperson',
    );

		register_post_type( 'job', $args );

	}

  public function register_taxonomy() {

    $labels = array(
      'name'                       => _x( 'Categories', 'Category General Name', THEME_SLUG ),
      'singular_name'              => _x( 'Category', 'Category Singular Name', THEME_SLUG ),
      'menu_name'                  => __( 'Category', THEME_SLUG ),
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
    register_taxonomy( 'job_cat', array( 'job' ), $args );

  }


	public function fields() {

		$prefix = 'job_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix.'count',
          'label' => __( 'Count', THEME_SLUG ),
          'name' => $prefix.'count',
          'type' => 'number',
        ),
      ),
      // 'style' => 'seamless',
      'position' => 'side',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'job',
          ),
        ),
      ),
    ));
	}


  public function post_states( $post_states, $post ) {

    // if ( get_field('job_category', $post->ID ) == 'job' && 'job' == get_post_type( $post->ID ) ) {
    //   $post_states[] = __( 'Job', THEME_SLUG );
    // }else {
    //   $post_states[] = __( 'Promotion', THEME_SLUG );
    // }
    return $post_states;

  }
  public function columns( $columns ) {

    unset( $columns['title'] );
    unset( $columns['date'] );
    // unset( $columns['taxonomy-job_cat'] );

    // $columns['mimo_thumbnail']    = '<span class="dashicons-format-image"></span>';
    $columns['title']             = __( 'Title' );
    // $columns['taxonomy-job_cat'] = __( 'Category' );    
    // $columns['author']            = __( 'Author', THEME_SLUG );
    $columns['date']              = __( 'Date' );


    return $columns;

  }

  public function columns_display( $column, $post_id ) {

    switch ( $column ) {
      case 'mimo_thumbnail' :
        if ( has_post_thumbnail($post_id ) ) {
          echo '<a href="'. get_edit_post_link( $post_id ) .'">' . get_the_post_thumbnail( $post_id, 'thumbnail' ) . '</a>';
        }else{
          echo '<img src="https://via.placeholder.com/150x150">';
        }
      break;
    }
  }

  public function save( $post_id ) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
      return;

    if ( wp_is_post_revision( $post_id ) )
      return;

    if ( 'blog' != get_post_type( $post_id ) )
      return;
  }

  public function permalink($post_link, $post = 0) {

    if($post->post_type === 'job') {
      return home_url('job/' . $post->ID . '/');
    }
    else{
      return $post_link;
    }
  }

  public function rewrite(){
    add_rewrite_rule('job/([0-9]+)?$', 'index.php?post_type=job&p=$matches[1]', 'top');
  }

}

Mimo_Job::get_instance();