
<?php
/**
 * Template Name: Inspection Service
 * Template Post Type: product
 */
global $product;
get_header(); ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
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
      <?php while (have_posts()) : the_post();
      $variations = $product->get_available_variations();
      $package = [];
      if ($variations) : 
        foreach ($variations as $variation) {
          $sizes = get_term_by('slug', $variation['attributes']['attribute_pa_condominium-size'], 'pa_condominium-size');
          $package[] = [
            'id'    => $variation['variation_id'],
            'title' => $sizes->name,
            'price' => $variation['display_price'],
          ];
        }
      endif; ?>
        <section class="section pt-0">
          <div class="container">
            <div class="columns is-multiline">
              <div class="column is-8-widescreen is-12-desktop pt-6">
                <div class="product-content content pt-5">
                  <?php the_content(); ?>
                  <!-- <hr class="is-primary">
                  <h3>อัตราค่าบริการ</h3>
                  <div class="table-container">
                    <table class="table is-hoverable is-fullwidth">
                      <tr>
                        <th>Condominium Size</th>
                        <th>Service Fee</th>
                      </tr>
                      <?php foreach ($package as $value) { ?>
                        <tr>
                          <td><?php echo $value['title']; ?></td>
                          <td><?php echo wc_price($value['price']); ?></td>
                        </tr>
                      <?php } ?>
                    </table>
                  </div>
                  <p><strong>Remark</strong></p>
                  <ul>
                    <li>ในกรณีที่ทำการตรวจสภาพห้องแล้วทั้ง 2 ครั้ง แต่ยังพบข้อบกพร่องของห้องอยู่ ลูกค้าสามารถรับบริการตรวจสภาพเพิ่มเติมได้ โดยมีค่าบริการครั้งละ 1,000 บาท</li>
                    <li>ราคารวม VAT 7% แล้ว</li>
                  </ul> -->
                </div>
              </div>
              <div class="column is-4-widescreen is-12-desktop">
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
                        <div class="inspection-service-form"><inspection-service-form product-id="<?php the_ID(); ?>" price="<?php echo htmlspecialchars($product->get_price_html()); ?>" package="<?php echo htmlspecialchars(json_encode($package)); ?>"></inspection-service-form></div>
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