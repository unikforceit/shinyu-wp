
<?php
/**
 * Template Name: Interior Service
 * Template Post Type: product
 */
global $product;
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
      <div class="page-description"><?php echo wpautop($product->get_short_description()); ?></div>
    </div>
    <?php if (has_post_thumbnail()) : ?>
    <div class="page-header-background">
      <?php the_post_thumbnail('full'); ?>
    </div>
    <?php endif; ?>
  </section><!-- .page-header -->
	<main class="main-content">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <section class="section pt-0">
          <div class="container">
            <div class="columns is-multiline">
              <div class="column is-8-widescreen is-12-desktop pt-6">
                <div class="product-content content pt-5">
                  <?php the_content(); ?>
                  <div class="interior-work pt-6">
                    <h3 class="mb-5"><?php pll_e('Package samples'); ?></h3>
                    <?php $luxury = get_field('_product_interior_luxury_gallery'); ?>
                    <?php if ($luxury) : ?>
                      <h4>Luxury</h4>
                      <div class="shinyu-galleries mr-6">
                        <div class="shinyu-gallery swiper-container">
                          <div class="swiper-wrapper">
                              <?php foreach ($luxury as $key => $image) : ?>
                                <div class="swiper-slide">
                                  <?php echo wp_get_attachment_image($image, 'gallery') ?>
                                </div>
                              <?php endforeach; ?>
                          </div>
                        </div>
                        <div class="shinyu-gallery-thumb mb-6">
                          <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?php foreach ($luxury as $key => $image) : ?>
                                  <div class="swiper-slide">
                                    <?php echo wp_get_attachment_image($image, 'thumbnail') ?>
                                  </div>
                                <?php endforeach; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>

                    <?php $legacy = get_field('_product_interior_legacy_gallery'); ?>
                    <?php if ($legacy) : ?>
                      <h4>Legacy</h4>
                      <div class="shinyu-galleries mr-6">
                        <div class="shinyu-gallery swiper-container">
                          <div class="swiper-wrapper">
                              <?php foreach ($legacy as $key => $image) : ?>
                                <div class="swiper-slide">
                                  <?php echo wp_get_attachment_image($image, 'gallery') ?>
                                </div>
                              <?php endforeach; ?>
                          </div>
                        </div>
                        <div class="shinyu-gallery-thumb mb-6">
                          <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?php foreach ($legacy as $key => $image) : ?>
                                  <div class="swiper-slide">
                                    <?php echo wp_get_attachment_image($image, 'thumbnail') ?>
                                  </div>
                                <?php endforeach; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>

                    <?php $supremacy = get_field('_product_interior_supremacy_gallery'); ?>
                    <?php if ($supremacy) : ?>
                      <h4>Supremacy</h4>
                      <div class="shinyu-galleries mr-6">
                        <div class="shinyu-gallery swiper-container">
                          <div class="swiper-wrapper">
                              <?php foreach ($supremacy as $key => $image) : ?>
                                <div class="swiper-slide">
                                  <?php echo wp_get_attachment_image($image, 'gallery') ?>
                                </div>
                              <?php endforeach; ?>
                          </div>
                        </div>
                        <div class="shinyu-gallery-thumb mb-6">
                          <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?php foreach ($supremacy as $key => $image) : ?>
                                  <div class="swiper-slide">
                                    <?php echo wp_get_attachment_image($image, 'thumbnail') ?>
                                  </div>
                                <?php endforeach; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="column is-4-widescreen is-12-desktop ">
                <div class="product-sidebar">
                  <div class="card product-sidebar-content">
                    <div class="card-image product-sidebar-image">
                      <?php
                        if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-room');
                        else : echo "<img src='https://via.placeholder.com/358x210/FFFF00/000000'>";
                        endif;
                      ?>
                    </div>
                    <div class="card-content">
                      <div class="content">
                        <h3 class="has-text-primary"><?php the_title(); ?></h3>
                        <div class="interior-service-form"><interior-form></interior-form></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      <?php endwhile; ?>
    <?php endif ?>
    <?php if ($testimonials = get_field('_product_testimonial')) : ?>
      <section class="section testimonial">
        <div class="container">
          <h3 class="has-text-primary has-text-centered">เสียงตอบรับจากลูกค้า</h3>
          <div class="swiper-container testimonial-swiper-container">
            <div class="swiper-wrapper">
              <?php foreach ($testimonials as $testimonial) : ?>
              <div class="swiper-slide">
                <div class="testimonial-item">
                  <p><strong>“</strong><?php echo $testimonial['message'] ?></p>
                  <h4><?php echo $testimonial['name'] ?></h4>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
    <?php endif; ?>
    <section class="section product-other">
      <div class="container">
       <h3 class="title has-text-primary"><?php pll_e('Other services'); ?></h3>
        <?php
          $args = [
            'post_type'          => 'product',
            'posts_per_page'     => 3,
            'post_status'        => 'publish',
            'order'              => 'DESC',
            'post__not_in'       => [get_the_ID()],
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

              <div class="column product-column">
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


