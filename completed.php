<?php
session_start();
include_once('./dbconnect.php');
include_once('./member_property.php');

if (!isset($_SESSION['join'])) {
  header('Location: ./index.php');
}

$statement = $pdo->prepare('SELECT name FROM members WHERE email=:email');
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$member = $statement->fetch(PDO::FETCH_ASSOC);

unset($_SESSION['join']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./dist/app.css">
    <title>[登録完了] 犬・猫 どちら派掲示板</title>
  </head>
  <body>
      <div id="login">
        <h3 class="text-center text-white pt-5">犬・猫 どちら派掲示板</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12 completed">
                        <form id="login-form" class="form" action="" method="">
                            <h3 class="text-center text-info">会員登録完了</h3>
                            <div class="form-group mt-5">
                              <p class="text-center"><?php echo $member['name']; ?> さん</p>
                              <p class="text-center">無事に会員登録が完了しました。</p>
                            </div>
                            <p class="text-right"><a href="./index.php">TOPへ戻る</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="./dist/app.js"></script>
  </body>
</html>