<?php

class Shinyu_Unit {

  protected static $instance = null;

  public static function get_instance() {
    if ( !self::$instance ) {
      self::$instance = new Shinyu_Unit();
    }
    return self::$instance;
  }

	public function __construct() {
		$this->hooks();
	}

	public function hooks() {

    //add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

    add_action('save_post', [$this, 'save'], 13, 2);

    // add_action('transition_post_status', [$this, 'transition_post_status'], 10, 3 );

    add_action('init', [$this, 'register_post_type']);
    add_action('init', [$this, 'register_taxonomy']);
    //add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );
    add_action('acf/init', [$this, 'fields']);

    // add_action('display_post_states', [$this, 'post_states'], 10, 2);

    add_filter('manage_room_posts_columns', [$this, 'columns']);
    add_action('manage_room_posts_custom_column', [$this, 'columns_display'], 10, 2);

    add_filter('manage_edit-room_facility_columns', [$this, 'facility_columns']); 
    add_filter('manage_room_facility_custom_column', [$this, 'manage_facility_columns'], 10, 3);

    add_filter('the_title', [$this, 'the_title'], 10, 2);
	}


  public function scripts() {}

	public function register_post_type(){

		$labels = [
			'name'                  => __('Unit', THEME_SLUG),
			'menu_name'             => __('Units', THEME_SLUG),
			'all_items'             => __('All Unit', THEME_SLUG),
			'singular_name'         => __('Unit', THEME_SLUG),
			'add_new'               => __('Add New', THEME_SLUG),
			'add_new_item'          => __('Add Unit', THEME_SLUG),
			'edit_item'             => __('Edit Unit', THEME_SLUG),
			'new_item'              => __('Add Unit', THEME_SLUG),
			'view_item'             => __('View Unit', THEME_SLUG),
			'search_items'          => __('Search Unit', THEME_SLUG),
    ];
    
		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
      'has_archive'        => true,
      'capability_type'    => 'post',
      'rewrite'            => ['slug' => 'unit', 'with_front' => false],
      'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-grid-view',
      //'show_in_menu'  => 'edit.php?post_type=project',
			'supports'  => ['title', 'editor', 'author']
    ];

