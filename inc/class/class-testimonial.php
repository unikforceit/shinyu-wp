<?php

class Mimo_Testimonial {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Testimonial();
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
    add_action( 'acf/init', array( $this, 'fields' ) );

    // add_action('init', array( $this, 'rewrite') );
    // add_filter('post_type_link', array( $this, 'permalink' ), 1, 3 );

    add_action( 'display_post_states', array( $this, 'post_states' ), 10, 2 );

    add_filter( 'manage_testimonial_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_testimonial_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );
	}

	public function register_post_type(){

    $labels = array(
      'name'                  => _x( 'Testimonial', 'Post Type General Name', THEME_SLUG ),
      'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', THEME_SLUG ),
      'menu_name'             => __( 'Testimonial', THEME_SLUG ),
      'name_admin_bar'        => __( 'Testimonial', THEME_SLUG ),
    );
    $args = array(
      'label'                 => __( 'Testimonial', THEME_SLUG ),
      'description'           => __( 'Post Type Description', THEME_SLUG ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'editor' ),
      'taxonomies'            => array( 'testimonial_category' ),
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
      'menu_icon'             => 'dashicons-smiley',
    );

		register_post_type( 'testimonial', $args );

	}

	public function fields() {

		$prefix = 'testimonial_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Profile', THEME_SLUG ),
      'fields' => array (
        // array(
        //   'key' => $prefix . 'category',
        //   'label' => __('Category', THEME_SLUG ),
        //   'name' => $prefix . 'category',
        //   'type' => 'radio',
        //   'instructions' => '',
        //   'required' => 1,
        //   'conditional_logic' => 0,
        //   'choices' => array(
        //     'promotion' => __( 'Promotion', THEME_SLUG ),
        //     'testimonial' => __( 'Testimonial', THEME_SLUG ),
        //   ),
        //   'allow_null' => 0,
        //   'other_choice' => 0,
        //   'default_value' => '',
        //   'layout' => 'vertical',
        //   'return_format' => 'value',
        //   'save_other_choice' => 0,
        // ),
        array (
          'key' => $prefix.'profile',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ),
        array (
          'key' => $prefix.'description',
          'label' => __( 'Description', THEME_SLUG ),
          'name' => $prefix.'description',
          'type' => 'textarea',
        ),
        // array (
        //   'key' => $prefix . 'gallery',
        //   'label' => __('Gallery', THEME_SLUG ),
        //   'name' => $prefix . 'gallery',
        //   'type' => 'gallery',
        //   'insert' => 'append',
        //   'library' => 'all',
        //   'mime_types' => '',
        //   // 'instructions' => '600px X 600px',
        // )
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
            'value' => 'testimonial',
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

    // if ( get_field('testimonial_category', $post->ID ) == 'testimonial' && 'testimonial' == get_post_type( $post->ID ) ) {
    //   $post_states[] = __( 'Testimonial', THEME_SLUG );
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

    if($post->post_type === 'testimonial') {
      return home_url('testimonial/' . $post->ID . '/');
    }
    else{
      return $post_link;
    }
  }

  public function rewrite(){
    add_rewrite_rule('testimonial/([0-9]+)?$', 'index.php?post_type=testimonial&p=$matches[1]', 'top');
  }

}

Mimo_Testimonial::get_instance();