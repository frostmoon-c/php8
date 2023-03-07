<?php
session_start();

//セッション変数の中身を空にする
$_SESSION = array();


//サーバ側のセッションを破棄
session_destroy();

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
	<title>ログアウト</title>
</head>
<body>
	<p>ログアウトしました</p>
	<a href="./top">topページに戻る</a>
</body>
</html>