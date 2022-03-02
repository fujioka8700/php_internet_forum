<?php

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="./dist/app.css">
    <title>Bootstrap</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col col-md-8 offset-md-2">
          <p class="h1 text-center my-3 text-white fs-2">犬・猫 どちら派掲示板</p>
          <button type="button" class="btn btn-secondary btn-sm mb-3">ログアウト</button>

          <!-- 本文、投稿部分 -->
          <div class="card mb-3">
            <div class="card-body post-text">
              <p>ねこ派 さん、ようこそ！</p>
              <p class="mb-2">コメントしてください</p>
              <div class="input-group">
                <textarea class="form-control" aria-label="With textarea"></textarea>
              </div>
              <div class="mt-3">
                <label for="formFile" class="form-label">可愛い犬や猫の写真があれば、アップしてください</label>
                <input class="form-control" type="file" id="formFile">
              </div>
              <button type="button" class="btn btn-info mt-3">投稿する</button>
            </div>
          </div>

          <!-- 投稿記事 -->
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <div class="text-start">
                <img src="images_src/animalface_neko.png" class="img-fluid" alt="img-fluid" style="width: 50px;">
                hacchi さん
                </div>
                <div class="text-end">
                19:31:11
                <button type="button" class="btn-sm btn-outline-secondary">削除</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center mb-3">
                <img src="images/90555661621ac7c3c949a5.38810188.jpg" class="img-fluid w-50" alt="img-fluid">
              </div>
              <p class="card-text">自慢の家の猫です♪</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <script src="./dist/app.js"></script>
  </body>
</html>