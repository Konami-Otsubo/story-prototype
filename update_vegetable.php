<?php
include('funcs.php');
$pdo = db_conn();

// POSTデータ取得
$id = $_POST['id'];
$name = $_POST['name'];
$upload_dir = "uploads/";
$top_image = null;

// ファイルアップロード処理
if (!empty($_FILES['top_image']['name'])) {
    $top_image = basename($_FILES['top_image']['name']);
    $target_file = $upload_dir . $top_image;

    if (!move_uploaded_file($_FILES['top_image']['tmp_name'], $target_file)) {
        echo "画像のアップロードに失敗しました。";
        exit();
    }
}

// データベース更新
$sql = "UPDATE vegetables SET name = :name, top_image = :top_image WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':top_image', $top_image, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header('Location: index.php');
} else {
    echo "データの更新に失敗しました。";
}
?>
