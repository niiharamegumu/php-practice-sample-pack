<?php
setcookie('id名', '任意', time() + 60 * 60 *24);
echo $_COOKIE['id名'];

?>

<form method="post">
	<p><input type="text" name="email" placeholder="メールアドレス"></p>
	<p><input type="password" name="password" placeholder="パスワード"></p>
	<input type="submit" value="送信する">
</form>
