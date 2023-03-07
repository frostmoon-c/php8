<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';


$error = '';

// try {
//     if ($query) {
//         $max = pg_num_rows($query);
//         $dataArray = pg_fetch_all($query);
//         if ($max < 1) {
//             header('Location: ./login');
//         }
//     }

//     foreach ($dataArray as $data):

//         if ($userId === $data['id']) {
//             $name = $data['name'];
//         }

//     endforeach;
// } catch (PDOException $e) {
//     $error = $e->getMessage(); //開発中はエラーの詳細表示させる
// //$error="データベース処理中にエラーが発生しました";
// }

$name = $seller['name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/style.css">
	<title>管理者マイページ</title>
</head>
<body>
	<h1>管理者マイページ</h1>
	<h2>ようこそ、<?=$name?>さん</h2>
	<a href="product/regist">商品登録ページへ</a>
    <br>
    <a href="product/list">商品一覧ページへ</a>
	<br>
	<a href="./user/list">顧客一覧ページへ</a>
	<br>
	<a href="../logout">ログアウト</a>
</body>
</html>