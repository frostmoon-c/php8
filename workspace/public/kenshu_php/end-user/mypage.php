<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/end-user/end-user.php';

$userId = $_SESSION['userId'];


$sql = "SELECT * FROM endusers WHERE id =". "$userId";
$error = '';

$name = $endUser['name'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/style.css">
	<title>ユーザーマイページ</title>
</head>
<body>
	<h1>ユーザーマイページ</h1>
	<h2>ようこそ、<?=$name; ?>さん</h2>
	<a href="./contact/contact">お問い合わせページへ</a>
	<br>
	<a href="./shoppinglist">購入ページへ</a>
	<br>
	<a href="./buylist">購入履歴ページへ</a>
	<br>
	<a href="../logout">ログアウト</a>
</body>
</html>