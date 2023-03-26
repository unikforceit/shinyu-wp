<?php
/**
 * Template Name: Contact
 */
get_header();
 the_content();
 get_footer(); ?>

<?php 

// $args = [
// 	'post_type'          => 'project',
// 	'post_status'        => 'publish',
// 	'paged'              => 4,
// 	'posts_per_page'     => 50,
// ];

// $the_query = new WP_Query( $args );

// if ($the_query->have_posts()) :
// 	while ($the_query->have_posts()) : $the_query->the_post();
// 		$galleries = [];
// 		$gallery = [];

// 	endwhile;
// 	wp_reset_postdata();
// endif;


// $id = 11721;

// $gallery = get_field('room_gallery', $id, false, false);
// foreach ($gallery as $key => $id) {
// 	$galleries[] = pll_get_post($id);
// }

// var_dump($galleries);
// update_field('room_gallery', $galleries,  get_the_ID());

