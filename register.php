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

	if ( array_key_exists('email',$_POST) OR array_key_exists('email',$_POST) ) {
		if( $_POST['email'] == '' ){
			echo '<p>アドレスを入れてください</p>';
		}elseif ($_POST['password'] == '') {
			echo '<p>パスワードを入れてください</p>';
		}else {
			$query = "SELECT `カラム名` FROM `table名` WHERE カラム名='" .
								mysqli_real_escape_string($link, $_POST['email']) . "'";
			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) > 0 ){
				echo 'すでに使用されているアドレスです。';
			}else{
				$query = "INSERT INTO `table名` (`カラム名`,`カラム名`)
									VALUES('" . mysqli_real_escape_string($link,$_POST['email']) . "','"
									. mysqli_real_escape_string($link,$_POST['password'])."')";
				if( mysqli_query($link,$query)){
					echo "登録されました。";
				}else{
					echo "登録に失敗しました。";
				}
			}
		}
	}
?>

<form method="post">
	<p><input type="text" name="email" placeholder="メールアドレス"></p>
	<p><input type="password" name="password" placeholder="パスワード"></p>
	<input type="submit" value="送信する">
</form>
