<?php 
function render_fields($fields) {

  $output = [];
  foreach ($fields as $key => $field) {
    $output[] = [
      'label' => $field,
      'value' => $key
    ];
  }
  return $output;

}