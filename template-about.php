<?php
/**
 * Template Name: About
 */
get_header(); ?>

		
		<?php $my_current_lang = apply_filters( 'wpml_current_language', NULL );
		// Check WPML current lang and put in in variable to create custom logic - Nutn0n, Nov 28, 2022. 
		?>
		

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
      <h1 class="page-title has-text-white text-center">INVEST IN TRUST</h1>
      <!-- <?php woocommerce_breadcrumb(); ?> -->
    </div>
  </section><!-- .page-header -->
	<main class="main-content" <?php if (get_query_var('section')) echo 'data-goto="'. get_query_var('section') .'"'; ?>>
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <section class="about-overview" id="overview">
        <div class="container">
          <div class="columns">
            <div class="column is-6">
              <div class="about-overview-content">
                <h2 class="title is-1 has-text-primary"><?php the_title(); ?></h2>
                <div><?php echo wpautop(get_field('about_overview_content')); ?></div>
              </div>
            </div>  
            <div class="column is-6">
              <?php the_post_thumbnail('full'); ?>
            </div>     
          </div>
        </div>

		<!--
        <div class="about-vision container">
          <div class="columns">
            <div class="column">
              <div class="about-vision-item">
                <h3><?php the_field('about_vision_title'); ?></h3>
                <p><?php the_field('about_vision_description'); ?></p>
              </div>
            </div>
            <div class="column">
              <div class="about-vision-item">
                <h3><?php the_field('about_mission_title'); ?></h3>
                <p><?php the_field('about_mission_description'); ?></p>
              </div>
            </div>
            <div class="column">
              <div class="about-vision-item">
                <h3><?php the_field('about_slogan_title'); ?></h3>
                <p><?php the_field('about_slogan_description'); ?></p>
              </div>
            </div>
          </div>
        </div>

