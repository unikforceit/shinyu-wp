<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define( 'THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'THEME_URI', trailingslashit( get_template_directory_uri() ) );
define( 'THEME_NAME', 'Tubkaew' );
define( 'THEME_SLUG', 'mimo' );
define( 'THEME_VERSION', '0.9.3' );
define( 'JS_URI', THEME_URI . 'js' );
define( 'CSS_URI', THEME_URI . 'css' );
define( 'INC_DIR', THEME_DIR . 'inc' );
define( 'IMG_DIR', THEME_DIR . 'images' );
define( 'IMG_URI', THEME_URI . 'images' );

require INC_DIR . '/helpers.php';
require INC_DIR . '/class/class-email.php';
require INC_DIR . '/class/class-home.php';
require INC_DIR . '/class/class-about-us.php';
require INC_DIR . '/class/class-contact-us.php';
require INC_DIR . '/class/class-service.php';
require INC_DIR . '/class/class-project.php';
require INC_DIR . '/class/class-project-landing-page.php';
require INC_DIR . '/class/class-room.php';
require INC_DIR . '/class/class-news.php';
require INC_DIR . '/class/class-job.php';
require INC_DIR . '/class/class-promotion.php';
require INC_DIR . '/class/class-testimonial.php';
require INC_DIR . '/class/class-form.php';
require INC_DIR . '/class/form/class-post-property.php';

require INC_DIR . '/class/class-social.php';
require INC_DIR . '/class/class-currencies.php';
require INC_DIR . '/icons.php';
require INC_DIR . '/strings-translations.php';

require INC_DIR . '/api/languages.php';
require INC_DIR . '/api/menu.php';
require INC_DIR . '/api/api-home.php';
require INC_DIR . '/api/api-about-us.php';
require INC_DIR . '/api/api-contact-us.php';
require INC_DIR . '/api/api-job.php';
require INC_DIR . '/api/api-service.php';
require INC_DIR . '/api/api-news.php';
require INC_DIR . '/api/api-promotion.php';
require INC_DIR . '/api/api-project.php';
require INC_DIR . '/api/api-room.php';
require INC_DIR . '/api/api-compare.php';
require INC_DIR . '/api/form/api-form.php';
require INC_DIR . '/api/form/api-post-property.php';
require INC_DIR . '/api/form/api-request-view.php';

require INC_DIR . '/api/api-subscribe.php';
require INC_DIR . '/api/api-social.php';
require INC_DIR . '/api/api-statistic.php';
require INC_DIR . '/api/api-project-landing-page.php';

if ( ! function_exists( 'mimo_setup' ) ) :

	function mimo_setup() {

    load_theme_textdomain( THEME_SLUG, THEME_DIR . '/languages' );

    add_theme_support( 'post-formats', array( 'video', 'gallery', 'image'  ) );

		add_theme_support( 'post-thumbnails' );
    add_filter( 'jpeg_quality', function($arg){return 100;} );
    add_image_size( 'thumb-news', 450, 300, true );
    add_image_size( 'large-news', 920, 600, true );
    add_image_size( 'thumb-room', 330, 285, true );
    add_image_size( 'large-gallery', 882, 533, true );
    add_image_size( 'thumb-gallery', 140, 120, true );
    
	  register_nav_menus( array(
	    'primary' => esc_html__('Primary Menu', $lang),
	    'footer' => esc_html__('Footer Menu', $lang),
	  ) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

	}
endif;
add_action( 'after_setup_theme', 'mimo_setup' );

function mimo_style() {

  wp_enqueue_style( THEME_SLUG . '-style', get_stylesheet_uri(), array(), THEME_VERSION );

}
add_action( 'wp_enqueue_scripts', 'mimo_style' );



function mimo_admin_enqueue_scripts(){

  wp_enqueue_script('jquery-ui-dialog');
  wp_enqueue_style('wp-jquery-ui-dialog');
  
  wp_enqueue_script(THEME_SLUG . '-admin-js', JS_URI . '/admin.js', ['jquery'], THEME_VERSION, true);
  wp_enqueue_style( THEME_SLUG . '-admin-style', CSS_URI . '/admin.css', false, THEME_VERSION, 'all' );

}
add_action( 'admin_enqueue_scripts', 'mimo_admin_enqueue_scripts' );


function remove_menus_admin(){

  remove_menu_page( 'edit-links.php' );
  remove_menu_page( 'edit.php' );
  remove_menu_page( 'edit-comments.php' );
  // remove_menu_page( 'mb_email_configuration' );
  remove_menu_page( 'aiowpsec' );
  if( get_current_user_id() != 1 ){
    remove_menu_page( 'edit.php?post_type=acf-field-group' );
    // remove_menu_page( 'options-general.php' );
    remove_menu_page( 'tools.php' );
    // remove_menu_page( 'sitepress-multilingual-cms/menu/languages.php' );    
    remove_menu_page( 'plugins.php' );  
    remove_submenu_page( 'themes.php', 'themes.php' );
    remove_submenu_page( 'themes.php', 'widgets.php' );
    remove_submenu_page( 'themes.php', 'theme-editor.php' );
    remove_submenu_page( 'themes.php', 'customize.php' );
  }

}
add_action( 'admin_menu', 'remove_menus_admin', 999 );

function remove_admin_bar_links() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments');
  $wp_admin_bar->remove_menu('wp-logo');
  $wp_admin_bar->remove_menu('about');
  $wp_admin_bar->remove_menu('wporg');
  $wp_admin_bar->remove_menu('documentation');
  $wp_admin_bar->remove_menu('support-forums');
  $wp_admin_bar->remove_menu('feedback');
  $wp_admin_bar->remove_menu('new-post');
  $wp_admin_bar->remove_menu('wp_mail_bank');  
  if( get_current_user_id() != 1 ){
    $wp_admin_bar->remove_menu('autoptimize');
    $wp_admin_bar->remove_menu('wpfc-toolbar-parent');
  }

}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links', 9999 );

function mimo_login_logo() { ?>
  <style type="text/css">
    body.login div#login h1 a {
      width: 100%;
      height: 80px;
      padding: 0px;
      margin: 0px;
      background-image: url(<?php echo IMG_URI . '/logo_backend.png' ?>);
      background-size: 40%;
    }
    #nav,
    #backtoblog{
      display: none;
    }
  </style>
  <?php
}
add_action( 'login_footer', 'mimo_login_logo' );

