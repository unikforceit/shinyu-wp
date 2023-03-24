
<?php get_header(); ?>
  <section class="search-bar is-relative"><search-bar></search-bar></section>
  <section class="page-header mb-0">
    <div class="container">
      <h1 class="page-title"><?php _e('Project', THEME_SLUG); ?></h1>
      <?php woocommerce_breadcrumb(); ?>
      <p class="page-description"><?php pll_e('Shinyu Real Estate is your true friend who can assist you on real estate investment with specialized experience in both Thai and overseas market.'); ?></p>
    </div>
  </section><!-- .page-header -->

	<main class="main-content">
    <div class="navigation mb-6">
      <div class="navigation-inner">
        <ul class="container d-flex">
          <li>
            <a href="<?php echo get_post_type_archive_link('project'); ?>"><?php pll_e('All Projects'); ?></a>
          </li>
          <?php $terms = get_terms('project_tag', ['order' => 'ID', 'orderby' => 'ASC']);
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
    <div class="container mb-6 pb-5">
      <?php if ( have_posts() ) : ?>
        <div class="columns is-multiline">
          <?php while ( have_posts() ) : the_post(); ?>
            <?php $developer = wp_get_post_terms(get_the_ID(), 'project_developer'); ?>
            <div class="column is-4 project-col">
              <div class="card project-item">
                <a href="<?php the_permalink(); ?>" class="card-image project-image">
                  <?php
                    if (has_post_thumbnail()) : echo get_the_post_thumbnail(get_the_ID(), 'thumb-news');
                    else : echo "<img src='https://via.placeholder.com/552x245/FFFF00/000000'>";
                    endif
                  ?>
                </a>
                <div class="card-content">
                  <h4 class="project-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                    <small class="is-block"><?php echo $developer[0]->name; ?></small>
                  </h4>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif ?>
    </div>
    <?php the_pagination(); ?>
  </main>
<?php get_footer(); ?>