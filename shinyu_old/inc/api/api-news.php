<?php
class Mimo_News_API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Mimo_News_API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();

  }

  public function hooks() {

    add_action( 'rest_api_init', array( $this , 'rest_api_init' ) );
    
  }
  
  public function rest_api_init() {

    register_rest_route( 'sy', '/news', array(
      'methods'  => 'GET',
      'callback' => array( $this, 'archive' ),
      'args'     => array( 'category', 'lang')
    ) );
    
    register_rest_route( 'sy', '/news/single', array(
      'methods'  => 'GET',
      'args'     => array('slug', 'lang'),
      'callback' => array( $this, 'single' )
    ) );

    register_rest_route( 'sy', '/news/cat/', array(
      'methods'  => 'GET',
      'args'     => array('slug', 'lang'),
      'callback' => array( $this, 'category' )
    ) );
  }

  public function category($data) {

    $lang = $data['lang'];

    $terms = get_terms( 'news_cat', array(
      'orderby'    => 'count',
      'hide_empty' => 0,
      'lang'       => $lang
    ) );

    $categories[] = array(
      'id' => 0,
      'name'  => pll_translate_string('All', $lang),
      'link'  => array(
        'name' => 'news',
      )
    );
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
      foreach ($terms as $term ) {

        $categories[] = array(
          'id'    => $term->term_id,
          'name'  => $term->name,
          // 'slug'  => $term->slug,
          'link'  => array(
            'name' => 'news-category-slug',
            'params' => array(
              'slug' => $term->slug
            )
          )
        );
      }
    }

    return $categories;
  
  }
  public function archive($data) {

    $category = $data['category'];
    $news = array();

    $lang = $data['lang'];
    
    $head = array(
      'title'   => __('News', THEME_SLUG) . ' - ' . get_bloginfo('name'),
      'meta'    => array(
        'hid' => '',
        'name' => '',
        'content' => ''
      )
    );
  
    $breadcrumb = array(
      array(
        'title' => pll_translate_string('Home', $lang),
        'name'  => ''
      ),
      array(
        'title'  => __('News', THEME_SLUG),
        'name'   => $category ? 'news' : '',
      )
    );

    if ( $category ) {
      $breadcrumb[] = array(
          'title'  => $category,
          'name'   => '',
      );
    }

    $args = array(
      'post_type'          => 'news',
      'posts_per_page'     => -1,
      'post_status'        => 'publish',
      // 'orderby'            => 'Date',
      // 'order'              => 'ASC'
    );

    if ( $category ) {
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'news_cat',
          'field' => 'slug',
          'terms' => array($category)
        )
      );
    }

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();

        $terms = get_the_terms( get_the_ID(), 'news_cat' );
        unset($categories);
        if ( $terms && ! is_wp_error( $terms ) ) {
          foreach ( $terms as $term ) {
            $categories[] = $term->name;
          }
        }

        $news[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(get_post_field( 'post_name', get_the_ID() )),
          'title'     => html_entity_decode(get_the_title()),
          'excerpt'   => get_short_excerpt( get_the_excerpt(), 110 ),
          'date'      => get_the_date(),
          'category'  => $categories,
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-news' ),
        );
      endwhile;
      wp_reset_postdata();
    endif;
  
    $pages = array(
      'title'          => 'News',
      'page_title'     => 'Insight news',
      'page_sub_title' => 'and knowledges',
      'content'        => $news,
      'head'           => $head,
      'breadcrumb'     => $breadcrumb
    );
    
    return $pages;

  }
  
  public function single($data) {

    $sad = '';

    $slug = urlencode( $data['slug'] );
    $post = get_page_by_path( $slug, OBJECT, 'news' );

    $head = array(
      'title'   => $post->post_title . ' - ' . get_bloginfo('name'),
      'meta'    => array(
        'hid' => '',
        'name' => '',
        'content' => ''
      )
    );

    $breadcrumb = array(
      array(
        'title' => pll_translate_string('Home', $lang),
        'name'  => ''
      ),
      array(
        'title'  => __('News', THEME_SLUG),
        'name'   => 'news',
      ),
      array(
        'title'  => $post->post_title,
        'name'   => '',
      )
    );
  
    $args = array(
      'post_type'          => 'news',
      'posts_per_page'     => 3,
      'post_status'        => 'publish',
      'orderby'            => 'rand',
      'post__not_in'       => array( $post->ID )
      // 'order'              => 'ASC'
    );
    $the_query = new WP_Query( $args );
  
    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();
  
        $terms = get_the_terms( get_the_ID(), 'news_cat' );
        unset($categories);
        if ( $terms && ! is_wp_error( $terms ) ) {
          foreach ( $terms as $term ) {
            $categories[] = $term->name;
          }
        }

        $related[] = array(
          'id'        => get_the_ID(),
          'slug'      => urldecode(get_post_field( 'post_name', get_the_ID() )),
          'title'     => html_entity_decode(get_the_title()),
          'excerpt'   => get_short_excerpt( get_the_excerpt(), 110 ),
          'date'      => get_the_date(),
          'category'  => $categories,
          'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumb-news' ),
        );
  
      endwhile;
      wp_reset_postdata();
    endif;
    
    if ( $images = get_field( 'news_gallery', $post->ID ) ) {
      foreach( $images as $image ):
  
        $gallery[] = array(
          'thumbnail' => wp_get_attachment_image_url( $image['ID'], 'thumbnail'),
          'large'     => wp_get_attachment_image_url( $image['ID'], 'large-news')
        );
  
      endforeach;
    }
    $page = array(
      'id'         => $post->ID,
      'title'      => $post->post_title,
      'content'    => apply_filters( 'the_content', $post->post_content ),
      'date'       => array(
        'day'        => get_the_date( 'd', $post->ID ),
        'month_year' => get_the_date( 'M.Y', $post->ID ),
      ),
      'thumbnail'  => get_the_post_thumbnail_url( $post->ID, 'large' ),
      'gallery'    => $gallery,
      'head'       => $head,
      'breadcrumb' => $breadcrumb,
      'related'    => array(
        'title'     => 'Related',
        'sub_title' => 'Articles',        
        'itmes'     => $related
      )
    );
  
    return $page;
  
  }

}

Mimo_News_API::get_instance();