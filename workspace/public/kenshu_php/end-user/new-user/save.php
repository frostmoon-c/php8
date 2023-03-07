<?php

require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';

session_start();
$err = '';
$error = array();

 //セッション変数から値を取得
 $newUserName = $_SESSION['user_name'];
 $newTel = $_SESSION['tel'];
 $newMail = $_SESSION['mail'];
 $newPass = $_SESSION['pass'];

 $date = date('Y-m-d');
 //プレースホルダーを利用したSQL文の定義

	try {
		$insertSql = "INSERT INTO endusers(name,regist_date,tel,mail,pass)VALUES('$newUserName','$date','$newTel','$newMail','$newPass')";
		$insertQuery = pg_query($connect, $insertSql);

		if (!$insertQuery) {
			throw new Exception('データベース処理エラー');
		}

		$sql = "SELECT * FROM endusers WHERE tel = "."'$newTel'"."LIMIT 1";
		$query = pg_query($connect, $sql);
		$setArray = pg_fetch_all($query);
		foreach ($setArray as $set):
		endforeach;

		if (!$query) {
			throw new Exception('データベース処理エラー');
		}

	} catch (PDOException $e) {
		$err = $e->getMessage();
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/style.css">
	<style>
		body{
			font-family: 'Kaisei Opti', serif;
		}
	</style>
	<title>ユーザー登録（完了）</title>
</head>
<body>
	<?php if ($err !== ''):?>
		<p><?=$err; ?></p>
	<?php else :?>
		<h1>以下のデータを登録しました</h1>
		<table class="table table-info table-striped table-hover">
			<tr>
				<th class="registration col-md-6" style="text-align: right;">氏名</th>
				<td><?=$newUserName; ?></td>
			</tr>

			<tr>
				<th class="registration col-md-6" style="text-align: right;">電話番号</th>
				<td><?=$newTel; ?></td>
			</tr>

			<tr>
				<th class="registration col-md-6" style="text-align: right;">メールアドレス</th>
				<td><?=$newMail; ?></td>
			</tr>

			<tr>
				<th class="registration col-md-6" style="text-align: right;">パスワード</th>
				<td><?=$newPass; ?></td>
			</tr>

		</table>

		<p>ユーザーIDは<?= $set['id']; ?>です</p>
		<?php endif; ?>
		<hr>
		<br>
		<a href="../../top">トップに戻る</a>
</body>
</html>