<?php 
// Clean up wordpres <head>
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_filter('oembed_dataparse', 'show_admin_bar', 10);

remove_action('wp_footer', 'aiowps_footer_content', 10);

add_filter( 'widgets_init', function() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
});

// add_filter( 'rest_endpoints', function($endpoints) {
//   $endpoints_to_remove = array(
//     'media555',
//     'types',
//     'statuses',
//     'taxonomies',
//     'tags',
//     'users',
//     'comments',
//     'settings',
//     'themes',
//     'blocks',
//     'oembed',
//     'posts',
//     'pages',
//     'block-renderer',
//     'search',
//     'categories'
//   );

//   foreach ( $endpoints_to_remove as $endpoint ) {
//     $base_endpoint = "/wp/v2/{$endpoint}";
//     foreach ( $endpoints as $maybe_endpoint => $object ) {
//       if ( strpos( $maybe_endpoint, $base_endpoint ) !== false ) {
//         unset( $endpoints[ $maybe_endpoint ] );
//       }
//     }
//   }

//   unset($endpoints['/oembed/1.0']);
//   unset($endpoints['/oembed/1.0/embed']);
//   unset($endpoints['/oembed/1.0/proxy']);
//   unset($endpoints['/wp/v2']);  
//   unset($endpoints['/']);

//   return $endpoints;
// });


function wp_force_remove_style(){

	add_filter( 'print_styles_array', function($styles) {
	
    $styles_to_remove = array('woocommerce-inline');

    if(is_array($styles) AND count($styles) > 0){

      foreach($styles AS $key => $code){

        if(in_array($code, $styles_to_remove)){
            unset($styles[$key]);
        }
      }
    }

    return $styles;

  }); 
	
}
	
add_action('wp_enqueue_scripts', 'wp_force_remove_style', 99);