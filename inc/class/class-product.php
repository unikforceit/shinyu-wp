<?php

class Shinyu_Product {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Product();
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
    if (function_exists('acf_add_local_field_group')) :

      $prefix = '_product_';

      acf_add_local_field_group([
        'key' => $prefix . 'setting',
        'title' => 'Testimonial',
        'fields' => [
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
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'product',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
      ]);

      $prefix = '_product_interior_';
      acf_add_local_field_group([
        'key' => $prefix . 'setting',
        'title' => 'Work',
        'fields' => [
          [
            'key' => $prefix . 'gallery',
            'label' => '',
            'name' => $prefix . 'gallery',
            'type' => 'gallery',
            'insert' => 'append',
            'library' => 'all',
            'mime_types' => '',
            'return_format' => 'id',
            'translations' => 'sync',
          ],
          
          [
            'key' => $prefix . 'luxury_tab',
            'label' => __('Luxury', THEME_SLUG ),
            'name' => $prefix . 'luxury_tab',
            'type' => 'tab',
          ],
          [
            'key' => $prefix . 'gallery',
            'label' => '',
            'name' => $prefix . 'gallery',
            'type' => 'gallery',
            'insert' => 'append',
            'library' => 'all',
            'mime_types' => '',
            'return_format' => 'id',
            'translations' => 'sync',
          ],
          [
            'key' => $prefix . 'luxury_gallery',
            'label' => '',
            'name' => $prefix . 'luxury_gallery',
            'type' => 'gallery',
            'insert' => 'append',
            'library' => 'all',
            'mime_types' => '',
            'return_format' => 'id',
            'translations' => 'sync',
          ],
          [
            'key' => $prefix . 'legacy_tab',
            'label' => __('Legacy', THEME_SLUG ),
            'name' => $prefix . 'legacy_tab',
            'type' => 'tab',
          ],
          [
            'key' => $prefix . 'legacy_gallery',
            'label' => '',
            'name' => $prefix . 'legacy_gallery',
            'type' => 'gallery',
            'insert' => 'append',
            'library' => 'all',
            'mime_types' => '',
            'return_format' => 'id',
            'translations' => 'sync',
          ],
          [
            'key' => $prefix . 'supremacy_tab',
            'label' => __('Supremacy', THEME_SLUG ),
            'name' => $prefix . 'supremacy_tab',
            'type' => 'tab',
          ],
          [
            'key' => $prefix . 'supremacy_gallery',
            'label' => '',
            'name' => $prefix . 'supremacy_gallery',
            'type' => 'gallery',
            'insert' => 'append',
            'library' => 'all',
            'mime_types' => '',
            'return_format' => 'id',
            'translations' => 'sync',
          ],
        ],
        'location' => [
          [
            [
              'param' => 'post_template',
              'operator' => '==',
              'value' => 'template-product-interior.php',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
      ]);

      $prefix = '_product_courses_';
      acf_add_local_field_group([
        'key' => $prefix . 'setting',
        'title' => 'Courses Option',
        'fields' => [
          [
            'key' => $prefix . 'coach',
            'label' => __('ผู้สอน', THEME_SLUG ),
            'name' => $prefix . 'coach',
            'type' => 'text',
          ],
          [
            'key' => $prefix . 'ep',
            'label' => __('จำนวนบทเรียน', THEME_SLUG ),
            'name' => $prefix . 'ep',
            'type' => 'text',
          ],
          [
            'key' => $prefix . 'time',
            'label' => __('เวลา', THEME_SLUG ),
            'name' => $prefix . 'time',
            'type' => 'text',
          ],
          [
            'key' => $prefix . 'study_link',
            'label' => __('กลุ่มเรียน', THEME_SLUG ),
            'name' => $prefix . 'study_link',
            'type' => 'url',
          ],
        ],
        'location' => [
          [
            [
              'param' => 'post_template',
              'operator' => '==',
              'value' => 'template-product-courses.php',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
      ]);

      $prefix = '_product_management_';
      acf_add_local_field_group([
        'key' => $prefix . 'setting',
        'title' => 'Management',
        'fields' => [
          [
            'key' => $prefix . 'general_tab',
            'label' => __( 'General', THEME_SLUG ),
            'name' => $prefix . 'general_tab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => $prefix . 'title',
            'label' => __('Title', THEME_SLUG ),
            'name' => $prefix . 'title',
            'type' => 'text',
            'translations' => 'translate',
          ],
          [
            'key' => $prefix . 'description',
            'label' => __('Description', THEME_SLUG ),
            'name' => $prefix . 'description',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'default_value' => '',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
            'delay' => 0,
            'translations' => 'translate',
          ],
          [
            'key' => $prefix.'plan',
            'label' => '',
            'name' => $prefix.'plan',
            'type' => 'repeater',
            'required' => 0,
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => __( 'Add row', THEME_SLUG ),
            'translations' => 'translate',
            'sub_fields' => [
              [
                'key'   => $prefix . 'plan_title',
                'label' => __( 'Title', THEME_SLUG ),
                'name'  => 'title',
                'type'  => 'text',
                'wrapper' => ['width' => 40]
              ],
              [
                'key' => $prefix . 'plan_1',
                'label' => __('3 months', THEME_SLUG ),
                'name' => 'plan_1',
                'type' => 'text',
                'wrapper' => ['width' => 10]
              ],
              [
                'key' => $prefix . 'plan_2',
                'label' => __('6 months', THEME_SLUG ),
                'name' => 'plan_2',
                'type' => 'text',
                'wrapper' => ['width' => 10]
              ],
              [
                'key' => $prefix . 'plan_3',
                'label' => __('1 year', THEME_SLUG ),
                'name' => 'plan_3',
                'type' => 'text',
                'wrapper' => ['width' => 10]
              ],
              [
                'key' => $prefix . 'plan_4',
                'label' => __('3 months', THEME_SLUG ),
                'name' => 'plan_4',
                'type' => 'text',
                'wrapper' => ['width' => 10]
              ],
              [
                'key' => $prefix . 'plan_5',
                'label' => __('6 months', THEME_SLUG ),
                'name' => 'plan_5',
                'type' => 'text',
                'wrapper' => ['width' => 10]
              ],
              [
                'key' => $prefix . 'plan_6',
                'label' => __('1 year', THEME_SLUG ),
                'name' => 'plan_6',
                'type' => 'text',
                'wrapper' => ['width' => 10]
              ],
            ]
          ],
          [
            'key' => $prefix . 'property_consultant_tab',
            'label' => 'Property Consultant',
            'name' => $prefix . 'property_consultant_tab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => $prefix . 'property_consultant',
            'label' => '',
            'name' => $prefix . 'property_consultant',
            'type' => 'textarea',
            'rows' => 20,
          ],
        ],
        'location' => [
          [
            [
              'param' => 'post_template',
              'operator' => '==',
              'value' => 'template-product-service-package-management.php',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
      ]);
    endif;
  }
}

Shinyu_Product::get_instance();



// if( function_exists('acf_add_local_field_group') ):

// acf_add_local_field_group(array(
// 	'key' => 'group_608fb69b4e13f',
// 	'title' => 'Test',
// 	'fields' => array(
// 		array(
// 			'key' => 'field_608fb6a2c65fd',
// 			'label' => 'asdasdas',
// 			'name' => 'asdasdas',
// 			'type' => 'text',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'default_value' => '',
// 			'placeholder' => '',
// 			'prepend' => '',
// 			'append' => '',
// 			'maxlength' => '',
// 			'translations' => 'sync',
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'post_template',
// 				'operator' => '==',
// 				'value' => 'template-product-interior.php',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'top',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));

// endif;
