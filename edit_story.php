<?php
include('funcs.php');
$pdo = db_conn();

// GETリクエストからIDを取得
$id = $_GET['id'];

// データ取得
$sql = "SELECT * FROM stories WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC); // 編集するデータを取得
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ストーリー編集</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="file"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        img {
            margin-top: 10px;
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>ストーリー編集</h1>
    <form method="post" action="update_story.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'], ENT_QUOTES) ?>">
        
        <label for="display_order">表示順序:</label>
        <input type="text" id="display_order" name="display_order" value="<?= htmlspecialchars($row['display_order'], ENT_QUOTES) ?>">
        
        <label for="story_image">ストーリー画像:</label>
        <input type="file" id="story_image" name="story_image">
        <?php if (!empty($row['story_image'])): ?>
            現在の画像: <img src="uploads/<?= htmlspecialchars($row['story_image'], ENT_QUOTES) ?>" alt="ストーリー画像"><br>
        <?php endif; ?>
        
        <label for="speech_image">スピーチ画像:</label>
        <input type="file" id="speech_image" name="speech_image">
        <?php if (!empty($row['speech_image'])): ?>
            現在の画像: <img src="uploads/<?= htmlspecialchars($row['speech_image'], ENT_QUOTES) ?>" alt="スピーチ画像"><br>
        <?php endif; ?>

        <label for="other_image">その他画像:</label>
        <input type="file" id="other_image" name="other_image">
        <?php if (!empty($row['other_image'])): ?>
            現在の画像: <img src="uploads/<?= htmlspecialchars($row['other_image'], ENT_QUOTES) ?>" alt="その他画像"><br>
        <?php endif; ?>

        <input type="submit" value="更新">
    </form>
</body>
</html>
