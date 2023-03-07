<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';
$productName = $_SESSION['productName'];
$price = $_SESSION['price'];
$image = $_SESSION['image'];
$userId = $_SESSION['userId'];

$img = base64_encode(file_get_contents($image));

$error = '';

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
	<title>データ登録（完了）</title>
</head>
<body>

		<p>以下のデータを登録しました</p>
		<table border="1" style="margin: auto;">
			<tr>
				<th>商品名</th>
				<th>価格</th>
				<th>商品画像</th>
				<th>登録者</th>
				<tr>
					<td><?=$productName; ?></td>
					<td><?=$price; ?>円</td>
					<td><img src="data:image/jpg;base64,<?php echo $img; ?>"></td>
					<td><?=$name; ?></td>
				</tr>
			</tr>
		</table>
		<hr>
		<a href="regist">商品登録画面に戻る</a>
        <br>
        <a href="list">商品一覧へ</a>
		<br>
        <a href="../../logout">ログアウト</a>

</body>
</html>