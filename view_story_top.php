<?php
session_start();
include('funcs.php');

$pdo = db_conn();

// GETパラメータでスタートIDを受け取る（デフォルトは1）
$start_id = isset($_GET['start_id']) ? (int)$_GET['start_id'] : 1;

// 該当する野菜のストーリートップ画像を取得
$stmt = $pdo->prepare("SELECT * FROM stories WHERE id = :start_id");
$stmt->bindValue(':start_id', $start_id, PDO::PARAM_INT);
$stmt->execute();
$story = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$story) {
    echo "<p>ストーリートップ画像が見つかりません。</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ストーリートップ</title>
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

    .story-top-container {
      position: relative;
      text-align: center;
    }

    .story-image {
      max-width: 80%;
      height: auto;
      display: block;
      margin: 0 auto;
    }

    .button-container {
      position: absolute;
      top: 90%; 
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .button-image {
      width: 200px;
      height: auto;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="story-top-container">
    <img src="uploads/<?php echo htmlspecialchars($story['story_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="ストーリートップ画像" class="story-image">

    <!-- はじめるボタン -->
    <div class="button-container">
      <a href="view_story.php?start_id=<?php echo $start_id + 1; ?>">
        <img src="img/get_started_button.png" alt="はじめるボタン" class="button-image">
      </a>
    </div>
  </div>
</body>
</html>

