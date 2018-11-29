<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機</title>
</head>
<body>

  <div class="result-wrapper">
    <h1>購入結果ページ</h1>

    <section class="purchase-result">
      <h2>販売結果</h2>
      <?php if ( count( $err_msg ) === 0 ) : ?>
        <img src="./images/<?php echo $result_data[0]['img_path']; ?>" alt="ドリンクイメージ">
        <p>購入ドリンク：<?php echo $result_data[0]['drink_name']; ?></p>
        <p>おつり：<?php echo $remaining_amount; ?>円</p>
      <?php else : ?>
        <ul>
          <?php foreach ( $err_msg as $err ): ?>
              <li><?php echo $err; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <footer><a href="index.php">戻る</a></footer>
    </section>

  </div>

</body>
</html>
