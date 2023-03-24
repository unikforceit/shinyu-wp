<?php get_header();  ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header mb-0">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
    </div>
  </section><!-- .page-header -->
	<main class="main-content pb-0">
    <div class="single-promotion-image">
      <?php
        if ($image = get_field('promotion_image')) {
          echo wp_get_attachment_image($image, 'slideshow');
        } else {
          the_post_thumbnail('slideshow');
        }
       ?>
    </div>
  
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <div class="container">
          <div class="single-promotion-content the-content">
            <div class="columns">
              <div class="column is-8">
                <h2 class="single-promotion-title"><?php the_title() ?></h2>
                <?php the_content(); ?>
              </div>
              <div class="column is-4"><div class="promotion-form"><promotion-form promotion-name="<?php the_title(); ?>"></promotion-form></div></div>
            </div>
          </div>
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

    <?php 
      $args = array(
        'post_type'          => 'promotion',
        'posts_per_page'     => 2,
        'post_status'        => 'publish',
        'orderby'            => 'rand',
        'post__not_in'       => [get_the_ID()],
        // 'order'              => 'ASC'
      );
      $the_query = new WP_Query( $args );

      if ($the_query->have_posts()) : ?>
        <section class="promotion-recommended section mb-0">
          <div class="container">
            <h3 class="promotion-recommended-title text-center">
			  <?php if($my_current_lang == 'th'){ echo('โปรโมชันแนะนำ'); } elseif($my_current_lang == 'ja'){ echo('おすすめ'); } else{ echo('Promotions'); } ?>
			  </h3>
            <div class="columns is-multiline mt-0 mb-0">
              <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="column is-6 promotion-col">
                  <figure class="promotion-item">
                    <a href="<?php the_permalink(); ?>" class="promotion-thumbnail">
                      <?php
                        if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-promotion');
                        else : echo "<img src='https://via.placeholder.com/552x245/FFFF00/000000'>";
                        endif
                      ?>
                    </a>
                    <figcaption class="d-flex align-items-start flex-column promotion-caption">
                      <h4 class="promotion-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
                    </figcaption>
                  </figure>
                </div>
              <?php endwhile;
              wp_reset_postdata(); ?>
            </div>
          </div>
        </section>
      <?php endif;
    ?>
  </main>
<?php get_footer(); ?>
