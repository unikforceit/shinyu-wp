<?php

class Mimo_home {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_home();
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


    $prefix = 'home_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Content', THEME_SLUG ),
      'fields' => array(
        array(
          'key' => $prefix . 'banner_tab',
          'label' => __( 'Banner', THEME_SLUG ),
          'name' => $prefix . 'banner_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'banner',
          'label' => '',
          'name' => $prefix.'banner',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add banner', THEME_SLUG ),
          'sub_fields' => array (
            array (
              'key'           => $prefix . 'banner_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'thumbnail',
              'library'       => 'all',
            ),
            array (
              'key'           => $prefix . 'banner_link',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'url',
            ),
          ),
        ),
        array(
          'key' => $prefix . 'menu_tab',
          'label' => __( 'Menu', THEME_SLUG ),
          'name' => $prefix . 'menu_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'menu',
          'label' => '',
          'name' => $prefix.'menu',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add menu', THEME_SLUG ),
          'sub_fields' => array (
            array (
              'key'           => $prefix . 'menu_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'thumbnail',
              'library'       => 'all',
            ),
            array (
              'key'           => $prefix . 'menu_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
            ),
            array (
              'key'           => $prefix . 'menu_description',
              'label'         => __('Description', THEME_SLUG ),
              'name'          => 'description',
              'type'          => 'textarea',
            ),
            array (
              'key'           => $prefix . 'menu_link',
              'label'         => __('Link', THEME_SLUG ),
              'name'          => 'link',
              'type'          => 'text',
            ),
          ),
        ),
        array(
          'key' => $prefix . 'state',
          'label' => __( 'State', THEME_SLUG ),
          'name' => $prefix . 'state',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key'           => $prefix . 'state_customer',
          'label'         => __('Customers', THEME_SLUG ),
          'name'          => $prefix . 'state_customer',
          'type'          => 'text',
        ),
        array (
          'key'           => $prefix . 'state_total',
          'label'         => __('Total sqm leased', THEME_SLUG ),
          'name'          => $prefix . 'state_total',
          'type'          => 'text',
        ),
        array (
          'key'           => $prefix . 'state_room',
          'label'         => __('Room', THEME_SLUG ),
          'name'          => $prefix . 'state_room',
          'type'          => 'text',
        ),
        array (
          'key'           => $prefix . 'state_project',
          'label'         => __('Project', THEME_SLUG ),
          'name'          => $prefix . 'state_project',
          'type'          => 'text',
        ),
        array(
          'key' => $prefix . 'video_tab',
          'label' => __( 'Video', THEME_SLUG ),
          'name' => $prefix . 'video_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key'           => $prefix . 'video_title',
          'label'         => __('Title', THEME_SLUG ),
          'name'          => $prefix . 'video_title',
          'type'          => 'text',
        ),
        array (
          'key'           => $prefix . 'video_sub_title',
          'label'         => __('Sub Title', THEME_SLUG ),
          'name'          => $prefix . 'video_sub_title',
          'type'          => 'text',
        ),
        array (
          'key'           => $prefix . 'video_description',
          'label'         => __('Description', THEME_SLUG ),
          'name'          => $prefix . 'video_description',
          'type'          => 'textarea',
        ),
        array (
          'key'           => $prefix . 'video_cover',
          'label'         => __('Cover', THEME_SLUG ),
          'name'          => $prefix . 'video_cover',
          'type'          => 'image',
          'return_format' => 'id',
          'preview_size'  => 'meduim',
          'library'       => 'all',
        ),
        array (
          'key'           => $prefix . 'video_url',
          'label'         => __('Url', THEME_SLUG ),
          'name'          => $prefix . 'video_url',
          'type'          => 'url',
        ),        
      ),
      'location' => array(
        array(
          array(
            'param' => 'page_type',
            'operator' => '==',
            'value' => 'front_page',
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

Mimo_home::get_instance();
