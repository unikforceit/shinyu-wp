<?php

class Shinyu_Page_Academy{

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Page_Academy();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    add_action( 'acf/init', array( $this, 'settings_fields' ) );

	}

  public function settings_fields() {


    $prefix = 'academy_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Content', THEME_SLUG ),
      'fields' => array(
        [
          'key' => $prefix . 'banner_1_tab',
          'label' => __( 'Banner', THEME_SLUG ),
          'name' => $prefix . 'banner_1_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        [
          'key' => $prefix.'banner_1',
          'label' => '',
          'name' => $prefix.'banner_1',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Banner', THEME_SLUG ),
          'sub_fields' => [
            [
              'key'           => $prefix . 'banner_1_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'large',
              'library'       => 'all',
              'instructions'  => '3840px X 1180px',
            ],
            // [
            //   'key'           => $prefix . 'banner_1_image_mobile',
            //   'label'         => __('Image for Mobile', THEME_SLUG ),
            //   'name'          => 'image_mobile',
            //   'type'          => 'image',
            //   'return_format' => 'id',
            //   'preview_size'  => 'large',
            //   'library'       => 'all',
            //   'instructions'  => '991px X 512px',
            // ],
            [
              'key'           => $prefix . 'banner_1_link',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'url',
            ],
          ],
        ],
        array(
          'key' => $prefix . 'overview',
          'label' => __( 'Overview', THEME_SLUG ),
          'name' => $prefix . 'overview',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'overview_title',
          'label' => __( 'Title', THEME_SLUG ),
          'name' => $prefix . 'overview_title',
          'type' => 'text',
        ),
        array(
          'key' => $prefix . 'overview_subtitle',
          'label' => __( 'Subtitle', THEME_SLUG ),
          'name' => $prefix . 'overview_subtitle',
          'type' => 'text',
        ),
        array(
          'key' => $prefix . 'overview_content',
          'label' => __( 'Description', THEME_SLUG ),
          'name' => $prefix . 'overview_content',
          'type' => 'textarea',
        ),
        array(
          'key' => $prefix . 'overview_video',
          'label' => __( 'Video', THEME_SLUG ),
          'name' => $prefix . 'overview_video',
          'type' => 'title',
        ),
        array(
          'key' => $prefix.'overview_video_cover',
          'label' => __( 'Cover', THEME_SLUG ),
          'name' => $prefix.'overview_video_cover',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'medium',
          'library' => 'all',
          'mime_types' => '',
        ),
        array(
          'key' => $prefix . 'overview_video_url',
          'label' => __( 'Video URL', THEME_SLUG ),
          'name' => $prefix . 'overview_video_url',
          'type' => 'url',
        ),
        [
          'key' => $prefix . 'banner_2_tab',
          'label' => __( 'Best Seller', THEME_SLUG ),
          'name' => $prefix . 'banner_2_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        [
          'key' => $prefix.'banner_2',
          'label' => '',
          'name' => $prefix.'banner_2',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Banner', THEME_SLUG ),
          'sub_fields' => [
            [
              'key'           => $prefix . 'banner_2_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'large',
              'library'       => 'all',
              'instructions'  => '3840px X 780px',
            ],
            [
              'key'           => $prefix . 'banner_2_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'banner_2_description',
              'label'         => __('Description', THEME_SLUG ),
              'name'          => 'description',
              'type'          => 'textarea',
            ],
            [
              'key'           => $prefix . 'banner_2_link',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'url',
            ],
          ],
        ],
        array(
          'key' => $prefix . 'feature_tab',
          'label' => __( 'Feature', THEME_SLUG ),
          'name' => $prefix . 'feature_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'feature_title_1',
          'label' => __( 'Title', THEME_SLUG ),
          'name' => $prefix . 'feature_title_1',
          'type' => 'text',
        ),
        array(
          'key' => $prefix.'feature_1',
          'label' => '',
          'name' => $prefix.'feature_1',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __( 'Add Item', THEME_SLUG ),
          'sub_fields' => array(
            array(
              'key'   => $prefix . 'feature_description_1',
              'label' => __( 'Description', THEME_SLUG ),
              'name'  => 'title',
              'type'  => 'textarea'
            ),
            array(
              'key' => $prefix.'feature_image_1',
              'label' => __( 'Icon', THEME_SLUG ),
              'name' => 'image',
              'type' => 'image',
              'return_format' => 'id',
              'preview_size' => 'medium',
              'library' => 'all',
              'mime_types' => '',
            ),
            [
              'key'           => $prefix . 'feature_link_1',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'url',
            ],
          )
        ),
        array(
          'key' => $prefix . 'feature_title',
          'label' => __( 'Title', THEME_SLUG ),
          'name' => $prefix . 'feature_title',
          'type' => 'text',
        ),
        array(
          'key' => $prefix.'feature',
          'label' => '',
          'name' => $prefix.'feature',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __( 'Add Item', THEME_SLUG ),
          'sub_fields' => array(
            array(
              'key'   => $prefix . 'feature_description',
              'label' => __( 'Description', THEME_SLUG ),
              'name'  => 'title',
              'type'  => 'text'
            ),
            array(
              'key' => $prefix.'feature_image',
              'label' => __( 'Image', THEME_SLUG ),
              'name' => 'image',
              'type' => 'image',
              'return_format' => 'id',
              'preview_size' => 'medium',
              'library' => 'all',
              'mime_types' => '',
            ),
          )
        ),
        [
          'key' => $prefix . 'banner_3_tab',
          'label' => __( 'Banner 2', THEME_SLUG ),
          'name' => $prefix . 'banner_3_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        [
          'key' => $prefix.'banner_3',
          'label' => '',
          'name' => $prefix.'banner_3',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Banner', THEME_SLUG ),
          'sub_fields' => [
            [
              'key'           => $prefix . 'banner_3_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'large',
              'library'       => 'all',
              'instructions'  => '3840px X 780px',
            ],
            [
              'key'           => $prefix . 'banner_3_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'banner_3_description',
              'label'         => __('Description', THEME_SLUG ),
              'name'          => 'description',
              'type'          => 'textarea',
            ],
            [
              'key'           => $prefix . 'banner_3_link',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'url',
            ],
          ],
        ],
        array(
          'key' => $prefix . 'promotion_tab',
          'label' => __( 'Promotion', THEME_SLUG ),
          'name' => $prefix . 'promotion_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix.'promotion_image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => $prefix.'promotion_image',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'large',
          'library' => 'all',
          'mime_types' => '',
        ),
        array(
          'key' => $prefix . 'promotion_url',
          'label' => __( 'Link', THEME_SLUG ),
          'name' => $prefix . 'promotion_url',
          'type' => 'url',
        ),
        array(
          'key' => $prefix . 'coach_tab',
          'label' => __( 'Coach', THEME_SLUG ),
          'name' => $prefix . 'coach_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix.'coach',
          'label' => '',
          'name' => $prefix.'coach',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __( 'Add coach', THEME_SLUG ),
          'sub_fields' => array(
            array(
              'key' => $prefix.'coach_profile',
              'label' => __( 'Profile', THEME_SLUG ),
              'name' => 'profile',
              'type' => 'image',
              'return_format' => 'id',
              'preview_size' => 'medium',
              'library' => 'all',
              'mime_types' => '',
              'wrapper' => array(
                'width' => 20
              )
            ),
            array(
              'key'   => $prefix . 'coach_name',
              'label' => __( 'Name', THEME_SLUG ),
              'name'  => 'name',
              'type'  => 'text',
              'wrapper' => array(
                'width' => 30
              )
            ),
            array(
              'key'   => $prefix . 'coach_position',
              'label' => __( 'Position', THEME_SLUG ),
              'name'  => 'position',
              'type'  => 'textarea',
              'wrapper' => array(
                'width' => 50
              )
            ),
          )
        ),
        array(
          'key' => $prefix . 'review_tab',
          'label' => __( 'Review', THEME_SLUG ),
          'name' => $prefix . 'review_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix.'review',
          'label' => '',
          'name' => $prefix.'review',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __( 'Add review', THEME_SLUG ),
          'sub_fields' => array(
            array(
              'key'   => $prefix . 'review_name',
              'label' => __( 'Name', THEME_SLUG ),
              'name'  => 'name',
              'type'  => 'text',
              'wrapper' => array(
                'width' => 20
              )
            ),
            array(
              'key'   => $prefix . 'review_message',
              'label' => __( 'Message', THEME_SLUG ),
              'name'  => 'message',
              'type'  => 'text',
              'wrapper' => array(
                'width' => 80
              )
            ),
          )
        ),
        array(
          'key' => $prefix . 'gallery_tab',
          'label' => __( 'Gallery', THEME_SLUG ),
          'name' => $prefix . 'gallery_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
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
        [
          'key' => $prefix . 'article_tab',
          'label' => __( 'Article', THEME_SLUG ),
          'name' => $prefix . 'article_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ],
        array(
          'key' => $prefix . 'article',
          'label' => '',
          'name' => $prefix . 'article',
          'type' => 'post_object',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'post_type' => array(
            0 => 'news',
          ),
          'taxonomy' => array(
            0 => 'news_cat:knowledge',
          ),
          'allow_null' => 0,
          'multiple' => 1,
          'return_format' => 'id',
          'ui' => 1,
          'translations' => 'sync',
        ),
      ),
      'location' => [
        [
          [
            'param' => 'page_template',
            'operator' => '==',
            'value' => 'template-academy.php',
          ],
        ],
      ],
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => array(
        // 0 => 'the_content',
        // 1 => 'page_attributes',
        2 => 'featured_image',
      ),
      'active' => true,
      'description' => '',
    ));
  }

  public function save( $post_id ) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
      return;

    if ( wp_is_post_revision( $post_id ) )
      return;

    if ( 'page' != get_post_type( $post_id ) && $post_id === 8 )

      return;

  }

}

Shinyu_Page_Academy::get_instance();
