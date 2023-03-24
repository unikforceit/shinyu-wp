<?php
add_action('wp_enqueue_scripts', function() {

	wp_deregister_script('jquery');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-block-style');
	wp_dequeue_style('woocommerce-general');
	wp_dequeue_style('woocommerce-layout');
	wp_dequeue_style('woocommerce-smallscreen');
	wp_dequeue_style('woocommerce-confirm-payment');	
	wp_dequeue_style('select2');

	wp_enqueue_style(THEME_SLUG, THEME_URI . 'build/' . manifest()->front->css, [], THEME_VERSION, 'all');
	wp_enqueue_script(THEME_SLUG, THEME_URI . 'build/' . manifest()->front->js, [], THEME_VERSION, true);
  wp_localize_script(THEME_SLUG, 'SHINYU', array(
		'ajaxurl'         => admin_url('admin-ajax.php'),
		// 'nonce'           => wp_create_nonce('add_to_cart'),
		'homeurl'         => home_url(),
		'siteurl'         => site_url(),
		'api'             => [
			'url'   => get_rest_url(),
			'nonce' => wp_create_nonce('wp_rest')
		],
		'user'            => [
			'ID'         => get_current_user_id(),
			'logged_in'  => is_user_logged_in(),
			'logout_url' => wp_logout_url(get_permalink(wc_get_page_id('myaccount'))),
			'data'       => get_usersdata(),
		],
		'search_url'      => get_permalink(PAGE_ID_SEARCH),
		'compare_url'     => get_permalink(PAGE_ID_COMPARE),
		'static_uri'      => STATIC_URI,
		'marker'          => STATIC_URI . '/icons/marker.svg',
		'field'           => unit_fields(['lang' => pll_current_language()]),
		'i18n'            => require INC_DIR . '/i18n.php',
		'lang'            => pll_current_language(),
		'lang_code'       => pll_current_language('locale') === 'th' ? 'th_TH' : pll_current_language('locale'),
		'max_upload_size' => wp_max_upload_size(),
		'currency'        => [
			'code' =>	CURRENCY,
			'unit' => get_currency_by_code(CURRENCY),
		],
		'location'        => location(),
		'page' => [
			'privacy_policy'       => get_permalink(PAGE_ID_PRIVACY_POLICY),
			'term_of_condition' => get_permalink(PAGE_ID_TERMS_AND_CONDITIONS),
			'lostpassword' => wc_lostpassword_url(),			
		],
	));
}, 99);

add_action('admin_enqueue_scripts', function() {
	wp_enqueue_style(THEME_SLUG, THEME_URI . 'build/' . manifest()->admin->css, array(), THEME_VERSION, 'all');
}, 9999);