<?php

class Shinyu_Service {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Service();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    //add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

    // add_action( 'save_post', array( $this, 'save' ), 13, 2 );

		add_action( 'init', array( $this, 'register_post_type' ) );
    add_action( 'acf/init', array( $this, 'fields' ) );

    // add_action('init', array( $this, 'rewrite') );
    // add_filter('post_type_link', array( $this, 'permalink' ), 1, 3 );

    add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );

    add_filter( 'manage_service_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_service_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );
	}

	public function register_post_type(){

    $labels = [
			'name'                  => __('Services', THEME_SLUG),
			'menu_name'             => __('Services', THEME_SLUG),
			'all_items'             => __('All Services', THEME_SLUG),
			'singular_name'         => __('Service', THEME_SLUG),
			'add_new'               => __('Add Service', THEME_SLUG),
			'add_new_item'          => __('Add Service', THEME_SLUG),
			'edit_item'             => __('Edit Service', THEME_SLUG),
			'new_item'              => __('Add Service', THEME_SLUG),
			'view_item'             => __('View Service', THEME_SLUG),
			'search_items'          => __('Search Service', THEME_SLUG),
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
      'menu_icon'          => 'dashicons-heart',
      'rewrite'            => ['slug' => 'services', 'with_front' => false],
    ];

		register_post_type('service', $args);

	}

	public function fields() {

		$prefix = '_service_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        // array (
        //   'key' => $prefix.'product',
        //   'label' => __( 'Package', THEME_SLUG ),
        //   'name' => $prefix.'product',
        //   'type' => 'post_object',
        //   'instructions' => '',
        //   'post_type' => ['product'],
        //   'taxonomy' => array(
        //     0 => 'product_cat:packages',
        //   ),
        //   'allow_null' => 0,
        //   'multiple' => 0,
        //   'return_format' => 'id',
        //   'ui' => 1,
        // ),
        array(
          'key' => $prefix . 'link',
          'label' => __('Link', THEME_SLUG ),
          'name' => $prefix . 'link',
          'type' => 'url',
        ),
        array(
          'key' => $prefix.'image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array(
          'key' => $prefix . 'description',
          'label' => __('Description', THEME_SLUG ),
          'name' => $prefix . 'description',
          'type' => 'textarea',
        )
      ),
      // 'style' => 'seamless',
      // 'position' => 'side',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'service',
          ),
        ),
      ),
      'hide_on_screen' => array(
        0 => 'the_content',
        1 => 'page_attributes',
        2 => 'featured_image',
      ),
    ));
	}


  public function post_states( $post_states, $post ) {

    // if ( get_field('service_category', $post->ID ) == 'service' && 'service' == get_post_type( $post->ID ) ) {
    //   $post_states[] = __( 'Service', THEME_SLUG );
    // }else {
    //   $post_states[] = __( 'Promotion', THEME_SLUG );
    // }
    return $post_states;

  }
  public function columns( $columns ) {

    unset( $columns['title'] );
    unset( $columns['date'] );

    $columns['mimo_thumbnail'] = '<span class="dashicons-format-image"></span>';
    $columns['title']          = __( 'Title' );
    $columns['author']         = __( 'Author', THEME_SLUG );
    $columns['date']           = __( 'Date' );


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

    if($post->post_type === 'service') {
      return home_url('service/' . $post->ID . '/');
    }
    else{
      return $post_link;
    }
  }

  public function rewrite(){
    add_rewrite_rule('service/([0-9]+)?$', 'index.php?post_type=service&p=$matches[1]', 'top');
  }

}

Shinyu_Service::get_instance();