    register_post_type('room', $args);
    
	}

  public function register_taxonomy() {

    $labels = array(
      'name'                       => __('Facility', THEME_SLUG),
      'singular_name'              => __('Facility', THEME_SLUG),
      'menu_name'                  => __('Facilities', THEME_SLUG),
      'all_items'                  => __('All Facility', THEME_SLUG),
      'parent_item'                => __('Parent Facility', THEME_SLUG),
      'parent_item_colon'          => __('Parent Facility:', THEME_SLUG),
      'new_item_name'              => __('New Facility', THEME_SLUG),
      'add_new_item'               => __('Add Facility', THEME_SLUG),
      'edit_item'                  => __('Edit Facility', THEME_SLUG),
      'update_item'                => __('Update Facility', THEME_SLUG),
      'view_item'                  => __('View Facility', THEME_SLUG),
    );

    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    );
    register_taxonomy('room_facility', ['room'], $args);

    $labels = [
      'name'                       => __('Tag', THEME_SLUG),
      'singular_name'              => __('Tag', THEME_SLUG),
      'menu_name'                  => __('Tags', THEME_SLUG),
      'all_items'                  => __('All Tag', THEME_SLUG),
      'parent_item'                => __('Parent Tag', THEME_SLUG),
      'parent_item_colon'          => __('Parent Tag:', THEME_SLUG),
      'new_item_name'              => __('New Tag', THEME_SLUG),
      'add_new_item'               => __('Add Tag', THEME_SLUG),
      'edit_item'                  => __('Edit Tag', THEME_SLUG),
      'update_item'                => __('Update Tag', THEME_SLUG),
      'view_item'                  => __('View Tag', THEME_SLUG),
    ];

    $args = [
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
      'meta_box_cb'                => false,      
    ];
    register_taxonomy('room_tag', ['room'], $args);

  }

  public function add_submenu_page() {
    add_submenu_page(
      'edit.php?post_type=project',
      __( 'Add New', THEME_SLUG ),
      __( 'Add New', THEME_SLUG ),
      'manage_options',
      'post-new.php?post_type=room'
    );
  }

	public function fields() {

		$prefix = 'room_';

    $choice = array();

    acf_add_local_field_group([
      'key' => $prefix . 'contact_information',
      'title' => __( 'Contact information', THEME_SLUG ),
      'fields' => [
        [
          'key' => $prefix . 'author',
          'label' => __( 'Author', THEME_SLUG ),
          'name' => $prefix . 'author',
          'type' => 'user',
          'return_format' => 'id',
          'translations' => 'sync',
        ],
        [
          'key' => $prefix . 'contact_name',
          'label' => __( 'Name', THEME_SLUG ),
          'name' => $prefix . 'contact_name',
          'type' => 'text',
        ],
        [
          'key' => $prefix . 'contact_phone',
          'label' => __( 'Phone', THEME_SLUG ),
          'name' => $prefix . 'contact_phone',
          'type' => 'text',
        ],
        [
          'key' => $prefix . 'contact_email',
          'label' => __( 'Email', THEME_SLUG ),
          'name' => $prefix . 'contact_email',
          'type' => 'text',
        ],
        [
          'key' => $prefix . 'contact_line',
          'label' => __( 'Line', THEME_SLUG ),
          'name' => $prefix . 'contact_line',
          'type' => 'text',
        ],
      ],
      'position' => 'side',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => [
        [
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'room',
          ],
        ],
      ],
    ]);

    acf_add_local_field_group([
      'key' => $prefix . 'note_group',
      'title' => __( 'Other', THEME_SLUG ),
      'fields' => [
        [
          'key' => $prefix . 'include_commission',
          'label' => 'Include commission 3%',
          'name' => $prefix . 'include_commission',
          'type' => 'true_false',
          'instructions' => '',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
        ],
        [
          'key' => $prefix . 'note',
          'label' => 'Note',
          'name' => $prefix . 'note',
          'type' => 'textarea',
        ],
      ],
      'position' => 'side',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => [
        [
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'room',
          ],
        ],
      ],
    ]);

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => __( 'Setting', THEME_SLUG ),
      'fields' => array (
        array(
          'key' => $prefix . 'general',
          'label' => __( 'General', THEME_SLUG ),
          'name' => $prefix . 'general',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'project',
          'label' => __('Project', THEME_SLUG ),
          'name' => $prefix . 'project',
          'type' => 'post_object',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'wrapper' => array(),
          'post_type' => array(
            0 => 'project',
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'return_format' => 'id',
          'ui' => 1,
          'wrapper' => array( 'width' => 50 ),
          'translations' => 'sync',
        ),
        // array(
        //   'key' => $prefix . 'recommend',
        //   'label' => __('Recommend', THEME_SLUG ),
        //   'name' => $prefix . 'recommend',
        //   'type' => 'true_false',
        //   'instructions' => '',
        //   'message' => '',
        //   'default_value' => 0,
        //   'ui' => 1,
        //   'wrapper' => array( 'width' => 50 )
        // ),
        array(
          'key' => $prefix . 'condition',
          'label' => __('For', THEME_SLUG ),
          'name' => $prefix . 'condition',
          'type' => 'checkbox',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'choices' => field_transaction(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'sell_price',
          'label' => __('Price for sell', THEME_SLUG ),
          'name' => $prefix . 'sell_price',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'rent_price',
          'label' => __('Price for rent', THEME_SLUG ),
          'name' => $prefix . 'rent_price',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'deposit_price',
          'label' => __('Deposit Price', THEME_SLUG ),
          'name' => $prefix . 'deposit_price',
          'type' => 'number',
          'instructions' => '',
          'required' => 0,
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'unit_no',
          'label' => __('Unit No.', THEME_SLUG ),
          'name' => $prefix . 'unit_no',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'levels',
          'label' => __('Levels', THEME_SLUG ),
          'name' => $prefix . 'levels',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'area_sqm',
          'label' => __('Room Area (SQM)', THEME_SLUG ),
          'name' => $prefix . 'area_sqm',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'view',
          'label' => __('View', THEME_SLUG ),
          'name' => $prefix . 'view',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_view(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'direction',
          'label' => __('Direction', THEME_SLUG ),
          'name' => $prefix . 'direction',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_direction(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'type',
          'label' => __('Room Type', THEME_SLUG ),
          'name' => $prefix . 'type',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_room_type(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'bedrooms',
          'label' => __('Bedrooms', THEME_SLUG ),
          'name' => $prefix . 'bedrooms',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_bedrooms(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'bathrooms',
          'label' => __('Bathrooms', THEME_SLUG ),
          'name' => $prefix . 'bathrooms',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'choices' => field_bathrooms(),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
          'wrapper' => array( 'width' => 20 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix.'facility',
          'label' => __( 'Facility', THEME_SLUG ),
          'name' => $prefix.'facility',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'taxonomy' => 'room_facility',
          'field_type' => 'checkbox',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 1,
          'allow_null' => 0,
          // 'wrapper' => array( 'width' => 50 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix.'tag',
          'label' => __( 'Tags', THEME_SLUG ),
          'name' => $prefix.'tag',
          'type' => 'taxonomy',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'taxonomy' => 'room_tag',
          'field_type' => 'checkbox',
          'add_term' => 0,
          'save_terms' => 1,
          'load_terms' => 1,
          'return_format' => 'id',
          'multiple' => 1,
          'allow_null' => 0,
          // 'wrapper' => array( 'width' => 50 ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'image',
          'label' => __( 'Image', THEME_SLUG ),
          'name' => $prefix . 'image',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array (
          'key' => $prefix.'cover',
          'label' => __( 'Cover', THEME_SLUG ),
          'name' => '_thumbnail_id',
          'type' => 'image',
          'return_format' => 'id',
          'preview_size' => 'thumbnail',
          'library' => 'all',
          'mime_types' => '',
          'instructions' => 'Reccomment image size 1024px X 885px',
          'translations' => 'sync',
        ),
        array (
          'key' => $prefix . 'gallery',
          'label' => __('Gallery', THEME_SLUG ),
          'name' => $prefix . 'gallery',
          'type' => 'gallery',
          'insert' => 'append',
          'library' => 'all',
          'mime_types' => '',
          // 'instructions' => '600px X 600px',
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'video_tab',
          'label' => __( 'Video', THEME_SLUG ),
          'name' => $prefix . 'video_tab',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
          'translations' => 'sync',
        ),
        array (
          'key' => $prefix.'video',
          'label' => '',
          'name' => $prefix.'video',
          'type' => 'oembed',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'width' => '800',
          'height' => '600',
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'floor',
          'label' => __( 'Floor', THEME_SLUG ),
          'name' => $prefix . 'floor',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
          'translations' => 'sync',
        ),
        array (
          'key' => $prefix.'floor_item',
          'label' => '',
          'name' => $prefix.'floor_item',
          'type' => 'repeater',
          'required' => 0,
          'min' => 0,
          'max' => 0,
          'layout' => 'row',
          'button_label' => __( 'Add Floor', THEME_SLUG ),
          'sub_fields' => array (
            array (
              'key'           => $prefix . 'floor_title',
              'label'         => __('Title', THEME_SLUG ),
              'name'          => 'title',
              'type'          => 'text',
            ),
            array (
              'key'           => $prefix . 'floor_image',
              'label'         => __('Image', THEME_SLUG ),
              'name'          => 'image',
              'type'          => 'image',
              'return_format' => 'id',
              'preview_size'  => 'meduim',
              'library'       => 'all',
            ),
          ),
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'stat',
          'label' => __( 'Market Stat', THEME_SLUG ),
          'name' => $prefix . 'stat',
          'type' => 'tab',
          'placement' => 'top',
          'endpoint' => 0,
        ),
        array(
          'key' => $prefix . 'stat_1',
          'label' => __('Current asking price per sqm.', THEME_SLUG ),
          'name' => $prefix . 'stat_1',
          'type' => 'text',
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'stat_2',
          'label' => __('Asking price change from last quarter', THEME_SLUG ),
          'name' => $prefix . 'stat_2',
          'type' => 'text',
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'stat_3',
          'label' => __('Asking price chang from last year', THEME_SLUG ),
          'name' => $prefix . 'stat_3',
          'type' => 'text',
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'stat_4',
          'label' => __('Achievable gross rental yield', THEME_SLUG ),
          'name' => $prefix . 'stat_4',
          'type' => 'text',
          'translations' => 'sync',
        ),
        array(
          'key' => $prefix . 'stat_5',
          'label' => __('Rent price change from last year', THEME_SLUG ),
          'name' => $prefix . 'stat_5',
          'type' => 'text',
          'translations' => 'sync',
        ),        
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'room',
          ),
        ),
      ),
    ));

    $prefix = 'room_tag_';

    acf_add_local_field_group(array(
      'key' => $prefix . 'setting',
      'title' => '',
      'fields' => array (
        [
          'key' => $prefix . 'display_footer',
          'label' => __('Footer', THEME_SLUG ),
          'name' => $prefix . 'display_footer',
          'type' => 'true_false',
          'instructions' => '',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
        ],
        [
          'key' => $prefix . 'display_tab',
          'label' => __('Tab', THEME_SLUG ),
          'name' => $prefix . 'display_tab',
          'type' => 'true_false',
          'instructions' => '',
          'message' => '',
          'default_value' => 0,
          'ui' => 1,
        ],
      ),
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'location' => array (
        array (
          array (
            'param' => 'taxonomy',
            'operator' => '==',
            'value' => 'room_tag',
          ),
        ),
      ),
    ));

	}


  public function post_states( $post_states, $post ) {

    if ( get_field('room_recommend', $post->ID == 1) && 'room' == get_post_type( $post->ID ) ) {
      $post_states[] = __( 'Recommend', THEME_SLUG );
    }

    return $post_states;

  }
  public function columns( $columns ) {

    unset( $columns['title'] );
    unset( $columns['date'] );
    unset( $columns['taxonomy-room_facility'] );
    unset( $columns['taxonomy-room_tag'] );
    unset( $columns['author'] );    

    $columns['mimo_thumbnail']              = '<span class="dashicons-format-image"></span>';
    $columns['title']                       = __( 'Name', THEME_SLUG );
    $columns['room_project']                = __( 'Project', THEME_SLUG );
    $columns['room_condition']              = __( 'For', THEME_SLUG );
    // $columns['taxonomy-room_facility']      = __( 'Facility', THEME_SLUG );
    $columns['taxonomy-room_tag']           = __( 'Tag', THEME_SLUG );
    $columns['date']                        = __( 'Date', THEME_SLUG );

    return $columns;

  }

  public function columns_display( $column, $post_id ) {

    switch ( $column ) {
      case 'mimo_thumbnail' :
        if ( has_post_thumbnail($post_id ) ) {
          echo '<a href="'. get_edit_post_link( $post_id ) .'">' . get_the_post_thumbnail( $post_id, 'thumbnail' ) . '</a>';
        }else{}
      break;
      case 'room_condition' :
        if( $condition = get_field('room_condition', $post_id) ) echo implode(', ', $condition);
      break;
      case 'room_project' :
        if( $project_id = get_field('room_project', $post_id) ) echo get_the_title($project_id);
      break;  
    }
  }
 
  public function facility_columns($columns) {
    $new_columns = array(
      'cb'                 => '<input type="checkbox" />',
      'name'               => __('Name'),
      'facility_icon'      => __('Icon'),
      'posts'              => __('Count'),
    );
    return $new_columns;
  }
  
  public function manage_facility_columns($out, $column_name, $term_id) {
    $icon = get_field('room_facility_icon', 'term_'. $term_id); 
  
    switch ($column_name) {
      case 'facility_icon': 
        echo "<i class='".  $icon ."'></i>" ;
        break;
      default:
        break;
    }
    return $out;
  }

  
  public function save( $post_id ) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
      return;

    if ( wp_is_post_revision( $post_id ) )
      return;

    if ( 'room' != get_post_type( $post_id ) )

      return;

  }

  function transition_post_status($new_status, $old_status, $post) {
    if (('publish' === $new_status && 'draft' === $old_status )
      && 'room' === $post->post_type
    ){
      $recipient = get_field('room_contact_email', $post->ID);
      if ($recipient) {
        $email_class = WC()->mailer();
        $subject = '';
        $content = '';
        $email_class->send($recipient, $content, $message);
      }
    }
  }

  public function the_title( $title, $id = null ) {
 
    if (is_admin() && get_post_type($id) === 'room' &&  get_field('room_unit_no', $id)) {
      $title = $title . ' --- ' .  get_field('room_unit_no', $id);
    }
  
    return $title;
  }
}

Shinyu_Unit::get_instance();
