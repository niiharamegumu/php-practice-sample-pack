<?php
$pref_data = array(
        '北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県',
        '埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県',
        '岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県',
        '鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県',
        '佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県');
$number = Null;
$pref = Null;
$city = Null;
$errors = array();
$query_result_data = array();


$host = '';
$userName = '';
$userPw = '';
$dbName = '';
$link = mysqli_connect( $host, $userName, $userPw, $dbName );
if ( $link ) {
  mysqli_set_charset( $link, 'utf8' );
  if ( isset($_GET['search']) ) {

    if ( $_GET['search'] === 'number' ) {
      if ( !isset($_GET['number']) || mb_strlen($_GET['number']) === 0 ) {
        $errors['error_number'] = '郵便番号を入力してください。';
      } elseif ( preg_match( "/[0-9]{7}/", $_GET['number'] ) !== 1 ) {
        $errors['error_number'] = '半角数字7文字でお願いします。';
      } else {
        $number = htmlspecialchars($_GET['number'], ENT_QUOTES, 'UTF-8');
        $number = "'" . $number . "'";
        $query = "SELECT number,pref,city,town  FROM postal_search WHERE number=" . $number;
        $result = mysqli_query( $link, $query );

        while ( $record = mysqli_fetch_array( $result ) ) {
          $query_result_data[] = $record;
        }
        mysqli_free_result( $result );
        mysqli_close( $link );
      }
    }

    if ( $_GET['search'] === 'adress' ) {
      if ( !isset($_GET['pref']) || $_GET['pref'] === '' || mb_strlen($_GET['city']) === 0 ) {
        $errors['error_pref'] = '都道府県を選択後、市区町村を記入ください';
      } elseif ( preg_match( "/[ｦ-ﾟァ-ヴぁ-ん]+/", $_GET['city'] ) !== 1 ) {
        $errors['error_pref'] = '全角カタカナ・ひらがな/半角ｶﾀｶﾅでお願いします。';
      } else {
        $pref = htmlspecialchars($_GET['pref'], ENT_QUOTES, 'UTF-8');
        $city = htmlspecialchars($_GET['city'], ENT_QUOTES, 'UTF-8');
        $city = mb_convert_kana( $city, "kVh" );
        $pref = "'" . $pref . "'";
        $city = "'" . $city . "'";
        $query = "SELECT number,pref,city,town  FROM postal_search WHERE pref=" . $pref . "AND city_kana=" . $city;
        $result = mysqli_query( $link, $query );

        while ( $record = mysqli_fetch_array( $result ) ) {
          $query_result_data[] = $record;
        }
        mysqli_free_result( $result );
        mysqli_close( $link );
      }
    }

  }

} else {
  echo 'データベースと接続できていません。';
}
