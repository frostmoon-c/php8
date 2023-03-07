<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>データ登録</title>
</head>
<body>
	<h1>登録するデータの入力</h1>
	<form action="comfirm.php" method="post">
		<p>商品名：<input type="text" name="itemName" required></p>
		<p>価格：<input type="number" name="price" required></p>
		<input type="submit" value="登録">
	</form>
	<br>
	<a href="top.php">メイン画面に戻る</a>
</body>
</html>