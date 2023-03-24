<?php get_header();  ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
    </div>
  </section><!-- .page-header -->
	<main class="main-content container">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    <?php endif ?>
  </main>
<?php get_footer(); ?>
