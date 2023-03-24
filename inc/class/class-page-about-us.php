<?php

class Shinyu_Page_About {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_Page_About();
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
          'key' => $prefix . 'vision_mission_tab',
          'label' => __( 'Vision Mission', THEME_SLUG ),
          'name' => $prefix . 'vision_mission_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        [
          'key'           => $prefix . 'vision_section_title',
          'label'         => 'Vision',
          'name'          => $prefix . 'vision_section_title',
          'type'          => 'title',
        ],
        [
          'key'           => $prefix . 'vision_title',
          'label'         => 'Title',
          'name'          => $prefix . 'vision_title',
          'type'          => 'text',
        ],
        [
          'key'           => $prefix . 'vision_description',
          'label'         => 'Description',
          'name'          => $prefix . 'vision_description',
          'type'          => 'textarea',
          'new_lines'     => 'br',
        ],
        [
          'key'           => $prefix . 'mission_section_title',
          'label'         => 'Mission',
          'name'          => $prefix . 'mission_section_title',
          'type'          => 'title',
        ],
        [
          'key'           => $prefix . 'mission_title',
          'label'         => 'Title',
          'name'          => $prefix . 'mission_title',
          'type'          => 'text',
        ],
        [
          'key'           => $prefix . 'mission_description',
          'label'         => 'Description',
          'name'          => $prefix . 'mission_description',
          'type'          => 'textarea',
          'new_lines'     => 'br',
        ],
        [
          'key'           => $prefix . 'slogan_section_title',
          'label'         => 'Slogan',
          'name'          => $prefix . 'slogan_section_title',
          'type'          => 'title',
        ],
        [
          'key'           => $prefix . 'slogan_title',
          'label'         => 'Title',
          'name'          => $prefix . 'slogan_title',
          'type'          => 'text',
        ],
        [
          'key'           => $prefix . 'slogan_description',
          'label'         => 'Description',
          'name'          => $prefix . 'slogan_description',
          'type'          => 'text',
        ],

        array(
          'key' => $prefix . 'invest_in_trust',
          'label' => __( 'Shinyu Value', THEME_SLUG ),
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
            // array(
            //   'key'   => $prefix . 'invest_in_trust_icon',
            //   'label' => __( 'Icon', THEME_SLUG ),
            //   'name'  => 'icon',
            //   'type'  => 'text'
            // ),
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
          'key' => $prefix . 'people_image',
          'label' => __( 'Description', THEME_SLUG ),
          'name' => $prefix . 'people_image',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'medium',
          'library' => 'all',
          'mime_types' => '',
        ),
        array(
          'key' => $prefix.'people_item',
          'label' => __( 'Team', THEME_SLUG ),
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
                'width' => 20
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
            [
              'key' => $prefix . 'people_education',
              'label' => 'Education',
              'name' => 'education',
              'type' => 'textarea',
              'new_lines' => 'br',
              'wrapper' => array(
                'width' => 40
              )
            ],
          )
        ),
        [
          'key' => $prefix . 'location_tab',
          'label' => 'Location',
          'name' => $prefix . 'location_tab',
          'type' => 'tab',
        ],
        [
          'key' => $prefix . 'corporate_name',
          'label' => 'Corporate name',
          'name' => $prefix . 'corporate_name',
          'type' => 'text',
        ],
        [
          'key' => $prefix . 'corporate_address',
          'label' => 'Address',
          'name' => $prefix . 'corporate_address',
          'type' => 'textarea',
          'new_lines' => 'br',
        ],
        [
          'key' => $prefix . 'corporate_registration_date',
          'label' => 'Registration date',
          'name' => $prefix . 'corporate_registration_date',
          'type' => 'text',
        ],
        [
          'key' => $prefix . 'corporate_registered_capital',
          'label' => 'Registered capital',
          'name' => $prefix . 'corporate_registered_capital',
          'type' => 'text',
        ],
        [
          'key' => $prefix.'corporate_image',
          'label' => 'Image',
          'name' => $prefix.'corporate_image',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'medium',
          'library' => 'all',
          'mime_types' => '',
        ],
        [
          'key' => $prefix . 'certificate_tab',
          'label' => 'Certificate',
          'name' => $prefix . 'certificate_tab',
          'type' => 'tab',
        ],
        [
          'key' => $prefix . 'certificate',
          'label' => '',
          'name' => $prefix . 'certificate',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
        ],
        [
          'key' => $prefix . 'history_tab',
          'label' => 'History',
          'name' => $prefix . 'history_tab',
          'type' => 'tab',
        ],
        [
          'key' => $prefix.'history',
          'label' => '',
          'name' => $prefix.'history',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Year', THEME_SLUG ),
          'sub_fields' => [
            [
              'key'           => $prefix . 'history_year',
              'label'         => 'Title',
              'name'          => 'title',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'history_description',
              'label'         => 'Description',
              'name'          => 'description',
              'type' => 'wysiwyg',
              'tabs' => 'all',
              'toolbar' => 'full',
              'media_upload' => 0,
            ],
          ],
        ],
        [
          'key' => $prefix . 'subsidiaries_tab',
          'label' => 'Subsidiaries',
          'name' => $prefix . 'subsidiaries_tab',
          'type' => 'tab',
        ],
        [
          'key' => $prefix.'subsidiaries',
          'label' => '',
          'name' => $prefix.'subsidiaries',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add', THEME_SLUG ),
          'sub_fields' => [
            [
              'key'           => $prefix . 'subsidiaries_name',
              'label'         => 'Name',
              'name'          => 'name',
              'type'          => 'text',
            ],
            [
              'key'           => $prefix . 'subsidiaries_description',
              'label'         => 'Description',
              'name'          => 'description',
              'type'          => 'textarea',
              'new_lines'     => 'br',
            ],
            [
              'key' => $prefix.'subsidiaries_logo',
              'label' => 'Logo',
              'name' => 'logo',
              'type' => 'image',
              'return_format' => 'id',
              'preview_size' => 'thumbnail',
              'library' => 'all',
            ]
          ],
        ],

        [
          'key' => $prefix . 'services_tab',
          'label' => 'Services',
          'name' => $prefix . 'services_tab',
          'type' => 'tab',
        ],
        [
          'key' => $prefix . 'services_content',
          'label' => 'Description',
          'name' => $prefix . 'services_content',
          'type' => 'textarea',
          'new_lines' => 'br',
        ],
        [
          'key' => $prefix.'services_image',
          'label' => 'Image',
          'name' => $prefix.'services_image',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'medium',
          'library' => 'all',
          'mime_types' => '',
        ],

        [
          'key' => $prefix . 'award_tab',
          'label' => 'Award',
          'name' => $prefix . 'award_tab',
          'type' => 'tab',
        ],
        [
          'key' => $prefix.'award',
          'label' => '',
          'name' => $prefix.'award',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => 'Add Award',
          'sub_fields' => [
            [
              'key'           => $prefix . 'award_name',
              'label'         => 'Name',
              'name'          => 'name',
              'type'          => 'textarea',
              'new_lines'     => 'br',
            ],
            [
              'key' => $prefix.'award_image',
              'label' => 'Logo',
              'name' => 'logo',
              'type' => 'image',
              'return_format' => 'id',
              'preview_size' => 'thumbnail',
              'library' => 'all',
            ]
          ],
        ],
        [
          'key' => $prefix . 'work_tab',
          'label' => 'Works',
          'name' => $prefix . 'work_tab',
          'type' => 'tab',
        ],
        [
          'key' => $prefix.'work',
          'label' => '',
          'name' => $prefix.'work',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 4,
          'layout' => 'row',
          'button_label' => 'Add work',
          'sub_fields' => [
            [
              'key'           => $prefix . 'work_name',
              'label'         => 'Name',
              'name'          => 'name',
              'type'          => 'text',
              'new_lines'     => 'br',
            ],
            [
              'key' => $prefix.'work_image',
              'label' => 'Image',
              'name' => 'image',
              'type' => 'image',
              'return_format' => 'id',
              'preview_size' => 'thumbnail',
              'library' => 'all',
            ],
            [
              'key'           => $prefix . 'work_link',
              'label'         => 'Link',
              'name'          => 'link',
              'type'          => 'url',
            ],
          ],
        ],

        array(
          'key' => $prefix . 'building_owners',
          'label' => __( 'PARTNERSHIP', THEME_SLUG ),
          'name' => $prefix . 'building_owners',
          'type' => 'tab',
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
          'label' => __( 'STRATEGIC PARTNERS', THEME_SLUG ),
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
      'location' => [
        [
          [
            'param' => 'page_template',
            'operator' => '==',
            'value' => 'template-about.php',
          ],
        ],
      ],
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => array(
        0 => 'the_content',
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

Shinyu_Page_About::get_instance();