function mimo_login_logo_link() {
  return site_url();
}
add_filter('login_headerurl','mimo_login_logo_link');

function excerpt_length( $length ) {
  return 1000;
}
add_filter( 'excerpt_length', 'excerpt_length', 999 );


function get_short_excerpt( $text, $length ){

  $new_text =  mb_substr( $text,0,$length );
  if( mb_strlen($text) > $length ){
    $new_text .= '...';
  }

  return $new_text;
  
}

function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyBy-0iQ24or8h-eIaUhVM7aDjldpJ1XMnc');
}

add_action('acf/init', 'my_acf_init');

function field_year_built($show_option_all = '') {

  $years_now = date('Y', strtotime('+2 years'));
  $years = array();
  if ( $show_option_all ) {
    $years[] = $show_option_all;
  }
  foreach (range($years_now, 2005) as $year) {       
    $years[$year] = $year;
  }
  $years['older'] = pll_translate_string('Older', $lang);

  return $years;

}
function field_transaction($show_option_all = '', $lang = 'th') {

  $items = array(
    'sell' => pll_translate_string('Sell', $lang),
    'rent' => pll_translate_string('Rent', $lang),
  );
  if ( $show_option_all ) {
    array_unshift( $items, $show_option_all);
  }
  return $items;
}

function price($val = 0, $code = 'THB') {

  if(!$code) $code = 'THB';

  $rate = get_field('_currency_'. strtolower($code) .'_rate', 'option');

  return $val * $rate;

}

function field_price_range($show_option_all = '', $lang = 'th') {

  $items = array(
    '0-1000000'         => pll_translate_string('Under 1M', $lang),
    '1000000-2000000'   => pll_translate_string('1-2M', $lang),
    '2000000-3000000'   => pll_translate_string('2-3M', $lang),
    '3000000-5000000'   => pll_translate_string('3-5M', $lang),
    '3000000-7000000'   => pll_translate_string('5-7M', $lang),
    '7000000-10000000'  => pll_translate_string('7-10M', $lang),
    '10000000-15000000' => pll_translate_string('10-15M', $lang),
    '15000000-30000000' => pll_translate_string('15-30M', $lang),
    '30000000'          => pll_translate_string('Over 30M', $lang),
  );

  if ( $show_option_all ) {
    array_unshift( $items, $show_option_all);
  }
  return $items;

}

function field_room_type($show_option_all = '', $lang = 'th') {

  $items = array(
    ''            => pll_translate_string('Any', $lang),
    '1_bedroom'   => pll_translate_string('1 bedroom', $lang),
    '2_bedroom'   => pll_translate_string('2 bedrooms', $lang),
    '3_bedroom'   => pll_translate_string('3 bedrooms', $lang),
    'studio'      => pll_translate_string('Studio', $lang),
    'duplex'      => pll_translate_string('Duplex', $lang),
    'penthouse'   => pll_translate_string('Penthouse', $lang),    
  );

  return $items;

}

