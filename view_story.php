<?php
session_start();
include('funcs.php');

$pdo = db_conn();

// GETパラメータからスタートIDを取得
$start_id = isset($_GET['start_id']) ? (int)$_GET['start_id'] : 1;

// 該当するID範囲のストーリーを取得
$stmt = $pdo->prepare("SELECT * FROM stories WHERE id BETWEEN :start_id AND :end_id ORDER BY display_order ASC");
$stmt->bindValue(':start_id', $start_id, PDO::PARAM_INT);
$stmt->bindValue(':end_id', $start_id + 4, PDO::PARAM_INT);
$stmt->execute();
$stories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$stories) {
    echo "<p>ストーリーが見つかりません。</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ストーリー</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f5f5f5;
      overflow: hidden;
    }

    .story-container {
      position: relative;
      text-align: center;
    }

    .story-image {
      max-width: 75%;
      height: auto;
    }

    .speech-image {
      position: absolute;
      top: 45%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 50%;
      height: auto;
    }

    .other-image {
      position: absolute;
      width: 50px; /* テントウムシの幅 */
      height: auto;
      z-index: 10;
      pointer-events: none;
      top: 30%; /* スピーチ画像の少し上 */
      left: 50%;
      transform: translate(-50%, -50%);
      animation: float 7s ease-in-out infinite; /* フロートアニメーションを適用 */
    }

    /* アニメーション定義 */
    @keyframes float {
      0% {
        transform: translate(-50%, -50%) translate(0px, 0px); /* 初期位置 */
      }
      25% {
        transform: translate(-50%, -50%) translate(-10px, -10px); /* 左上に移動 */
      }
      50% {
        transform: translate(-50%, -50%) translate(10px, 10px); /* 右下に移動 */
      }
      75% {
        transform: translate(-50%, -50%) translate(-10px, 10px); /* 左下に移動 */
      }
      100% {
        transform: translate(-50%, -50%) translate(0px, 0px); /* 元の位置に戻る */
      }
    }

    .button-container {
      position: absolute;
      top: 85%; 
      left: 50%;
      transform: translateX(-50%);
      display: none;
    }

    .button-image {
      width: 200px;
      height: auto;
      cursor: pointer;
    }

    .next-button-container {
      position: absolute;
      top: 20%;
      left: 50%;
      transform: translateX(-50%);
      display: none;
    }

    .next-button-image {
      width: 200px;
      height: auto;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="story-container">
    <img id="storyImage" src="" alt="ストーリー画像" class="story-image">
    <img id="speechImage" src="" alt="スピーチ画像" class="speech-image" style="display: none;">
    <img id="otherImage" src="" alt="その他画像" class="other-image" style="display: none;">

    <!-- ボタン -->
    <div id="buttonContainer" class="button-container">
      <a href="view_top.php">
        <img src="img/back_to_top_button.png" alt="はじめにもどるボタン" class="button-image">
      </a>
    </div>

    <div id="nextButtonContainer" class="next-button-container">
      <a href="view_story_top.php?start_id=<?php echo $start_id + 5; ?>">
        <img src="img/next_story_button.png" alt="つぎにすすむボタン" class="next-button-image">
      </a>
    </div>
  </div>

  <script>
  const stories = <?php echo json_encode($stories); ?>;
  const storyImage = document.getElementById('storyImage');
  const speechImage = document.getElementById('speechImage');
  const otherImage = document.getElementById('otherImage');
  const buttonContainer = document.getElementById('buttonContainer');
  const nextButtonContainer = document.getElementById('nextButtonContainer');

  let currentIndex = 0;

  function showStory() {
    const story = stories[currentIndex];
    storyImage.src = `uploads/${story.story_image}`;
    
    if (story.speech_image) {
        speechImage.src = `uploads/${story.speech_image}`;
        speechImage.style.display = 'block';
    } else {
        speechImage.style.display = 'none';
    }

    if (story.other_image) {
        otherImage.src = `uploads/${story.other_image}`;
        otherImage.style.display = 'block';
    } else {
        otherImage.style.display = 'none';
    }

    // ボタン表示の条件追加
    if (currentIndex === stories.length - 1) {
        setTimeout(() => {
            buttonContainer.style.display = 'block';
            
            // 表示順序が30の場合は「つぎにすすむ」ボタンを非表示
            if (story.display_order === 30) {
                nextButtonContainer.style.display = 'none';
            } else {
                nextButtonContainer.style.display = 'block';
            }

            otherImage.style.display = 'none'; // 最後にテントウムシを非表示
        }, 10000);
    } else {
        buttonContainer.style.display = 'none';
        nextButtonContainer.style.display = 'none';
    }

    currentIndex++;
    if (currentIndex < stories.length) {
        setTimeout(showStory, 10000);
    }
}

  // 初期化処理
  showStory();
  </script>
</body>
</html>
