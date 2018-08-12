<?php

	$link = mysqli_connect(
		'localhost',
		'root',
		'root',
		'DB名'
	);

	if( mysqli_connect_error() ){
		die( '接続に失敗しました。' );
	};

	$query = "SELECT * FROM table名 WHERE カラム名 LIKE '%e%' ";
		if( $result = mysqli_query( $link, $query ) ){
			echo 'クエリの発行に成功しました。<br>';
		};

	while( $row = mysqli_fetch_array( $result ) ){
		print_r( $row );
	};

?>
