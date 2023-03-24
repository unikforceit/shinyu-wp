<?php

class TOT_Taxonomy_Package {

  protected static $instance = null;

  public static function get_instance() {

    if ( !self::$instance ) {
      self::$instance = new TOT_Taxonomy_Package();
    }
    return self::$instance;

  }

	public function __construct() {

		$this->hooks();

	}

	public function hooks() {
    add_action('init', [$this, 'register_meta']);
    add_action('pa_package_add_form_fields', [$this, 'add_form']);
    add_action('pa_package_edit_form_fields', [$this, 'edit_form']);

    add_action('edit_pa_package', [$this, 'save']);
    add_action('create_pa_package', [$this, 'save']);

    add_filter('manage_edit-pa_package_columns', [$this, 'columns'], 10, 3 );
    add_filter('manage_pa_package_custom_column', [$this, 'column'], 10, 3 );
	}

  public function sanitize($value) {
    return sanitize_text_field ($value);
  }

  public function register_meta() {
    register_meta('term', '_package_id', [$this, 'sanitize']);
  }

  public function get($term_id) {
    $value = get_term_meta( $term_id, '_package_id', true );
    $value = $this->sanitize($value);
    return $value;
  }

  public function add_form() { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'package_id_nonce' ); ?>
    <div class="form-field term-meta-text-wrap">
      <label for="term-meta-text"><?php _e( 'Package ID', 'text_domain' ); ?></label>
      <input type="text" name="term_meta_text" id="term-meta-text" value="" class="term-meta-text-field" />
    </div>
  <?php }

  public function edit_form($term) {

    $value  = $this->get( $term->term_id );

    if ( ! $value )
        $value = ""; ?>

    <tr class="form-field term-meta-text-wrap">
      <th scope="row"><label for="term-meta-text"><?php _e( 'Package ID', 'text_domain' ); ?></label></th>
      <td>
        <?php wp_nonce_field( basename( __FILE__ ), 'package_id_nonce' ); ?>
        <input type="text" name="term_meta_text" id="term-meta-text" value="<?php echo esc_attr( $value ); ?>" class="term-meta-text-field"  />
      </td>
    </tr>
  <?php }

  public function save( $term_id ) {

    // verify the nonce --- remove if you don't care
    if ( ! isset( $_POST['package_id_nonce'] ) || ! wp_verify_nonce( $_POST['package_id_nonce'], basename( __FILE__ ) ) )
        return;

    $old_value  = $this->get($term_id);
    $new_value = isset( $_POST['term_meta_text'] ) ? $this->sanitize( $_POST['term_meta_text'] ) : '';


    if ( $old_value && '' === $new_value )
      delete_term_meta( $term_id, '_package_id' );

    else if ( $old_value !== $new_value )
      update_term_meta( $term_id, '_package_id', $new_value );
  }

  public function columns( $columns ) {
  
    $posts = $columns['posts'];

    unset($columns['description']);
    unset($columns['posts']);

    $columns['_package_id'] = __( 'Package ID', 'text_domain' );
    $columns['posts'] = $posts;

    return $columns;
}
  
  public function column( $out, $column, $term_id ) {

    if ( '_package_id' === $column ) {

      $value  = $this->get( $term_id );

      if ( ! $value )
          $value = '';

      $out = sprintf( '<span class="term-meta-text-block" style="" >%s</div>', esc_attr( $value ) );
    }

    return $out;
  }
}

TOT_Taxonomy_Package::get_instance();
