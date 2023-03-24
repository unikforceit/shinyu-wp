<?php 
function render_fields($fields) {

  foreach ($fields as $key => $field) {
    $output[] = array(
      'label' => $field,
      'value' => $key
    );
  }
  return $output;

}