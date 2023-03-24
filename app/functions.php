<?php

function shinyu_icon($name) {
  get_template_part('templates/icons/icon', $name);
} 

function the_pagination() {
  global $wp_query;
  $big = 999999999; //I trust StackOverflow.
  $total_pages = $wp_query->max_num_pages; //you can set a custom int value to this var
  $pages = paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $total_pages,
    'prev_next' => false,
    'type'  => 'array',
    'prev_next'   => true,
    'prev_text'    => '',
    'next_text'    => '',
  ) );

  if ( is_array( $pages ) ) {
    echo '<nav class="pagination d-flex justify-content-center is-centered">';
  //Get current page
    $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var( 'paged' );

  //Disable Previous button if the current page is the first one
    if ($paged == 1) {
      echo '<a class="pagination-link pagination-previous" disabled></a>';
    } else {
      echo '<a class="pagination-link pagination-previous" href="' . get_previous_posts_page_link() . '"></a>';
    }

  //Disable Next button if the current page is the last one
    if ($paged<$total_pages) {
      echo '<a class="pagination-link pagination-next" href="' . get_next_posts_page_link() . '"></a>
      <ul class="pagination-list">';
    } else {
      echo '<a class="pagination-link pagination-next" disabled></a>
      <ul class="pagination-list">';
    }

    for ($i=1; $i<=$total_pages; $i++) {
      if ($i == $paged) {
        echo '<li><a class="pagination-link is-current" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
      } else {
        echo '<li><a class="pagination-link" href="'. get_pagenum_link($i) . '">' . $i . '</a></li>';
      }
    }

    echo '</ul>';
    echo '</nav>';
  }
}


function get_post_parent_id() {
	global $post;

	$page_id = null;

	if ( $post->post_parent ) {
		if ( wp_get_post_parent_id( $post->post_parent ) ) {
			$page_id = wp_get_post_parent_id( $post->post_parent );
			if ( wp_get_post_parent_id( $page_id ) )  {
				$page_id = wp_get_post_parent_id( $page_id );
			}
		}else{
			$page_id = $post->post_parent;
		}
	}else{
		$page_id = get_the_ID();
	}

	return $page_id;
}


function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyBy-0iQ24or8h-eIaUhVM7aDjldpJ1XMnc');
}

add_action('acf/init', 'my_acf_init');

function field_year_built($show_option_all = '', $lang = 'th') {

  $years_now = date('Y', strtotime('+2 years'));
  $years = array();
  if ( $show_option_all ) {
    $years[] = $show_option_all;
  }
  foreach (range($years_now, 2005) as $year) {       
    $years[$year] = $year;
  }
  $years['older'] = pll_translate_string('Older', $lang);

  return $years;

}
function field_transaction($show_option_all = '', $lang = 'th') {

  $items = array(
    'sell' => pll_translate_string('Sell', $lang),
    'rent' => pll_translate_string('Rent', $lang),
  );
  if ( $show_option_all ) {
    array_unshift( $items, $show_option_all);
  }
  return $items;
}

function price($val = 0, $code = 'THB') {

  if(!$code) $code = 'THB';

  $rate = get_field('_currency_'. strtolower($code) .'_rate', 'option');

  return intval($val) * $rate;

}

function price_html($val = 0, $code = 'THB') {
  return get_currency_by_code(CURRENCY) . number_format(price($val, CURRENCY));
}

function field_price_range_for_sell($show_option_all = '', $lang = 'th') {

  $items = [
    '0-1000000'         => pll_translate_string('Under 1M', $lang),
    '1000000-2000000'   => pll_translate_string('1-2M', $lang),
    '2000000-3000000'   => pll_translate_string('2-3M', $lang),
    '3000000-5000000'   => pll_translate_string('3-5M', $lang),
    '5000000-7000000'   => pll_translate_string('5-7M', $lang),
    '7000000-10000000'  => pll_translate_string('7-10M', $lang),
    '10000000-15000000' => pll_translate_string('10-15M', $lang),
    '15000000-30000000' => pll_translate_string('15-30M', $lang),
    '30000000'          => pll_translate_string('Over 30M', $lang),
  ];

  if ($show_option_all) {
    $items = ['' => $show_option_all] + $items;
  }
  return $items;

}


