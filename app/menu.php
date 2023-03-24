<?php
/**
 * Register navigation menus
 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
 */
register_nav_menus([
  'primary_navigation' => __('Primary Navigation', 'sage')
]);

/**
 * Add classes menu item
 * @link https://developer.wordpress.org/reference/hooks/nav_menu_css_class/
 */
add_filter('nav_menu_css_class', function($classes, $item) {

  global $post;

  if (is_singular('csr') && $item->ID === 50) {
    $classes[] = 'is-active';
  }

  if (is_post_type_archive('csr') && $item->ID === 50) {
    $classes[] = 'is-active';
  }

  if (is_singular('post') && in_array('current_page_parent', $classes)) {
    $classes[] = 'is-active';
  }

  if (in_array( 'current-menu-item', $classes)
    || in_array( 'current_page_item', $classes)
    || in_array( 'current-menu-parent', $classes)
    || in_array( 'current-menu-ancestor', $classes)
  ){
    $classes[] = 'is-active';
  }
  return $classes;
}, 10, 2);
