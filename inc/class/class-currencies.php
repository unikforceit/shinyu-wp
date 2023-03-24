<?php

class Mimo_Currencies {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Currencies();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

    // add_action( 'init', array( $this, 'register_post_type' ) );
    
    add_action('acf/init', array( $this, 'options_pages') );
    add_action('acf/init', array( $this, 'fields') );
    
	}


  public function scripts() {
  }

  public function options_pages() {

    // Check function exists.
    if( !function_exists('acf_add_options_page') )
        return;
  
    $option_page = acf_add_options_sub_page(array(
      'page_title' 	=> 'ตั้งค่าสกุลเงิน',
      'menu_title' 	=> 'สกุลเงิน',
      'menu_slug' 	=> 'currencies-settings',
      'parent_slug' => 'options-general.php',
      'redirect' 	  => false
    ));
  }

	public function fields() {

		$prefix = '_currency_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'สกุลเงิน', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix.'thb_section_title',
          'label' => __( 'Baht', THEME_SLUG ),
          'name' => $prefix.'thb_section_title',
          'type' => 'title',
        ),
        array(
          'key' => $prefix.'thb_title',
          'label' => 'Title',
          'name' => $prefix.'thb_title',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'thb_unit',
          'label' => __( 'Unit', THEME_SLUG ),
          'name' => $prefix.'thb_unit',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'thb_rate',
          'label' => __( 'Rate', THEME_SLUG ),
          'name' => $prefix.'thb_rate',
          'type' => 'number',
          'readonly' => 1,
          'default_value' => 1,
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'thb_code',
          'label' => __( 'Code', THEME_SLUG ),
          'name' => $prefix.'thb_code',
          'type' => 'text',
          'readonly' => 1,
          'default_value' => 'THB',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'usd_section_title',
          'label' => __( 'US Dollar', THEME_SLUG ),
          'name' => $prefix.'usd_section_title',
          'type' => 'title',
        ),
        array(
          'key' => $prefix.'usd_title',
          'label' => 'Title',
          'name' => $prefix.'usd_title',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'usd_unit',
          'label' => __( 'Unit', THEME_SLUG ),
          'name' => $prefix.'usd_unit',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'usd_rate',
          'label' => __( 'Rate', THEME_SLUG ),
          'name' => $prefix.'usd_rate',
          'type' => 'number',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'usd_code',
          'label' => __( 'Code', THEME_SLUG ),
          'name' => $prefix.'usd_code',
          'type' => 'text',
          'readonly' => 1,
          'default_value' => 'USD',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'jpy_section_title',
          'label' => __( 'Yen', THEME_SLUG ),
          'name' => $prefix.'jpy_section_title',
          'type' => 'title',
        ),
        array(
          'key' => $prefix.'jpy_title',
          'label' => 'Title',
          'name' => $prefix.'jpy_title',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'jpy_unit',
          'label' => __( 'Unit', THEME_SLUG ),
          'name' => $prefix.'jpy_unit',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'jpy_rate',
          'label' => __( 'Rate', THEME_SLUG ),
          'name' => $prefix.'jpy_rate',
          'type' => 'number',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'jpy_code',
          'label' => __( 'Code', THEME_SLUG ),
          'name' => $prefix.'jpy_code',
          'type' => 'text',
          'readonly' => 1,
          'default_value' => 'JPY',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'cny_section_title',
          'label' => __( 'Yuan', THEME_SLUG ),
          'name' => $prefix.'cny_section_title',
          'type' => 'title',
        ),
        array(
          'key' => $prefix.'cny_title',
          'label' => 'Title',
          'name' => $prefix.'cny_title',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'cny_unit',
          'label' => __( 'Unit', THEME_SLUG ),
          'name' => $prefix.'cny_unit',
          'type' => 'text',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'cny_rate',
          'label' => __( 'Rate', THEME_SLUG ),
          'name' => $prefix.'cny_rate',
          'type' => 'number',
          'wrapper' => array('width' => 25)
        ),
        array(
          'key' => $prefix.'cny_code',
          'label' => __( 'Code', THEME_SLUG ),
          'name' => $prefix.'cny_code',
          'type' => 'text',
          'readonly' => 1,
          'default_value' => 'CNY',
          'wrapper' => array('width' => 25)
        ),
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'currencies-settings',
          ),
        ),
      ),
    ));

  }
}

Mimo_Currencies::get_instance();