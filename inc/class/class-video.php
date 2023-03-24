<?php

class Shinyu_Video {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Video();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {
		add_action('init',[$this, 'register_post_type']);
    add_action('acf/init', [$this, 'fields']);

    add_filter('manage_video_posts_columns', [$this, 'columns']);
    add_action('manage_video_posts_custom_column', [$this, 'columns_display'], 10, 2);
	}

	public function register_post_type(){
		$labels = array(
			'name' => __('Video', THEME_SLUG),
			'menu_name' => __('Video', THEME_SLUG),
			'all_items' => __('All Video', THEME_SLUG),
			'singular_name' => __('Video', THEME_SLUG),
			'add_new' => __('Add Video', THEME_SLUG),
			'add_new_item' => __('Add Video', THEME_SLUG),
			'edit_item' => __('Edit Video', THEME_SLUG),
			'new_item' => __('Add Video', THEME_SLUG),
			'view_item' => __('View Video', THEME_SLUG),
			'search_items' => __('Search Video', THEME_SLUG),
			'not_found' => __('No Video found.', THEME_SLUG),
			'not_found_in_trash' => __('No Video found.', THEME_SLUG),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => false,
      'has_archive' => true,
      'capability_type' => 'post',
			'hierarchical' => false,
      'menu_position' => 20,
      // 'rewrite' => ['slug' => 'sustainable-development/video', 'with_front' => false],
			'menu_icon' => 'dashicons-youtube',
      'supports'  => ['title'],
      'show_in_rest'          => true,
		);

		register_post_type('video', $args);

  }

  public function fields() {

    $prefix = '_video_';

    acf_add_local_field_group([
      'key' => $prefix . 'setting',
      'title' => __('Video Options', THEME_SLUG),
      'fields' => [
        [
          'key' => $prefix.'cover',
          'label' => __( 'Cover', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
        ],
        [
          'key' => $prefix.'url',
          'label' => __( 'Video URL', THEME_SLUG ),
          'name' => $prefix.'url',
          'type' => 'url',
        ],
      ],
      'location' => [
        [
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'video',
          ],
        ],
      ],
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'left',
      'instruction_placement' => 'label',
      'hide_on_screen' => [],
      'active' => true,
      'description' => '',
    ]);
    
  }

  public function columns($columns) {

    unset($columns['title']);
    unset($columns['date']);

    $columns['mimo_thumbnail']    = '<span class="dashicons-format-image"></span>';
    $columns['title']             = __('Title');
    $columns['author']            = __('Author', THEME_SLUG);
    $columns['date']              = __('Date');


    return $columns;

  }

  public function columns_display( $column, $post_id ) {

    switch ( $column ) {
      case 'mimo_thumbnail' :
        if ( has_post_thumbnail($post_id ) ) {
          echo '<a href="'. get_edit_post_link( $post_id ) .'">' . get_the_post_thumbnail( $post_id, 'thumbnail' ) . '</a>';
        }else{
          echo '<img src="https://via.placeholder.com/150/e8e8e8/e8e8e8">';
        }
      break;
    }
  }
}

Shinyu_Video::get_instance();