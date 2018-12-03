<?php
function show_form ( $errors = [] ) {
  $defaults = [
    'delivery' => 'yes',
    'size' => 'medium'
  ];
  $form = new FormHelper($defaults);
  include_once('include/view/form-view.php');
}



function validate_form () {
  $input = [];
  $errors = [];

  $input['name'] = trim($_POST['name'] ?? '');
  if ( !strlen($input['name']) ) {
    $errors[] = 'Please enter your name.';
  }

  $input['size'] = $_POST['size'] ?? '';
  if ( !in_array($input['size'], ['small', 'medium', 'large']) ) {
    $errors[] = 'Please select a size.';
  }

  $input['sweet'] = $_POST['sweet'] ?? '';
  if ( !array_key_exists($input['sweet'], $GLOBALS['sweets']) ) {
    $errors[] = 'Please select a valid sweet item.';
  }

  $input['main_dish'] = $_POST['main_dish'] ?? [];
  if ( count($input['main_dish']) !== 2 ) {
    $errors[] = 'Please select exactly two main dishes.';
  } else {
    if ( !(array_key_exists($input['main_dish'][0], $GLOBALS['main_dishes']) &&
           array_key_exists($input['main_dish'][1], $GLOBALS['main_dishes']))) {
      $errors[] = 'Please select exactly two valid main dishes.';
    }
  }

  $input['delivery'] = $_POST['delivery'] ?? 'no';
  $input['comments'] = trim($_POST['comments'] ?? '');
  if ( ($input['delivery'] === 'yes') && (!strlen($input['comments'])) ) {
    $errors[] = 'Please enter your adress for delivery.';
  }
  return array($errors, $input);
}



function process_form( $input ) {
  $sweet = $GLOBALS['sweets'][$input['sweet']];
  $main_dish_1 = $GLOBALS['main_dishes'][$input['main_dish'][0]];
  $main_dish_2 = $GLOBALS['main_dishes'][$input['main_dish'][1]];
  if ( isset($input['delivery']) && ($input['delivery'] === 'yes') ) {
    $delivery = 'do';
  } else {
    $delivery = 'do not';
  }

  $message =<<<_ORDER_
Thank you for your order, {$input['name']}.
You requested the {$input['size']} size of $sweet, $main_dish_1 and $main_dish_2.
You $delivery want delivery.
_ORDER_;
  if ( strlen(trim($input['comments'])) ) {
    $message .= 'Your comments: ' . $input['comments'];
  }

  mail('', 'New Order', $message);
  print nl2br(htmlentities($message, ENT_HTML5));
}
