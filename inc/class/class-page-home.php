<?php

class Shinyu_Page_Home {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Page_Home();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    add_action( 'acf/init', [$this, 'settings_fields']);

	}

  public function settings_fields() {


    $prefix = '_page_home_';

    acf_add_local_field_group([
      'key' => $prefix . 'setting',
      'title' => __( 'Content', THEME_SLUG ),
      'fields' => [
        [
          'key' => $prefix . 'slideshow_tab',
          'label' => __( 'Slideshow', THEME_SLUG ),
          'name' => $prefix . 'slideshow_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        [
          'key' => $prefix.'slideshow',
          'label' => '',
          'name' => $prefix.'slideshow',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Slideshow', THEME_SLUG ),
          'sub_fields' => [
            [
              'key'           => $prefix . 'slideshow_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'large',
              'library'       => 'all',
              'instructions'  => '3840px X 1180px',
            ],
            [
              'key'           => $prefix . 'slideshow_image_mobile',
              'label'         => __('Image for Mobile', THEME_SLUG ),
              'name'          => 'image_mobile',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'large',
              'library'       => 'all',
              'instructions'  => '991px X 512px',
            ],
            [
              'key'           => $prefix . 'slideshow_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'slideshow_description',
              'label'         => __('Description', THEME_SLUG ),
              'name'          => 'description',
              'type'          => 'textarea',
            ],
            [
              'key'           => $prefix . 'slideshow_link',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'url',
            ],
          ],
        ],
        [
          'key' => $prefix . 'project_tab',
          'label' => __( 'Project Pre - Sale', THEME_SLUG ),
          'name' => $prefix . 'project_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        [
          'key' => $prefix.'project',
          'label' => '',
          'name' => $prefix.'project',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Project', THEME_SLUG ),
          'sub_fields' => [
            [
              'key' => $prefix . 'gallery',
              'label' => __('Gallery', THEME_SLUG ),
              'name' => 'gallery',
              'type' => 'gallery',
              'insert' => 'append',
              'library' => 'all',
              'mime_types' => '',
              // 'instructions' => '600px X 600px',
            ],
            [
              'key'           => $prefix . 'project_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'project_description',
              'label'         => __('Description', THEME_SLUG ),
              'name'          => 'description',
              'type'          => 'textarea',
            ],
            [
              'key'           => $prefix . 'project_price',
              'label'         => __('Price', THEME_SLUG ),
              'name'          => 'price',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'project_developer',
              'label'         => __('Developer', THEME_SLUG ),
              'name'          => 'developer',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'project_link',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'url',
            ],
          ],
        ],
        [
          'key' => $prefix . 'testimonial_tab',
          'label' => __( 'Testimonial', THEME_SLUG ),
          'name' => $prefix . 'testimonial_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        [
          'key' => $prefix.'testimonial',
          'label' => '',
          'name' => $prefix.'testimonial',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __( 'Add', THEME_SLUG ),
          'sub_fields' => [
            [
              'key' => $prefix . 'testimonial_image',
              'label' => 'Image',
              'name' => 'image',
              'type' => 'image',
              'return_format' => 'id',
              'preview_size' => 'thumbnail',
              'library' => 'all',
              'mime_types' => '',
              'translations' => 'sync',
              'wrapper' => ['width' => 20]
            ],
            [
              'key'   => $prefix . 'testimonial_name',
              'label' => 'Name',
              'name'  => 'name',
              'type'  => 'text',
              'wrapper' => ['width' => 30]
            ],
            [
              'key'   => $prefix . 'testimonial_message',
              'label' => 'Message',
              'name'  => 'message',
              'type'  => 'text',
              'wrapper' => ['width' => 50]
            ],
          ]
        ],
        [
          'key' => $prefix . 'state',
          'label' => __( 'State', THEME_SLUG ),
          'name' => $prefix . 'state',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        [
          'key'           => $prefix . 'state_customer',
          'label'         => __('Customers', THEME_SLUG ),
          'name'          => $prefix . 'state_customer',
          'type'          => 'text',
        ],
        [
          'key'           => $prefix . 'state_total',
          'label'         => __('Total sqm leased', THEME_SLUG ),
          'name'          => $prefix . 'state_total',
          'type'          => 'text',
        ],
        [
          'key'           => $prefix . 'state_room',
          'label'         => __('Room', THEME_SLUG ),
          'name'          => $prefix . 'state_room',
          'type'          => 'text',
        ],
        [
          'key'           => $prefix . 'state_project',
          'label'         => __('Project', THEME_SLUG ),
          'name'          => $prefix . 'state_project',
          'type'          => 'text',
        ],
      ],
      'location' => [
        [
          [
            'param' => 'page_type',
            'operator' => '==',
            'value' => 'front_page',
          ],
        ],
      ],
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => [
        0 => 'the_content',
        1 => 'page_attributes',
        2 => 'featured_image',
      ],
      'active' => true,
      'description' => '',
    ]);
  }
  public function save($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;

    if (wp_is_post_revision($post_id))
      return;

    if ('page' != get_post_type($post_id) && $post_id === 8)
      return;
  }

}

Shinyu_Page_Home::get_instance();
