<?php
/*-----------------------------------------------------------------------------------*/
/*  Define Theme Vars
/*-----------------------------------------------------------------------------------*/
define('THEME_DIR', trailingslashit(get_template_directory()));
define('THEME_URI', trailingslashit(get_template_directory_uri()));
define('THEME_NAME', 'Shinyu');
define('THEME_SLUG', 'syrs');
define('THEME_VERSION', '0.2.8');
define('SRC_URI', THEME_URI . 'src');
define('STATIC_URI', THEME_URI . 'static');
define('INC_DIR', THEME_DIR . 'inc');
define('IMG_URI', STATIC_URI . '/images/');
define('CURRENCY', isset($_COOKIE['currency']) ? $_COOKIE['currency'] : 'THB');

define('PAGE_ID_SEARCH', pll_get_post(get_page_by_path('search')->ID));
define('PAGE_ID_CONTACT', pll_get_post(get_page_by_path('contact')->ID));
define('PAGE_ID_POST_PROPERTY', pll_get_post(get_page_by_path('post-property')->ID));
define('PAGE_ID_ABOUT', pll_get_post(get_page_by_path('about-us')->ID));
define('PAGE_ID_COMPARE', pll_get_post(get_page_by_path('compare')->ID));
define('PAGE_ID_CALCULATOR', pll_get_post(get_page_by_path('calculator')->ID));
define('PAGE_ID_STATISTICS', pll_get_post(get_page_by_path('statistics')->ID));
define('PAGE_ID_SITEMAP', pll_get_post(get_page_by_path('statistics')->ID));
define('PAGE_ID_CONTACT_FORM', pll_get_post(get_page_by_path('contact-form')->ID));
define('PAGE_ID_ACADEMY', pll_get_post(get_page_by_path('academy')->ID));
define('PAGE_ID_PACKAGES', pll_get_post(get_page_by_path('packages')->ID));
define('PAGE_ID_ACCOUNT', pll_get_post(get_page_by_path('account')->ID));
//define('PAGE_ID_ROOM_DEPOSIT', pll_get_post(get_page_by_path('room-deposit', OBJECT, 'product')->ID));
define('PAGE_ID_PRIVACY_POLICY', pll_get_post(get_page_by_path('privacy-policy')->ID));
define('PAGE_ID_TERMS_AND_CONDITIONS', pll_get_post(get_page_by_path('terms-and-conditions')->ID));

// Check WPML current lang and put in in variable to create custom logic - Nutn0n, Nov 28, 2022. 
$my_current_lang = apply_filters( 'wpml_current_language', NULL );

if (strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false) {
	define('WEBP', true);
} else {
	define('WEBP', false);
}

array_map(function($file) {
	require_once THEME_DIR . 'app/'. $file .'.php';
}, [
	'helpers',
	'functions',
	'enqueue-scripts',
	'setup',
	//'cleanup',
	'sidebar',
	'menu',
	//'branding',
	'theme-customizer',
]);

// require_once THEME_DIR . 'vendor/autoload.php';

require INC_DIR . '/lib/class-ds-wp-breadcrumb.php';

require INC_DIR . '/helpers.php';
require INC_DIR . '/class/class-compression-html.php';
require INC_DIR . '/class/class-video.php';
require INC_DIR . '/class/class-email.php';
require INC_DIR . '/class/class-contact-us.php';
// require INC_DIR . '/class/class-page-service.php';
require INC_DIR . '/class/class-project.php';
// require INC_DIR . '/class/class-project-landing-page.php';
require INC_DIR . '/class/class-unit.php';
require INC_DIR . '/class/class-promotion.php';
require INC_DIR . '/class/class-article.php';
require INC_DIR . '/class/class-service.php';
require INC_DIR . '/class/class-job.php';
require INC_DIR . '/class/class-partner.php';
// require INC_DIR . '/class/class-testimonial.php';
// require INC_DIR . '/class/class-job.php';
require INC_DIR . '/class/class-form.php';
// require INC_DIR . '/class/form/class-post-property.php';

require INC_DIR . '/class/class-product.php';
require INC_DIR . '/class/class-product-custom.php';

require INC_DIR . '/class/class-page-home.php';
require INC_DIR . '/class/class-page-about-us.php';
require INC_DIR . '/class/class-page-academy.php';

require INC_DIR . '/class/class-social.php';
require INC_DIR . '/class/class-currencies.php';
// require INC_DIR . '/icons.php';
require INC_DIR . '/strings-translations.php';

require_once INC_DIR . '/woocommerce/override_fields.php';
require_once INC_DIR . '/woocommerce/global.php';
require_once INC_DIR . '/woocommerce/checkout.php';
require_once INC_DIR . '/woocommerce/cart.php';

require INC_DIR . '/api/api.php';
require INC_DIR . '/api/api-unit-recommended.php';
require INC_DIR . '/api/api-unit-project.php';

require INC_DIR . '/api/api-unit-special.php';
require INC_DIR . '/api/api-unit-search.php';
require INC_DIR . '/api/api-room-tag.php';
require INC_DIR . '/api/api-project-area-search.php';
require INC_DIR . '/api/api-project-search.php';
require INC_DIR . '/api/api-uploadimage.php';
require INC_DIR . '/api/api-post-property.php';
require INC_DIR . '/api/api-unit-compare.php';
require INC_DIR . '/api/api-user-login.php';
require INC_DIR . '/api/api-user-me.php';
require INC_DIR . '/api/api-user-order.php';
require INC_DIR . '/api/api-user-property.php';
require INC_DIR . '/api/api-user-reset-password.php';
require INC_DIR . '/api/api-add-to-cart.php';
require INC_DIR . '/api/api-contact.php';
require INC_DIR . '/api/api-promotion.php';
require INC_DIR . '/api/api-service-tax.php';
require INC_DIR . '/api/api-service-interior.php';
require INC_DIR . '/api/api-unit-register.php';

