<?php
include('funcs.php');
$pdo = db_conn();

// IDを取得
$id = $_GET['id'];

// データ取得
$sql = "SELECT * FROM vegetables WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// 編集フォーム
if ($row) {
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>トップ画像編集</title>
</head>
<body>
    <h1>トップ画像編集</h1>
    <form action="update_vegetable.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
        <label>名前:
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>">
        </label><br>
        <label>トップ画像:
            <input type="file" name="top_image">
        </label><br>
        <img src="uploads/<?= htmlspecialchars($row['top_image']) ?>" alt="現在の画像"><br>
        <button type="submit">更新</button>
    </form>
</body>
</html>
<?php
} else {
    echo "データが見つかりませんでした。";
}
?>
