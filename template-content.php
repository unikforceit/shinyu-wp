<?php
/**
 * Template Name: Content
 */
get_header(); ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header minimal">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php //woocommerce_breadcrumb(); ?>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <div class="columns">
        <div class="column is-8-fullhd is-12<?php if (!is_user_logged_in()) echo ' is-12-fullhd'; ?>">
          <div class="content">
            <?php if ( have_posts() ) : ?>
              <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
              <?php endwhile; ?>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
	</main>
<?php get_footer(); ?>