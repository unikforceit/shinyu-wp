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
      $badge            = [];
      $area             = [];
      $location         = [];
      $facilities       = [];
      $developer        = wp_get_post_terms(get_the_ID(), 'project_developer');
      $locations        = wp_get_post_terms(get_the_ID(), 'project_location');
      $project_facility = wp_get_post_terms(get_the_ID(), 'project_facility');
      $areas            = wp_get_post_terms(get_the_ID(), 'project_area');
      $galleries        = get_field('project_gallery', false, false);
      $facilities       = $project_facility;

      $location_lat     = get_field('project_location_lat');
      $location_lng     = get_field('project_location_lng');

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

      $field_bedrooms = field_bedrooms(get_locale());
      $field_bathrooms = field_bathrooms(get_locale());

      if ($tags) {
        foreach ($tags as $tag) {
          $badge[] = $tag->description;
        }
      }

      if ($areas) {
        foreach ($areas as $item) {
          $area[] = $item->name;
        }
      }

      if ($locations) {
        foreach ($locations as $item) {
          $location[] = $item->name;
        }
      }
      
      if ($galleries && get_post_thumbnail_id()) array_unshift($galleries, get_post_thumbnail_id());


      $rooms = [];
      $room_type_item = get_field('project_room_type_item');

      if ($room_type_item) {
        foreach ($room_type_item as $room) {
          $rooms[] = [
            'label' => $room['label'],
            'value' => $room['value'] . ' ' . pll__('Sq.m.'),
          ];
        }
      }
    
      $details = [
        [
          'label' => pll__('The Developer'),
          'value' => $developer[0]->name,
        ],
        [
          'label' => pll__('Total area'),
          'value' => get_field('project_area'),
        ],
        [
          'label' => pll__('Building Amount'),
          'value' => get_field('project_towers'),
        ], 
        [
          'label' => pll__('Total Floor'),
          'value' => get_field('project_floors'),
        ],    
        [
          'label' => pll__('Total Unit'),
          'value' => get_field('project_total_units'),
        ],
        [
          'label' => pll__('Room Type'),
          'value' => get_field('project_room_type'),
        ],
        ...$rooms,
        [
          'label' => pll__('Parking Space'),
          'value' => get_field('project_parking_space'),
        ],  
        [
          'label' => pll__('Presales Date'),
          'value' => get_field('project_year_sell'),
        ],  
        [
          'label' => pll__('Completed date'),
          'value' => get_field('project_year_built'),
        ],
        [
          'label' => pll__('Start price'),
          'value' => price_html(get_field('project_start_price'), CURRENCY),
        ],
        [
          'label' => pll__('Average price/sq.m.'),
          'value' => price_html(get_field('project_pricing_per_sqm'), CURRENCY),
        ],
        [
          'label' => pll__('Common Fee'),
          'value' => price_html(get_field('project_fee')) . ' ' . pll__('/ Sq.m.'),
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
      <section class="project-gallery" id="gallery">
        <nav class="navigation scrollspy">
          <div class="navigation-inner">
            <ul class="container d-flex">
              <li><a href="#gallery" class="active"><?php pll_e('Gallery'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#detail"><?php pll_e('Project Detail'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#facilities"><?php pll_e('Facilities'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#location"><?php pll_e('Location'); ?><div class="rippleJS"></div></a></li>
              <li><a href="#recommended-projects"><?php pll_e('Recommended Units'); ?><div class="rippleJS"></div></a></li>
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
                <div class="container">
                  <a  data-fslightbox class="project-gallery-item glightbox" href="<?php echo wp_get_attachment_image_url($gallery, '1536x1536'); ?>">
                    <?php echo wp_get_attachment_image($gallery, 'project-gallery', null, ['class' => $detection]); ?>
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="container">
            <div class="project-gallery-control d-flex align-items-center">
              <div class="project-gallery-pagination"></div>
              <button class="button prev"></button>
              <button class="button next"></button>
            </div>
          </div>
			
        </div>
      </section>
      <?php endif; ?>

      <section class="project-body" id="detail">
        <div class="project-herder">
          <div class="container h-100">
            <div class="d-flex align-items-center justify-content-between h-100">
              <div class="project-title-wrap">
                <h1 class="project-title"><?php the_title(); ?></h1>
                <?php if ($project_no) : ?>
                <small class="project-no"><?php echo pll__('Unit') . ' ' . $project_no; ?> </small>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="project-content">
          <div class="container">
            <div class="pb-5">
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
        </div>
      </section>

      <div class="unit-detail">
        <div class="container">
          <?php foreach ($details as $detail) : ?>
            <?php if ($detail['value']) : ?>
            <div class="unit-detail-item">
              <div class="columns">
                <div class="column"><strong class="has-text-primary"><?php echo $detail['label']; ?></strong></div>
                <div class="column"><?php echo $detail['value']; ?></div>
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>

      <?php if ($facilities) : ?>
      <section class="project-facility" id="facilities">
        <div class="container">
          <h3 class="has-text-primary">
			<?php if($my_current_lang == 'th'){ echo('สิ่งอำนวยความสะดวก'); } elseif($my_current_lang == 'ja'){ echo('ファシリティ'); } else{ echo('Facilities'); } ?>
			</h3>
          <ul class="project-facility-list">
            <?php foreach ($facilities as $facility) : ?>
              <li class="project-facility-item" title="<?php echo $facility->name; ?>"><?php shinyu_icon('tick'); ?> <?php echo $facility->name; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </section>
      <?php endif ?>

      <section class="project-map" id="location" data-lat="<?php echo $location_lat; ?>" data-lng="<?php echo $location_lng; ?>">
        <div class="container">
          <h3 class="has-text-primary"><?php if($my_current_lang == 'th'){ echo('ข้อมูลที่ตั้ง'); } elseif($my_current_lang == 'ja'){ echo('ロケーション'); } else{ echo('Location'); } ?></h3>
          <div class="columns is-gapless">
			 <!-- Disable Google Maps until can slove API problem , Nutn0n Feb 13, 2023. 
            <div class="column"><div class="project-google-map"></div></div>
            <!-- <div class="column"><div class="project-google-pano"></div>  </div> -->
          </div>
          <p calss="has-text-centered"><a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo get_the_title(); ?>" target="_blank" class="button is-primary" href="<?php ?>">
			  		  <?php if($my_current_lang == 'th'){ echo('นำทาง Google Maps'); } elseif($my_current_lang == 'ja'){ echo('Google マップ'); } else{ echo('Get Google Maps Direction'); } ?>
			  </a></p>
       
		  </div>
      </section>


      <?php if ($stat = get_field('project_stat')): ?>
      <section class="project-stat">
        <div class="container">
          <h3 class="has-text-primary mb-5">กราฟราคาเสนอขายย้อนหลัง</h3>
          <div data-stat="<?php echo htmlspecialchars(json_encode($stat)); ?>" id="project-stat"></div>
        </div>
      </section>
      <?php endif; ?>

      <section class="unit-recommended">
        <div class="container">
          <h3 class="has-text-primary">
			<?php if($my_current_lang == 'th'){ echo('ยูนิต'); } elseif($my_current_lang == 'ja'){ echo('ユニット'); } else{ echo('Units'); } ?>
			</h3>
          <div class="project-recommended-list"><unit-project :project="<?php the_ID(); ?>"></unit-project></div>
        </div>
      </section>

    <?php endwhile; ?>
  <?php endif ?>
  </main>
<?php get_footer(); ?>