function field_bedrooms($show_option_all='', $lang = 'th') {

  $items = array(
    ''       => pll_translate_string('Any', $lang),
    'studio' => pll_translate_string('Studio', $lang),    
    '1'      => pll_translate_string('1 Bedroom', $lang),
    '2'      => pll_translate_string('2 Bedrooms', $lang),
    '3'      => pll_translate_string('3 Bedrooms', $lang),
    '4'      => pll_translate_string('4 Bedrooms and more', $lang),
    
  );
  if ( $show_option_all ) {
    //array_unshift( $items, $show_option_all);
  }
  return $items;
}

function field_view($lang = 'th') {

  return array(
    ''         => pll_translate_string('Any', $lang),
    'city'     => pll_translate_string('City View', $lang),
    'river'    => pll_translate_string('River View', $lang),
    'garden'   => pll_translate_string('Garden View', $lang),
    'panorama' => pll_translate_string('Panorama View', $lang),
    'sea'      => pll_translate_string('Sea View', $lang),
    'mountain' => pll_translate_string('Mountain View', $lang),
    'cleared'  => pll_translate_string('Cleared View', $lang),    
  );

}

function field_direction() {

  return array(
    ''           => pll_translate_string('Unknown', $lang),
    'north'      => pll_translate_string('North', $lang),
    'west'       => pll_translate_string('West', $lang),
    'east'       => pll_translate_string('East', $lang),
    'south'      => pll_translate_string('South', $lang),
    'north_west' => pll_translate_string('North West', $lang),
    'north_east' => pll_translate_string('North East', $lang),
    'south_west' => pll_translate_string('South West', $lang),
    'south_east' => pll_translate_string('South East', $lang),   
  );

}

function field_bathrooms() {

  return array(
    ''    => pll_translate_string('Any', $lang),
    '1'   => pll_translate_string('1', $lang),
    '2'   => pll_translate_string('2', $lang),
    '3'   => pll_translate_string('3', $lang),
    '4'   => pll_translate_string('4', $lang),
    '5'   => pll_translate_string('5', $lang),
  );

}

function field_sort_by() {

  return array(
    'most_recent'       => pll_translate_string('Most Recent', $lang),
    'price_low_to_high' => pll_translate_string('Price : low to high', $lang),
    'price_high_to_low' => pll_translate_string('Price : high to low', $lang), 
  );

}

function field_yield($show_option_all='', $lang = 'th') {

  $items = array(
    '10'   => pll_translate_string('Over 10%', $lang),
    '9-10' => pll_translate_string('9-10%', $lang),
    '8-9'  => pll_translate_string('8-9%', $lang),
    '7-8'  => pll_translate_string('7-8%', $lang),
    '6-7'  => pll_translate_string('6-7%', $lang),
    '5-6'  => pll_translate_string('5-6%', $lang),
    '4-5'  => pll_translate_string('4-5%', $lang),
    '3-4'  => pll_translate_string('3-4%', $lang),
    '2-3'  => pll_translate_string('2-3%', $lang),
    '1-2'  => pll_translate_string('1-2%', $lang),
    '0-1'  => pll_translate_string('0-1%', $lang),
  );
  if ( $show_option_all ) {
    array_unshift( $items, $show_option_all);
  }
  return $items;
}

function field_what_can_we_help($show_option_all='') {

  $items = array(
    'buy'        => pll_translate_string('I’d like to buy a condo', $lang),
    'sell_lease' => pll_translate_string('Can you help me sell/lease my condo?', $lang),
  );

  return $items;
}

function field_bts(){

  $bts = array();

  $terms = get_terms('project_location', array(
    'hide_empty' => false,
    'meta_query' => array(
      array(
        'key'       => 'project_location_type',
        'value'     => 'bts',
        'compare'   => '='
      )
    )
  ));

  $bts[''] = 'Select';

  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
      $bts[$term->term_id] = $term->name;
    }
  }

  return $bts;

}

function field_mrt(){

  $mrt = array();

  $terms = get_terms('project_location', array(
    'hide_empty' => false,
    'meta_query' => array(
      array(
        'key'       => 'project_location_type',
        'value'     => 'mrt',
        'compare'   => '='
      )
    )
  ));

  $mrt[''] = 'Select';

  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
      $mrt[$term->term_id] = $term->name;
    }
  }

  return $mrt;

}

function line_notify( $message, $token ){

  $body = array(
    'message'         => $message
  );

  $response = wp_remote_post( 'https://notify-api.line.me/api/notify', array(
    'method' => 'POST',
    'headers' => array(
      'Authorization' => 'Bearer '.$token,
    ),
    'body' => $body,
  ));

  $code = wp_remote_retrieve_response_code( $response );

  if ($code=='200' ){
    return true;
  }else{
    return false;
  }
  
}

if ( get_current_user_id() != 1 && is_admin()) {
  // exit();
}

function get_youtube_video_ID($youtube_video_url) {

  $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

  if (preg_match($pattern, $youtube_video_url, $match)) {
    return $match[1];
  }

  // if no match return false.
  return false;
}