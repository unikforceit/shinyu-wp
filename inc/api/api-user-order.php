<?php
class Shinyu_User_Order_API extends API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_User_Order_API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();

  }

  public function hooks() {

    add_action('rest_api_init', [$this , 'rest_api_init']);
    
  }
  
  public function rest_api_init() {

    register_rest_route('shinyu', '/user/order', [
      'methods'  => 'GET',
      'callback' => [$this , 'fetch'],
      'permission_callback' => 'is_user_logged_in',
    ]);

    register_rest_route('shinyu', '/user/order/confirm_payment', [
      'methods'  => 'POST',
      'callback' => [$this , 'confirm_payment'],
      'permission_callback' => 'is_user_logged_in',
    ]);

    register_rest_route('shinyu', '/user/order/(?P<order_id>[\\d]+)', [
      'methods'  => 'GET',
      'callback' => [$this , 'get'],
      'permission_callback' => 'is_user_logged_in',
    ]);

  }

  public function get($request) {
    $order_id = $request['order_id'];
    $data = [];

    $order = wc_get_order($order_id);
    $order_items = $order->get_items();
    $line_items = [];

    if ($order_items) {
      foreach ($order_items as $item_id => $item) {
        $line_items[] = [
          'id' => $item->get_id(),
          'name' => $item->get_name(),
          'type' => $item->get_type(), 
          'total' => $item->get_total(),
          'product_id' => $item->get_product_id(),
        ];
      }
    }

    $data = [
      'id' => $order->get_id(),
      'date_created' => $order->get_date_created(),
      'line_items' => $line_items,
      'status' => $order->get_status(),
      'total' =>  $order->get_total(),
      'payment_method' => $order->get_payment_method_title(),
      'address' => $order->get_formatted_billing_address()
    ];

    return array(
      'data'      => $data,
    );
  } 

  function confirm_payment($request) {

    $order_id = $request['order_id'];
    $image_id = $request['image_id'];

    $user = get_usersdata();

    if (!$order_id) return $this->error_403('');

    $post_id = wp_insert_post( array(
      'post_type'         => 'wcp_confirm_payment',
      'post_title'        => wp_strip_all_tags($user['first_name'] . ' ' . $user['last_name'] ),
      'post_status'       => 'wcp-pending_confirm',
      'post_author'       => 1,
    ) );


    update_post_meta( $post_id, '_wcp_payment_date', date('Y-m-d H:i'));
    update_post_meta( $post_id, '_wcp_payment_phone', $user['phone']);
    update_post_meta( $post_id, '_wcp_payment_bank', 'ธนาคารกรุงเทพ' );
    update_post_meta( $post_id, '_wcp_payment_amount', '' );
    update_post_meta( $post_id, '_wcp_payment_order_id', $order_id );
    update_post_meta( $post_id, '_wcp_payment_user_id', ( is_user_logged_in() ? get_current_user_id() : 'guest' ) );
    update_post_meta( $order_id,'_wcp_order_payment_id', $post_id );

    update_post_meta( $post_id, '_thumbnail_id', $image_id );
    update_post_meta( $image_id, '_wcp_payment_slip', $post_id );
    
    return array(
      'data'      => $data,
      'success'   => true,
    );
  }

  public function fetch($request) {
    $page = $request['pagenum'];
    $data = [];

    $customer_orders  = get_posts([
			'meta_key'    => '_customer_user',
			'meta_value'  => get_current_user_id(),
			'post_type'   => wc_get_order_types( 'view-orders' ),
			'post_status' => array_keys( wc_get_order_statuses() ),
      'numberposts' => -1
    ]);

    if ($customer_orders) {
      foreach ($customer_orders as $order_id) {
        $order = wc_get_order($order_id);
        $order_items = $order->get_items();
        $line_items = [];

        if ($order_items) {
          foreach ($order_items as $item_id => $item) {
            $line_items[] = [
              'id' => $item->get_id(),
              'name' => $item->get_name(),
              'type' => $item->get_type(), 
              'product_id' => $item->get_product_id(),
            ];
          }
        }

        $data[]  = [
          'id' => $order->get_id(),
          'date_created' => $order->get_date_created(),
          'line_items' => $line_items,
          'status' => $order->get_status(),
          'total' =>  $order->get_total(),
        ];
      }
    }

    
    $the_query = new WP_Query($args);

    return array(
      'data'      => $data,
      'meta'      => [
        'total'       => $the_query->found_posts,
        'total_pages' => $the_query->max_num_pages
      ],
    );
  } 
}

Shinyu_User_Order_API::get_instance();