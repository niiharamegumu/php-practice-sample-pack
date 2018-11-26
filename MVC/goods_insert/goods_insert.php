<?php
require_once 'include/conf/const.php';
require_once 'include/model/function.php';

$goods_name = '';
$price   = '';
$err_msg = array();


$request_method = get_request_method();
if ($request_method === 'POST') {

   $goods_name = get_post_data('goods_name');
   $price   = get_post_data('price');
   // 本来はここで商品名や価格の入力値チェックを行います。

   $link = get_db_connect();

   if (insert_goods_table($link, $goods_name, $price) !== TRUE) {
       $err_msg[] = 'INSERT失敗';
   }

   close_db_connect($link);

   $goods_name = entity_str($goods_name);
   $price   = entity_str($price);

   if (count($err_msg) === 0) {
       include_once 'include/view/goods_insert_result.php';
       exit;
   }
}
// 新規追加テンプレートファイル読み込み
include_once 'include/view/goods_insert.php';
