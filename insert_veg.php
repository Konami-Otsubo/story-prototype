<?php
include('funcs.php');
$pdo = db_conn();

// POSTデータ取得
$name = $_POST['name'];

// 画像アップロード
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (!empty($_FILES["top_image"]["name"])) {
    $target_file = $target_dir . basename($_FILES["top_image"]["name"]);
    if (move_uploaded_file($_FILES["top_image"]["tmp_name"], $target_file)) {
        $top_image_path = basename($_FILES["top_image"]["name"]);
    } else {
        echo "画像のアップロードに失敗しました。";
        exit();
    }
} else {
    echo "トップ画像は必須です。";
    exit();
}

// SQL文を準備
$sql = "INSERT INTO vegetables (name, top_image) VALUES (:name, :top_image)";
$stmt = $pdo->prepare($sql);

// バインド変数に値を割り当て
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':top_image', $top_image_path, PDO::PARAM_STR);

// SQL実行
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
} else {
    header('Location: index.php');
    exit();
}
?>
