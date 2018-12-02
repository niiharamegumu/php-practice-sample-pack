<?php
require_once( 'entree.php' );
require_once( 'ingredients.php' );
use Meals\Ingredients;


class PricedEntree extends Entree {
  public function __construct ( $name, $ingredients ) {
    parent::__construct($name, $ingredients);
    foreach ( $this->ingredients as $ingredient ) {
      if ( !$ingredient instanceof Ingredients) {
        throw new Exception('Elements of $ingredients must be Ingredient objects');
      }
    }
  }

  public function getCost () {
    $cost = 0;
    foreach ($this->ingredients as $ingredient) {
      $cost += $ingredient->getCost();
    }
    return $cost;
  }

}

try {
  $banana = new Ingredients( 'banana', 80 );
  $tomato = new Ingredients( 'tomato', 100 );
  $pricedTset = new PricedEntree( '合計', [$banana, $tomato] );


} catch ( Exception $e ) {
  print $e->getMessage();
  exit;
}
print $pricedTset->getName();
print $pricedTset->getCost();
