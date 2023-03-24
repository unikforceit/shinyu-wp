<?php 
add_action('after_setup_theme', function () {

  load_theme_textdomain( THEME_SLUG, THEME_DIR . '/languages' );

  add_filter('show_admin_bar','__return_false');

  add_theme_support( 'woocommerce' );

  /**
   * Enable plugins to manage the document title
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
   */
  add_theme_support('title-tag');

  /**
   * Enable post thumbnails
   * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
   */
  add_theme_support('post-thumbnails');
  /**
   * Enable HTML5 markup support
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
   */
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

}, 20);

// woocommerce_thumbnail
// woocommerce_single
// woocommerce_gallery_thumbnail
// shop_catalog
// shop_single
// shop_thumbnail
add_action('after_setup_theme', function () {
  add_filter( 'jpeg_quality', function($arg){return 100;} );
  add_filter( 'big_image_size_threshold', '__return_false' );
  add_image_size('slideshow', 1920, 590, true);
  add_image_size('thumb-room', 358, 210, true);
  add_image_size('thumb-video', 220, 130, true);
  add_image_size('thumb-news', 360, 189, true); 
  add_image_size('thumb-promotion', 350, 300, true);
  add_image_size('unit-gallery', 1136, 560, true);
  add_image_size('gallery', 660, 420, true);
}, 100);


add_action('init', function () {
  remove_image_size('woocommerce_thumbnail');
  remove_image_size('woocommerce_single');
  remove_image_size('woocommerce_gallery_thumbnail');
  remove_image_size('shop_catalog');
  remove_image_size('shop_single');
  remove_image_size('shop_thumbnail');
  // remove_image_size('1536x1536');
  // remove_image_size('2048x2048');
});
