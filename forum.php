<?php
session_start();
include_once('./dbconnect.php');

// ログイン処理
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $statement = $pdo->prepare('SELECT * FROM members WHERE id=:id');
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $member = $statement->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: ./index.php');
}

// 投稿内容の書き込み
if (!empty($_GET['message'])) {
  $message = $pdo->prepare('INSERT INTO posts (message, created_by, created) VALUES (:message, :created_by, NOW())');
  $message->execute(array(':message' => $_GET['message'], ':created_by' => $member['id']));
  header('Location: ./forum.php');
}

// 全ての投稿内容を取得
$posts = $pdo->query('SELECT members.name, posts.message, posts.created FROM members, posts WHERE members.id = posts.created_by ORDER BY created DESC');

unset($pdo);

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
      // print_r($posts);
      // print_r($_SESSION);
      // foreach($posts as $post) {
        // echo $post['name'];
      // }
      ?>
      <h1>犬・猫 どちら派掲示板</h1>
      <p><?php echo $member['name']; ?> さん、ようこそ</p>
      <p><a href="index.php">ログアウト</a></p>
      <form action="./forum.php" method="get">
          <textarea name="message" id="" cols="30" rows="10"></textarea><br>
          <input type="submit" value="投稿する">
      </form>
      <?php foreach($posts as $post): ?>
        <div class="message">
          <?php echo $post['message']; ?> | <?php echo $post['name']; ?> | <?php echo $post['created']; ?>
        </div>
      <?php endforeach; ?>
  </body>
</html>