<?php

class Shinyu_Partner {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Partner();
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

    add_filter( 'manage_partner_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_partner_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );
	}

	public function register_post_type(){

    $labels = [
			'name'                  => __('Partners', THEME_SLUG),
			'menu_name'             => __('Partners', THEME_SLUG),
			'all_items'             => __('All Partners', THEME_SLUG),
			'singular_name'         => __('Partner', THEME_SLUG),
			'add_new'               => __('Add Partner', THEME_SLUG),
			'add_new_item'          => __('Add Partner', THEME_SLUG),
			'edit_item'             => __('Edit Partner', THEME_SLUG),
			'new_item'              => __('Add Partner', THEME_SLUG),
			'view_item'             => __('View Partner', THEME_SLUG),
			'search_items'          => __('Search Partner', THEME_SLUG),
    ];


    $args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'query_var'          => true,
      'has_archive'        => false,
      'capability_type'    => 'post',
			'hierarchical'       => false,
      'menu_icon'             => 'dashicons-groups',
    );

		register_post_type( 'partner', $args );

	}

	public function fields() {

		$prefix = '_partner_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array (
          'key' => $prefix.'profile',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
          'instructions' => '400px X 300px',
        ),
        array (
          'key' => $prefix.'url',
          'label' => __( 'Website', THEME_SLUG ),
          'name' => $prefix.'url',
          'type' => 'url',
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
      'style' => 'seamless',
      // 'position' => 'side',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'partner',
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

    // if ( get_field('partner_category', $post->ID ) == 'partner' && 'partner' == get_post_type( $post->ID ) ) {
    //   $post_states[] = __( 'Partner', THEME_SLUG );
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

    if($post->post_type === 'partner') {
      return home_url('partner/' . $post->ID . '/');
    }
    else{
      return $post_link;
    }
  }

  public function rewrite(){
    add_rewrite_rule('partner/([0-9]+)?$', 'index.php?post_type=partner&p=$matches[1]', 'top');
  }

}

Shinyu_Partner::get_instance();