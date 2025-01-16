<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body class="log-in-background">
  <div class="log-in-container">
    <form action="view_top.php" method="POST" class="input-container">
      <input type="email" name="email" placeholder="メールアドレス" class="input-box" required>
      <input type="password" name="password" placeholder="パスワード" class="input-box" required>

      <div class="button-container">
        <!-- ログインボタン -->
        <a href="view_story_top.php">
          <img src="img/login_button.png" alt="ログインボタン" class="button-image">
        </a>
        <!-- アーカイブボタン -->
        <a href="archive.php">
          <img src="img/archive_button.png" alt="アーカイブボタン" class="button-image">
        </a>
      </div>
    </form>
  </div>
</body>
</html>
