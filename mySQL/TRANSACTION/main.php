<?php
require('transaction.php');
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>トランザクション</title>
</head>
<body>
  <?php if (!empty($message)) : ?>
    <p><?php print $message; ?></p>
  <?php endif; ?>

  <section>
    <h1>保有ポイント</h1>
    <p><?php print number_format($point); ?>ポイント</p>
  </section>

  <section>
  <h1>ポイント商品購入</h1>
  <form method="post" action="main.php">
    <ul>
      <?php foreach ($point_gift_list as $point_gift) : ?>
      <li>
        <span><?php print $point_gift['name']; ?></span>
        <span><?php print number_format($point_gift['point']); ?>ポイント</span>
        <?php if ($point_gift['point'] <= $point) : ?>
          <button type="submit" name="point_gift_id" value="<?php print $point_gift['point_gift_id']; ?>">購入する</button>
        <?php else : ?>
          <button type="button" disabled="disabled">購入不可</button>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
    </ul>
  </form>
  </section>
</body>
</html>
