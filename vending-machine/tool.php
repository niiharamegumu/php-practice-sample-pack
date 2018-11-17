<?php

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機</title>
</head>
<body>

  <div class="administration-wrapper">
    <h1>管理ページ</h1>

    <section class="addition">
      <h2>新規商品の追加</h2>
      <form method="post">
        <label for="name">名前</label>：
        <input type="text" name="name" value="" id="name"><br>
        <label for="price">値段</label>：
        <input type="text" name="price" value="" id="price"><br>
        <label for="add-number">個数</label>：
        <input type="text" name="add-number" value="" id="add-number"><br>
        <input type="file" name="drink-image"><br>
        <select name="status">
          <option value="0">非公開</option>
          <option value="1">公開</option>
        </select><br>
        <input type="submit" name="submit-addition" value="商品の追加">
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
          <?php  ?>
          <?php  ?>
        </tbody>
      </table>
    </section>
    
  </div>

</body>
</html>
