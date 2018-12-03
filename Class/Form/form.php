<?php
require_once('include/model/FormHelper.php');
require_once('include/model/functions.php');

$sweets = [
  'puff'     => 'Sesame Seed Puff',
  'square'   => 'Coconut Milk Gelatin Square',
  'cake'     => 'Brown Sugar Cake',
  'ricemeat' => 'Sweet Rice and Meat'
];
$main_dishes = [
  'cuke' => 'Braised Sea Cucumber',
  'stomach' => "Sauteed Pig's Stomach",
  'tripe' => 'Sauteed Tripe with Wine Sauce',
  'taro' => 'Stewed Pork with Taro',
  'giblets' => 'Baked Giblets with Salt',
  'abalone' => 'Abalone with Marrow and Duck Feet'
];


if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  list($errors, $input) = validate_form();
  if ( $errors ) {
    show_form($errors);
  } else {
    process_form($input);
  }
} else {
  show_form();
}
?>
