<?php

class Shinyu_Job {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Job();
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

    $labels = [
			'name'                  => __('Jobs', THEME_SLUG),
			'menu_name'             => __('Jobs', THEME_SLUG),
			'all_items'             => __('All Jobs', THEME_SLUG),
			'singular_name'         => __('Job', THEME_SLUG),
			'add_new'               => __('Add Job', THEME_SLUG),
			'add_new_item'          => __('Add Job', THEME_SLUG),
			'edit_item'             => __('Edit Job', THEME_SLUG),
			'new_item'              => __('Add Job', THEME_SLUG),
			'view_item'             => __('View Job', THEME_SLUG),
			'search_items'          => __('Search Job', THEME_SLUG),
    ];

    $args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
      'has_archive'        => true,
      'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => 10,
      'menu_icon'          => 'dashicons-businessperson',
      'rewrite'            => ['slug' => 'jobs', 'with_front' => false],
    ];

		register_post_type('job', $args);

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

Shinyu_Job::get_instance();