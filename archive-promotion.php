
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
      <h1 class="page-title"><?php _e('Promotion', THEME_SLUG); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
      <p class="page-description"><?php pll_e('Shinyu Real Estate is your true friend who can assist you on real estate investment with specialized experience in both Thai and overseas market.'); ?></p>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <?php if ( have_posts() ) : ?>
        <div class="columns is-multiline">
          <?php while ( have_posts() ) : the_post();  ?>
            <div class="column is-4 promotion-col">
              <figure class="promotion-item">
                <a href="<?php the_permalink(); ?>" class="promotion-thumbnail">
                  <?php
                    if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-promotion');
                    else : echo "<img src='https://via.placeholder.com/350x300/FFFF00/000000'>";
                    endif
                  ?>
                </a>
                <figcaption class="d-flex align-items-start flex-column promotion-caption">
                  <h4 class="promotion-title mb-2"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
                  <p><?php the_excerpt(); ?></p>
                </figcaption>
              </figure>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif ?>
    </div>
  </main>
<?php get_footer(); ?>
