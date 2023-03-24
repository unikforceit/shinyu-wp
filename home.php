<?php get_header();
  $page_id = get_option('page_for_posts');
?>
  <section class="page-header is-fixed">
    <h1><?php echo get_the_title($page_id); ?></h1>
    <?php 
      $images = get_field('_page_slider', $page_id);
      if ($images) page_slider($images); 
    ?>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="container">
      <div class="blog-search">
        <form action="#">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group field-type  d-flex justify-content-between align-items-end">
                <?php 
                  $categories = get_categories([
                    'orderby' => 'ID',
                    'order'   => 'ASC'
                  ]);
                ?>
                <label for="">ประเภท</label>
                <select class="form-control flex-grow-1" id="">
                  <option>ทั้งหมด</option>
                  <?php
                    foreach ( $categories as $category ) {
                      printf( '<option value="%1$s">%2$s</option>',
                        esc_url(get_category_link( $category->term_id )),
                        esc_html($category->name)
                      );
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="form-group field-keyword d-flex justify-content-between align-items-end">
                <label for="">ค้นหา</label>
                <input type="text" class="form-control flex-grow-1" id="">
              </div>
            </div>
          </div>
        </form>
      </div>
      <?php if ( have_posts() ) : ?>
        <div class="row">
          <?php while ( have_posts() ) : the_post(); ?>
            <div class="col-sm-4 blog-col">
              <figure class="blog-item">
                <a href="<?php the_permalink(); ?>" class="blog-thumbnail">
                  <?php
                    if( has_post_thumbnail() ) : echo get_the_post_thumbnail( get_the_ID(), 'thumb-blog' );
                    else : echo "<img src='https://via.placeholder.com/150/FFFF00/000000?Text=WebsiteBuilders.com'>";
                    endif
                  ?>
                </a>
                <figcaption class="d-flex align-items-start flex-column blog-caption">
                  <h4 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
                  <div class="blog-fot d-flex justify-content-between">
                    <div class="blog-date">
                      <?php shinyu_icon('calendar') ?>
                      <span><?php echo get_the_date( get_option( 'date_format' ) ) ?></span>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="blog-readmore"><?php _e('Read More', THEME_SLUG) ?></a>
                  </div>
                </figcaption>
              </figure>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>
<?php get_footer(); ?>