function manifest(){
	return json_decode(file_get_contents('build/assets.json', true));
}

add_filter( 'big_image_size_threshold', function($threshold) {
	return 6000; // new threshold
}, 999, 1);


// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
add_filter('body_class', function($classes) {
	global $post;

	if (cart_has_room_deposit()) $classes[] = 'has-room-deposit';

	if (is_home()) {
		$key = array_search('blog', $classes);
		// if ($key > -1) {
		// 	unset($classes[$key]);
		// }
		$classes[] = 'page';
	} elseif (is_singular()) {
		if ($post->post_parent) {
			$classes[] =  'parent-' . get_post_field( 'post_name', $post->post_parent);
		}
		
		$classes[] = sanitize_html_class($post->post_name);
	}
	return $classes;
});

add_filter( 'wp_title', function($title) {
  return html_entity_decode($title);
}, 10, 2);


add_filter( 'excerpt_length', function($length) {
  return 100;
}, 999);


add_filter( 'excerpt_more', function($length) {
  return ' ...';
});

add_filter( 'rest_url_prefix', function() {
  return 'api';
});

add_filter('query_vars', function($qvars) {
	$qvars[] = 'transaction';
	$qvars[] = 'section';
	return $qvars;
});

add_filter('init', function(){
	if (!isset($_COOKIE['currency'])) {
		setcookie('currency', 'THB', time() + 31556926); 
	}
}, 10, 2);


add_filter('woocommerce_add_to_cart_redirect', function($url){
	return wc_get_cart_url();
}, 10, 2);


function reset_pass_url() { 
	$siteURL = get_option('siteurl'); return "{$siteURL}/wp-login.php?action=NewPassword";
} 
add_filter( 'lostpassword_url', 'reset_pass_url', 11, 0 );


add_filter('posts_search', function($search, $wp_query){
	global $wpdb;
 
	if (empty($search)) return $search;

	$q = $wp_query->query_vars;    
	$n = ! empty( $q['exact'] ) ? '' : '%';

	$search = '';
	$searchand = '';

	foreach ( (array) $q['search_terms'] as $term ) {
		$term = esc_sql($wpdb->esc_like($term));
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}

	if (!empty($search)) {
		$search = " AND ({$search}) ";
	
		if (!is_user_logged_in())
			$search .= " AND ($wpdb->posts.post_password = '') ";
	}

	return $search;

}, 10, 2);

add_action('wp_footer', function() { ?>
<div class="compare-selected"><compare-selected></compare-selected></div>
<!-- <a class="floating-icon-contact"></a> -->
<!-- <div class="fb-customerchat" page_id="761630313876344" logged_in_greeting="สอบถามเพิ่มเติม ?" logged_out_greeting="สอบถามเพิ่มเติม ?" theme_color="#0f4b81"></div> -->
<?php }, 9999);

// add_filter( 'post_thumbnail_html', 'my_post_thumbnail_fallback', 20, 5 );
// function my_post_thumbnail_fallback( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
// 	if (WEBP) {
// 		$src = str_replace('wp-content/uploads', 'wp-content/uploads-webpc/uploads', get_the_post_thumbnail_url($post_id, $size));
// 		return '<img src="' . $src  . '.webp">';
// 	} 
// 	return $html;
// }

// echo admin_url('post.php?post=31856&action=edit'); exit();

// exit();

// $value = [];

// update_field('project_stat', $value, 26614);

function update_stat($project_id) {
	$year = date('Y', current_time('timestamp', 1));
	$sell_price = 0;
	$rent_price = 0;
	$sell_price_count = 0;
	$rent_price_count = 0;

	$args = [
		'post_type'          => 'room',
		'posts_per_page'     => -1,
		'post_status'        => 'publish',
		'meta_query'         => [
			[
				'key'     => 'room_project',
				'value'   => $project_id,
				'compare' => 'IN'
			],
		]
	];

  $room_query = new WP_Query($args);

	if ($room_query->have_posts()) :
		while ($room_query->have_posts()) : $room_query->the_post(); 
			$current_sell_price = get_field('room_sell_price');
			$current_rent_price = get_field('room_rent_price');

			if ($current_sell_price) {
				$sell_price = $sell_price + $current_sell_price;
				$sell_price_count = $sell_price_count + 1;
			}

			if ($current_rent_price) {
				$rent_price = $rent_price + $current_rent_price;
				$rent_price_count = $rent_price_count + 1;
			}

		endwhile;
		wp_reset_postdata();
	else : return;
	endif;


	if ($sell_price) $sell_price = $sell_price / $sell_price_count;
	if ($rent_price) $rent_price = $rent_price / $rent_price_count;

	// if (!$room_query->found_posts) return;

	$stats = get_field('project_stat', $project_id);
	$new_value = ['year' => $year, 'sell_price' => $sell_price, 'rent_price' => $rent_price];

	if ($stats ) {
		$key = array_search($year, array_column($stats, 'year'));
		if ($key > -1) {
			$stats[$key] = $new_value;
		} else {
			$stats[] = $new_value;
		}
	} else {
		$stats[] = $new_value;
	}
	update_field('project_stat', $stats, $project_id);
}

