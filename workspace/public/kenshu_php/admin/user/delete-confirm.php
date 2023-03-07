<?php

$id = $_POST["id"];
require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';
$sql = "SELECT * FROM products2 WHERE id = '$id';";

$query = pg_query($connect, $sql);
$error = '';

try {
    if ($query) {
        $max = pg_num_rows($query);
        $dataArray = pg_fetch_all($query);
        if ($max < 1) {
            $error = "エラーが発生しました";
        }
    }

    foreach ($dataArray as $data):

		if ($id === $data['id']) {
			$deleteId = $data['id'];
            $productName = $data['name'];
			$price = $data['price'];
			//$image = $data['image'];
			//$img = base64_encode(file_get_contents($data['image']));
			$img = base64_encode(file_get_contents($data['image']));
        }
    endforeach;

	$_SESSION['productName'] = $productName;
        $_SESSION['price'] = $price;
        $_SESSION['image'] = $img;
} catch (PDOException $e) {
    $error = $e->getMessage(); //開発中はエラーの詳細表示させる
//$error="データベース処理中にエラーが発生しました";
}


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
	<title>商品削除</title>
</head>
<body>
		<h1>商品削除</h1>
		<h2>以下のデータを削除してよろしいですか？</h2>
		<table border="1" style="margin: auto;">
			<form action="delete" method="post">
			<tr>
				<th>商品id</th>
				<th>商品名</th>
				<th>価格</th>
				<th>商品画像</th>
				<th>登録者</th>
				<tr>
					<td><?=$deleteId; ?></td>
					<td><?=$productName; ?></td>
					<td><?=$price; ?></td>
					<td><img src="data:image/jpg;base64,<?php echo $img; ?>"></td>
					<td><?=$seller['name']; ?></td>
				</tr>
			</tr>
		</table>
		<br>
		<input type="submit" name="check" class="check" value="削除">
		<input type="hidden" name="id" value=<?= $deleteId; ?>>
		</form>
		<hr>
		<a href="regist">商品登録画面に戻る</a>
        <br>
        <a href="list">商品一覧へ</a>
</body>
</html>