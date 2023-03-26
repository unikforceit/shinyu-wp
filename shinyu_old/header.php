<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo wp_is_mobile() ? 'mobile' : 'pc'; ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="theme-color" id="theme-color" content="#0f4b81">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-TileColor" content="#0f4b81">
    <?php wp_head(); ?>
    <!-- LINE Tag Base Code -->
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
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