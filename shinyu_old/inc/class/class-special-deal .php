<?php

class Mimo_Special_Deal  {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Special_Deal ();
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

    add_filter( 'manage_news_posts_columns', array( $this, 'columns' ) );
    add_action( 'manage_news_posts_custom_column', array( $this, 'columns_display' ), 10, 2  );
	}

	public function register_post_type(){

    $labels = array(
      'name'                  => _x( 'Special Deal', 'Post Type General Name', THEME_SLUG ),
      'singular_name'         => _x( 'Special Deal', 'Post Type Singular Name', THEME_SLUG ),
      'menu_name'             => __( 'Special Deal', THEME_SLUG ),
      'name_admin_bar'        => __( 'Post Type', THEME_SLUG ),
      'archives'              => __( 'Item Archives', THEME_SLUG ),
      'attributes'            => __( 'Item Attributes', THEME_SLUG ),
      'parent_item_colon'     => __( 'Parent Item:', THEME_SLUG ),
      'all_items'             => __( 'All Items', THEME_SLUG ),
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
      'label'                 => __( 'Special Deal', THEME_SLUG ),
      'description'           => __( 'Post Type Description', THEME_SLUG ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'editor' ),
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
    );

		register_post_type( 'special_deal', $args );

	}

	public function fields() {

		$prefix = 'special_deal_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
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
        //     'news' => __( 'Special Deal', THEME_SLUG ),
        //   ),
        //   'allow_null' => 0,
        //   'other_choice' => 0,
        //   'default_value' => '',
        //   'layout' => 'vertical',
        //   'return_format' => 'value',
        //   'save_other_choice' => 0,
        // ),
        array (
          'key' => $prefix.'cover',
          'label' => __( 'Cover', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
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
      'position' => 'side',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'special_deal',
          ),
        ),
      ),
    ));
	}


  public function post_states( $post_states, $post ) {

    // if ( get_field('news_category', $post->ID ) == 'news' && 'news' == get_post_type( $post->ID ) ) {
    //   $post_states[] = __( 'Special Deal', THEME_SLUG );
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

    if($post->post_type === 'news') {
      return home_url('news/' . $post->ID . '/');
    }
    else{
      return $post_link;
    }
  }

  public function rewrite(){
    add_rewrite_rule('news/([0-9]+)?$', 'index.php?post_type=news&p=$matches[1]', 'top');
  }

}

Mimo_Special_Deal ::get_instance();