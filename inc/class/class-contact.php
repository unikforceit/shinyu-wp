<?php

class TR_Contact {

  protected static $instance = null;

  private $url = '';

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new TR_Contact();
    }
    return self::$instance;

  }

	public function __construct() {
		$this->hooks();
	}

	public function hooks() {
    add_action('acf/init', [$this, 'fields']);
	}

  public function fields() {
    $prefix = '_contact_';

    if (function_exists('acf_add_local_field_group')):

      acf_add_local_field_group([
        'key' => $prefix . 'options',
        'title' => __('Page Options', THEME_SLUG),
        'fields' => [
          [
            'key' => $prefix . 'title_tab',
            'label' => __( 'Page Title', THEME_SLUG ),
            'name' => $prefix . 'title_tab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => '_page_slider',
            'label' => __( 'Slider', THEME_SLUG ),
            'name' => '_page_slider',
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
              'param' => 'page_template',
              'operator' => '==',
              'value' => 'template-contact.php',
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
  }
}

TR_Contact::get_instance();