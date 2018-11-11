<?php
$pref_data = array(
        '北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県',
        '埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県',
        '岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県',
        '鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県',
        '佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県');
$host = 'localhost';
$userName = 'root';
$userPw = 'root';
$dbName = 'code_camp';
$link = mysqli_connect( $host, $userName, $userPw, $dbName );

if ( $link ) {
  mysqli_set_charset( $link, 'utf8' );
  $query_select = "SELECT  FROM ";

} else {
  echo 'データベースと接続できていません。';
}




?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>住所検索</title>
</head>
<body>
  <h1>郵便番号検索</h1>
  <section>
    <h2>郵便番号から検索</h2>
    <form>
      <input type="text" name="number" placeholder="例）1010001" value="">
      <input type="submit" value="検索">
    </form>
    <h2>地名から検索</h2>
    <form>
      都道府県を選択
      <select name="pref">
        <option value="" selected>都道府県を選択</option>
        <?php
          foreach ($pref_data as $value) {
            $html = "";
            $html .= "<option value='" . $value . "'>";
            $html .= $value;
            $html .= "</option>";
            echo $html;
          }
        ?>
      </select>
      <input type="text" name="address" value="" placeholder="ﾐﾅﾄｸ">
      <input type="submit" value="検索">
    </form>
  </section>
  <section class="search-reslut">
    <p>検索結果0件</p>
  </section>
</body>
</html>
