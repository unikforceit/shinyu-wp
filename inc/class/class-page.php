<?php

class TR_Page {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new TR_Page();
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
        'key' => $prefix . 'options',
        'title' => __('Page Options', THEME_SLUG),
        'fields' => [
          [
            'key' => $prefix . 'title_tab',
            'label' => __( 'Page Header', THEME_SLUG ),
            'name' => $prefix . 'title_tab',
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
          [
            'key' => $prefix . 'banner_tab',
            'label' => __( 'Banner', THEME_SLUG ),
            'name' => $prefix . 'banner_tab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => $prefix . 'start_column',
            'label' => __( 'Start', THEME_SLUG ),
            'name' => $prefix . 'start_column',
            'type' => 'button_group',
            'instructions' => '',
            'choices' => [
              '1' => 'One Column',
              '2' => 'Two Column',
            ],
            'allow_null' => 0,
            'default_value' => '1',
            'layout' => 'horizontal',
            'return_format' => 'value',
          ],
          [
            'key' => $prefix . 'banner',
            'label' => ' ',
            'name' => $prefix . 'banner',
            'type' => 'repeater',
            'layout' => 'row',
            'button_label' => '',
            'sub_fields' => [
              [
                'key' => $prefix . 'banner_title',
                'label' => __( 'Title', THEME_SLUG ),
                'name' => 'title',
                'type' => 'text',
                'wrapper' => ['width' => 50],
              ],
              [
                'key' => $prefix . 'background',
                'label' => __( 'Background', THEME_SLUG ),
                'name' => 'background',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'wrapper' => ['width' => 25],
              ],
              [
                'key' => $prefix . 'banner_link',
                'label' => __( 'Link', THEME_SLUG ),
                'name' => 'link',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => ['width' => 25],
              ],
              [
                'key' => $prefix . 'banner_description',
                'label' => __( 'Description', THEME_SLUG ),
                'name' => 'description',
                'type' => 'textarea',
              ],
              [
                'key' => $prefix . 'text_align',
                'label' => __( 'Align', THEME_SLUG ),
                'name' => 'text_align',
                'type' => 'button_group',
                'instructions' => '',
                'choices' => [
                  'center' => 'Center',
                  'left' => 'left',
                  'right' => 'Right',
                ],
                'allow_null' => 0,
                'default_value' => 'center',
                'layout' => 'horizontal',
                'return_format' => 'value',
              ],
              [
                'key' => $prefix . 'color',
                'label' => __('Color', THEME_SLUG),
                'name' => 'color',
                'type' => 'button_group',
                'instructions' => '',
                'choices' => [
                  'white' => 'White',
                  'blue' => 'Blue',
                ],
                'allow_null' => 0,
                'default_value' => 'white',
                'layout' => 'horizontal',
                'return_format' => 'value',
              ],
              [
                'key' => $prefix . 'zoom_background',
                'label' => __('Background Zoom On Hover', THEME_SLUG),
                'name' => 'zoom_background',
                'type' => 'true_false',
                'instructions' => '',
                'message' => '',
                'default_value' => 1,
                'ui' => 1,
              ],
            ],
          ],
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
              'value' => 'template-thairung-layout.php',
            ],
            [
              'param' => 'page_type',
              'operator' => '==',
              'value' => 'top_level',
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

  public function save($post_id) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
      return;

    if (wp_is_post_revision($post_id))
      return;

    if ('page' != get_post_type($post_id))
      return;
  }
}

TR_Page::get_instance();