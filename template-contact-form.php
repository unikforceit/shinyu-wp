
<?php
/**
 * Template Name: Contact Form
 */
get_header();
the_content();
get_footer(); ?>

<?php

// $args = [
// 	'post_type'          => 'project',
// 	'posts_per_page'     => -1,
// 	'post_status'        => 'publish',
// ];

// $room_query = new WP_Query($args);

// if ($room_query->have_posts()) :
// 	while ($room_query->have_posts()) : $room_query->the_post(); 
// 		update_stat(get_the_ID());
// 	endwhile;
// 	wp_reset_postdata();
// endif;
