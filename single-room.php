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
	<main class="main-content">
  <?php if (have_posts()) : ?>
    <?php while(have_posts()) : the_post();
      $transaction      = get_field('room_condition');
      $badge            = [];
      $area             = [];
      $location         = [];
      $location_id      = [];
      $facilities       = [];
      $project_id       = get_field('room_project');
      $developer        = wp_get_post_terms($project_id, 'project_developer');
      $locations        = wp_get_post_terms($project_id, 'project_location');
      $room_facility    = wp_get_post_terms(get_the_ID(), 'room_facility');
      $project_facility = wp_get_post_terms($project_id, 'project_facility');
      $tags             = wp_get_post_terms(get_the_ID(), 'room_tag');
      $areas            = wp_get_post_terms($project_id, 'project_area');
      $galleries        = get_field('room_gallery', false, false) ?  get_field('room_gallery', false, false) : [];
      $price_sell       = price(get_field('room_sell_price'), 'THB');
      $price_rent       = price(get_field('room_rent_price'), 'THB');
      $unit_no          = get_field('room_unit_no');
      $facilities       =  $room_facility + $project_facility;

      $location_lat     = get_field('project_location_lat', $project_id);
      $location_lng     = get_field('project_location_lng', $project_id);

      $deposit_price    = get_field('room_deposit_price');
      $deposit_price    = $deposit_price ? price($deposit_price, 'THB') : price(get_post_meta(PAGE_ID_ROOM_DEPOSIT, '_regular_price', true), 'THB');
      

      // if ($room_facility) {
      //   foreach ($room_facility as $facility) {
      //     $facilities[] = $facility->name;
      //   }
      // }
  
      // if ($project_facility) {
      //   foreach ($project_facility as $facility) {
      //     $facilities[] = $facility->name;
      //   }
      // }

      $field_bedrooms = field_bedrooms('', get_locale());
      $field_bathrooms = field_bathrooms(get_locale());

      if ($areas) {
        foreach ($areas as $item) {
          $area[] = $item->name;
        }
      }

      if ($locations) {
        foreach ($locations as $item) {
          $location[] = $item->name;
          $location_id[] = $item->term_id;
        }
      }

      array_unshift($galleries, get_post_thumbnail_id());

      $details = [
        [
		
          'label' => pll__('Project'),
          'value' => '<a class="is-underlined" href="' . get_permalink($project_id) . '">' . get_the_title($project_id) . '</a>',
        ],
        [
          'label' => pll__('Floor'),
          'value' => get_field('room_levels'),
        ],        
        [
          'label' => pll__('Size'),
          'value' => get_field('room_area_sqm') . ' ' . pll__('Sq.m.'),
        ],
        [
          'label' => pll__('Bedroom'),
          'value' => $field_bedrooms[get_field('room_bedrooms')],
        ],
        [
          'label' => pll__('Bathroom'),
          'value' => $field_bathrooms[get_field('room_bathrooms')],
        ],
        [
          'label' => pll__('The Developer'),
          'value' => $developer[0]->name,
        ],
        [
          'label' => pll__('BTS/MRT'),
          'value' => implode(' / ', $location),
        ],
        // [
        //   'label' => 'Badge'
        //   'value' => $badge,
        // ],
        [
          'label' => pll__('Location'),
          'value' => implode(' / ', $area),
        ],
      ];

      if ($galleries) : ?>
      <section class="unit-gallery" id="gallery">
        <nav class="navigation scrollspy  d-none d-md-block">
          <div class="navigation-inner">
            <ul class="container d-flex">
              <li><a href="#gallery" class="active"><?php pll_e('Gallery'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#detail"><?php pll_e('Project Detail'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#facilities"><?php pll_e('Facilities'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#location"><?php pll_e('Location'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#recommended-units"><?php pll_e('Recommended units'); ?><div class="rippleJS"></div></a></li>
              <!-- <li><a href="#register"><?php pll_e('Register'); ?><div class="rippleJS"></div></a></li>               -->
            </ul>
          </div>
        </nav>
        <div class="swiper-container gallery-swiper-container">
          <div class="swiper-wrapper">
            <?php foreach ($galleries as $gallery) : ?>
              <?php
                $sizes = wp_get_attachment_image_src($gallery, 'large');
                $detection = 'horizontal';
                if ($sizes[1] < $sizes[2]) $detection = 'vertical';
              ?>
              <div class="swiper-slide">
                <?php $url = wp_get_attachment_image_url($gallery, 'large');?>
                <a  data-fslightbox class="unit-gallery-item glightbox" href="<?php echo remove_query_arg('v', $url); ?>">
                  <?php echo wp_get_attachment_image($gallery, 'unit-gallery', null, ['class' => $detection]); ?>
                  <?php if ($sizes[1] < $sizes[2]) echo '<div class="background">' . wp_get_attachment_image($gallery, 'large') . '</div>'; ?>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="container">
            <div class="unit-gallery-control d-flex align-items-center">
              <div class="unit-gallery-pagination"></div>
              <button class="button prev"></button>
              <button class="button next"></button>
            </div>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <section class="unit-body" id="detail">
        <div class="unit-herder">
          <div class="container h-100">
            <div class="d-flex align-items-center justify-content-between h-100">
              <div class="unit-title-wrap">
                <h1 class="unit-title"><?php the_title(); ?></h1>
                <?php if ($unit_no) : ?>
                <small class="unit-no"><?php echo pll__('Unit') . ' ' . $unit_no; ?> </small>
                <?php endif; ?>
              </div>
              <div class="unit-single-price h-100<?php if ($price_sell && $price_rent) echo ' is-multiprice'; ?>">
                <?php if ($price_rent) : ?>
                <bdi class="d-flex align-items-center rent">
                  <div>
                    <small class="d-block pb-1"><?php pll_e('Rent'); ?>/<?php pll_e('Month'); ?></small> <span class="d-block"><?php echo price_html($price_rent, CURRENCY); ?></span>
                  </div>
                </bdi>
                <?php endif; ?>
                <?php if ($price_sell) : ?>
                <bdi class="d-flex align-items-center sell">
                  <div>
                    <small class="d-block pb-1"><?php pll_e('Sell'); ?></small> <span class="d-block"><?php echo price_html($price_sell, CURRENCY); ?></span>
                  </div>
                </bdi>
                <?php endif; ?>

                <form class="unit-single-book">
                  <?php if (count($transaction) > 1) : ?>
                    <div class="field has-addons m-0">
                      <div class="control">
                        <div class="select is-fullwidth">
                          <select class="select-transaction" name="transaction">
                            <option value="rent">
								<?php if($my_current_lang == 'th'){ echo('เช่า'); } elseif($my_current_lang == 'ja'){ echo('賃貸'); } else{ echo('Rent'); } ?>
							  </option>
                            <option value="buy">
								<?php if($my_current_lang == 'th'){ echo('ซื้อ'); } elseif($my_current_lang == 'ja'){ echo('購入'); } else{ echo('Buy'); } ?>
							  </option>
                          </select>
                        </div>
                      </div>
                      <div class="control"> 
                        <a href="#" class="button is-primary is-fullwidth button-booknow"><span>
							<?php if($my_current_lang == 'th'){ echo('จองเลย'); } elseif($my_current_lang == 'ja'){ echo('予約する'); } else{ echo('Book Now'); } ?>
							</span></a>
                      </div>
                    </div>
                    <div class="unit-single-deposit-price">
                      <span class="is-hidden price-sell"><?php echo price_html($deposit_price, CURRENCY); ?></span>
                      <span class="price-rent"><?php echo price_html($price_rent, CURRENCY); ?></span>
                    </div>
                  <?php else : ?>
                    <a href="#" class="button is-fullwidth button-booknow<?php echo ($transaction[0] === 'sell') ? ' is-primary' : ' is-danger'; ?>"><span><?php pll_e('Book now'); ?></span></a>
                    <div class="unit-single-deposit-price">
                      <?php if ($transaction[0] === 'sell') : 
                          echo price_html($deposit_price, CURRENCY);
                        else :
                          echo price_html($price_rent, CURRENCY);
                        endif; ?>
                    </div>
                    <input type="hidden" name="transaction" value="<?php echo $transaction[0]; ?>">
                  <?php endif; ?>
                  <input type="hidden" name="product_id" value="<?php echo PAGE_ID_ROOM_DEPOSIT; ?>">
                  <input type="hidden" name="unit_id" value="<?php the_ID(); ?>">
                  <input type="hidden" name="action" value="shinyu_add_to_cart">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="columns is-multiline">
            <div class="column is-12 is-9-fullhd">
              <div class="unit-content">
                <div class="unit-badge-and-share d-flex justify-content-between align-items-start">
                  <?php if ($tags) : ?>
                  <div class="unit-badge d-flex is-relative mb-5">
                    <?php foreach ($tags as $tag) : ?>
                    <div class="unit-badge-item"><?php echo $tag->description; ?></div>
                    <?php endforeach; ?>
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
                <?php the_content(); ?>
              </div>

              <div class="unit-detail">
                <?php foreach ($details as $detail) : ?>
                  <?php if ($detail['value']) : ?>
                  <div class="unit-detail-item">
                    <div class="columns is-mobile">
                      <div class="column"><strong class="has-text-primary"><?php echo $detail['label']; ?></strong></div>
                      <div class="column"><?php echo $detail['value']; ?></div>
                    </div>
                  </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="column is-12 is-3-fullhd is-3-fullhd">
              <div class="unit-registration-form">
                <h3 class="has-text-primary has-text-centered">
				  <?php if($my_current_lang == 'th'){ echo('สนใจยูนิตนี้'); } elseif($my_current_lang == 'ja'){ echo('お気に入り'); } else{ echo('Prefer this unit'); } ?>
				  </h3>
                <unit-registration-form unit="<?php echo get_the_title() . ' - ' . $unit_no; ?>"></unit-registration-form>
              </div>
            </div>
          </div>
        </div>
      </section>
      

      <?php if ($facilities) : ?>
      <section class="unit-facility" id="facilities">
        <div class="container">
          <h3 class="has-text-primary"><?php if($my_current_lang == 'th'){ echo('สิ่งอำนวยความสะดวก'); } elseif($my_current_lang == 'ja'){ echo('ファシリティ'); } else{ echo('Facilities'); } ?></h3>
          <ul class="unit-facility-list">
            <?php foreach ($facilities as $facility) : ?>
              <li class="unit-facility-item d-flex"><?php shinyu_icon('tick'); ?> <?php echo $facility->name; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </section>
      <?php endif ?>

      <section class="unit-map" id="location" data-lat="<?php echo $location_lat; ?>" data-lng="<?php echo $location_lng; ?>">
        <div class="container">
          <h3 class="has-text-primary"><?php if($my_current_lang == 'th'){ echo('ข้อมูลที่ตั้ง'); } elseif($my_current_lang == 'ja'){ echo('ロケーション'); } else{ echo('Location'); } ?></h3>
          <div class="columns is-gapless">
            <div class="column">
				<!-- Disable Google Maps API till can slove API key, Nutn0n Jan 23, 2023 -->
				<!--<div class="unit-google-map"></div>--> 
			  </div>
            <!-- <div class="column"><div class="unit-google-pano"></div></div> -->
          </div>
          <p calss="has-text-centered"><a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo get_the_title($project_id); ?>" target="_blank" class="button is-primary" href="<?php ?>">
			  <?php if($my_current_lang == 'th'){ echo('นำทาง Google Maps'); } elseif($my_current_lang == 'ja'){ echo('Google マップ'); } else{ echo('Get Google Maps Direction'); } ?>
			  </a></p>  
        </div>
      </section>

      <?php if ($stat = get_field('project_stat', $project_id)): ?>
      <section class="project-stat">
        <div class="container">
          <h3 class="has-text-primary mb-5">กราฟราคาเสนอขายย้อนหลัง</h3>
          <div data-stat="<?php echo htmlspecialchars(json_encode($stat)); ?>" id="project-stat"></div>
        </div>
      </section>
      <?php endif; ?>

      <section class="unit-recommended" id="recommended-units">
        <div class="container">
          <h3 class="has-text-primary">
			<?php if($my_current_lang == 'th'){ echo('ยูนิตที่คุณอาจสนใจ'); } elseif($my_current_lang == 'ja'){ echo('おすすめ'); } else{ echo('Recommended units'); } ?>
			</h3>
          <div class="unit-recommended-list"><unit-recommended :project="<?php echo $project_id; ?>" location="<?php echo implode(',', $location_id); ?>" :unit="<?php the_ID(); ?>"></unit-recommended></div>
        </div>
      </section>

      <!-- <section class="unit-registration" id="register">
        <div class="container">
          <div class="unit-registration-form">
            <h3 class="has-text-primary has-text-centered">สนใจยูนิตนี้</h3>
            <unit-registration-form></unit-registration-form>
          </div>
        </div>
      </section> -->
		
    <?php endwhile; ?>
  <?php endif ?>
  </main>
<?php get_footer(); ?>
