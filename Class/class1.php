<?php
class Entree {
  //private:このクラスからのみアクセスできる。
  private $name;
  //protected:このクラス自身、このクラスを継承したクラス、親クラスからのみアクセスできる。
  protected $ingredients = [];

  //construct
  //インスタンス化するときに実行される
  public function __construct ( $name, $ingredients ) {
    if ( !is_array( $ingredients ) ) {
      // 例外の捕捉をすべき
      throw new Exception('$ingredients must be an array.');
    }
    $this->name = $name;
    $this->ingredients = $ingredients;
  }
  //public:どこからでもアクセス可。
  //アクセサ：アクセス権privateの取得手段の提供。
  public function getName () {
    return $this->name;
  }

  public function hasIngredients ( $ingredients ) {
    return in_array( $ingredients, $this->ingredients );
  }
  //静的メソッド(クラスのインスタンス化なしにアクセスできる:static)
  //疑似変数($this)の使用はできない。
  //デフォルトでpublic
  public static function getSizes () {
    return array('small','medium','large');
  }
}

//Entreeクラスを継承
class ComboMeal extends Entree {
  public function __construct ( $name, $entrees ) {
    //親クラス(ここではEntreeクラス)のコンストラクタを参照する
    parent::__construct ( $name, $entrees );
    foreach ( $entrees as $entree ) {
      // instanceof演算子でEntreeのインスタンスか調べる
      if ( !$entree instanceof Entree ) {
        throw new Exception("Elements of $entrees must be entree object.");
      }
    }
  }

  public function hasIngredients($ingredients) {
    foreach ($this->ingredients as $entree) {
      if ( $entree->hasIngredients($ingredients) ) {
        return true;
      }
    }
    return false;
  }
}

//静的メソッドの呼び出し
//インスタンス化なしに呼び出せる。
$size = Entree::getSizes();
// print_r($size);

//soupインスタンス
$soup = new Entree('Chicken Soup', ['chicken', 'water']);
//sandwithインスタンス
$sandwich = new Entree('Chicken Sand', ['chicken', 'bread']);

$combo = new ComboMeal('soup + sandwith', [$soup, $sandwich]);

foreach (['chicken', 'water', 'pickles'] as $ing) {
  if ( $combo->hasIngredients($ing) ) {
    print "Something in the combo contains $ing. \n";
  }
}

foreach ( ['chicken', 'lemon', 'bread', 'water'] as $ing ) {
  if ( $soup->hasIngredients($ing) ) {
    echo "Soup Contains $ing .\n";
  }
  if ( $sandwich->hasIngredients($ing) ) {
    echo "Sandwith Contains $ing .\n";
  }
}
