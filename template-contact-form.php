
<?php
/**
 * Template Name: Contact Form
 */
get_header(); ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header mb-0">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <div class="contact-form"><contact-form></contact-form></div>
    </div>
	</main>
<?php get_footer(); ?>

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
