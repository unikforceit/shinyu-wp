<?php
/**
 * Template Name: Management Service
 * Template Post Type: product
 */
global $product;
get_header(); ?>
    <section class="search-bar is-relative custom-global-search">
        <div class="search-box-item">
            <div class="container">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="autocomplete control">
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
	<main class="main-content pb-0">
    <section class="management-plan section">
      <div class="container">
        <div class="content"><?php the_field('_product_management_description'); ?></div>
      </div>
    </section>

    <section class="management-deposit section">
      <div class="container">
        <?php the_content(); ?>
      </div>
    </section>
    <section class="section management-form" id="management-form">
      <?php 
        $package = [];
        if ($plans) : 
          foreach ($plans as $plan) {
            $months = get_term_by('slug', $plan['attributes']['attribute_pa_months'], 'pa_months');
            $subscription = get_term_by('slug', $plan['attributes']['attribute_pa_subscription'], 'pa_subscription');

            $package[] = [
              'id'    => $plan['variation_id'],
              'title' => $months->name . ' (' . $subscription->name . ')',
              'price' => $plan['display_price'],
              'month' => $plan['attributes']['attribute_pa_months'],   
            ];
          }
        endif; ?>
      <?php $consultant = explode(PHP_EOL, get_field('_product_management_property_consultant')); ?>
		<section id="form"></section>
      <management-form :product-id="<?php echo $product->get_id(); ?>" package="<?php echo htmlspecialchars(json_encode($package)); ?>" consultant="<?php echo htmlspecialchars(json_encode($consultant)); ?>"></management-form>
    </section>
		
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
       <h3 class="title has-text-primary mb-6"><?php pll_e('Other services'); ?></h3>
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