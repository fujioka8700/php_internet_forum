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

// 投稿内容の書き込み（CSRF対策）
if (!empty($_POST['message'])) {
  if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
    // 画像のファイル名をユニーク化
    $image = uniqid(mt_rand(), true);
    $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
    $file = "images/{$image}";

    // データベースへ投稿内容登録
    $message = $pdo->prepare('INSERT INTO posts (message, image, created_by, created) VALUES (:message, :image, :created_by, NOW())');
    $message->execute(array(':message' => $_POST['message'], ':image' => $image, ':created_by' => $member['id']));

    // ファイルのアップロード
    if (!empty($_FILES['image']['name'])) {
      // imagesディレクトリにファイルを移動
      move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);
      // 画像ファイルかチェック
      if (exif_imagetype($file)) {
        $message = '画像をアップロードしました';
      } else {
        $message = '画像ファイルではありません';
      }
    }
    
    header('Location: ./forum.php');
  } else {
    $error['login'] = 'token';
  }
}

// 全ての投稿内容を取得
$posts = $pdo->query('SELECT m.animal, p.message, p.image, m.name, p.created, p.created_by, p.id FROM members AS m, posts AS p WHERE m.id = p.created_by ORDER BY p.created DESC');

// CSRF対策
$TOKEN_LENGTH = 16;
$tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
$token = bin2hex($tokenByte);
$_SESSION['token'] = $token;

unset($pdo);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>犬・猫 どちら派掲示板</title>
    <style>
      .message img {
        width: 100px;
      }
    </style>
  </head>
  <body>
      <?php
      // デバッグ
      // print_r($_SESSION);
      // phpinfo();
      ?>
      <h1>犬・猫 どちら派掲示板</h1>
      <p><a href="index.php">ログアウト</a></p>
      <?php if($error['login'] == "token"): ?>
          <p>不正アクセスです</p>
      <?php endif; ?>
      <p><?php echo $member['name']; ?> さん、ようこそ</p>
      <form action="./forum.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="token" value="<?=$token?>">
          <textarea name="message" id="" cols="30" rows="10"></textarea><br>
          <input type="file" name="image" id=""><br>
          <input type="submit" value="投稿する">
      </form>
      <?php foreach($posts as $post): ?>
        <div class="message">
        <?php echo $post['animal']; ?> | <?php echo $post['message']; ?> | <?php echo $post['name']; ?> | <?php echo $post['created']; ?> | 
          <?php if(exif_imagetype('./images/' . $post['image'])): ?>
            <img src="./images/<?php echo $post['image']; ?>"> 
          <?php endif; ?>
          <?php if ($_SESSION['id'] == $post['created_by']): ?>
            <a href="delete.php?id=<?php echo htmlspecialchars($post['id']); ?>">削除</a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
  </body>
</html>