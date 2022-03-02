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

// 投稿数の合計
function sumPosts($pdo) {
  $sth = $pdo->query('select count(*) from posts');
  $posts_count = $sth->fetch(PDO::FETCH_ASSOC);
  return $posts_count['count(*)'];
}

// 現在のページ
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

$max = 5; //コンテンツの表示数
$contents_sum = sumPosts($pdo); //コンテンツの総数
$max_page = ceil($contents_sum / $max); //ページの最大値
$start = $max * ($page - 1); // スタートするページを取得

// 投稿内容を取得
$sth = $pdo->prepare('SELECT m.animal, p.message, p.image, m.name, p.created, p.created_by, p.id FROM members AS m, posts AS p WHERE m.id = p.created_by ORDER BY p.created DESC LIMIT :start, :max');
$sth->bindParam(':start', $start, PDO::PARAM_INT);
$sth->bindParam(':max', $max, PDO::PARAM_INT);
$sth->execute();
$posts = $sth->fetchAll();

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
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="./dist/app.css">
    <title>犬・猫 どちら派掲示板</title>
  </head>
  <body>
      <div class="container">
        <div class="row">
          <div class="col col-md-8 offset-md-2">
            <p class="h1 text-center my-3 text-white fs-2">犬・猫 どちら派掲示板</p>
            <?php if($error['login'] == "token"): ?>
                <p class="text-danger fw-bold">不正アクセスです</p>
            <?php endif; ?>
            <button type="button" class="btn btn-secondary btn-sm mb-3"><a href="index.php" class="text-white text-decoration-none">ログアウト</a></button>

            <!-- 本文、投稿部分 -->
            <div class="card mb-3">
              <div class="card-body post-text">
                <div class="memberAnimalFace text-center">
                  <?php
                    $anomaleface = $member['animal'] == 'cat' ? 'animalface_neko.png' : 'animalface_inu.png'
                  ?>
                  <img src="images_src/<?= $anomaleface ?>" class="img-fluid" alt="img-fluid" style="width: 50px;">
                </div>
                <p><?php echo $member['name']; ?> さん、ようこそ!!</p>
                <p class="mb-2">コメントしてください</p>
                <form action="./forum.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="token" value="<?=$token?>">
                  <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" name="message"></textarea>
                  </div>
                  <div class="mt-3">
                    <label for="formFile" class="form-label">可愛い犬や猫の写真があれば、アップしてください</label>
                    <input class="form-control" type="file" name="image" id="formFile">
                  </div>
                  <button type="submit" class="btn btn-info mt-3">投稿する</button>
                </form>
              </div><!-- .post-text -->
            </div><!-- .card -->

            <!-- 投稿記事 -->
            <?php foreach($posts as $post): ?>
              <div class="message">
                <div class="card mb-3">
                  <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="text-start">
                        <?php
                          $anomaleface = $post['animal'] == 'cat' ? 'animalface_neko.png' : 'animalface_inu.png'
                        ?>
                        <img src="images_src/<?= $anomaleface ?>" class="img-fluid" alt="img-fluid" style="width: 50px;">
                        <?php echo $post['name']; ?> さん
                      </div>
                      <div class="text-end">
                        <?php echo $post['created']; ?>
                        <?php if ($_SESSION['id'] == $post['created_by']): ?>
                          <button type="button" class="btn-sm btn-outline-secondary"><a href="delete.php?id=<?php echo htmlspecialchars($post['id']); ?>" class="text-dark text-decoration-none">削除</a></button>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div><!-- .card-header -->
                  <div class="card-body">
                    <?php if(exif_imagetype('./images/' . $post['image'])): ?>
                      <div class="text-center mb-3">
                        <img src="./images/<?php echo $post['image']; ?>"  class="img-fluid w-50" alt="img-fluid"> 
                      </div>    
                    <?php endif; ?>
                    <p class="card-text"><?php echo $post['message']; ?></p>
                  </div><!-- .card-body -->
                </div><!-- .card -->
              </div><!-- .message -->
            <?php endforeach; ?>
            <!-- ページネーション -->
            <div class="card mb-3">
              <div class="card-body">
                <div class="pg">
                  <nav aria-label="Page navigation example">
                    <ul class="pagination d-flex justify-content-center mb-0">
                      <li class="page-item">
                        <?php  if ($page > 1): ?>
                          <a class="page-link" href="forum.php?page=<?php echo ($page-1); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        <?php endif; ?>
                      </li>
                      <li class="page-item disabled"><a class="page-link"><?=$page?></a></li>
                      <li class="page-item">
                        <?php  if ($page < $max_page): ?>
                          <a class="page-link" href="forum.php?page=<?php echo ($page+1); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        <?php endif; ?>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div><!-- .col -->
        </div><!-- .row -->
      </div><!-- .container -->
      <script src="./dist/app.js"></script>
  </body>
</html>