<?php get_header(); ?>

	<?php $my_current_lang = apply_filters( 'wpml_current_language', NULL );
		// Check WPML current lang and put in in variable to create custom logic - Nutn0n, Nov 28, 2022. 
		?>

  <section class="search-bar is-relative d-lg-none"><search-bar></search-bar></section>
  <section class="slideshow is-loading">
    <div class="swiper-container slideshow-swiper-container">
      <div class="swiper-wrapper">
        <?php if ($slideshow = get_field('_page_home_slideshow')): ?>
          <?php foreach ($slideshow as $key => $value) : ?>
            <?php
              $image_url = wp_get_attachment_image_url($value['image'], 'slideshow');
              $image_mobile_url = wp_get_attachment_image_url($value['image_mobile'], 'full');

              if (!$image_mobile_url) $image_mobile_url = $image_url;
            ?>
            <div class="swiper-slide slideshow-item d-flex justify-content-center align-items-center text-center">
              <?php if ($link = $value['link']) echo '<a class="is-block" href="' . $link . '" target="_blank">'; ?>
              <div class="slideshow-content d-flex justify-content-center align-items-center text-center">
                <div class="slideshow-content-inner">
                  <h2 class="slideshow-title"><?php echo $value['title']; ?></h2>
                  <p class="slideshow-description"><?php echo $value['description']; ?></p>
                </div>
              </div>
              <img data-src="<?php echo $image_url; ?>" class="swiper-lazy d-none d-lg-block">
              <img data-src="<?php echo $image_mobile_url; ?>" class="swiper-lazy d-lg-none">
              <?php if ($value['link']) echo '</a>'; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="slideshow-navigation swiper-navigation d-flex justify-content-between">
        <button class="prev">Prev</button>
        <button class="next">Next</button>
      </div>
      <div class="container">
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>
  <section class="search-box">
    <search-box></search-box>
  </section>
  <main class="main-content">
    <section class="unit-special">
      <div class="container">
        <h2 class="text-center">
			<?php if($my_current_lang == 'th'){ echo('ยูนิตคัดพิเศษ'); } elseif($my_current_lang == 'ja'){ echo('おすすめ物件'); } else{ echo('Special Units'); } ?>
			<small>
			<?php if($my_current_lang == 'th'){ echo('ชินยู นำมาให้คุณได้เลือกก่อนใคร'); } elseif($my_current_lang == 'ja'){ echo(''); } else{ echo('Special Units for you to choose'); } ?>
			</small>
		  </h2>
        <div class="unit-special-app"><unit-special></unit-special></div>
      </div>
    </section>

    <section class="project-presale d-none d-lg-block">
      <div class="container">
        <h2 class="section-title text-center"><?php pll_e('Pre-sale projects'); ?></h2>
        <p class="section-description text-center"><?php pll_e('Shinyu collects quality projects exclusively for you along with special promotions'); ?></p>
        <?php if (have_rows('_page_home_project')) : ?>
          <?php $i = 0; ?>
          <?php while (have_rows('_page_home_project')) : the_row(); ?>
            <?php $images = get_sub_field('gallery', false, false); ?>
            <div class="project-presale-item">
              <div class="columns is-gapless<?php if ($i % 2 != 0) echo ' is-flex-direction-row-reverse' ?>">
                <div class="column is-6">
                  <div class="project-presale-gallery">
                    <?php if ($images ) : ?>
                      <div class="swiper-container project-swiper-container">
                        <div class="swiper-wrapper">
                          <?php foreach ($images as $image) : ?>
                            <div class="swiper-slide">
                              <div class="project-presale-gallery-item">
                                <img src="<?php echo webp(wp_get_attachment_image_url($image, 'large')); ?>" alt="">
                              </div>
                            </div>
                          <?php endforeach; ?>
                          <div class="swiper-pagination"></div>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="column is-6">
                  <div class="project-presale-content">
                    <h4 class="project-presale-title"><a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('title'); ?></a></h4>
                    <small class="project-presale-developer">by <?php the_sub_field('developer'); ?></small>
                    <p class="project-presale-description"><?php the_sub_field('description'); ?></p>
                    <a href="<?php the_sub_field('link'); ?>" class="project-presale-price"><?php the_sub_field('price'); ?></a>
                  </div>
                </div>
              </div>
            </div>
            <?php $i++; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </section>

    <section class="service">
      <div class="service-background d-none d-lg-block"></div>
      <div class="container">
        <div class="service-inner">
          <h2 class="section-title text-center">
			<?php if($my_current_lang == 'th'){ echo('บริการทั้งหมดของชินยู'); } elseif($my_current_lang == 'ja'){ echo('私達のサービスについて'); } else{ echo('Our Service'); } ?>
			</h2>
          <p class="section-description text-center">
			  <?php if($my_current_lang == 'th'){ echo('Shinyu Real Estate คือเพื่อนสนิทที่ตอบโจทย์คุณ ด้วยความเชี่ยวชาญทางด้านการลงทุน อสังหาริมทรัพย์ที่มีความเชี่ยวชาญ ทั้งตลาดในไทยและต่างประเทศ'); } elseif($my_current_lang == 'ja'){ echo(''); } else{ echo('Shinyu Real Estate is your true friend who can assist you on real estate investment with specialized experience in both Thai and overseas market.'); } ?></p>
          <div class="columns is-multiline">
            <?php
              $args = [
                'post_type'          => 'service',
                'posts_per_page'     => 6,
                'post_status'        => 'publish',
                'order'              => 'DESC',
              ];

              $the_query = new WP_Query( $args );

              if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post(); 
                  $link = get_permalink();
                  $product_id = get_field('_service_product');
                  if ($product_id) $link = get_permalink($product_id);
                ?>
                  <div class="column is-4">
                    <div class="service-item card">
                      <a class="service-image card-image" href="<?php echo $link; ?>">
                        <?php
                          if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-news');
                          else : echo "<img src='https://via.placeholder.com/358x210/FFFF00/000000'>";
                          endif
                        ?>
                      </a>
                      <div class="service-content card-content">
                        <h4 class="service-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h4>
                        <p class="service-description"><?php the_field('_service_description'); ?></p>
                      </div>
                    </div>
                  </div>
                <?php endwhile;
                wp_reset_postdata();
              endif;
            ?>
          </div>
        </div>
      </div>
      <p class="has-text-centered"><a class="" href="<?php echo get_post_type_archive_link('service'); ?>"><strong><?php pll_e('View all Services'); ?></strong></a></p>
    </section>

    <section class="shinyu-channel">
      <div class="container">
        <h2 class="section-title">SHINYU CHANNEL</h2>
        <p class="section-description"><?php pll_e('Another channel for you to stay updated with and learn a wide range of  real estate news and technique : follow us on'); ?></p>
        <div class="columns">
          <?php
            $args = [
              'post_type'          => 'video',
              'posts_per_page'     => 5,
              'post_status'        => 'publish',
              'order'              => 'DESC',
            ];

            $i = 0;
            $big = '';
            $small = '';

            $the_query = new WP_Query( $args );

            if ($the_query->have_posts()) :
              while ($the_query->have_posts()) : $the_query->the_post();
                $i++; 

                if ($i === 1) :
                  $big .= '<a class="media big d-block glightbox" href="'. get_field('_video_url') .'">';
                  $big .= '<figure class="image">';
                  $big .= '<img src="'. webp(get_the_post_thumbnail_url(get_the_ID(), 'large')) .'">';
                  $big .= '</figure>'; 
                  $big .= '<div class="media-content">';
                  $big .= '<h4 class="pt-4">'. get_the_title() .'</h4>';                      
                  $big .= '</div>';
                  $big .= '</a>';
                else : 
                  $small .= '<a class="media glightbox" href="'. get_field('_video_url') .'">';
                  $small .= '<div class="media-left">';
                  $small .= '<figure class="image">';
                  $small .= '<img src="'. webp(get_the_post_thumbnail_url(get_the_ID(), 'thumb-video')) .'">';
                  $small .= '</figure>';                  
                  $small .= '</div>';
                  $small .= '<div class="media-content">';
                  $small .= '<h4>'. get_the_title() .'</h4>';                      
                  $small .= '</div>';                                 
                  $small .= '</a>';
                endif;

              endwhile;
              wp_reset_postdata();
            endif;
          ?>
          <div class="column is-7"><?php echo $big; ?></div>
          <div class="column is-5">
            <?php echo $small; ?>
            <a class="button is-fullwidth mt-5" href="https://www.youtube.com/channel/UCL3QLc5C06VxE6zQvqAwuCw" target="_blank">SHINYU YOUTUBE CHANNEL</a>
          </div>
        </div>
      </div>
    </section>

    <section class="news">
		
      <div class="container">
        <h2 class="section-title text-center">
			<?php if($my_current_lang == 'th'){ echo('ข่าวสารแวดวงอสังหาริมทรัพย์'); } elseif($my_current_lang == 'ja'){ echo('不動産情報'); } else{ echo('Real estate trend, news, and updates'); } ?>
			<a class="d-none d-md-block" href="<?php echo get_post_type_archive_link('news'); ?>">+</a>
		  </h2>
        <p class="section-description text-center">
		<?php if($my_current_lang == 'th'){ echo('พบกับข่าวสารจากผู้เชี่ยวชาญด้านอสังหาริมทรัพยที่อัพเดทล่าสุด'); } elseif($my_current_lang == 'ja'){ echo('最新のニュース'); } else{ echo('Latest updates and news about real estate and brokerage industry from experienced specialists'); } ?>
          <a class="d-block d-md-none" href="<?php echo get_post_type_archive_link('news'); ?>"><?php pll_e('View all') ?></a>
        </p>
        <div class="swiper-container news-swiper-container">
          <div class="swiper-wrapper">
            <?php
              $args = [
                'post_type'          => 'news',
                'posts_per_page'     => 9,
                'post_status'        => 'publish',
                'order'              => 'DESC',
              ];

              $the_query = new WP_Query( $args );

              if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post(); ?>
                  <div class="swiper-slide">
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
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>
    <?php if ($testimonials = get_field('_page_home_testimonial')) : ?>
      <section class="section home-testimonial testimonial">
        <div class="container py-6">
          <h3 class="has-text-primary has-text-centered">
			<?php if($my_current_lang == 'th'){ echo('เสียงตอบรับจากลูกค้า'); } elseif($my_current_lang == 'ja'){ echo('レビュー'); } else{ echo('Reviews'); } ?>
			</h3>
          <div class="swiper-container testimonial-swiper-container">
            <div class="swiper-wrapper">
              <?php foreach ($testimonials as $testimonial) : ?>
              <div class="swiper-slide">
                <?php echo wp_get_attachment_image($testimonial['image'], 'thumb-room'); ?>
                <div class="testimonial-item">
                  <p><strong>“</strong><?php echo $testimonial['message']; ?></p>
                  <h4><?php echo $testimonial['name']; ?></h4>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
    <?php endif; ?>
    <section class="partner d-none d-lg-block">
      <div class="container">
        <h2 class="section-title text-center">
		  <?php if($my_current_lang == 'th'){ echo('พาร์ทเนอร์ของเรา'); } elseif($my_current_lang == 'ja'){ echo('パートナー'); } else{ echo('Our special partners'); } ?>
		  </h2>
        <p class="section-description text-center">
		  	  <?php if($my_current_lang == 'th'){ echo('เพราะเราต้องคัดสรรสิ่งที่ดีที่สุดเพื่อลูกค้าของเรา'); } elseif($my_current_lang == 'ja'){ echo('より良いものをご提供するため'); } else{ echo('Because we need to bring the best things to our customers'); } ?>
		  </p>

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
  </main>
<?php get_footer(); ?>