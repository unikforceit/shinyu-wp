<?php

class TR_Blog {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new TR_Blog();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

  }

	public function hooks() {
    add_action('acf/init', [$this, 'fields']);
    add_action('save_post', [$this, 'save'], 13, 2);
	}
  
  public function fields() {
    $prefix = '_page_';

    if (function_exists('acf_add_local_field_group')):

      acf_add_local_field_group([
        'key' => $prefix . 'setting',
        'title' => __('Page Options', THEME_SLUG),
        'fields' => [
          // [
          //   'key' => $prefix . 'title',
          //   'label' => __( 'Title', THEME_SLUG ),
          //   'name' => $prefix . 'title',
          //   'type' => 'text',
          // ],
          // [
          //   'key' => $prefix . 'description',
          //   'label' => __( 'Description', THEME_SLUG ),
          //   'name' => $prefix . 'description',
          //   'type' => 'textarea',
          // ],
          [
            'key' => $prefix . 'slider',
            'label' => __( 'Slider', THEME_SLUG ),
            'name' => $prefix . 'slider',
            'type' => 'gallery',
            'instructions' => '',
            'return_format' => 'id',
            'preview_size' => 'large',
            'insert' => 'append',
            'library' => 'all',
          ],
        ],
        'location' => [
          [
            [
              'param' => 'page_type',
              'operator' => '==',
              'value' => 'posts_page',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => ['the_content'],
        'active' => true,
        'description' => '',
      ]);
      
    endif;

    $prefix = '_blog_';

    acf_add_local_field_group([
      'key' => $prefix . 'setting',
      'title' => __('Blog Options', THEME_SLUG),
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
          'key' => $prefix . 'gallery',
          'label' => __( 'Gallery', THEME_SLUG ),
          'name' => $prefix . 'gallery',
          'type' => 'gallery',
          'instructions' => '',
          'return_format' => 'id',
          'preview_size' => 'large',
          'insert' => 'append',
          'library' => 'all',
        ],
      ],
      'location' => [
        [
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
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

  public function save($post_id) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
      return;

    if (wp_is_post_revision($post_id))
      return;

    if ('blog' != get_post_type($post_id))
      return;
  }
}

TR_Blog::get_instance();