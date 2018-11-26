<?php
require_once('include/conf/const.php');
require_once('include/model/model.php');


$goods_data = array();

$link = get_db_connect();

$goods_data = get_goods_table_list($link);

close_db_connect($link);

$goods_data = price_before_tax_assoc_array($goods_data);

$goods_data = entity_assoc_array($goods_data);


include_once('include/view/view.php');
