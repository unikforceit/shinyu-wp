
<?php get_header(); ?>
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
  <section class="page-header mb-0">
    <div class="container">
      <div class="columns m-0">
        <div class="column is-8 p-0">
          <h1 class="page-title"><?php pll_e('ร่วมงานกับเรา'); ?></h1>
          <?php woocommerce_breadcrumb(); ?>
          <p class="page-description"><?php pll_e('แหล่งเรียนรู้เรื่องราวต่างๆเกี่ยวกับ Rael Estate Agents <br> ที่มาจากประสบการณ์จริง เรียนจบพร้อมสร้างรายได้หลักล้านให้คุณได้ทันที '); ?></p>
        </div>
      </div>
    </div>
  </section><!-- .page-header -->
	<main class="main-content pt-5">
    <div class="container">
      <?php if ( have_posts() ) : ?>
        <?php $i = 0; ?>
        <div class="accordion">
          <?php while ( have_posts() ) : the_post();  ?>
            <?php $i++; ?>
            <div class="accordion__item">
              <button class="accordion__toggle<?php if( $i === 1 ) echo ' is-active'; ?>"><?php the_title(); ?><div class="rippleJS"></div></button>
              <div class="accordion__content"<?php if( $i === 1 ) echo ' style="max-height:none"'; ?>>
                <div class="accordion__body">
                  <div class="job-content"><?php the_content(); ?></div>
                  <div class="columns job-footer">
                    <div class="column is-4">
                      <?php social_share('Share :', get_the_permalink()); ?>
                    </div>
                    <div class="column"> 
                      For more information, Please contact  Ms. Narinchort Sangnopparus <br>
                      Tel : <a href="tel:020013033">02-001-3033</a> <br>
                      Email: <a href="mailto:info@shinyurealestate.com">info@shinyurealestate.com</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
      <?php the_pagination(); ?>
    </div>
  </main>
<?php get_footer(); ?>
