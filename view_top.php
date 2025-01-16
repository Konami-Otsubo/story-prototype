<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップ画像表示</title>
   
    <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f5f5f5;
    }

    .top-container {
      position: relative;
      text-align: center;
    }

    .top-image {
      max-width: 70%;
      height: auto;
      display: block;
      margin: 0 auto;
    }

    .button-container {
      position: absolute;
      top: 80%; /* 画像内の「畑友ストーリー」の文字の下に配置 */
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }

    .button-image {
      width: 200px; /* ボタンの幅を調整 */
      height: auto;
      cursor: pointer;
    }
  </style>
</head>

<body>
    <div class="top-container">
        <!-- トップ画像 -->
        <img src="uploads/1_tamana_top.png" alt="トップ画像" class="top-image">

        <!-- ボタン -->
        <div class="button-container">
      <!-- ログインボタン -->
      <a href="view_log_in.php">
        <img src="img/login_button.png" alt="ログインボタン" class="button-image">
      </a>
      <!-- 新規登録ボタン -->
      <a href="sign_up.php">
        <img src="img/sign_up_button.png" alt="新規登録ボタン" class="button-image">
      </a>
    </div>
  </div>
</body>
</html>