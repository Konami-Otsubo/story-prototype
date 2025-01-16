<?php
include('funcs.php');
$pdo = db_conn();

// POSTデータ取得
$id = $_POST['id'];
$display_order = $_POST['display_order'];

// アップロードフォルダ
$upload_dir = "uploads/";

// ストーリー画像アップロード処理
if (!empty($_FILES['story_image']['name'])) {
    $story_image = basename($_FILES['story_image']['name']);
    move_uploaded_file($_FILES['story_image']['tmp_name'], $upload_dir . $story_image);
} else {
    $story_image = null; // 新しい画像がアップロードされていない場合
}

// スピーチ画像アップロード処理
if (!empty($_FILES['speech_image']['name'])) {
    $speech_image = basename($_FILES['speech_image']['name']);
    move_uploaded_file($_FILES['speech_image']['tmp_name'], $upload_dir . $speech_image);
} else {
    $speech_image = null; // 新しい画像がアップロードされていない場合
}

// その他画像アップロード処理
if (!empty($_FILES['other_image']['name'])) {
    $other_image = basename($_FILES['other_image']['name']);
    move_uploaded_file($_FILES['other_image']['tmp_name'], $upload_dir . $other_image);
} else {
    $other_image = null; // 新しい画像がアップロードされていない場合
}

// SQL文
$sql = "UPDATE stories SET 
            display_order = :display_order,
            story_image = IFNULL(:story_image, story_image),
            speech_image = IFNULL(:speech_image, speech_image),
            other_image = IFNULL(:other_image, other_image)
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':display_order', $display_order, PDO::PARAM_INT);
$stmt->bindValue(':story_image', $story_image, PDO::PARAM_STR);
$stmt->bindValue(':speech_image', $speech_image, PDO::PARAM_STR);
$stmt->bindValue(':other_image', $other_image, PDO::PARAM_STR);

// SQL実行
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
} else {
    redirect('index.php');
}
?>
