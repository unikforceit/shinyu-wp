<?php

class Mimo_Service {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Service();
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


    $prefix = 'service_';

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
          'key' => $prefix . 'buy_sell_rent',
          'label' => __( 'Buy/Sell/Rent', THEME_SLUG ),
          'name' => $prefix . 'buy_sell_rent',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'buy_description',
          'label' => __( 'Buy', THEME_SLUG ),
          'name' => $prefix . 'buy_description',
          'type' => 'textarea',
          'wrapper' => array(
            'width' => '33.3333'
          )
        ),
        array(
          'key' => $prefix . 'sell_description',
          'label' => __( 'Sell', THEME_SLUG ),
          'name' => $prefix . 'sell_description',
          'type' => 'textarea',
          'wrapper' => array(
            'width' => '33.3333'
          )
        ),
        array(
          'key' => $prefix . 'rent_description',
          'label' => __( 'Rent', THEME_SLUG ),
          'name' => $prefix . 'rent_description',
          'type' => 'textarea',
          'wrapper' => array(
            'width' => '33.3333'
          )
        ),
        array(
          'key' => $prefix.'buy_sell_rent_image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => $prefix.'buy_sell_rent_image',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'full',
          'library' => 'all',
          'wrapper' => array(
            'width' => '50'
          )
        ),
        array(
          'key' => $prefix.'buy_sell_rent_background',
          'label' => __( 'Background', THEME_SLUG ),
          'name' => $prefix.'buy_sell_rent_background',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'full',
          'library' => 'all',
          'wrapper' => array(
            'width' => '50'
          )
        ),
        array(
          'key' => $prefix . 'investment',
          'label' => __( 'Investment', THEME_SLUG ),
          'name' => $prefix . 'investment',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'investment_content',
          'label' => __( 'Content', THEME_SLUG ),
          'name' => $prefix . 'investment_content',
          'type' => 'textarea',
          // 'wrapper' => array(
          //   'width' => '33.3333'
          // )
        ),
        array(
          'key' => $prefix . 'interior_design',
          'label' => __( 'Interior Design', THEME_SLUG ),
          'name' => $prefix . 'interior_design',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'interior_design_content',
          'label' => __( 'Content', THEME_SLUG ),
          'name' => $prefix . 'interior_design_content',
          'type' => 'textarea',
          // 'wrapper' => array(
          //   'width' => '33.3333'
          // )
        ),
        array(
          'key' => $prefix.'interior_design_image_1',
          'label' => __( 'Image 1', THEME_SLUG ),
          'name' => $prefix.'interior_design_image_1',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'full',
          'library' => 'all',
          'wrapper' => array(
            'width' => '50'
          )
        ),
        array(
          'key' => $prefix.'interior_design_image_2',
          'label' => __( 'Image 2', THEME_SLUG ),
          'name' => $prefix.'interior_design_image_2',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'full',
          'library' => 'all',
          'wrapper' => array(
            'width' => '50'
          )
        ),
        array(
          'key' => $prefix . 'management',
          'label' => __( 'Management', THEME_SLUG ),
          'name' => $prefix . 'management',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'management_content',
          'label' => __( 'Content', THEME_SLUG ),
          'name' => $prefix . 'management_content',
          'type' => 'textarea',
          // 'wrapper' => array(
          //   'width' => '33.3333'
          // )
        ),
        array(
          'key' => $prefix.'management_image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => $prefix.'management_image',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'full',
          'library' => 'all',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'page',
            'operator' => '==',
            'value' => 4401,
          ),
        ),
        array(
          array(
            'param' => 'page',
            'operator' => '==',
            'value' => 191,
          ),
        ),
        array(
          array(
            'param' => 'page',
            'operator' => '==',
            'value' => 7578,
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

}

Mimo_Service::get_instance();
