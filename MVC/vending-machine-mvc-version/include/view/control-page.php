<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="administration-wrapper">
    <h1>管理ページ</h1>
    <?php if ( count($err_msg) > 0 ) : ?>
      <ul>
        <?php foreach ( $err_msg as $err ) : ?>
          <li><?php echo $err; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <section class="addition">
      <h2>新規商品の追加</h2>
      <form method="post" enctype="multipart/form-data" action="stock-tool.php">
        <label for="drink-name">名前</label>：
        <input type="text" name="drink-name" value="" id="drink-name"><br>

        <label for="drink-price">値段</label>：
        <input type="text" name="drink-price" value="" id="drink-price"><br>

        <label for="stock-num">個数</label>：
        <input type="text" name="stock-num" value="" id="stock-num"><br>

        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" name="drink-image"><br>

        <select name="status">
          <option value="0">非公開</option>
          <option value="1">公開</option>
        </select><br>

        <input type="hidden" name="submit-type" value="add-item">
        <input type="submit" value="商品の追加">
      </form>
    </section>

    <section class="information-change">
      <h2>商品情報の変更</h2>
      <table>
        <caption>商品一覧</caption>

        <thead>
          <tr>
            <th colspan="col">商品画像</th>
            <th colspan="col">商品名</th>
            <th colspan="col">価格</th>
            <th colspan="col">在庫数</th>
            <th colspan="col">ステータス</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ( $drink_data_list as $drink_data ) : ?>
            <tr>
              <td><img src="./images/<?php echo $drink_data['img_path'] ?>"></td>
              <td><?php echo $drink_data['drink_name'] ?></td>
              <td><?php echo $drink_data['drink_price'] ?></td>

              <form method="post" action="stock-tool.php">
                <td>
                  <input type="text" name="stock-update-num" value="<?php echo $drink_data['stock_num'] ?>">個<br>
                  <input type="submit" value="変更">
                </td>
                <input type="hidden" name="drink-id" value="<?php echo $drink_data['drink_id'] ?>">
                <input type="hidden" name="submit-type" value="stock-update">
              </form>

              <form method="post" action="stock-tool.php">
                <td>
                  <?php if (  (int)$drink_data['public_status'] === 1 ) : ?>
                    <input type="submit" value="公開→非公開">
                    <?php $reverse = 0; ?>
                  <?php else : ?>
                    <input type="submit" value="非公開→公開">
                    <?php $reverse = 1; ?>
                  <?php endif; ?>
                </td>
                <input type="hidden" name="reverse-status" value="<?php echo $reverse ?>">
                <input type="hidden" name="drink-id" value="<?php echo $drink_data['drink_id'] ?>">
                <input type="hidden" name="submit-type" value="change-status">
              </form>

            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </section>

  </div>

</body>
</html>
