<?php
class Shinyu_Post_Property_API {
  protected static $instance = null;

  public static function get_instance() {
    if ( !self::$instance ) {
      self::$instance = new Shinyu_Post_Property_API();
    }
    return self::$instance;
  }

  public function __construct() {
    $this->hooks();
    $this->line_token = 'rftiR4ei3LJLZyUy6JIpTE7gyNeU5WuC6yVNFx90Hde';
  }

  public function hooks() {
    add_action('rest_api_init', [$this , 'rest_api_init']);
  }
  
  public function rest_api_init() {
    register_rest_route('shinyu', '/unit', [
      'methods'  => 'POST',
      'callback' => [$this , 'api'],
      'permission_callback' => 'is_user_logged_in',
    ]);
  }

  public function api($request) {

    $unit_thumb   = '';
    $unit_image   = '';
    $line_message = '';
    $data         = [];
    $galleries    = [];
    $lang         = $request['lang'];
    $name         = $request['name'];
    $phone        = $request['phone'];
    $line         = $request['line'];
    $email        = $request['email'];

    $transaction      = $request['transaction'];
    $project_name     = $request['project_name'];
    $project_id       = $request['project_id'];
    $project_type     = $request['property_type'];
    
    $bedroom        = $request['bedroom'];
    $bathroom       = $request['bathroom'];
    $facility       = $request['facility'];
    $images         = $request['images'];
    $price_sell     = $request['price_sell'];
    $price_rent     = $request['price_rent'];
    $include_commission = $request['include_commission'];
    $size           = $request['size'];
    $floor          = $request['floor'];
    $note           = $request['note'];

    $post_id = wp_insert_post([
      'post_type'         => 'room',
      'post_title'        => wp_strip_all_tags($project_name),
      'post_status'       => 'draft',
      'post_author'       => get_current_user_id(),
    ]);

    if (is_wp_error($post_id)){
      return new WP_REST_Response(
        [
          'code'    => 'rest_forbidden',
          'message' => $post_id->get_error_message(),
          'data'    => ['status' => 403],
          'success' => false
        ],
        403
      );
    }

    pll_set_post_language($post_id, $lang);
    // pll_set_post_language
    // pll_current_language

    if ($note)         $note  = 'รายละเอียดเพิ่มเติม: ' . $note . PHP_EOL;
    if ($project_type) $note .= 'ประเภทโครงการ: ' . $project_type . PHP_EOL;

    if ($images) {
      foreach ($images as $image) {
        $galleries[] = $image['id'];
      }
      set_post_thumbnail($post_id, $galleries[0]);
      unset($galleries[0]);
    }
    // $unit_thumb = get_the_post_thumbnail_url($post_id, 'thumbnail');
    // $unit_image = get_the_post_thumbnail_url($post_id, 'large');

    $line_message .= 'Customer Name: ' . $name . PHP_EOL;
    $line_message .= 'Tel: ' . $phone . PHP_EOL;
    $line_message .= 'Email: ' . $email . PHP_EOL;
    $line_message .= 'Number of bedrooms: ' . $bedroom . PHP_EOL;
    $line_message .= 'Project: ' . $project_name . PHP_EOL;
    $line_message .= 'Types for publishing: ' . $transaction . PHP_EOL;

    if ($price_sell) $line_message .= 'Price for sale: ' . price_html($price_sell) . PHP_EOL;
    if ($price_rent) $line_message .= 'Price for rent: ' . price_html($price_rent) . PHP_EOL;

    $line_message .= 'Unit Detail: ' . admin_url('post.php?post='. $post_id .'&action=edit') . PHP_EOL;

    line_notify(PHP_EOL . $line_message, $unit_thumb, $unit_image, $this->line_token);

    if ($facility) wp_set_object_terms($post_id, $facility, 'room_facility');

    update_field('room_contact_name', $name, $post_id);
    update_field('room_contact_phone', $phone, $post_id);
    update_field('room_contact_line', $line, $post_id);
    update_field('room_contact_email', $email, $post_id);
    update_field('room_condition', explode('_', $transaction), $post_id);

    update_field('room_bedrooms', $bedroom, $post_id);
    update_field('room_bathrooms', $bathroom, $post_id);
    update_field('room_project', $project_id, $post_id);
    update_field('room_gallery', $galleries, $post_id);

    update_field('room_sell_price', $price_sell, $post_id); 
    update_field('room_rent_price', $price_rent, $post_id); 

    update_field('room_area_sqm', $size, $post_id);
    update_field('room_levels', $floor, $post_id);
    update_field('room_note', $note, $post_id);
    update_field('room_include_commission', $include_commission, $post_id);
    
    update_field('room_author', get_current_user_id(), $post_id);

    $email_class = WC()->mailer();
    ob_start();
    do_action('woocommerce_email_header', pll_translate_string('Post Property', $lang), $email); 
    echo '<p>'. pll_translate_string('Hi', $lang) . ' ' . $name . '</p>'; 

    if ($lang === 'th')  {
      echo '<p>ขอบคุณที่ไว้วางใจใช้บริการฝาก ขาย/เช่า กับ บริษัท Shinyu Real Estate ทางทีมงานจะนำห้องของท่านไปทำการตลาดตามข้อมูลที่ได้รับตามช่องทางต่างๆ ของบริษัทต่อไปจนกว่าจะได้รับการแจ้งเปลี่ยนแปลงข้อมูลจากลูกค้า หากมีลูกค้าสนใจ ทางทีมงานจะรีบติดต่อท่านกลับไปให้เร็วที่สุด รบกวนตรวจสอบห้องของท่านอีกครั้งและยืนยันความถูกต้องของข้อมูลด้วยการตอบกลับทางอีเมล์นี้ด้วยนะคะ มิเช่นนั้นทางทีมงานจะไม่สามารถนำห้องของท่านไปทำการตลาดได้ ขอบคุณค่ะ</p>';
      echo '<h3>ข้อมูลห้อง</h3>';
    } else {
      echo '<p>Thank you for trust to use the service with Shinyu Real Estate. Our team will collect your unit information and do the marketing through the various channels. <br>
      If there are interested customers, Our team will contact you back as soon as possible. <br>
      Please check your unit detail again and confirm back by replying to this email. <br>
      Otherwise, the team could not be able to do the marketing for your unit. 
      </p><br>';

      echo '<h3>Customer room information that the customer enters</h3>';
    }

    echo email_message_item(pll_translate_string('Types for publishing', $lang), $transaction); 
    echo email_message_item(pll_translate_string('Project name', $lang), $project_name); 
    echo email_message_item(pll_translate_string('Number of bedrooms', $lang), $bedroom); 
    echo email_message_item(pll_translate_string('Number of bathrooms', $lang), $bathroom); 
    echo email_message_item(pll_translate_string('Size', $lang), $size); 
    echo email_message_item(pll_translate_string('Floor', $lang), $floor); 
    echo email_message_item(pll_translate_string('Price for Sale', $lang), $price_sell); 
    echo email_message_item(pll_translate_string('Price for Rent', $lang), $price_rent);

    if ($lang !== 'th')  {
      echo 'Best Regards<br> Shinyu Real Estate';
    }
    
    do_action('woocommerce_email_footer', $email);
    $message = ob_get_contents();
    ob_end_clean();
    $email_class->send($email, pll_translate_string('Post Property', $lang), $message, '', '');

    return [
      'data'   => $line_message,
      'status' => 200
    ];
  } 
}

Shinyu_Post_Property_API::get_instance();