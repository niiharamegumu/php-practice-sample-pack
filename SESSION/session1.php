<?php
session_start();
$_SESSION['username'] = '任意';
echo $_SESSION['username'];

header('Location: ファイル名');

?>
