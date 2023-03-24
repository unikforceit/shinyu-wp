
<?php get_header(); ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header mb-0">
    <div class="container">
      <div class="columns m-0">
        <div class="column is-8 p-0">
          <h1 class="page-title"><?php echo single_term_title(); ?></h1>
          <?php woocommerce_breadcrumb(); ?>
        </div>
      </div>
    </div>
  </section><!-- .page-header -->
	<main class="main-content">
    <div class="navigation">
      <div class="navigation-inner">
        <ul class="container d-flex">
          <li>
            <a href="<?php echo get_post_type_archive_link('news'); ?>">ทั้งหมด</a>
          </li>
          <?php $terms = get_terms('news_cat');
            if (!empty($terms) && !is_wp_error($terms)) {
              foreach ($terms as $term) { ?>
                <li>
                  <a <?php if ($term->term_id === get_queried_object()->term_id) echo 'class="active"' ?> href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name ?></a>
                </li>
              <?php }
            } ?>
        </ul>
      </div>  
    </div>
    <div class="container">
      <?php if ( have_posts() ) : ?>
        <div class="columns is-multiline mt-0 mb-0">
          <?php while ( have_posts() ) : the_post();  ?>
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
                  <a class="news-read" href="<?php the_permalink(); ?>">อ่านต่อ</a>
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
