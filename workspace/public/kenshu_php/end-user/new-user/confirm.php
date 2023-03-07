<?php
 session_start();//セッション管理の開始（セッション変数の利用）
//不正な経路によるアクセスのチェック
if(!isset($_SESSION['user_name'])|| !isset($_SESSION['tel'])|| !isset($_SESSION['mail'])|| !isset($_SESSION['pass'])){
	header('Location: ../login');
	exit();
 }

$user_name = $_SESSION['user_name'];
$tel = $_SESSION['tel'];
$mail = $_SESSION['mail'];
$pass = $_SESSION['pass'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/style.css">
	<style>
		body{
			font-family: 'Kaisei Opti', serif;
		}
	</style>
	<title>ユーザー登録（確認）</title>
</head>
<body>
	<h1>以下のデータで登録しますか？</h1>
	<table class="table table-info table-striped table-hover">
		<tr>
		<th class="registration col-md-6" style="text-align: right;">氏名</th>
		<td><?=$user_name ?></td>
		</tr>

		<tr>
		<th class="registration col-md-6" style="text-align: right;">電話番号</th>
		<td><?=$tel ?></td>
		</tr>

		<tr>
		<th class="registration col-md-6" style="text-align: right;">メールアドレス</th>
		<td><?=$mail ?></td>
		</tr>



		<tr>
		<th class="registration col-md-6" style="text-align: right;">パスワード</th>
		<td><?=$pass ?></td>
		</tr>

	</table>
 	<br>
	<a href="save" style="margin: 5px;">登録</a>
	<a href="regist" style="margin: 5px;">取消</a>
</body>
</html>