<?php
namespace Meals;

class Ingredients {
  protected $name;
  protected $cost;

  public function __construct ( $name, $cost ) {
    if ( !is_int( $cost ) ) {
      throw new Exception( '$cost must be an integer.' );
    }
    $this->name = $name;
    $this->cost = $cost;
  }

  public function getName () {
    return $this->name;
  }

  public function getCost () {
    return $this->cost;
  }

  public function setCost ( $cost ) {
    $this->cost = $cost;
  }
}
