<?php
session_start();
include_once('./dbconnect.php');
include_once('./member_property.php');

$statement = $pdo->prepare('SELECT name FROM members WHERE email=:email');
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$member = $statement->fetch(PDO::FETCH_ASSOC);

print_r($count);

unset($_SESSION['join']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>会員登録完了</title>
  </head>
  <body>
      <?php
      // デバッグ
      // print_r($_SESSION);
      ?>
      <h1>会員登録完了</h1>
      <p><?php echo $member['name']; ?> さん</p>
      <p>無事に会員登録が完了しました。</p>
      <p><a href="./index.php">TOPへ戻る</a></p>
  </body>
</html>