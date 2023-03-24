<?php get_header();  ?>
  <section class="page-header">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>
      <?php endif ?>
    </div>
  </main>
<?php get_footer(); ?>
