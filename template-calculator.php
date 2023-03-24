
<?php
/**
 * Template Name: Calculator
 */
get_header(); ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header mb-0">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
    </div>
  </section><!-- .page-header -->
	<main class="main-content"><calculator></calculator></main>
<?php get_footer(); ?>