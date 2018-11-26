<?php
/**
* 税込み価格へ変換する(端数は切り上げ)
* @param int  $price 税抜き価格
* @return int 税込み価格
*/
function price_before_tax($price) {
    return floor($price * TAX);
}

/**
* 商品の値段を税込みに変換する(配列)
* @param array  $assoc_array 税抜き商品一覧配列データ
* @return array 税込み商品一覧配列データ
*/
function price_before_tax_assoc_array($assoc_array) {
  foreach ($assoc_array as $key => $value) {
      $assoc_array[$key]['price'] = price_before_tax($assoc_array[$key]['price']);
  }
  return $assoc_array;
}

/**
* 特殊文字をHTMLエンティティに変換する
* @param str  $str 変換前文字
* @return str 変換後文字
*/
function entity_str($str) {
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

/**
* 特殊文字をHTMLエンティティに変換する(2次元配列の値)
* @param array  $assoc_array 変換前配列
* @return array 変換後配列
*/
function entity_assoc_array($assoc_array) {
  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      $assoc_array[$key][$keys] = entity_str($values);
    }
}
  return $assoc_array;
}

/**
* DBハンドルを取得
* @return obj $link DBハンドル
*/
function get_db_connect() {
  if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
    die('error: ' . mysqli_connect_error());
  }
  mysqli_set_charset($link, DB_CHARACTER_SET);
  return $link;
}

/**
* DBとのコネクション切断
* @param obj $link DBハンドル
*/
function close_db_connect($link) {
  mysqli_close($link);
}

/**
* クエリを実行しその結果を配列で取得する
*
* @param obj  $link DBハンドル
* @param str  $sql SQL文
* @return array 結果配列データ
*/
function get_as_array($link, $sql) {
  $data = array();
  if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
    }
  mysqli_free_result($result);
  }
  return $data;
}

/**
* 商品の一覧を取得する
*
* @param obj $link DBハンドル
* @return array 商品一覧配列データ
*/
function get_goods_table_list($link) {
  $sql = 'SELECT goods_name, price FROM goods_table';
  return get_as_array($link, $sql);
}
