
<?php get_header(); ?>
  <section class="search-bar is-relative custom-global-search">
    <div class="search-box-item">
        <div class="container">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="autocomplete control">
                    <?php shinyu_cs_filter();?>
                    <div class="control is-medium is-clearfix">
                        <div class="columns">
                            <div class="column is-10">
                                <input type="search" class="search-field input is-medium" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder', 'your-text-domain' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            </div>
                            <div class="column is-2">
                                <button type="submit" class="search-submit button is-medium is-danger"><span><?php echo _x( 'Search', 'submit button', 'shyinuaddons' ); ?></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
  <section class="page-header">
    <div class="container">
      <h1 class="page-title"><?php pll_e('All Services'); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
      <p class="page-description"><?php pll_e('Services Description'); ?></p>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <?php if (have_posts()) : $i = 0;
        while (have_posts()) : the_post(); 
          $i++; ?>
          <div class="columns is-multiline archive-service-item<?php if ($i % 2 === 0) echo ' is-flex-direction-row-reverse'; ?>">
            <div class="column is-6">
              <div class="archive-service-image">
                <?php
                  if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'large');
                  else : echo "<img src='https://via.placeholder.com/358x210/FFFF00/000000'>";
                  endif
                ?>
              </div>
            </div>
            <div class="column is-6">
              <div class="archive-service-content">
                <h4 class="archive-service-title has-text-primary"><?php the_title(); ?></h4>
                <p class="archive-service-description mb-4"><?php the_field('_service_description'); ?></p>
                <?php if ($link = get_field('_service_link')) : ?>
                 <a href="<?php echo $link; ?>"><strong><?php pll_e('More details'); ?></strong></a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile;
      endif ?>
    </div>
  </main>
<?php get_footer(); ?>