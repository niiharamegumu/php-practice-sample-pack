<?php
function img_file_upload () {
  $temp_file = $_FILES['item-img']['tmp_name'];
  $file_name = "./images/" . $_FILES['item-img']['name'];
  $ext = get_extension( $file_name );
  $img_name = get_uniq_num() . $ext;

  if ( is_uploaded_file($temp_file) ) {
    move_uploaded_file($temp_file, $file_name );
    rename($file_name, "./images/" . $img_name);
    return $img_name;
  } else {
    return '';
  }

}

function get_extension ( $file_name ) {
  $ext = "." . pathinfo($file_name, PATHINFO_EXTENSION);
  return $ext;
}

function get_uniq_num () {
  $uniq = md5( uniqid() );
  return $uniq;
}

function entity_str($str) {
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

function entity_assoc_array($assoc_array) {
  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      $assoc_array[$key][$keys] = entity_str($values);
    }
}
  return $assoc_array;
}