function field_price_range_for_rent($show_option_all = '', $lang = 'th') {

  $items = array(
    '0-10000'       => pll_translate_string('Under 10K', $lang),
    '10000-20000'   => pll_translate_string('10-20K', $lang),
    '20000-30000'   => pll_translate_string('20-30K', $lang),
    '30000-40000'   => pll_translate_string('30-40K', $lang),
    '40000-50000'   => pll_translate_string('40-50K', $lang),
    '50000-60000'   => pll_translate_string('50-60K', $lang),
    '60000-70000'   => pll_translate_string('60-70K', $lang),
    '70000-80000'   => pll_translate_string('70-80K', $lang),
    '80000-90000'   => pll_translate_string('80-90K', $lang),
    '90000-100000'  => pll_translate_string('90-100K', $lang),
    '100000-150000' => pll_translate_string('100-150K', $lang),
    '150000-200000' => pll_translate_string('150-200K', $lang),
    '200000'        => pll_translate_string('Over 200K', $lang),
  );

  if ($show_option_all) {
    $items = ['' => $show_option_all] + $items;
  }
  return $items;

}



function field_room_type($show_option_all = '', $lang = 'th') {

  $items = array(
    ''            => pll_translate_string('Any', $lang),
    '1_bedroom'   => pll_translate_string('1 bedroom', $lang),
    '2_bedroom'   => pll_translate_string('2 bedrooms', $lang),
    '3_bedroom'   => pll_translate_string('3 bedrooms', $lang),
    'studio'      => pll_translate_string('Studio', $lang),
    'duplex'      => pll_translate_string('Duplex', $lang),
    'penthouse'   => pll_translate_string('Penthouse', $lang),    
  );

  return $items;

}

function field_view($lang = 'th') {

  return array(
    ''         => pll_translate_string('Any', $lang),
    'city'     => pll_translate_string('City View', $lang),
    'river'    => pll_translate_string('River View', $lang),
    'garden'   => pll_translate_string('Garden View', $lang),
    'panorama' => pll_translate_string('Panorama View', $lang),
    'sea'      => pll_translate_string('Sea View', $lang),
    'mountain' => pll_translate_string('Mountain View', $lang),
    'cleared'  => pll_translate_string('Cleared View', $lang),    
  );

}

function field_direction($lang = 'th') {

  return array(
    ''           => pll_translate_string('Unknown', $lang),
    'north'      => pll_translate_string('North', $lang),
    'west'       => pll_translate_string('West', $lang),
    'east'       => pll_translate_string('East', $lang),
    'south'      => pll_translate_string('South', $lang),
    'north_west' => pll_translate_string('North West', $lang),
    'north_east' => pll_translate_string('North East', $lang),
    'south_west' => pll_translate_string('South West', $lang),
    'south_east' => pll_translate_string('South East', $lang),   
  );

}

function field_bedrooms($show_option_all = '', $lang = 'th') {

  $items = array(
    'studio' => pll_translate_string('Studio', $lang),    
    '1'      => pll_translate_string('1 Bedroom', $lang),
    '2'      => pll_translate_string('2 Bedrooms', $lang),
    '3'      => pll_translate_string('3 Bedrooms', $lang),
    '4'      => pll_translate_string('4 Bedrooms and more', $lang),
  );
  if ($show_option_all) {
    $items = ['' => $show_option_all] + $items;
  } else {
    array_unshift($items, pll_translate_string('Any', $lang));
  }
  return $items;
}


function field_bathrooms($lang = 'th') {

  return array(
    ''    => pll_translate_string('Any', $lang),
    '1'   => pll_translate_string('1 Bathroom', $lang),
    '2'   => pll_translate_string('2 Bathroom', $lang),
    '3'   => pll_translate_string('3 Bathroom', $lang),
    '4'   => pll_translate_string('4 Bathroom', $lang),
    '5'   => pll_translate_string('5 Bathroom', $lang),
  );

}

function field_sort_by($lang = 'th') {

  return array(
    'most_recent'       => pll_translate_string('Most Recent', $lang),
    'price_low_to_high' => pll_translate_string('Price : low to high', $lang),
    'price_high_to_low' => pll_translate_string('Price : high to low', $lang), 
  );

}

