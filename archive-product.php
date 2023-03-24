
<?php get_header(); ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header">
    <div class="container">
      <h1 class="page-title">แพคเกจและคอร์สเรียน</h1>
      <?php woocommerce_breadcrumb(); ?>
      <p class="page-description"><?php pll_e('Shinyu Real Estate is your true friend who can assist you on real estate investment with specialized experience in both Thai and overseas market.'); ?></p>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <?php if ( have_posts() ) : ?>
        <div class="columns is-multiline">
          <?php while ( have_posts() ) : the_post();  ?>
            <div class="column product-column is-4">
              <div class="product-item card">
                <a href="<?php the_permalink(); ?>" class="content-image promotion-image">
                  <?php
                    if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-room');
                    else : echo "<img src='https://via.placeholder.com/358x210/FFFF00/000000'>";
                    endif
                  ?>
                </a>
                <div class="d-flex align-items-start flex-column product-content card-content">
                  <div class="content">
                    <h4 class="product-title">
                      <a class="has-text-primary" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                    </h4>
                  </div>
                </div>
                <div class="product-footer is-flex is-justify-content-space-between is-align-items-center">
                  <span class="product-footer-item">
                    <?php woocommerce_template_loop_price(); ?>
                  </span>
                  <a href="<?php the_permalink(); ?>" class="product-footer-item buy"><?php pll_e('View Details'); ?></a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif ?>
    </div>
  </main>
<?php get_footer(); ?>
