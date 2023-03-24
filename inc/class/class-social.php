<?php

class Mimo_Social {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_Social();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {

    add_action( 'acf/init', array( $this, 'fields' ) );

	}


	public function fields() {

    $prefix = 'social_';
    
    $option_page = acf_add_options_sub_page(array(
      'page_title' 	=> 'Social',
      'menu_title' 	=> 'Social',
      'menu_slug' 	=> 'social-settings',
      'parent_slug' => 'options-general.php',
      'redirect' 	  => false
    ));

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix.'facebook',
          'label' => __( 'Facebook', THEME_SLUG ),
          'name' => $prefix.'facebook',
          'type' => 'title',
        ),
        array(
          'key' => $prefix . 'facebook_logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix . 'facebook_logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'wrapper' => array('width' => 30)
        ),
        array(
          'key' => $prefix.'facebook_url',
          'label' => __( 'Url', THEME_SLUG ),
          'name' => $prefix.'facebook_url',
          'type' => 'url',
          'wrapper' => array('width' => 70)
        ),
        array(
          'key' => $prefix.'instagram',
          'label' => __( 'Instagram', THEME_SLUG ),
          'name' => $prefix.'instagram',
          'type' => 'title',
        ),
        array(
          'key' => $prefix . 'instagram_logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix . 'instagram_logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'wrapper' => array('width' => 30)
        ),
        array(
          'key' => $prefix.'instagram_url',
          'label' => __( 'Url', THEME_SLUG ),
          'name' => $prefix.'instagram_url',
          'type' => 'url',
          'wrapper' => array('width' => 70)
        ),
        array(
          'key' => $prefix.'wechat',
          'label' => __( 'WeChat', THEME_SLUG ),
          'name' => $prefix.'wechat',
          'type' => 'title',
        ),
        array(
          'key' => $prefix . 'wechat_logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix . 'wechat_logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'wrapper' => array('width' => 30)
        ),
        array(
          'key' => $prefix.'wechat_url',
          'label' => __( 'Url', THEME_SLUG ),
          'name' => $prefix.'wechat_url',
          'type' => 'url',
          'wrapper' => array('width' => 70)
        ),
        array(
          'key' => $prefix.'whatsapp',
          'label' => __( 'WhatsApp', THEME_SLUG ),
          'name' => $prefix.'whatsapp',
          'type' => 'title',
        ),
        array(
          'key' => $prefix . 'whatsapp_logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix . 'whatsapp_logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'wrapper' => array('width' => 30)
        ),
        array(
          'key' => $prefix.'whatsapp_url',
          'label' => __( 'Url', THEME_SLUG ),
          'name' => $prefix.'whatsapp_url',
          'type' => 'url',
          'wrapper' => array('width' => 70)
        ),
        array(
          'key' => $prefix.'messenger',
          'label' => __( 'Messenger', THEME_SLUG ),
          'name' => $prefix.'messenger',
          'type' => 'title',
        ),
        array(
          'key' => $prefix . 'messenger_logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix . 'messenger_logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'wrapper' => array('width' => 30)
        ),
        array(
          'key' => $prefix.'messenger_url',
          'label' => __( 'Url', THEME_SLUG ),
          'name' => $prefix.'messenger_url',
          'type' => 'url',
          'wrapper' => array('width' => 70)
        ),
        array(
          'key' => $prefix.'line',
          'label' => __( 'Line', THEME_SLUG ),
          'name' => $prefix.'line',
          'type' => 'title',
        ),
        array(
          'key' => $prefix . 'line_logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix . 'line_logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'wrapper' => array('width' => 30)
        ),
        array(
          'key' => $prefix.'line_url',
          'label' => __( 'Url', THEME_SLUG ),
          'name' => $prefix.'line_url',
          'type' => 'url',
          'wrapper' => array('width' => 70)
        ),
        array(
          'key' => $prefix.'youtube',
          'label' => __( 'Youtube', THEME_SLUG ),
          'name' => $prefix.'youtube',
          'type' => 'title',
        ),
        array(
          'key' => $prefix . 'youtube_logo',
          'label' => __( 'Logo', THEME_SLUG ),
          'name' => $prefix . 'youtube_logo',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'wrapper' => array('width' => 30)
        ),
        array(
          'key' => $prefix.'youtube_url',
          'label' => __( 'Url', THEME_SLUG ),
          'name' => $prefix.'youtube_url',
          'type' => 'url',
          'wrapper' => array('width' => 70)
        ),
      ),
      // 'style' => 'seamless',
      'position' => 'normal',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'social-settings',
          ),
        ),
      ),
    ));
	}

}

Mimo_Social::get_instance();