<?php 

add_action('wp_before_admin_bar_render', function() {

	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
  $wp_admin_bar->remove_menu('wp-logo');
  $wp_admin_bar->remove_menu('updates');
  // $wp_admin_bar->remove_menu('site-name');  
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('new-post');
  $wp_admin_bar->remove_menu('new_draft');	
  $wp_admin_bar->remove_menu('wp_mail_bank');
  
	if (get_current_user_id() != 1) {
		$wp_admin_bar->remove_menu('autoptimize');
		$wp_admin_bar->remove_menu('wpfc-toolbar-parent');
	}

}, 9999);

add_action( 'admin_menu', function() {

  remove_menu_page('edit-links.php');
  remove_menu_page('edit.php');
  remove_menu_page('edit-comments.php');
  remove_menu_page('sitepress-multilingual-cms/menu/languages.php');
  remove_menu_page('mb_email_configuration');  

  if (get_current_user_id() != 1) {
    remove_menu_page('aiowpsec');	
    remove_menu_page('tools.php');
    remove_menu_page('edit.php?post_type=acf-field-group');
  }

}, 999);

add_action('admin_head', function() {
  $screen = get_current_screen();
  remove_meta_box('icl_div_config', $screen->post_type, 'normal');
  remove_meta_box('revisionsdiv', $screen->post_type, 'normal');
  remove_meta_box('commentstatusdiv', $screen->post_type, 'normal');
  remove_meta_box('commentsdiv', $screen->post_type, 'normal');
}, 100);

add_action('login_footer', function() { ?>
  <style type="text/css">
    body.login div#login h1 a {
      width: 100%;
      height: 60px;
      padding: 0px;
      margin: 0px;
      background-image: url(<?php echo content_url('uploads/2021/01/logo.png'); ?>);
      background-size: 60%;
    }
  </style>
<?php });

add_filter('login_headerurl', function(){
  return site_url();
});


add_action('wp_dashboard_setup', function(){

  global $wp_meta_boxes;

  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']); 
});
