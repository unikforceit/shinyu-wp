<?php 

add_action('wp_enqueue_scripts', function() {
  $custom_css = '.page-header, .search-header{background-image:url('. content_url('uploads/2021/01/page-header-bg.jpg') .') }';
  $custom_css .= '.page-template-template-academy .page-header{background-image:url('. content_url('uploads/2021/04/header-bg-academy.jpg') .') }';
  $custom_css .= '.post-type-archive-job .page-header{background-image:url('. content_url('uploads/2021/11/job-bg.jpg') .') }';
  $custom_css .= '.service-background{background-image:url('. content_url('uploads/2021/01/service-bg.jpg') .') }';
  $custom_css .= '.search-box, .search-bar{background-image:url('. content_url('uploads/2021/01/search-bg.jpg') .') }';
  $custom_css .= '.fullscreen-navigation, .about-history{background-image:url('. content_url('uploads/2021/01/menu-bg.jpg') .') }';
  $custom_css .= '.unit-registration{background-image:url('. content_url('uploads/2021/01/registration-bg.jpg') .') }';
  $custom_css .= '.shinyu-channel{background-image:url('. content_url('uploads/2021/01/shinyu-channel-bg.jpg') .') }';
  $custom_css .= '.academy-gallery{background-image:url('. content_url('uploads/2021/07/gallery-bg.jpg') .') }';  
  // $custom_css .= '.home .news{background-image:url('. content_url('uploads/2021/01/news-bg.jpg') .') }';
  $custom_css .= '.page-template-template-about .page-header{background-image:url('. content_url('uploads/2022/07/about-header-bg.jpg') .') }';
  $custom_css .= '.about-overview{background-image:url('. content_url('uploads/2022/07/about-overview-bg.jpg') .') }';  
  $custom_css .= '.about-award{background-image:url('. content_url('uploads/2022/07/about-award-bg.jpg') .') }';
  $custom_css .= '.about-works{background-image:url('. content_url('uploads/2022/07/about-work-bg.jpg') .') }';
  $custom_css .= '.about-team{background-image:url('. content_url('uploads/2022/07/about-team-bg.jpg') .') }';
  $custom_css .= '.about-shinyu-value{background-image:url('. content_url('uploads/2022/07/about-shinyu-value-bg.jpg') .') }';

  wp_add_inline_style(THEME_SLUG , minify_css($custom_css));
}, 100);