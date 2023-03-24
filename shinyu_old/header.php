<!DOCTYPE html>
<html>
<head>
<?php 

  if ( isset($wp->query_vars['preview']) && $wp->query_vars['post_type'] ) {
    wp_redirect( 'https://shinyurealestate.com/'. $wp->query_vars['post_type'] .'/' . $wp->query_vars['p']  ); exit;
  }

  if ( $wp->request || is_singular() ) {
    wp_redirect( 'https://shinyurealestate.com/' . $wp->request ); exit;
  }elseif( is_front_page() ) {
    wp_redirect( 'https://shinyurealestate.com/' ); exit;
  }
  
?>