function field_yield($show_option_all='', $lang = 'th') {

  $items = array(
    '10'   => pll_translate_string('Over 10%', $lang),
    '9-10' => pll_translate_string('9-10%', $lang),
    '8-9'  => pll_translate_string('8-9%', $lang),
    '7-8'  => pll_translate_string('7-8%', $lang),
    '6-7'  => pll_translate_string('6-7%', $lang),
    '5-6'  => pll_translate_string('5-6%', $lang),
    '4-5'  => pll_translate_string('4-5%', $lang),
    '3-4'  => pll_translate_string('3-4%', $lang),
    '2-3'  => pll_translate_string('2-3%', $lang),
    '1-2'  => pll_translate_string('1-2%', $lang),
    '0-1'  => pll_translate_string('0-1%', $lang),
  );
  if ( $show_option_all ) {
    array_unshift( $items, $show_option_all);
  }
  return $items;
}

function field_what_can_we_help($show_option_all='') {

  $items = array(
    'buy'        => pll_translate_string('I’d like to buy a condo', $lang),
    'sell_lease' => pll_translate_string('Can you help me sell/lease my condo?', $lang),
  );

  return $items;
}

function field_bts($show_option_all = true){

  $bts = array();

  $terms = get_terms('project_location', array(
    'hide_empty' => false,
    'meta_query' => array(
      array(
        'key'       => 'project_location_type',
        'value'     => 'bts',
        'compare'   => '='
      )
    )
  ));

  if ($show_option_all) $bts[''] = 'Select';

  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
      $bts[$term->term_id] = $term->name;
    }
  }

  return $bts;

}


function field_mrt($show_option_all = true){

  $mrt = array();

  $terms = get_terms('project_location', array(
    'hide_empty' => false,
    'meta_query' => array(
      array(
        'key'       => 'project_location_type',
        'value'     => 'mrt',
        'compare'   => '='
      )
    )
  ));

  if ($show_option_all) $mrt[''] = 'Select';

  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
      $mrt[$term->term_id] = $term->name;
    }
  }

  return $mrt;

}

function field_room_tag(){

  $tags = [];

  $terms = get_terms('room_tag', array(
    'hide_empty' => false,
    'orderby'    => 'date',
    'order'      => 'DESC'
  ));

  if (!empty($terms) && !is_wp_error($terms)){
    foreach ($terms as $term) {
      $tags[$term->term_id] = $term->name;
    }
  }

  return $tags;

}

function line_notify($message, $imageThumbnail, $imageFullsize, $token){

  $body = ['message' => $message];


  if ($imageThumbnail) {
    $body['imageThumbnail'] = $imageThumbnail;
    $body['imageFullsize']  = $imageFullsize;
  }

  $response = wp_remote_post( 'https://notify-api.line.me/api/notify', [
    'method' => 'POST',
    'headers' => [
      'Authorization' => 'Bearer '.$token,
    ],
    'body' => $body,
  ]);

  $code = wp_remote_retrieve_response_code( $response );

  if ($code=='200' ){
    return true;
  }else{
    return false;
  }
  
}

if ( get_current_user_id() != 1 && is_admin()) {
  // exit();
}

function get_youtube_video_ID($youtube_video_url) {

  $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

  if (preg_match($pattern, $youtube_video_url, $match)) {
    return $match[1];
  }

  // if no match return false.
  return false;
}

function get_all_currencies() {

  return [
    [
      'title'    => get_field('_currency_thb_title', 'option'),
      'unit'     => get_field('_currency_thb_unit', 'option'),
      'rate'     => get_field('_currency_thb_rate', 'option'),
      'code'     => get_field('_currency_thb_code', 'option')
    ],
    [
      'title'    => get_field('_currency_usd_title', 'option'),
      'unit'     => get_field('_currency_usd_unit', 'option'),
      'rate'     => get_field('_currency_usd_rate', 'option'),
      'code'     => get_field('_currency_usd_code', 'option')
    ],
    [
      'title'    => get_field('_currency_jpy_title', 'option'),
      'unit'     => get_field('_currency_jpy_unit', 'option'),
      'rate'     => get_field('_currency_jpy_rate', 'option'),
      'code'     => get_field('_currency_jpy_code', 'option')
    ],
    [
      'title'    => get_field('_currency_cny_title', 'option'),
      'unit'     => get_field('_currency_cny_unit', 'option'),
      'rate'     => get_field('_currency_cny_rate', 'option'),
      'code'     => get_field('_currency_cny_code', 'option')
    ]
  ];

}

function get_currency_by_code($code) {
  $currencies = get_all_currencies();
  $key = array_search($code, array_column($currencies, 'code'));
  return $currencies[$key]['unit'];
}

