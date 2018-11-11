<?php

require( 'postal_search.php' );

?>

<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>住所検索</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>郵便番号検索</h1>
<div class="wrapper">
  <section class="search-form">
    <h2>郵便番号から検索</h2>
    <form>
      <input type="text" name="number" placeholder="例）1010001" value="">
      <input type="hidden" name="search" value="number"><br>
      <input type="submit" value="検索">
    </form>
    <h2>地名から検索</h2>
    <form>
      都道府県を選択<br>
      <select name="pref">
        <option value="" selected>都道府県を選択</option>
        <?php
        foreach ($pref_data as $value) {
          $html = "";
          $html .= "<option value='" . $value . "'>";
          $html .= $value;
          $html .= "</option>\n";
          echo $html;
        }
        ?>
      </select><br>
      市区町村(全角カタカナ・ひらがな/半角ｶﾀｶﾅ)<br>
      <input type="text" name="city" value="" placeholder="ミヤザキシ">
      <input type="hidden" name="search" value="adress"><br>
      <input type="submit" value="検索">
    </form>
  </section>

  <section class="search-reslut">
    <p>ここに結果が表示されます</p>
    <?php if ( count($errors) > 0 ) : ?>
      <?php
      foreach ( $errors as $error ) {
        echo '<p>' . $error . '</p>';
      }
      ?>
    <?php elseif ( count($query_result_data) > 0 ) : ?>
      <table>
        <thead>
          <tr>
            <th>郵便番号</th>
            <th>都道府県</th>
            <th>市区町村</th>
            <th>町域</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ( $query_result_data as $value ) {
            $html = "";
            $html .= "<tr>";
              $html .= "<td>" . $value['number'] . "</td>";
              $html .= "<td>" . $value['pref'] . "</td>";
              $html .= "<td>" . $value['city'] . "</td>";
              $html .= "<td>" . $value['town'] . "</td>";
              $html .= "</tr>";
              echo $html;
            }
            ?>
          </tbody>
        </table>
      <?php else : ?>
        <p>検索結果0件</p>
      <?php endif; ?>
    </section>
</div>

</body>
</html>
