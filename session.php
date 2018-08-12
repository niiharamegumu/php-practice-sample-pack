<?php
//sessionの開始
//sessionはシンプルな方法で個々のユーザーのデータを格納する仕組み
session_start();
$_SESSION['username'] = '任意';
echo $_SESSION['username'];

//別ファイルへ移動
header('Location: ファイル名');

?>
