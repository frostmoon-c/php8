<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/end-user/end-user.php';

$error = '';

try {
    $sql = "SELECT * FROM buylist WHERE userid = "."'$userId'"." ORDER BY date";

    $query = pg_query($connect, $sql);
    $dataArray = pg_fetch_all($query);
    foreach ($dataArray as $data):

	endforeach;

    if (!$query) {
        throw new Exception('履歴検索処理中にエラーが発生しました');
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<title>購入履歴</title>
</head>
<body>
	<h1>購入履歴</h1>
	<p>以下の商品を購入しました</p>


		<table border="1" style="margin: auto;">

		<br>
		<br>
			<tr>
				<th>購入日</th>
				<th>商品ID</th>
				<th>商品名</th>
				<th>金額</th>
				<th>商品画像</th>
				<th>個数</th>

			</tr>
			<?php foreach ($dataArray as $data):?>
			<?php //if ($numberArray):?>

				<tr style="text-align: center;">
					<td><?= $data['date']; ?></td>
					<td><?= $data['productid']; ?></td>
					<td><?= $data['name']; ?></td>
					<td><?= $data['price']; ?>円</td>
					<td>
						<img src="data:image/jpg;base64,<?php $img = base64_encode(file_get_contents($data['image'])); echo $img; ?>">
					</td>
					<td><?= $data['number']; ?>個</td>
				</tr>
			<?php //endif;?>
			<?php endforeach; ?>
		</table>
			<a href="./shoppinglist">商品一覧へ</a>
			<br>
			<a href="./mypage">マイページに戻る</a>
			<br>
			<a href="../logout">ログアウトする</a>
</body>