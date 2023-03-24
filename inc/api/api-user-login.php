<?php
class Shinyu_User_Login_API extends API {
  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new Shinyu_User_Login_API();
    }
    return self::$instance;

  }

  public function __construct() {

    $this->hooks();

  }

  public function hooks() {
    add_action('rest_api_init', [$this , 'rest_api_init']);
    add_action('wp_ajax_facebook_login', [$this, 'facebook_login']);
  }
  
  public function rest_api_init() {

    register_rest_route('shinyu', '/user/register', [
      'methods'  => 'POST',
      'callback' => [$this , 'register'],
      'permission_callback' => function() { return true; },
    ]);

    register_rest_route('shinyu', '/user/login', [
      'methods'  => 'POST',
      'callback' => [$this , 'login'],
      'permission_callback' => function() { return true; },
    ]);

    register_rest_route('shinyu', '/user/login/facebook', [
      'methods'  => 'POST',
      'callback' => [$this , 'facebook_login'],
      'permission_callback' => function() { return true; },
    ]);

    register_rest_route('shinyu', '/user/logout', [
      'methods'  => 'POST',
      'callback' => [$this , 'logout'],
      'permission_callback' => function() { return true; },
    ]);
  }

  public function register($request) {

    $lang = $request['lang'];
    $response  = [];
    $first_name  =  sanitize_text_field($request['first_name']);
    $last_name  =  sanitize_text_field($request['last_name']);
    $password  =  sanitize_text_field($request['password']);
    $email     =  sanitize_text_field($request['email']);
    $phone     =  sanitize_text_field($request['phone']);


    $user = [
			'first_name'   => $first_name,
			'last_name'    => $last_name,
			'user_email'   => $email,
    ];

    $error = new WP_Error();

    // if (empty($username)) {
    //   $error->add(403, __('Username field "username" is required.', THEME_SLUG), ['status' => 403]);
    //   return $error;
    // }

    if (empty($email)) {
      $error->add(403, __('Email field "email" is required.', THEME_SLUG), ['status' => 403]);
      return $error;
    }

    if (empty($password)) {
      $error->add(403, __('Password field "password" is required.', THEME_SLUG), ['status' => 403]);
      return $error;
    }
    
    if (email_exists($email) == false) {
  
      $username = $this->generate_username($user);
      $user_id = wp_create_user($username, $password, $email);

      if (!is_wp_error($user_id)) {
        update_user_meta($user_id, 'billing_first_name', $user['first_name']);
        update_user_meta($user_id, 'billing_last_name', $user['last_name']);
        update_user_meta($user_id, 'billing_phone', $phone);

        $user['ID']           = $user_id;
        $user['display_name'] = $user['first_name'] .' '. $user['last_name'];
        wp_update_user($user);

        $user = get_user_by('id', $user_id);
        $user->set_role('subscriber');
        if (class_exists('WooCommerce')) $user->set_role('customer');
        
        wp_new_user_notification($user_id, '', $username);
        wp_set_auth_cookie($user_id, true);

        $response['code'] = 200;
        $response['data'] = [
          'username'     => $user->user_login,
          'user_email'   => $user->user_email,
          'first_name'   => $user->first_name,
          'last_name'    => $user->last_name,
          'user_email'   => $user->user_email,
          'display_name' => $user->display_name,
          'avatar_url'   => get_avatar_url($user->user_email),
        ];
      
        $wc_emails = WC()->mailer()->get_emails();
        $wc_emails['WC_Email_Customer_New_Account']->trigger($user_id);
        
      } else {
        return $user_id;
      }
    } else {
      $error->add(403, __('Email already exists, please try "Reset Password"', THEME_SLUG), ['status' => 403]);
      return $error;
    }

    return $response;
  } 

  public function logout($request) {
    wp_logout();
    die();
  } 

  public function login($request) {
    $creds = [];
    $lang = $request['lang'];
    
    $credentials['user_login'] = $request['username'];
    $credentials['user_password'] =  $request['password'];
    $credentials['remember'] = true;
    $user = wp_signon($credentials, false);

    if (is_wp_error($user)) {
      $err_codes = $user->get_error_codes();
      if (empty($request['username']))  return $this->error_403(pll_translate_string('Please enter your username or email', $lang));
      if (empty($request['password'])) return $this->error_403(pll_translate_string('Please enter your password', $lang));
      if (in_array('invalid_username', $err_codes)) return $this->error_403(pll_translate_string('This username does not exist.', $lang));
      if (in_array('invalid_email', $err_codes)) return $this->error_403(pll_translate_string('This email does not exist.', $lang));
      if (in_array('incorrect_password', $err_codes)) return $this->error_403(pll_translate_string('Incorrect password, please try again.', $lang));

      return $this->error_403($user->get_error_message());
    }

    // $user = wp_authenticate( $credentials['user_login'], $credentials['user_password'] );

    // wp_set_current_user($user->ID, $request['username']);
    // wp_set_auth_cookie($user->ID, true, false);
    // do_action('wp_login', $request['username'], $user);

		$user = [
			'username'     => $user->user_login,
			'user_email'   => $user->user_email,
      'first_name'   => $user->first_name,
      'last_name'    => $user->last_name,
			'user_email'   => $user->user_email,
      'display_name' => $user->display_name,
			'avatar_url'   => get_avatar_url($user->user_email),
		];

    return [
      'code' => 200,
      'data' => $user
    ];
  } 

  public function facebook_login($request) {  
    // $app_secret = '1a314c2cfe5991c10540afa88626eee7';
    $lang = $request['lang'];
    $app_secret = 'f766e5c2744c56cee819bdf5a1a51fea';
    $fb_user_id = $request['userID'];
    $access_token = $request['accessToken'];

    $url = add_query_arg(
      [
        'fields'            =>  'email,first_name,last_name,name,picture,link,id',
        'access_token'      =>  $access_token,
      ],
      'https://graph.facebook.com/v9.0/' . $fb_user_id
    );

    $appsecret_proof = hash_hmac('sha256', $access_token, trim($app_secret));
  
    $url = add_query_arg(['appsecret_proof' => $appsecret_proof], $url);
    $response = wp_remote_get($url, ['timeout' => 30]);
    $response = json_decode($response['body']);


    if (is_wp_error($response))
      return $this->error_403($response->get_error_message());

		$user = [
			'fb_user_id'   => $response->id,
			'first_name'   => $response->first_name,
			'last_name'    => $response->last_name,
			'user_email'   => $response->email,
      'display_name' => $response->name,
    ];

		$user_obj = $this->get_user_by($user);
		$meta_updated = false;


		if ($user_obj) {
			$user_id = $user_obj->ID;

			if (empty($user_obj->user_email) ) {
				wp_update_user([
          'ID'         => $user_id,
          'user_email' => $user['user_email'] 
        ]);
      }

		} else {

      $user_id = wp_insert_user( array(
        'user_login'    => $this->generate_username($user),
        'user_pass'     => wp_generate_password(),
        'user_email'    => $user['user_email'],
        'first_name'    => $user['first_name'],
        'last_name'     => $user['last_name'],
        'display_name'  => $user['display_name'],
      ));

			if (!is_wp_error($user_id)) {
        update_user_meta($user_id, 'billing_first_name', $user['first_name'] );
        update_user_meta($user_id, 'billing_last_name', $user['last_name'] );
				wp_new_user_notification($user_id);
				update_user_meta($user_id, '_fb_user_id', $user['fb_user_id'] );
				$meta_updated = true;

        $wc_emails = WC()->mailer()->get_emails();
        $wc_emails['WC_Email_Customer_New_Account']->trigger($user_id);
			}
		}

		if (is_numeric($user_id)) {
			wp_set_auth_cookie($user_id, true);
			if (!$meta_updated) update_user_meta($user_id, '_fb_user_id', $user['fb_user_id']);
		}

    $user = get_user_by('id', $user_id);

    $users = [
      'user_login' => $user->user_login,
      'first_name' => $user->first_name,
      'last_name' => $user->last_name,
      'display_name' => $user->display_name,
    ];

    return [
      'data' => $users,
    ];
  }

	public function get_user_by($user) {
		if (is_user_logged_in())
			return wp_get_current_user();

		$user_data = get_user_by('email', $user['user_email']);

		if (!$user_data) {
			$users = get_users(
				[
					'meta_key'    => '_fb_user_id',
					'meta_value'  => $user['fb_user_id'],
					'number'      => 1,
					'count_total' => false
        ]
			);
			if (is_array($users)) $user_data = reset( $users );
		}
		return $user_data;
	}


	public function generate_username($user) {

		global $wpdb;
    $username = '';

		if (!empty($user['first_name']) && !empty($user['last_name']))
			$username = $this->clean_username(trim($user['first_name']) .'-'. trim($user['last_name']));

		if (!validate_username($username)) {
			$email = explode('@', $user['user_email']);
      $username = $this->clean_username($email[0]);
		}

    $illegal_names = get_site_option('illegal_names');
    if (empty($username) || in_array($username, (array) $illegal_names)) {
      $username = 'fbl_' . $user['fb_user_id'];
    }
  
		// "generate" unique suffix
		$suffix = $wpdb->get_var( $wpdb->prepare(
			"SELECT 1 + SUBSTR(user_login, %d) FROM $wpdb->users WHERE user_login REGEXP %s ORDER BY 1 DESC LIMIT 1",
			strlen( $username ) + 2, '^' . $username . '(-[0-9]+)?$' ) );

		if (!empty( $suffix)) {
			$username .= "-{$suffix}";
		}

		return $username;
	}

	public function clean_username( $username ) {
		return sanitize_title( str_replace('_','-', sanitize_user($username)));
	}
}

Shinyu_User_Login_API::get_instance();