// CSS Minifier => http://ideone.com/Q5USEF + improvement(s)
function minify_css($input) {
  if (trim($input) === "") return $input;
  return preg_replace(
    array(
      // Remove comment(s)
      '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
      // Remove unused white-space(s)
      '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
      // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
      '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
      // Replace `:0 0 0 0` with `:0`
      '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
      // Replace `background-position:0` with `background-position:0 0`
      '#(background-position):0(?=[;\}])#si',
      // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
      '#(?<=[\s:,\-])0+\.(\d+)#s',
      // Minify string value
      '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
      '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
      // Minify HEX color code
      '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
      // Replace `(border|outline):none` with `(border|outline):0`
      '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
      // Remove empty selector(s)
      '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
    ),
    array(
      '$1',
      '$1$2$3$4$5$6$7',
      '$1',
      ':0',
      '$1:0 0',
      '.$1',
      '$1$3',
      '$1$2$4$5',
      '$1$2$3',
      '$1:0',
      '$1$2'
    ),
  $input);
}

if ( ! function_exists( 'languages_switcher' ) ) {
  
  function languages_switcher() {

    $languages = pll_the_languages(array('raw' => 1, 'hide_current' => 1));

    $output = '';
  
    if ($languages) {
      foreach ($languages as $l) {
        $flag = STATIC_URI . '/flag/' . $l['slug'] . '.svg';
        $output .= sprintf('<a class="dropdown-item" href="%s"><img src="%s">%s</a>', urldecode($l['url']), $flag, $l['name']);
      }
    }

    return $output;
  
  }

}

function unit_fields($data) {
  $lang  = $data['lang'];
  $area  = [];
  $areas = get_terms('project_area', ['hide_empty' => false]);

  if ( ! empty($areas) && ! is_wp_error($areas) ){
    foreach ( $areas as $element ) {
      $area[] = $element->name;
    }
  }

  $bts = [];
  $mrt = [];

  $terms = get_terms('project_location', array(
    'hide_empty' => false,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
    'meta_query' => array(
      array(
        'key'       => 'project_location_type',
        'value'     => 'bts',
        'compare'   => '='
      )
    )
  ));

  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
      $bts[urldecode($term->slug)] = $term->name;
    }
  }

  $terms = get_terms('project_location', array(
    'hide_empty' => false,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
    'meta_query' => array(
      array(
        'key'       => 'project_location_type',
        'value'     => 'mrt',
        'compare'   => '='
      )
    )
  ));

  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
      $mrt[urldecode($term->slug)] = $term->name;
    }
  }

  return array(
    'transaction'       => render_fields(field_transaction('', $lang)),
    'location'          => ['bts' => render_fields($bts), 'mrt' => render_fields($mrt)],
    'area'              => $area,
    'price_sell'        => render_fields(field_price_range_for_sell('', $lang)),
    'price_rent'        => render_fields(field_price_range_for_rent('', $lang)),
    'bedrooms'          => render_fields(field_bedrooms('', $lang)),
    'bathrooms'         => render_fields(field_bathrooms($lang)),
    // 'year_built'        => render_fields(field_year_built(pll_translate_string('Any', $lang))),
    // 'developer'         => render_fields($this->get_terms('project_developer', '', $lang)),
    'property_type'     => render_fields(shinyu_get_terms('project_type', ['hide_empty' => false], '', $lang)),
    // 'country'           => render_fields($this->get_terms('project_country', '', $lang)),
    // 'yield'             => render_fields(field_yield(pll_translate_string('Any', $lang), $lang)),
    // 'order_by'          => render_fields(field_sort_by()),   
    'room_facility'     => render_fields(shinyu_get_terms('room_facility', ['hide_empty' => false], '', $lang)),
  );
} 


function shinyu_get_terms($name = '', $args = array(), $placeholder = '', $lang = 'th') {

  $terms = get_terms($name, $args);

  if ($placeholder) $fields[''] = pll_translate_string($placeholder, $lang);
  
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
      $fields[$term->slug] = $term->name;
    }
  }

  return $fields;

}

