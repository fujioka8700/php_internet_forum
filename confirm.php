<?php
session_start();
include_once('./member_property.php');

if (!isset($_SESSION['join'])) {
  header('Location: ./index.php');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>[確認] 犬・猫 どちら派掲示板</title>
  </head>
  <body>
      <div id="login">
        <h3 class="text-center text-white pt-5">犬・猫 どちら派掲示板</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="">
                            <h3 class="text-center text-info">登録情報の確認</h3>
                            <p class="text-center">下記の情報で登録してよろしいですか？</p>
                            <div class="form-group">
                              <p class="text-info">どちら派か</p>
                              <?php switch($animal):
                                    case ('dog'): ?><p>私は犬派です。</p><?php break ; ?>
                              <?php case('cat'): ?><p>私は猫派です。</p><?php break; ?>
                              <?php endswitch; ?>
                            </div>
                            <div class="form-group">
                                <p class="text-info">Name:</p>
                                <p><?php echo $name; ?></p>
                            </div>
                            <div class="form-group">
                                <p class="text-info">Email:</p>
                                <p><?php echo $email; ?></p>
                            </div>
                            <div class="form-group">
                                <p class="text-info">Password:</p>
                                <p>[セキュリティのため非表示]</p>
                            </div>
                            <div class="btn-toolbar">
                              <div class="btn-group">
                                <button class="btn btn-info"><a href="./registration.php" class="text-decoration-none text-white">修正する</a></button>
                              </div>
                              <div class="btn-group ml-auto">
                                <button class="btn btn-warning"><a href="./register.php" class="text-decoration-none text-dark">登録する</a></button>
                              </div>
                            </div>
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