<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';
$newUserName = $_SESSION['userName'];
$newRegistDate = $_SESSION['registDate'];
$newTel = $_SESSION['tel'];
$newMail = $_SESSION['mail'];
$newPass = $_SESSION['pass'];
$newDeleteDate = $_SESSION['delete'];


$error = '';


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
	<style>
		body{
			font-family: 'Kaisei Opti', serif;
		}
	</style>
	<title>顧客データ編集（完了）</title>
</head>
<body>

		<p>以下のデータを登録しました</p>
		<table border="1" style="margin: auto;">
			<tr>
				<th>名前</th>
				<th>登録日</th>
				<th>電話番号</th>
				<th>メールアドレス</th>
				<th>パスワード</th>
				<th>削除日</th>
				<tr>
					<td><?=$newUserName; ?></td>
					<td><?=$newRegistDate; ?></td>
					<td><?=$newTel; ?></td>
					<td><?=$newMail; ?></td>
					<td><?=$newPass; ?></td>
					<td><?=$newDeleteDate; ?></td>
				</tr>
			</tr>
		</table>
		<hr>
		<a href="./list">顧客データ一覧に戻る</a>
		<br>
		<a href="../home.">マイページに戻る</a>
		<br>
        <a href="../../logout">ログアウト</a>

</body>
</html>