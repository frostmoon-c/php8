<?php
session_start();

$userId=$_SESSION['userId'];

$name = $_POST['name'];
if ($name === '') {
    $resultName = '未入力';
} else {
    $resultName = "{$name}";
}

$tel = $_POST['tel'];
if ($tel === '') {
    $resultTel = '未入力';
} else {
    $resultTel = "{$tel}";
}

$mail = $_POST['mail'];
if ($mail === '') {
    $resultMail = '未入力';
} else {
    $resultMail = "{$mail}";
}

$add = $_POST['add'];
$pref = $_POST['pref'];
$city = $_POST['city'];
$zip1 = $_POST['zip1'];
$zip2 = $_POST['zip2'];

if ($zip1 === '' || $zip2 === '') {
    $resultAdd = '未入力';
} else {
    $resultAdd = "{$pref}{$city}{$add}";
}
$msg = $_POST['msg'];
if ($msg === '') {
    $resultMsg = '未入力';
} else {
    $resultMsg = "{$msg}";
}

$date=date("Y-m-d");

try{

require_once '/var/www/public/kenshu_php/connect.php';
$sql = "INSERT INTO contacts(user_id,user_name,tel,mail,date,msg)VALUES('$userId','$resultName','$resultTel','$resultMail','$date','$resultMsg')";
$query = pg_query($connect, $sql);
$error = '';
}catch(PDOException $e){

	echo $e->getMessage();

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
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/style.css">
	<style>
		body{
			font-family: 'Kaisei Opti', serif;
		}
	</style>
	<title>お問合わせ内容確認</title>
</head>

<html>

<body>
	<h1>お問合わせ内容確認</h1>
	<br>
	<table class="table table-info table-striped table-hover" id="shoppinglist">
			<tr>
				<th class="col-md-6" style="text-align: right;">氏名</th>
				<td><?= $resultName; ?></td>
			</tr>

			<tr>
				<th class="col-md-6"style="text-align: right;">電話番号</th>
				<td><?= $resultTel; ?></td>
			</tr>

			<tr>
				<th class="col-md-6"style="text-align: right;">メールアドレス</th>
				<td><?= $resultMail; ?></td>
			</tr>

			<tr>
				<th class="col-md-6"style="text-align: right;">住所</th>
				<td><?= $resultAdd; ?></td>
			</tr>

			<tr>
				<th class="col-md-6"style="text-align: right;">問い合わせ内容</th>
				<td><p style="max-width: 500px;"><?= $resultMsg; ?></p></td>
			</tr>

	</table>

	<a href="contact">問い合わせ入力画面に戻る</a>
	<br>
	<a href="../mypage.php">ユーザーマイページに戻る</a>
	<br>
	<a href="../../logout">ログアウト</a>

</body>

</html>