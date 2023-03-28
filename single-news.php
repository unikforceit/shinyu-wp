<?php get_header(); ?>
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
  <section class="page-header">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <?php if (have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
          <div class="single-news-image"><?php the_post_thumbnail('large'); ?></div>
          <div class="single-news-content">
            <div class="the-content"><?php the_content(); ?></div>
            <?php $images = get_field('news_gallery', false, false); ?>
            <?php if ($images) : ?>
              <div class="shinyu-galleries mb-6">
                <div class="shinyu-gallery swiper-container">
                  <div class="swiper-wrapper">
                      <?php foreach ($images as $key => $image) : ?>
                        <div class="swiper-slide">
                          <a class="glightbox" href="<?php echo wp_get_attachment_image_url($image, 'large'); ?>"><?php echo wp_get_attachment_image($image, 'large') ?></a>
                        </div>
                      <?php endforeach; ?>
                  </div>
                </div>
                <div class="shinyu-gallery-thumb mb-6">
                  <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $key => $image) : ?>
                          <div class="swiper-slide">
                            <?php echo wp_get_attachment_image($image, 'thumbnail') ?>
                          </div>
                        <?php endforeach; ?>
                    </div>
                  </div>
                  <!-- <div class="gallery-navigation prev"></div>
                  <div class="gallery-navigation next"></div> -->
                </div>
              </div>
            <?php endif; ?>
             <?php 	
					if($my_current_lang == 'th'){ 
						$share_text = 'แชร์ :';
					} 
					elseif($my_current_lang == 'ja'){ 
						$share_text = '共有 :';
					} 
					else{ 
						$share_text = 'Share :';
					}					
					social_share($share_text, get_the_permalink()); 
					?>  
          </div>
        <?php endwhile; ?>
      <?php endif ?>
    </div>

    <?php 
      $args = array(
        'post_type'          => 'news',
        'posts_per_page'     => 3,
        'post_status'        => 'publish',
        'orderby'            => 'rand',
        'post__not_in'       => [get_the_ID()],
        // 'order'              => 'ASC'
      );
      $the_query = new WP_Query( $args );

      if ($the_query->have_posts()) : ?>
        <section class="related-news container">
          <h3 class="related-news-title">
      <?php if($my_current_lang == 'th'){ echo('บทความน่าสนใจ'); } elseif($my_current_lang == 'ja'){ echo('おすすめ'); } else{ echo('Recommended'); } ?>
			</h3>
          <div class="columns is-multiline mt-0 mb-0">
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
              <div class="column is-4 news-col">
                <div class="news-item card">
                  <a class="card-image" href="<?php the_permalink(); ?>">
                    <?php
                      if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-news');
                      else : echo "<img src='https://via.placeholder.com/358x210/FFFF00/000000'>";
                      endif;
                    ?>
                  </a>
                  <div class="news-content card-content">
                    <h4 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="news-excerpt"><?php echo get_the_excerpt(); ?></div>
                    <a class="news-read" href="<?php the_permalink(); ?>">
					  <?php if($my_current_lang == 'th'){ echo('อ่านต่อ'); } elseif($my_current_lang == 'ja'){ echo('さらに詳しく'); } else{ echo('Read More'); } ?>
					  </a>
                  </div>
                </div>
              </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
          </div>
        </section>
      <?php endif;
    ?>
  </main>
<?php get_footer(); ?>
