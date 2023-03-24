<div class="product-list">
<?php
  $i    = 0;
  $args = array(
    'post_type'        => 'product',
    'posts_per_page'   => 2,
    'post__in'         => wc_get_featured_product_ids(),
  );
  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) { ?>
    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <div class="product-item">
        <?php
          $product_id = get_the_ID();
          $product = wc_get_product($product_id);
          $link = add_query_arg('add-to-cart', $product->get_id(), wc_get_checkout_url());
        ?>
        <div class="columns is-multiline <?php if ($i % 2 != 0) echo ' is-reverse' ?>">
          <div class="column is-6 is-6-fullhd is-6-desktop is-12-tablet">
            <div class="product-gallery">
              <div class="swiper-container product-gallery-swiper">
                <div class="swiper-wrapper">
                  <?php
                    $attachment_ids     = $product->get_gallery_image_ids();
                    $post_thumbnail_id  = $product->get_image_id();
                    array_unshift($attachment_ids, $post_thumbnail_id);
                  ?>
                  <?php if ($attachment_ids) :
                    foreach ($attachment_ids as $attachment_id) : ?>
                      <div class="swiper-slide">
                        <?php // echo wp_get_attachment_image($attachment_id, 'product_medium') ?>
                        <img data-src="<?php echo wp_get_attachment_image_url($attachment_id, 'product_medium') ?>" class="swiper-lazy" alt="">
                        <div class="swiper-lazy-preloader swiper-lazy-preloader-dark"></div>
                      </div>
                    <?php endforeach;
                  endif; ?>
                </div>
                <div class="swiper-pagination product-swiper-pagination"></div>
              </div><!-- .swiper-container -->
            </div>
          </div><!-- .column -->
          <div class="column is-5 is-5-fullhd is-6-desktop is-12-tablet">
            <div class="product-content">
              <h3 class="product-title"><?php echo $product->get_name(); ?></h3>
              <div class="product-description"><?php echo $product->get_description(); ?></div>
              <footer class="product-foot d-flex align-items-end">
                <!-- <div class="product-price"><?php echo $product->get_price_html(); ?></div> -->
                <div class="product-action d-flex">
                  <a href="#" data-select="package" data-product_id="<?php echo $product_id; ?>" class="button has-shadow buynow">เลือกรุ่นนี้<div class="rippleJS"></div></a>
                </div>
              </footer>
            </div>
          </div><!-- .column -->
        </div>
      </div>
    <?php $i++; ?>
    <?php endwhile; ?>
<?php }
  wp_reset_query();
?>
</div>