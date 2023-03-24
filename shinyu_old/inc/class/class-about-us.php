<?php

class Mimo_About {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_About();
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


    $prefix = 'about_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Content', THEME_SLUG ),
      'fields' => array(
        array(
          'key' => $prefix . 'overview',
          'label' => __( 'Overview', THEME_SLUG ),
          'name' => $prefix . 'overview',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'overview_content',
          'label' => __( 'Content', THEME_SLUG ),
          'name' => $prefix . 'overview_content',
          'type' => 'wysiwyg',
          'tabs' => 'all',
          'toolbar' => 'full',
          'media_upload' => 0,
          'wrapper' => array(
            'width' => '70',
          )
        ),
        array(
          'key' => $prefix.'overview_image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'medium',
          'library' => 'all',
          'mime_types' => '',
          'wrapper' => array(
            'width' => '30'
          )
        ),
        array(
          'key' => $prefix . 'invest_in_trust',
          'label' => __( 'Invest in Trust', THEME_SLUG ),
          'name' => $prefix . 'invest_in_trust',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix.'invest_in_trust_item',
          'label' => __( 'Content', THEME_SLUG ),
          'name' => $prefix.'invest_in_trust_item',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __( 'Add Item', THEME_SLUG ),
          'sub_fields' => array(
            array(
              'key'   => $prefix . 'invest_in_trust_icon',
              'label' => __( 'Icon', THEME_SLUG ),
              'name'  => 'icon',
              'type'  => 'text'
            ),
            array(
              'key'   => $prefix . 'invest_in_trust_title',
              'label' => __( 'Title', THEME_SLUG ),
              'name'  => 'title',
              'type'  => 'text'
            ),
            array(
              'key'   => $prefix . 'invest_in_trust_description',
              'label' => __( 'Description', THEME_SLUG ),
              'name'  => 'description',
              'type'  => 'textarea'
            ),
          )
        ),
        array(
          'key' => $prefix.'invest_in_trust_background',
          'label' => __( 'Background', THEME_SLUG ),
          'name' => $prefix.'invest_in_trust_background',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'full',
          'library' => 'all',
        ),
        array(
          'key' => $prefix . 'people',
          'label' => __( 'People', THEME_SLUG ),
          'name' => $prefix . 'people',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'people_content',
          'label' => __( 'Description', THEME_SLUG ),
          'name' => $prefix . 'people_content',
          'type' => 'wysiwyg',
          'tabs' => 'all',
          'toolbar' => 'full',
          'media_upload' => 0,
        ),
        array(
          'key' => $prefix.'people_item',
          'label' => __( 'People', THEME_SLUG ),
          'name' => $prefix.'people_item',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'block',
          'button_label' => __( 'Add People', THEME_SLUG ),
          'sub_fields' => array(
            array(
              'key' => $prefix.'people_profile',
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
              'key'   => $prefix . 'people_name',
              'label' => __( 'Name', THEME_SLUG ),
              'name'  => 'name',
              'type'  => 'text',
              'wrapper' => array(
                'width' => 60
              )
            ),
            array(
              'key'   => $prefix . 'people_position',
              'label' => __( 'Position', THEME_SLUG ),
              'name'  => 'position',
              'type'  => 'text',
              'wrapper' => array(
                'width' => 20
              )
            ),
          )
        ),
        array(
          'key' => $prefix . 'building_owners',
          'label' => __( 'Building Owners', THEME_SLUG ),
          'name' => $prefix . 'building_owners',
          'type' => 'tab',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix . 'building_owners_logo',
          'label' => '',
          'name' => $prefix . 'building_owners_logo',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
          // 'instructions' => '600px X 600px',
        ),
        array(
          'key' => $prefix . 'partners',
          'label' => __( 'Partners', THEME_SLUG ),
          'name' => $prefix . 'partners',
          'type' => 'tab',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix . 'partners_logo',
          'label' => '',
          'name' => $prefix . 'partners_logo',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
          // 'instructions' => '600px X 600px',
        ),
        array(
          'key' => $prefix . 'corporate',
          'label' => __( 'Corporate', THEME_SLUG ),
          'name' => $prefix . 'corporate',
          'type' => 'tab',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix . 'corporate_logo',
          'label' => '',
          'name' => $prefix . 'corporate_logo',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
          // 'instructions' => '600px X 600px',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'page',
            'operator' => '==',
            'value' => 4398,
          ),
        ),
        array(
          array(
            'param' => 'page',
            'operator' => '==',
            'value' => 3679,
          ),
        ),
        array(
          array(
            'param' => 'page',
            'operator' => '==',
            'value' => 7597,
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => array(
        0 => 'the_content',
        1 => 'page_attributes',
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

Mimo_About::get_instance();
