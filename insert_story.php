<?php
include('funcs.php');
$pdo = db_conn();

// POSTデータ取得
$vegetable_id = $_POST['vegetable_id'];
$display_orders = $_POST['display_order'];
$story_images = $_FILES['story_image'];
$speech_images = $_FILES['speech_image'];
$other_images = $_FILES['other_image']; // その他画像の取得

// アップロードフォルダ設定
$upload_dir = "uploads/";

// ストーリー画像、スピーチ画像、その他画像をループで処理
for ($i = 0; $i < count($story_images['name']); $i++) {
    $story_image_name = basename($story_images['name'][$i]);
    $story_image_tmp = $story_images['tmp_name'][$i];
    $speech_image_name = !empty($speech_images['name'][$i]) ? basename($speech_images['name'][$i]) : null;
    $speech_image_tmp = !empty($speech_images['tmp_name'][$i]) ? $speech_images['tmp_name'][$i] : null;

    // その他画像処理（任意）
    $other_image_name = !empty($other_images['name'][$i]) ? basename($other_images['name'][$i]) : null;
    $other_image_tmp = !empty($other_images['tmp_name'][$i]) ? $other_images['tmp_name'][$i] : null;

    // ストーリー画像アップロード
    if (!empty($story_image_tmp) && move_uploaded_file($story_image_tmp, $upload_dir . $story_image_name)) {
        $story_image_path = $story_image_name;
    } else {
        echo "ストーリー画像のアップロードに失敗しました: " . $story_images['name'][$i];
        exit();
    }

    // スピーチ画像アップロード（任意）
    $speech_image_path = null; // デフォルトはnull
    if (!empty($speech_image_tmp) && move_uploaded_file($speech_image_tmp, $upload_dir . $speech_image_name)) {
        $speech_image_path = $speech_image_name;
    }

    // その他画像アップロード（任意）
    $other_image_path = null; // デフォルトはnull
    if (!empty($other_image_tmp) && move_uploaded_file($other_image_tmp, $upload_dir . $other_image_name)) {
        $other_image_path = $other_image_name;
    }

    // SQL文
    $sql = "INSERT INTO stories (vegetable_id, display_order, story_image, speech_image, other_image)
            VALUES (:vegetable_id, :display_order, :story_image, :speech_image, :other_image)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':vegetable_id', $vegetable_id, PDO::PARAM_INT);
    $stmt->bindValue(':display_order', $display_orders[$i], PDO::PARAM_INT);
    $stmt->bindValue(':story_image', $story_image_path, PDO::PARAM_STR);
    $stmt->bindValue(':speech_image', $speech_image_path, PDO::PARAM_STR);
    $stmt->bindValue(':other_image', $other_image_path, PDO::PARAM_STR);

    // SQL実行
    if (!$stmt->execute()) {
        sql_error($stmt);
    }
}

// 登録完了後リダイレクト
redirect('index.php');
?>
