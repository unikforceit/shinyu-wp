<?php

function get_all_menus() {
  $menus = [];
  foreach (get_registered_nav_menus() as $slug => $description) {
    $obj = new stdClass;
    $obj->slug = $slug;
    $obj->description = $description;
    $menus[] = $obj;
  }

  return $menus;
}

function get_menu_data( $data ) {

//    $menu = new stdClass;
//	$menu->items = [];
  if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $data['id'] ] ) ) {
    $menu = get_term( $locations[ $data['id'] ] );

    $sad = '';

    $items = wp_get_nav_menu_items($menu->term_id);
    if( ! $items )
      return;

    $tmp = [];
    foreach( $items as $key => $item ){

      $frontpage_id = get_option( 'page_on_front' );

      
      if( 'page' == $item->object ){

        $post = get_post( $item->object_id ); 
        $slug = $post->post_name;
        $name = 'slug';

        $params = array(
          'slug' => $slug
        );

        if( $frontpage_id == $item->object_id ) {
          $slug = 'home';
          $name = 'index';
          unset($params);
        }

        if( 21 == $item->object_id || 3679 == $item->object_id ) {
          $slug = 'about-us';
          $name = 'about-us';
          unset($params);
        }
        
      }else{

        if( 'project' == $item->object ) {
          $name = 'project';
          unset($params);
        }

      }

      $tmp[$item->ID] = [
        'id'        => $item->ID,
        'parent_id' => $item->menu_item_parent,
        'title'     => $item->title,
        'type'      => $item->object,
        'link'      => array(
          'name'   => $name
        )
      ];

      if($params){
        $tmp[$item->ID]['link']['params'] = $params;
      }

    }

    $tree =  utexp_build_tree( $tmp, 0 );
    return  $tree;

  }


}
function utexp_build_tree( array &$elements, $parentId = 0 ){
  $branch = array();
  foreach ( $elements as &$element ){
    if ( $element['parent_id'] == $parentId ){
      $children = utexp_build_tree( $elements, $element['id'] );
      if ( $children ){
        $element['children'] = $children;
      }
      $branch[] = $element;
      unset( $element );
    }
  }
  return $branch;
}

add_action( 'rest_api_init', function () {

  register_rest_route( 'sy', '/menus', array(
    'methods' => 'GET',
    'callback' => 'get_all_menus',
  ) );

  register_rest_route( 'sy', '/menus/(?P<id>[a-zA-Z_(-]+)/', array(
    'methods' => 'GET',
    'callback' => 'get_menu_data',
    'args'     => array( 'lang')
  ) );

} );