<?php

class TR_Page_Job {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new TR_Page_Job();
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
    $prefix = '_page_';

    if (function_exists('acf_add_local_field_group')):

      acf_add_local_field_group([
        'key' => '_job_options',
        'title' => __('Page Options', THEME_SLUG),
        'fields' => [
          [
            'key' => $prefix . 'header_tab',
            'label' => __( 'Page Header', THEME_SLUG ),
            'name' => $prefix . 'header_tab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => $prefix . 'title',
            'label' => __( 'Title', THEME_SLUG ),
            'name' => $prefix . 'title',
            'type' => 'text',
          ],
          [
            'key' => $prefix . 'description',
            'label' => __( 'Description', THEME_SLUG ),
            'name' => $prefix . 'description',
            'type' => 'textarea',
          ],
          [
            'key' => $prefix . 'header_background',
            'label' => __( 'Background', THEME_SLUG ),
            'name' => $prefix . 'header_background',
            'type' => 'image',
            'return_format' => 'id',
            'preview_size' => 'thumbnail',
            'library' => 'all',
            'mime_types' => '',
          ]
        ],
        'location' => [
          [
            // array(
            //   'param' => 'post_type',
            //   'operator' => '==',
            //   'value' => 'page',
            // ),
            [
              'param' => 'page_template',
              'operator' => '==',
              'value' => 'template-job.php',
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

TR_Page_Job::get_instance();