--> 

      </section>

      <section class="about-location">
        <div class="container">
          <div class="columns">
            <div class="column is-6">
              <?php echo wp_get_attachment_image(get_field('about_corporate_image'), 'full') ?>
            </div>
            <div class="column is-6">
              <div class="about-location-content">
                <h4 class="is-size-3 has-text-weight-bold has-text-primary mb-5"><?php the_field('about_corporate_name'); ?></h4>
                <p class="mb-5 pb-5"><?php the_field('about_corporate_address'); ?></p>

                <div class="columns">
                  <div class="column">
                    <h4 class="is-size-3 has-text-weight-bold has-text-primary">
					  <?php if($my_current_lang == 'th'){ echo('วันจดทะเบียน'); } elseif($my_current_lang == 'ja'){ echo('Date'); } else{ echo('Date'); } ?>
					  </h4>
                    <span><?php the_field('about_corporate_registration_date'); ?></span>
                  </div>
                  <div class="column">
                    <h4 class="is-size-3 has-text-weight-bold has-text-primary">
					  <?php if($my_current_lang == 'th'){ echo('ทุนจดทะเบียน'); } elseif($my_current_lang == 'ja'){ echo('Capital'); } else{ echo('Capital'); } ?>
					  </h4>
                    <span><?php the_field('about_corporate_registered_capital'); ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="about-history">
        <div class="container">
          <h3 class="has-text-white text-center">
			<?php if($my_current_lang == 'th'){ echo('ความเป็นมา'); } elseif($my_current_lang == 'ja'){ echo('沿革'); } else{ echo('Our History'); } ?>
			</h3>

          <div class="about-history-timeline has-text-white">
          <?php if ($history = get_field('about_history')): ?>
            <?php foreach ($history as $value) : ?>
              <div class="about-history-timeline-item">
                <h4 class="about-history-timeline-year">
                  <span><?php echo $value['title']; ?></span>
                </h4>
                <div class="about-history-timeline-description"><?php echo $value['description']; ?></div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          </div>
        </div>
      </section>


      <section class="about-subsidiaries text-center">
        <div class="container">
          <h3 class="has-text-primary"><?php if($my_current_lang == 'th'){ echo('บริษัทในเครือ'); } elseif($my_current_lang == 'ja'){ echo('企業'); } else{ echo('Compaines'); } ?></h3>
          <div class="columns is-variable is-5 is-multiline">
            <?php if ($subsidiaries = get_field('about_subsidiaries')): ?>
              <?php foreach ($subsidiaries as $value) : ?>
                <div class="column is-4">
                  <div class="about-subsidiaries-logo">
                    <?php if($logo = $value['logo']): ?>
                      <?php echo wp_get_attachment_image($logo, 'medium'); ?>
                    <?php else : ?>
                      <img class="default" src="<?php echo content_url('uploads/2022/07/shinyu-logo@2x.png') ?>">
                    <?php endif; ?>
                  </div>
                  <h4 class="has-text-primary mb-3"><?php echo $value['name']; ?></h4>
                  <div class="mb-5"><?php echo $value['description']; ?></div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="about-shinyu-value has-text-white" id="shinyu-value">
        <div class="container">
          <h3 class="has-text-white text-center">SHINYU VALUE</h3>
          <img class="about-shinyu-value-image" src="<?php echo content_url('uploads/2022/07/about-shinyu-value@2x.png') ?>" alt="">
          <div class="columns">
            <?php
              if (have_rows('about_invest_in_trust_item')): 
                while( have_rows('about_invest_in_trust_item')): the_row(); ?>
                <div class="column">
                  <h4><?php the_sub_field('title'); ?></h4>
                  <p><?php the_sub_field('description'); ?></p>
                </div>
                <?php endwhile; 
              endif;
            ?>
          </div>
        </div>
      </section>

      <section class="about-team" id="team">
        <div class="container">
          <h3 class="has-text-primary text-center"><?php if($my_current_lang == 'th'){ echo('ผู้บริหาร'); } elseif($my_current_lang == 'ja'){ echo('エグゼクティブ'); } else{ echo('Executives'); } ?></h3>
			
			
			    <div class="columns about-team-content">
        			
					<div class="column about-team-feature-image">
					<?php echo wp_get_attachment_image(get_field('about_people_image'), 'full'); ?>
                			</div>
						<div class="column">
							<br/>
					<?php the_field('about_people_content'); ?>
						</div>
              
			</div>
			
			<!--
          <div class="columns is-variable is-multiline">
            <?php if (have_rows('about_people_item')): 
              while (have_rows('about_people_item')): the_row(); ?>
                <div class="column is-6 about-team-item">
                  <div class="about-team-profile is-relative">
                    <?php echo wp_get_attachment_image(get_sub_field('profile'), 'full'); ?>
                    <div class="about-team-item-content mb-5 pb-5">
                      <h4><?php the_sub_field('name'); ?></h4>
                      <span><?php the_sub_field('position'); ?></span>
                      <?php if(get_sub_field('education')): ?>
                      <div class="about-team-education pt-5">
                        <span>Education</span>
                        <div><?php the_sub_field('education'); ?></div>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endwhile; 
            endif; ?>
            <div class="column is-6">
              <div class="about-team-content">
                <?php echo wp_get_attachment_image(get_field('about_people_image'), 'full'); ?>
                <?php the_field('about_people_content'); ?>
              </div>
            </div>
          </div>
	--> 
	
	

        </div>
      </section>


      <section class="about-services">
        <div class="container">
          <div class="columns is-variable is-8">
            <div class="column is-6">
              <?php echo wp_get_attachment_image(get_field('about_services_image'), 'full') ?>
            </div>
            <div class="column is-6">
              <div class="about-services-content">
                <h3 class="has-text-primary">
				  <?php if($my_current_lang == 'th'){ echo('บริการของเรา'); } elseif($my_current_lang == 'ja'){ echo('サービス'); } else{ echo('Our Services'); } ?>
				  </h3>
                <p class="mb-5 pb-5"><?php the_field('about_services_content'); ?></p>
                <a class="button is-primary" href="<?php echo get_post_type_archive_link('service'); ?>">
				  <?php if($my_current_lang == 'th'){ echo('บริการทั้งหมด'); } elseif($my_current_lang == 'ja'){ echo('さらに詳しく'); } else{ echo('All Services'); } ?>
				  </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="about-certificate">
        <div class="container">
          <h3 class="has-text-primary text-center">Certificate</h3>
          <div class="swiper-container about-certificate-container">
            <div class="swiper-pagination"></div>
            <div class="swiper-wrapper">
              <?php
                if ($images = get_field('about_certificate', false, false)) :
                  foreach ($images as $image) : ?>
                  <div class="swiper-slide text-center">
                    <div class="about-certificate-item">
                      <?php echo wp_get_attachment_image($image, 'medium'); ?>
                    </div>
                  </div>
                  <?php endforeach;
                endif
              ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>

      <section class="about-award text-center">
        <div class="container">
          <h3 class="has-text-white">
			<?php if($my_current_lang == 'th'){ echo('รางวัลอันทรงเกียรติ'); } elseif($my_current_lang == 'ja'){ echo('アワード'); } else{ echo('Awards'); } ?>
			</h3>

          <div class="swiper-container about-award-container">
            <div class="swiper-pagination"></div>
            <div class="swiper-wrapper">
              <?php
                if ($awards = get_field('about_award')) :
                  foreach ($awards as $award) : ?>
                  <div class="swiper-slide text-center">
                    <div class="about-award-item">
                      <?php echo wp_get_attachment_image($award['logo'], 'medium'); ?>
                      <p class="has-text-white"><?php echo $award['name']; ?></p>
                    </div>
                  </div>
                  <?php endforeach;
                endif
              ?>
            </div>
          </div>
        </div>
      </section>

      <section class="about-works">
        <div class="container">
          <h3 class="has-text-primary text-center">
			<?php if($my_current_lang == 'th'){ echo('ผลงานที่โดดเด่น'); } elseif($my_current_lang == 'ja'){ echo('人気作品'); } else{ echo('Our Works'); } ?>
			</h3>
          <div class="columns is-multiline">
          <?php if (have_rows('about_work')): 
            while (have_rows('about_work')): the_row(); ?>
              <div class="column is-3 has-text-primary">
                <a  href="<?php the_sub_field('link'); ?>" class="about-works-item is-relative is-block">
                  <?php echo wp_get_attachment_image(get_sub_field('image'), 'thumb-room'); ?>
                  <h4><?php the_sub_field('name'); ?></h4>
                </a>
              </div>
            <?php endwhile; 
          endif; ?>
          </div>
          <p class="text-center pt-5 mt-5">
            <a class="button is-primary" href="<?php echo get_post_type_archive_link('project'); ?>">
			  <?php if($my_current_lang == 'th'){ echo('ผลงานทั้งหมด'); } elseif($my_current_lang == 'ja'){ echo('さらに詳しく'); } else{ echo('View All'); } ?>
			  </a>
          </p>
        </div>
      </section>
    
      <section class="about-partnership">
        <div class="container">
          <div class="columns">
            <div class="column is-4">
              <h3 class="has-text-white">PARTNERSHIP</h3>
              <small class="has-text-white">THE BEST DEVELOPER</small>
            </div>
            <div class="column is-9">
              <div class="swiper-container about-partnership-container">
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
                        <div class="about-partnership-item"><?php the_post_thumbnail('medium') ?></div>
                      </div>
                      <?php endwhile;
                      wp_reset_postdata();
                    endif;
                  ?>
                </div>
                <div class="swiper-pagination"></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="about-strategic-partners" id="partner">
        <div class="container">
          <div class="columns">
            <div class="column is-4">
              <h3 class="has-text-primary">STRATEGIC PARTNERS</h3>
              <small class="has-text-primary">AROUND THE WOLD</small>
            </div>
            <div class="column is-9">
              <div class="swiper-container about-strategic-partners-container">
                <div class="swiper-pagination"></div>
                <div class="swiper-wrapper">
                  <?php
                    if ($images = get_field('about_partners_logo', false, false)) :
                      foreach ($images as $image) : ?>
                      <div class="swiper-slide text-center">
                        <div class="about-strategic-partners-item">
                          <?php echo wp_get_attachment_image($image, 'medium'); ?>
                        </div>
                      </div>
                      <?php endforeach;
                    endif
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php endwhile; ?>
    <?php endif ?>
	</main>
<?php get_footer(); ?>