<?php

class Shinyu_Article {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Article();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    //add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

    add_action( 'save_post', [$this, 'save'], 13, 2);

    add_action('init', [$this, 'register_taxonomy'], 8);
    add_action('init', [$this, 'register_post_type'], 9);
    add_action('acf/init', [$this, 'fields']);

    // add_action('init', array( $this, 'rewrite') );
    // add_filter('post_type_link', array( $this, 'permalink' ), 1, 3 );

    // add_action('display_post_states', [$this, 'post_states'], 10, 2 );

    add_filter('manage_news_posts_columns', [$this, 'columns']);
    add_action('manage_news_posts_custom_column', [$this, 'columns_display'], 10, 2);
	}

	public function register_post_type(){

    $labels = array(
			'name'                  => __('Articles', THEME_SLUG),
			'menu_name'             => __('Articles', THEME_SLUG),
			'all_items'             => __('All Articles', THEME_SLUG),
			'singular_name'         => __('Article', THEME_SLUG),
			'add_new'               => __('Add Article', THEME_SLUG),
			'add_new_item'          => __('Add Article', THEME_SLUG),
			'edit_item'             => __('Edit Article', THEME_SLUG),
			'new_item'              => __('Add Article', THEME_SLUG),
			'view_item'             => __('View Article', THEME_SLUG),
			'search_items'          => __('Search Article', THEME_SLUG),
    );
    
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
      'menu_icon'          => 'dashicons-welcome-write-blog',
      'rewrite'            => ['slug' => 'articles', 'with_front' => false],
    ];

		register_post_type('news', $args);

	}

  public function register_taxonomy() {

    $labels = [
      'name'                       => __('Categories', THEME_SLUG),
      'singular_name'              => __('Category', THEME_SLUG),
      'menu_name'                  => __('Categories', THEME_SLUG),
      'all_items'                  => __('All Category', THEME_SLUG),
      'parent_item'                => __('Parent Category', THEME_SLUG),
      'parent_item_colon'          => __('Parent Category:', THEME_SLUG),
      'new_item_name'              => __('New Category', THEME_SLUG),
      'add_new_item'               => __('Add Category', THEME_SLUG),
      'edit_item'                  => __('Edit Category', THEME_SLUG),
      'update_item'                => __('Update Category', THEME_SLUG),
      'view_item'                  => __('View Category', THEME_SLUG),
    ];
  
    $args = [
      'labels'         => $labels,
      'hierarchical'   => false,
      'rewrite'        => [
        'slug'         => 'articles/category',
        'with_front'   => false,
        'hierarchical' => true,
      ],
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    ];
    register_taxonomy('news_cat', ['news'], $args );

  }


	public function fields() {

		$prefix = 'news_';

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
        //     'news' => __( 'News', THEME_SLUG ),
        //   ),
        //   'allow_null' => 0,
        //   'other_choice' => 0,
        //   'default_value' => '',
        //   'layout' => 'vertical',
        //   'return_format' => 'value',
        //   'save_other_choice' => 0,
        // ),
        array(
          'key' => $prefix.'cat',
          'label' => __( 'Category', THEME_SLUG ),
          'name' => $prefix.'cat',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'taxonomy' => 'news_cat',
          'field_type' => 'checkbox',
          'add_term' => 1,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 1,
          'allow_null' => 0,
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
            'value' => 'news',
          ),
        ),
      ),
    ));
	}


  public function post_states( $post_states, $post ) {

    // if ( get_field('news_category', $post->ID ) == 'news' && 'news' == get_post_type( $post->ID ) ) {
    //   $post_states[] = __( 'News', THEME_SLUG );
    // }else {
    //   $post_states[] = __( 'Promotion', THEME_SLUG );
    // }
    return $post_states;

  }
  public function columns( $columns ) {

    unset( $columns['title'] );
    unset( $columns['date'] );
    unset( $columns['taxonomy-news_cat'] );

    $columns['mimo_thumbnail']    = '<span class="dashicons-format-image"></span>';
    $columns['title']             = __( 'Title' );
    $columns['taxonomy-news_cat'] = __( 'Category' );    
    $columns['author']            = __( 'Author', THEME_SLUG );
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

Shinyu_Article::get_instance();