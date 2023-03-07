<?php
session_start();

$userName=$_SESSION['userName'];
$msg=$_SESSION['msg'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<p><?=$msg?></p>
	<p><?=$userName?>さん</p>
	<hr>
	<a href="sessionIn.php">入力画面に戻る</a>
</body>
</html>