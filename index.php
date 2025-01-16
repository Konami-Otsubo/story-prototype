<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>野菜とストーリー登録管理</title>
  <style>
    body {
      background-image: url('img/haikei2.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .container {
      max-width: 1100px;
      margin: 20px auto;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      margin-top: 0;
      font-size: 1.5em;
      text-align: center;
    }

    .form-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      align-items: flex-end;
      justify-content: space-between;
    }

    .form-container label {
      display: block;
      font-size: 0.9em;
    }

    input, textarea, button {
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1em;
      width: 100%;
      box-sizing: border-box;
    }

    input[type="file"] {
      padding: 3px;
    }

    button {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      width: auto;
      padding: 10px 20px;
    }

    button:hover {
      background-color: #45a049;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    td img {
      max-width: 100px;
      height: auto;
      border-radius: 10px;
    }

    .form-section {
      margin-bottom: 40px;
    }

    .form-row {
      display: flex;
      flex: 1;
      gap: 15px;
    }

    .form-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .button-container {
      text-align: right;
    }
  </style>
</head>
<body>
<div class="container form-section">
  <!-- 野菜登録フォーム -->
  <h2>野菜登録フォーム</h2>
  <form id="vegForm" method="POST" action="insert_veg.php" enctype="multipart/form-data">
    <div class="form-container">
      <div class="form-group">
        <label>名前：</label>
        <input type="text" name="name" required>
      </div>
      <div class="form-group">
        <label>トップ画像：</label>
        <input type="file" name="top_image" required>
      </div>
      <div class="button-container">
        <button type="submit">保存</button>
      </div>
    </div>
  </form>
</div>

<div class="container form-section">
  <!-- 野菜一覧表示 -->
  <h2>登録済み野菜</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>トップ画像</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include('funcs.php');
      $pdo = db_conn();

      $sql = 'SELECT * FROM vegetables';
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($result as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td><img src="uploads/' . htmlspecialchars($row['top_image']) . '" alt="' . htmlspecialchars($row['name']) . '"></td>';
        echo '<td>
                <a href="edit_vegetable.php?id=' . htmlspecialchars($row['id']) . '">編集</a> |
                <a href="delete.php?id=' . htmlspecialchars($row['id']) . '">削除</a>
              </td>';
        echo '</tr>';
      }
      ?>
    </tbody>
  </table>
</div>

<div class="container form-section">
  <h2>ストーリー登録フォーム</h2>
  <form id="storyForm" method="POST" action="insert_story.php" enctype="multipart/form-data">
  <div class="form-container">
    <div class="form-group">
      <label>野菜のID：</label>
      <select name="vegetable_id" required>
        <option value="" disabled selected>選択してください</option>
        <?php
        $sql = 'SELECT id, name FROM vegetables';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $vegetables = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($vegetables as $veg) {
            echo '<option value="' . htmlspecialchars($veg['id']) . '">' . htmlspecialchars($veg['name']) . '</option>';
        }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>表示順序（複数）：</label>
      <input type="number" name="display_order[]" required>
    </div>
    <div class="form-group">
      <label>ストーリー画像：</label>
      <input type="file" name="story_image[]" multiple required>
    </div>
    <div class="form-group">
      <label>スピーチ画像（任意）：</label>
      <input type="file" name="speech_image[]" multiple>
    </div>
    <div class="form-group">
      <label>その他画像（昆虫など、任意）：</label>
      <input type="file" name="other_image[]" multiple>
    </div>
    <button type="submit">保存</button>
  </div>
</form>

</div>

<div class="container">
  <h2>登録済みストーリー</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>野菜ID</th>
        <th>表示順序</th>
        <th>ストーリー画像</th>
        <th>スピーチ画像</th>
        <th>その他画像</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = 'SELECT * FROM stories';
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($result as $row) {
          echo '<tr>';
          echo '<td>' . htmlspecialchars($row['id']) . '</td>';
          echo '<td>' . htmlspecialchars($row['vegetable_id']) . '</td>';
          echo '<td>' . htmlspecialchars($row['display_order']) . '</td>';
          echo '<td><img src="uploads/' . htmlspecialchars($row['story_image']) . '" alt="ストーリー画像"></td>';
          echo '<td>';
          if ($row['speech_image']) {
              echo '<img src="uploads/' . htmlspecialchars($row['speech_image']) . '" alt="スピーチ画像">';
          } else {
              echo 'なし';
          }
          echo '</td>';
          echo '<td>';
          if ($row['other_image']) {
              echo '<img src="uploads/' . htmlspecialchars($row['other_image']) . '" alt="その他画像">';
          } else {
              echo 'なし';
          }
          echo '</td>';
          echo '<td>
                <a href="edit_story.php?id=' . htmlspecialchars($row['id']) . '">編集</a> |
                <a href="delete_story.php?id=' . htmlspecialchars($row['id']) . '">削除</a>
              </td>';
          echo '</tr>';
      }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
