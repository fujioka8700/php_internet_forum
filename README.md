# 成果物
https://www.dogcat.space

<br>

# 準備
## なぜこのようなことをしたのか
以前からLaravelやdockerを触っていたのですが、上手く扱えている気がしていませんでした。

それ以前にLinuxやCLIに慣れた方がいいのでは？と思い、Linuxを積極的に使うことにしました。

あとLinuxを触ると同時に、AWSの基本も理解しようと、デプロイ先はAWSにしました。

## 目的
以下の基本を理解し、CLI操作を慣れる。
- Linux
- Apache
- MariaDB
- PHP
- AWS

## 開発環境
- Ubuntu 20.04.4 LTS
- Apache 2.4.41
- MariaDB 10.3.34
- PHP 7.4.3

## 「犬・猫 どちら派掲示板」を作ろうと思った理由
大好きな犬と猫のことを、語り合える場を作りたかったから。

<br>

# 要件定義
頭の中のイメージをノートに書きます。
これがないと、何を作ればいいか全くわかりません。重要です。

## 各々ページの設計図
<img width="400" alt="TOP画面の設計図" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/493c0504-248a-b389-6088-319c86b8a981.jpeg">

<img width="400" alt="ログイン画面、会員登録画面の設計図" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/5bb795c7-9cf1-feeb-652e-202f7103dc57.jpeg">

<br>

## 画面遷移図
<img width="400" alt="画面遷移図" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/e17a912a-21ac-0831-caf8-23df3b7c6976.jpeg">

<br>

## ER図
書き出したイメージの図から、どういったデータベースが必要か書き出します。
投稿者と投稿記事のデータが保存できればいいので、以下のように作ります。

<img width="400" alt="ER図" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/629321bd-5663-caef-d1d4-7b7df617c5ea.jpeg">

<br>

# 成果物の詳細

## 本番環境
- Amazon Linux 2
- Apache 2.4.52
- MariaDB 10.3.34
- PHP 7.4.28

## AWSアーキテクチャ
Route53とApplicationLoadBalancerで、独自ドメインとSSL/TLSに対応させました。
投稿者と投稿記事のデータはRDSに保存しています。
毎日1回バックアップを取るようにし、1週間前までデータを復元できるようにしています。

<img width="500" alt="AWSアーキテクチャ" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/52fd6013-7460-8866-2147-0becf2f3b36c.jpeg">

<br>

## 作成したテーブル

### members
|カラム名|データ型、オプション|説明|
|---|---|:---:|
|id|INT PRIMARY KEY AUTO_INCREMENT|投稿者ID|
|name|VARCHAR(30)|名前|
|email|VARCHAR(50) UNIQUE|Eメールアドレス|
|password|VARCHAR(255)|パスワード|
|animal|VARCHAR(10)|犬派か？猫派か？|

### posts
|カラム名|データ型、オプション|説明|
|---|---|:---:|
|id|INT PRIMARY KEY AUTO_INCREMENT|投稿記事ID|
|message|TEXT|記事内容|
|created_by|INT FOREIGN KEY (created_by) REFERENCES members(id)|投稿者ID（FK）|
|created|DATETIME|作成日時|
|image|VARCHAR(100)|画像ファイル名|

<br>

# 各々ページ紹介

## TOP画面
<img width="400" alt="TOP画面" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/639a3d75-9432-9175-fa33-7d27bf7a131e.jpeg">

<br>

## 会員登録画面
<img width="400" alt="会員登録画面" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/f4226b2b-8208-b81a-1cc1-1803bd0ba6da.jpeg">

バリデーションで、誤入力を防ぎます。

<img width="400" alt="バリデーション" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/2f25a086-97b3-1e52-7578-cd62b885378e.jpeg">

<br>

## ログイン後、記事を投稿できます。

<img width="400" alt="ログイン" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/ccfda9f8-3eb2-13d5-f31a-da05dfa05777.jpeg">

↓ログイン

<img width="400" alt="記事の投稿" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/f264e602-59d7-6917-1521-aa7aadd64ea3.jpeg">

<br>

## 投稿者自身の記事のみ削除できます。
<img width="400" alt="記事の削除前" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/95bdc470-4ce7-ce11-84c1-892d03da75d7.jpeg">

↓「削除」ボタンを押す。

<img width="400" alt="" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/1a8158b7-b190-39fa-9f1a-d08967e556c8.jpeg">

<br>

## ページング
<img width="400" alt="2ページ目" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/da14f748-c63d-3401-11a3-f6ec1257751e.jpeg">

<br>

## CSRF対策

なりすましの送信を防ぎます。

<img width="400" alt="CSRF対策" src="https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/968572/3619dee9-55b3-ebc4-f7bf-da8b1ba98a22.jpeg">

<br>

# まとめ
成果物をデプロイできた時には、当初の目的のLinuxのCLIに慣れるという目的は達成できました。

AWSを触り始めた時は、VPC?サブネットマスク??というネットワークの基礎もよくわかっていませんでしたが、今では理解できました。

今後はLaravelを使い、作業を効率化します。
