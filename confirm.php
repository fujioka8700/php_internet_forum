<?php
session_start();
include_once('./member_property.php');

if (!isset($_SESSION['join'])) {
  header('Location: ./registration.php');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>会員情報確認画面</title>
  </head>
  <body>
      <?php
      // print_r($animal);
      ?>
      <h1>会員情報確認画面</h1>
      <?php switch($animal):
            case ('dog'): ?><p>私は犬派です。</p><?php break ; ?>
      <?php case('cat'): ?><p>私は猫派です。</p><?php break; ?>
      <?php endswitch; ?>
      <p>name: <?php echo $name; ?></p>
      <p>email: <?php echo $email; ?></p>
      <p>パスワード: [セキュリティのため非表示]</p>
      <input type="button" onclick="location.href='./registration.php'" value="修正する">
      <input type="button" onclick="location.href='./register.php'" value="登録する">
  </body>
</html>