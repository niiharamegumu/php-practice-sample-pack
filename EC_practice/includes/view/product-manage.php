<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品管理ページ</title>
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>

  <div class="wrapper">
    <h1>商品管理ページ</h1>

    <nav class="global-nav">
      <ul>
        <li><a href="logout.php">ログアウト</a></li>
        <li><a href="admin-side-user.php">ユーザ管理ページ</a></li>
      </ul>
    </nav>

    <?php if ( count($messages) > 0 ) : ?>
      <div class="message-wrapper">
        <ul>
          <?php foreach ( $messages as $message ) : ?>
            <li><?php echo $message; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <section class="addition">
      <h2>商品の登録</h2>
      <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="item-name">名前</label>：
        <input type="text" name="item-name" value="" id="item-name"><br>

        <label for="item-price">値段</label>：
        <input type="text" name="item-price" value="" id="item-price"><br>

        <label for="stock-num">個数</label>：
        <input type="text" name="stock-num" value="" id="stock-num"><br>

        <label for="item-img">商品画像</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
        <input type="file" name="item-img" id="item-img"><br>

        <select name="public-status">
          <option value="0">非公開</option>
          <option value="1">公開</option>
        </select><br>

        <input type="hidden" name="submit-type" value="add-item">
        <input type="submit" value="商品を登録する">
      </form>
    </section>

    <section class="product-info">
      <h2>商品情報の一覧・変更</h2>

      <table>
        <thead>
          <tr>
            <th colspan="col">商品画像</th>
            <th colspan="col">商品名</th>
            <th colspan="col">価格</th>
            <th colspan="col">在庫数</th>
            <th colspan="col">ステータス</th>
            <th colspan="col">操作</th>
          </tr>
        </thead>
        <?php if ( isset($items) ) : ?>
        <tbody>
          <?php foreach ( $items as $item ) : ?>
          <tr>
            <td><img src="images/<?php echo $item['item_img']; ?>"></td>
            <td><?php echo $item['item_name']; ?></td>
            <td><?php echo $item['item_price']; ?></td>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <td>
                <input type="text" name="stock-update" value="<?php echo $item['stock_num']; ?>">個
                <input type="submit" value="変更">
              </td>
              <input type="hidden" name="item-id" value="<?php echo $item['id']; ?>">
              <input type="hidden" name="submit-type" value="stock-update">
            </form>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <td>
                <?php if ( (int)$item['public_status'] === 0 ) : ?>
                  <input type="submit" value="非公開→公開">
                  <input type="hidden" name="reverse-status" value="1">
                <?php else : ?>
                  <input type="submit" value="公開→非公開">
                  <input type="hidden" name="reverse-status" value="0">
                <?php endif; ?>
              </td>
              <input type="hidden" name="item-id" value="<?php echo $item['id']; ?>">
              <input type="hidden" name="submit-type" value="change-status">
            </form>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <td><input type="submit" name="delete-item" value="削除する"></td>
              <input type="hidden" name="item-id" value="<?php echo $item['id']; ?>">
              <input type="hidden" name="submit-type" value="delete-item">
            </form>
          </tr>
            <?php endforeach; ?>
        </tbody>
        <?php endif; ?>
      </table>
    </section>

  </div>

</body>
</html>
