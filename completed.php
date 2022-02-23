<?php
session_start();

unset($_SESSION['join']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>会員登録完了</title>
  </head>
  <body>
      <?php
      // デバッグ
    //   print_r($_SESSION);
      ?>
      <h1>会員登録完了</h1>
      <p>*** さん</p>
      <p>無事に会員登録が完了しました。</p>
      <a href="./registration.php">TOPへ戻る</a>
  </body>
</html>