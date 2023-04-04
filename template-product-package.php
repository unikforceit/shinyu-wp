
<?php
/**
 * Template Name: Package
 */
get_header(); ?>
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
  <section class="page-header mb-0">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
      <div class="page-description"><?php the_content(); ?></div>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <?php endwhile; ?>
    <?php endif ?>
    <section class="section">
      <div class="container">
        <?php
          $args = [
            'post_type'          => 'product',
            'posts_per_page'     => -1,
            'post_status'        => 'publish',
            'order'              => 'DESC',
            'tax_query'          => [
              'relation' => 'AND',
              [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'packages',
                'operator' => 'IN'
              ],
              [
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
              ],
            ]
          ];

          $the_query = new WP_Query( $args );

          if ($the_query->have_posts()) : ?>
            <div class="columns is-multiline">
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

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
                      <p class="product-description"><?php echo get_the_excerpt(); ?></p>
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
            <?php wp_reset_postdata();
          endif;
        ?>
      </div>
    </section>
	</main>
<?php get_footer(); ?>