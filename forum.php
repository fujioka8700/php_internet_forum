<?php
session_start();
include_once('./dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $statement = $pdo->prepare('SELECT * FROM members WHERE id=:id');
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $member = $statement->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: ./index.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>犬・猫 どちら派掲示板</title>
  </head>
  <body>
      <?php
      // デバッグ
      // print_r($_COOKIE);
      // print_r($_SESSION);
      ?>
      <h1>犬・猫 どちら派掲示板</h1>
      <p><?php echo $member['name']; ?> さん、ようこそ</p>
      <p><a href="index.php">ログアウト</a></p>
      <form action="./forum.php">
          <textarea name="text1" id="" cols="30" rows="10"></textarea><br>
          <input type="submit" value="投稿する">
      </form>
  </body>
</html>