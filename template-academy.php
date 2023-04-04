
<?php
/**
 * Template Name: Academy
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
	<main class="main-content">
    <section class="academy-banner">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php if ($banner = get_field('academy_banner_1')): ?>
            <?php foreach ($banner as $key => $value) : ?>
              <?php
                $image_url = wp_get_attachment_image_url($value['image'], 'slideshow');
                $link = $value['link'];
              ?>
              <div class="swiper-slide banner-item">
                <?php if ($link) echo '<a class="is-block" href="' . $link . '" target="_blank">'; ?>
                <img data-src="<?php echo $image_url; ?>" class="swiper-lazy">
                <?php if ($link) echo '</a>'; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="swiper-navigation d-flex justify-content-between">
          <button class="prev">Prev</button>
          <button class="next">Next</button>
        </div>
        <div class="container">
          <div class="academy-banner-control d-flex">
            <!-- <button class="prev">prev</button> -->
            <div class="swiper-pagination d-flex circle"></div>
            <!-- <button class="next">next</button> -->
          </div>
        </div>
      </div>
    </section>
    <section class="mb-0 has-text-centered">
      <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <div class="page-description"><?php the_content(); ?></div>
      </div>
    </section><!-- .page-header -->

    <section class="section academy-intro has-text-centered">
      <div class="container">
        <a class="academy-intro-video glightbox" data-gallery="video" href="<?php the_field('academy_overview_video_url'); ?>">
          <?php echo wp_get_attachment_image(get_field('academy_overview_video_cover'), 'large'); ?>
        </a>
        <h2 class="title has-text-primary"><?php the_field('academy_overview_title'); ?></h2>
        <small class="subtitle has-text-primary pt-0 mb-5 is-block"><?php the_field('academy_overview_subtitle'); ?></small>
        <p><?php the_field('academy_overview_content'); ?></p>
      </div>
    </section>

    <section class="academy-banner best-seller m-0">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php if ($banner = get_field('academy_banner_2')): ?>
            <?php foreach ($banner as $key => $value) : ?>
              <?php
                $image_url = wp_get_attachment_image_url($value['image'], '2048x2048');
                $title = $value['title'];
                $link = $value['link'];
              ?>
              <div class="swiper-slide banner-item">
                <div class="container academy-banner-content<?php if ($title) echo ' has-text'; ?>">
                  <!-- <div class="academy-banner-ribbon"><span>BEST SELELER</span></div> -->
                  <?php if ($title) : ?>
                    <h3 class="academy-banner-title"><?php echo $title; ?></h3>
                    <?php if ($description = $value['description']) : ?>
                    <div class="academy-banner-description"><?php echo wpautop($description); ?></div>
                    <?php endif; ?>
                    <?php if ($link) : ?>
                    <a href="<?php echo $link; ?>" class="academy-banner-link button is-white">อ่านรายละเอียด</a>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
                <?php if ($link && !$title) echo '<a href="'. $link .'">'; ?>
                  <img data-src="<?php echo $image_url; ?>" class="swiper-lazy<?php if ($title) echo ' is-bg'; ?>">
                <?php if ($link && !$title) echo '</a>' ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="swiper-navigation d-flex justify-content-between">
          <button class="prev">Prev</button>
          <button class="next">Next</button>
        </div>
        <div class="container">
          <div class="academy-banner-control d-flex">
            <!-- <button class="prev">prev</button> -->
            <div class="swiper-pagination d-flex circle"></div>
            <!-- <button class="next">next</button> -->
          </div>
        </div>
      </div>
    </section>

    <section class="section covid-19">
      <div class="container py-6">
        <h3 class="title has-text-centered has-text-primary mb-6 pb-4"><?php the_field('academy_feature_title_1'); ?></h3>
        <div class="columns is-variable is-2 has-text-dark mb-6">
          <?php if ($features = get_field('academy_feature_1')) : ?>
            <?php foreach ($features as $feature) { ?>
              <div class="column">
                <figure>
                  <?php if ($link = $feature['link']) echo '<a class="is-block" href="' . $link . '" target="_blank">'; ?>
                    <?php echo wp_get_attachment_image($feature['image'], 'thumb-room', '', ['class' => 'mb-3 feature-icon'] ) ?>
                    <figcaption><?php echo wpautop($feature['title']); ?></figcaption>
                  <?php if ($feature['link']) echo '</a>'; ?>
                </figure>
              </div>
            <?php } ?>
          <?php endif; ?>
        </div>
        <h3 class="title has-text-centered has-text-primary mb-6"><strong class="has-text-primary">“</strong><?php the_field('academy_feature_title'); ?><strong class="has-text-primary">”</strong></h3>
        <div class="columns is-variable is-2 has-text-primary">
          <?php if ($features = get_field('academy_feature')) : ?>
            <?php foreach ($features as $feature) { ?>
              <div class="column">
                <figure>
                  <?php echo wp_get_attachment_image($feature['image'], 'thumb-room', '', ['class' => 'mb-3'] ) ?>
                  <figcaption><?php echo $feature['title']; ?></figcaption>
                </figure>
              </div>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="academy-banner best-seller m-0">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php if ($banner = get_field('academy_banner_3')): ?>
            <?php foreach ($banner as $key => $value) : ?>
              <?php
                $image_url = wp_get_attachment_image_url($value['image'], '2048x2048');
                $title = $value['title'];
                $link = $value['link'];
              ?>
              <div class="swiper-slide banner-item">
                <div class="container academy-banner-content<?php if ($title) echo ' has-text'; ?>">
                  <!-- <div class="academy-banner-ribbon"><span>BEST SELELER</span></div> -->
                  <?php if ($title) : ?>
                    <h3 class="academy-banner-title"><?php echo $title; ?></h3>
                    <?php if ($description = $value['description']) : ?>
                    <div class="academy-banner-description"><?php echo wpautop($description); ?></div>
                    <?php endif; ?>
                    <?php if ($link) : ?>
                    <a href="<?php echo $link; ?>" class="academy-banner-link button is-white">อ่านรายละเอียด</a>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
                <?php if ($link && !$title) echo '<a href="'. $link .'">'; ?>
                  <img data-src="<?php echo $image_url; ?>" class="swiper-lazy<?php if ($title) echo ' is-bg'; ?>">
                <?php if ($link && !$title) echo '</a>' ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="swiper-navigation d-flex justify-content-between">
          <button class="prev">Prev</button>
          <button class="next">Next</button>
        </div>
        <div class="container">
          <div class="academy-banner-control d-flex">
            <!-- <button class="prev">prev</button> -->
            <div class="swiper-pagination d-flex circle"></div>
            <!-- <button class="next">next</button> -->
          </div>
        </div>
      </div>
    </section>

    <section class="section academy-promotion">
      <div class="container">
        <h3 class="has-text-primary has-text-centered">คอร์สทั้งหมด</h3>
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
                'terms'    => 'courses',
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

              <div class="column is-4 mb-5">
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
                      <div class="product-info">
                        <span><?php shinyu_icon('film'); ?><?php the_field('_product_courses_ep'); ?> บทเรียน</span>
                        <span class="pl-4"><?php shinyu_icon('clock'); ?><?php the_field('_product_courses_time'); ?></span>
                      </div>
                    </div>
                  </div>
                  <div class="product-footer is-flex is-justify-content-space-between is-align-items-center">
                    <span class="product-footer-item">
                      <?php woocommerce_template_loop_price(); ?>
                    </span>
                    <a href="<?php echo esc_url(home_url('/'. pll_current_language() .'/?add-to-cart=' . get_the_ID())); ?>" class="product-footer-item buy">ซื้อคอร์สนี้</a>
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

    <section>
      <a href="<?php the_field('academy_promotion_url'); ?>"><?php echo wp_get_attachment_image(get_field('academy_promotion_image'), 'slideshow'); ?></a>
    </section>
    
    <section class="section academy-coach">
      <div class="container py-6">
        <h3 class="has-text-primary has-text-centered">ผู้บรรยาย</h3>
        <div class="columns">
          <?php if ($coachs = get_field('academy_coach')) : ?>
            <?php foreach ($coachs as $coach) { ?>
              <div class="column">
                <div class="image"><?php echo wp_get_attachment_image($coach['profile'], 'thumbnail'); ?></div>
                <h4 class="has-text-primary mb-3"><?php echo $coach['name']; ?></h4>
                <p><?php echo wpautop($coach['position']); ?></p>
              </div>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="academy-project partner d-none d-lg-block">
      <div class="container">
        <h3 class="has-text-primary has-text-centered">บริษัทที่ร่วมงาน</h3>

        <div class="swiper-container partner-swiper-container">
          <div class="swiper-wrapper">
            <?php
              $args = [
                'post_type'          => 'partner',
                'posts_per_page'     => -1,
                'post_status'        => 'publish',
                'order'              => 'ASC',
              ];

              $the_query = new WP_Query( $args );

              if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <div class="swiper-slide text-center">
                  <a href="" target="_blank" class="partner-item d-block"><?php the_post_thumbnail('medium') ?></a>
                </div>
                <?php endwhile;
                wp_reset_postdata();
              endif;
            ?>
          </div>
          <div class="container">
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="section testimonial academy-testimonial">
      <div class="container py-6">
        <h3 class="has-text-primary has-text-centered">นักเรียนของเรา</h3>
        <div class="swiper-container testimonial-swiper-container">
          <div class="swiper-wrapper">
          <?php if ($reviews = get_field('academy_review')) : ?>
            <?php foreach ($reviews as $review) { ?>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <p><strong>“</strong><?php echo $review['message'] ?></p>
                <h4><?php echo $review['name'] ?></h4>
              </div>
            </div>
            <?php } ?>
          <?php endif; ?>

          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>

    <section class="section academy-gallery">
      <div class="container py-6">
        <h3 class="has-text-white has-text-centered">ภาพกิจกรรม</h3>
        <div class="columns is-variable is-2">
          <?php if ($galleries = get_field('academy_gallery')) : ?>
            <?php foreach ($galleries as $image) { ?>
              <div class="column">
                <a href="<?php echo wp_get_attachment_image_url($image, 'large'); ?>" data-gallery="gallery" class="column glightbox">
                  <?php echo wp_get_attachment_image($image, 'medium'); ?>
                </a>
              </div>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="section academy-social">
      <div class="container">
        <div class="d-sm-flex justify-content-between">
          <h3 class="has-text-primary has-text-centered mb-6 mb-sm-0">สอบถามรายละเอียดเพิ่มเติม</h3>
          <ul class="columns">
            <li class="column">
              <a class="academy-social-link facebook" href="https://facebook.com/ShinyuAcademy" target="_blank">
                <?php shinyu_icon('facebook-2'); ?>
                <span class="d-block">Facebook</span>
              </a>
            </li>
            <li class="column">
              <a class="academy-social-link line" href="https://lin.ee/rgphTCC" target="_blank">
                <?php shinyu_icon('line'); ?>
                <span class="d-block">Line</span>
              </a>
            </li>
            <li class="column">
              <a class="academy-social-link messenger" href="https://www.facebook.com/ShinyuAcademy" target="_blank">
                <?php shinyu_icon('messenger'); ?>
                <span class="d-block">Messenger</span>
              </a>
            </li>
            <li class="column">
              <a  class="academy-social-link youtube" href="<?php the_field('social_youtube_url', 'option'); ?>" target="_blank">
                <?php shinyu_icon('youtube-2'); ?>
                <span class="d-block">Youtube</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <section class="section news academy-article">
      <div class="container">
        <div>
          <h3 class="has-text-primary has-text-centered">บทความเพิ่มความรู้</h3>
          <a class="tag" href="https://shinyurealestate.com/article/category/knowledge">อ่านบทความอื่นๆ</a>
        </div>

        <div class="columns">
          <?php
            $args = [
              'post_type'          => 'news',
              'posts_per_page'     => 3,
              'post_status'        => 'publish',
              'order'              => 'DESC',
              'post__in'           => get_field('academy_article'),
            ];

            $the_query = new WP_Query( $args );

            if ($the_query->have_posts()) :
              while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <div class="column">
                  <div class="news-item card">
                    <a class="card-image" href="<?php the_permalink(); ?>">
                      <?php
                        if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-news');
                        else : echo "<img src='https://via.placeholder.com/358x210/FFFF00/000000'>";
                        endif
                      ?>
                    </a>
                    <div class="news-content card-content">
                      <h4 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                      <a class="news-read" href="<?php the_permalink(); ?>">อ่านเพิ่มเติม</a>
                    </div>
                  </div>
                </div>
              <?php endwhile;
              wp_reset_postdata();
            endif;
          ?>
        </div>
      </div>
    </section>

	</main>
<?php get_footer(); ?>