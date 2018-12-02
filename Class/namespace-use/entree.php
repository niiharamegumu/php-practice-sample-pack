<?php
class Entree {
  private $name;
  protected $ingredients = [];


  public function __construct ( $name, $ingredients ) {
    if ( !is_array( $ingredients ) ) {
      throw new Exception('$ingredients must be an array.');
    }
    $this->name = $name;
    $this->ingredients = $ingredients;
  }

  public function getName () {
    return $this->name;
  }

  public function hasIngredients ( $ingredients ) {
    return in_array( $ingredients, $this->ingredients );
  }

  public static function getSizes () {
    return array('small','medium','large');
  }
}
