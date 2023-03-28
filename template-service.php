
<?php
/**
 * Template Name: Service
 */
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
    </div>
  </section><!-- .page-header -->
	<main class="main-content"<?php if (get_query_var('section')) echo 'data-goto="'. get_query_var('section') .'"'; ?>>
    <nav class="navigation d-none d-lg-block">
      <ul class="container d-flex">
        <li><a href="#overview"><?php pll_e('Overview'); ?><div class="rippleJS"></div></a></li>
        <li><a href="#shinyu-value">SHINYU VALUE<div class="rippleJS"></div></a></li>
        <li><a href="#team"><?php pll_e('Our Team'); ?><div class="rippleJS"></div></a></li>
        <li><a href="#developer"><?php pll_e('The Developer'); ?><div class="rippleJS"></div></a></li>
        <li><a href="#partner"><?php pll_e('Our Partners'); ?><div class="rippleJS"></div></a></li>
      </ul>
    </nav>
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <section class="about-overview" id="overview">
        <div class="container">
        <div class="columns">
          <div class="column">
            <?php the_post_thumbnail('full'); ?>
          </div>
          <div class="column">
            <div class="pl-5"><?php echo wpautop(get_field('about_overview_content')); ?></div>
          </div>        
        </div>
        </div>
      </section>

      <section class="about-shinyu-value" id="shinyu-value">
        <div class="container">
          <h3 class="has-text-primary">SHINYU VALUE</h3>
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
        <div class="about-shinyu-value-bg" style="background-image:url(<?php echo wp_get_attachment_image_url(get_field('about_invest_in_trust_background'), 'full'); ?>)"></div>
      </section>

      <section class="about-team" id="team">
        <div class="container">
          <div class="columns">
            <div class="column is-5">
              <div class="about-team-content">
                <h3 class="has-text-primary">SHINYU TEAM</h3>
                <?php the_field('about_people_content'); ?>
              </div>
            </div>
            <div class="column is-7">
              <div class="columns is-gapless is-multiline">
              <?php if (have_rows('about_people_item')): 
                while (have_rows('about_people_item')): the_row(); ?>
                  <div class="column is-6 about-team-item has-text-primary">
                    <div class="is-relative">
                      <?php echo wp_get_attachment_image(get_sub_field('profile'), 'full'); ?>
                      <div class="about-team-item-content">
                        <h4><?php the_sub_field('name'); ?></h4>
                        <small><?php the_sub_field('position'); ?></small>
                      </div>
                    </div>
                  </div>
                <?php endwhile; 
              endif; ?>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="partner about-developer" id="developer">
        <div class="container">
          <h3 class="has-text-primary">PARTNERSHIP</h3>
          <small class="has-text-primary">THE BEST DEVELOPER</small>
          <div class="swiper-container partner-swiper-container">
            <div class="swiper-pagination"></div>
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
                    <div class="partner-item">
                      <?php the_post_thumbnail('thumb') ?>
                    </div>
                  </div>
                  <?php endwhile;
                  wp_reset_postdata();
                endif;
              ?>
            </div>
          </div>
        </div>
      </section>

      <section class="about-partner" id="partner">
        <div class="container">
          <h3 class="has-text-primary">STRATEGIC PARTNERS</h3>
          <small class="has-text-primary">AROUND THE WOLD</small>
          <ul class="about-partner-list">
            <?php
              if ($images = get_field('about_partners_logo', false, false)) :
                foreach ($images as $image) : ?>
                <li class="about-partner-item"><?php echo wp_get_attachment_image($image, 'medium'); ?></li>
                <?php endforeach;
              endif
            ?>
          </ul>
        </div>
      </section>

      <?php endwhile; ?>
    <?php endif ?>
	</main>
<?php get_footer(); ?>