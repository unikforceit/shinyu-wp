<?php
/**
 * Template Name: Contact
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
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <section class="contact-address">
        <div class="container">
          <h3 class="contact-address-name has-text-primary">SHINYU RESIDENCE</h3>
          <small  class="contact-address-fullname"><?php pll_e('Shinyu Real Estate Co.,Ltd. (Head Office)') ?></small>
          <div class="columns">
            <div class="column is-6"><?php the_content(); ?></div>
            <div class="column pl-sm-6">
              <ul>
                <li>
                  <a href="tel:020013033"><?php pll_e('Tel'); ?> : 02-001-3033</a>
                </li>
                <li>
                  <a href="mailto:info@shinyurealestate.com"><?php pll_e('Email'); ?> : info@shinyurealestate.com</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="columns">
            <div class="column is-6">
              <?php 
                $src = 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31007.45807364113!2d100.580582!3d13.722551!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc69dd70382e55f5d!2sShinyu%20Real%20Estate!5e0!3m2!1sen!2sth!4v1615105702371!5m2!1sen!2sth';
                if (pll_current_language('locale') === 'th') $src = 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31007.45807364113!2d100.580582!3d13.722551!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc69dd70382e55f5d!2sShinyu%20Real%20Estate!5e0!3m2!1sth!2sth!4v1615105817937!5m2!1sth!2sth';
              ?>
              <iframe class="contact-map" src="<?php echo $src; ?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="column pl-sm-6">
              <div class="contact-form"><contact-form></contact-form></div>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    <?php endif ?>
	</main>
<?php get_footer(); ?>

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

