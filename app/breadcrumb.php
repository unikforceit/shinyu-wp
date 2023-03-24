<?php 

function woocommerce_breadcrumb() {

	$separator = '>';

	$templates = array(
		'before' => '<nav class="breadcrumbs"><div class="container">',
		'after' => '</div></nav>',
	);
	$options = array(
		'show_htfpt' => true,
		'separator' => $separator,
	);
	$breadcrumb = new DS_WP_Breadcrumb( $templates, $options );
}