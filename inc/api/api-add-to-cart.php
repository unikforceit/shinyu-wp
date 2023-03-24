<?php
class Shinyu_Add_To_Cart_API {
  protected static $instance = null;

  public static function get_instance() {
    if ( !self::$instance ) {
      self::$instance = new Shinyu_Add_To_Cart_API();
    }
    return self::$instance;
  }

  public function __construct() {
    $this->hooks();
  }

  public function hooks() {
    // add_action('rest_api_init', [$this , 'rest_api_init']);

    add_action('wp_ajax_shinyu_add_to_cart', [$this, 'add_to_cart']);
    add_action('wp_ajax_nopriv_shinyu_add_to_cart', [$this, 'add_to_cart']);
  }

  public function add_to_cart() {

    $cart_item_data = [];
    $redirect = wc_get_checkout_url();

    $product_id = absint($_POST['product_id']);
    $variation_id = absint($_POST['variation_id']);    
    $project_name = $_POST['project_name'];  
    $unit_no = $_POST['unit_no'];  
    $floor = $_POST['floor'];
    $unit_type = $_POST['unit_type'];
    $consultant = $_POST['consultant'];
    
    
    $unit_id = absint($_POST['unit_id']);
    $transaction = $_POST['transaction'];

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', $product_id);

    if ($project_name) $cart_item_data['project_name'] = $project_name;
    if ($unit_no) $cart_item_data['unit_no'] = $unit_no;
    if ($floor) $cart_item_data['floor'] = $floor;
    if ($unit_type) $cart_item_data['unit_type'] = $unit_type;
    if ($consultant) $cart_item_data['consultant'] = $consultant;

    if ($unit_id) $cart_item_data['unit_id'] = $unit_id;
    if ($transaction) $cart_item_data['transaction'] = $transaction;
  
    WC()->cart->empty_cart(); 
    WC()->cart->add_to_cart($product_id, 1, $variation_id, [], $cart_item_data);


    if ($product_id === PAGE_ID_ROOM_DEPOSIT) $redirect = wc_get_cart_url();

    $data = [
      'code' => 200,
      'redirect' => $redirect,
      'transaction' => $transaction,
    ];

    wp_send_json($data);
  
  } 
}

Shinyu_Add_To_Cart_API::get_instance();