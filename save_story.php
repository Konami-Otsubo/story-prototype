<?php
require_once 'db_connect.php'; // DB接続スクリプトを呼び出し

$title = $_POST['title'];
$vegetable_id = $_POST['vegetable_id'];
$story = $_POST['story'];

$sql = "INSERT INTO stories (title, vegetable_id, story, created_at, updated_at) 
        VALUES (:title, :vegetable_id, :story, NOW(), NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':vegetable_id', $vegetable_id, PDO::PARAM_INT);
$stmt->bindValue(':story', $story, PDO::PARAM_STR);
$stmt->execute();

header('Location: index.php'); // フォームに戻る
?>