function unit_item($the_query) {

  $items = [];

  if ($the_query->have_posts()) :
    while ($the_query->have_posts()) : $the_query->the_post();

      $images     = [];
      $galleries  = [];
      $project_id = get_field('room_project');
      $badge      = [];
      $area       = [];
      $tags       = wp_get_post_terms(get_the_ID(), 'room_tag');
      $areas      = wp_get_post_terms($project_id, 'project_area');

      if (get_field('room_gallery')) $galleries  = get_field('room_gallery', false, false);

      if (get_post_thumbnail_id()) array_unshift($galleries, get_post_thumbnail_id());

      if ($galleries) {
        foreach ($galleries as $image_id) {
          $images[] = wp_get_attachment_image_url($image_id, 'thumb-room');
        }
      }


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

      $items[] = [
        'id'             => get_the_ID(),
        'author'         => get_field('room_author'),
        'for'            => get_field('room_condition'),
        'slug'           => get_post_field('post_name', get_the_ID()),
        'link'           => get_permalink(),
        'title'          => html_entity_decode(get_the_title()),
        'project'        => html_entity_decode(get_field('room_unit_no')),
        'badge'          => $badge,
        'area'           => implode(' / ', $area),
        'image_url'      => get_the_post_thumbnail_url(get_the_ID(), 'thumb-room'),
        'images'         => $images,
        'price' => [
          'sell' => price(get_field('room_sell_price'), CURRENCY),
          'rent' => price(get_field('room_rent_price'), CURRENCY)
        ],
        'info'           => [
          'bedrooms'  => get_field('room_bedrooms'),
          'bathrooms' => get_field('room_bathrooms'),
          'area_sqm'  => get_field('room_area_sqm'),
        ],
      ];
    endwhile;
    wp_reset_postdata();
  endif;

  return $items;
}

function social_share($title = '', $link = '') { ?>

<ul class="social-share d-flex">
  <li class="social-share-title"><span><?php echo $title; ?></span></li>
  <li><a href="http://www.facebook.com/sharer.php?u=<?php echo $link; ?>" target="_blank"><?php shinyu_icon('facebook-3'); ?></a></li>
  <li><a href="https://twitter.com/share?url=<?php echo $link; ?>" target="_blank"><?php shinyu_icon('twitter-2'); ?></a></li>
  <li><a href="https://social-plugins.line.me/lineit/share?url=<?php echo $link; ?>" target="_blank"><?php shinyu_icon('line-2'); ?></a></li>
</ul>

<?php }

function webp($url) {
	// if (WEBP) {
	// 	$url = str_replace('wp-content/uploads', 'wp-content/uploads-webpc/uploads', $url);
	// 	return $url . '.webp';
	// } 
	return $url;
}


function location(){

  $bts = $mrt = [];

  $terms = get_terms('project_location', array(
    'hide_empty' => false,
    'meta_query' => array(
      array(
        'key'       => 'project_location_recommend',
        'value'     => '1',
        'compare'   => '='
      )
    )
  ));

  if ($terms) {
    foreach ($terms as $term) {
      $type = get_field('project_location_type', 'term_'. $term->term_id);

      $data = [
        'slug' => $term->slug,
        'name' => $term->name,
      ];

      if ($type) {
        if ($type === 'bts') {
          $bts[] = $data;
        } else {
          $mrt[] = $data;
        } 
      }
    }
  }

  return [
    'bts' => $bts,
    'mrt' => $mrt,
  ];
}

function cart_has_room_deposit() {
  $items = WC()->cart->get_cart();

  if ($items) {
    foreach($items as $item => $values) { 
      if (PAGE_ID_ROOM_DEPOSIT === $values['data']->get_id()) return true;
    } 
  }

  return false;
}

function message_room_deposit() {
  echo '<h4><strong class="has-text-danger">'. pll__('Condition') . '</strong></h4>';
  echo '<ol class="has-text-danger pb-6 pl-4">';
  echo '<li>'. pll__('In case of booking cancellation, the deposit could not be refunded.') .'</li>';
  echo '<li>'. pll__("If the room that you've paid booking is not available or there's any changes of the information that not meet your requirements, The company would refund the deposit fully amount. With the conditions for refunding. We would refund according to the company's payment round.") .'</li>'; 
  echo '</ol>';
}

function email_message_item($title = '', $value = '') {
  if (!$value) return '';
	return '<strong>'. $title . ' : </strong>' . $value . '<br>';
}

function get_usersdata() {

  if (!is_user_logged_in()) return false;

  $user = get_userdata(get_current_user_id());
  $customer = new WC_Customer(get_current_user_id());

  return [
    'username'     => $user->user_login,
    'user_email'   => $user->user_email,
    'first_name'   => $customer->get_billing_first_name(),
    'last_name'    => $customer->get_billing_last_name(),
    'display_name' => $user->display_name,
    'phone'        => $customer->get_billing_phone(),
    'avatar_url'   => get_avatar_url($user->user_email),
  ];
}
