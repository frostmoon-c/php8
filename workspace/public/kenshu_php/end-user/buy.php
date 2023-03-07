<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/end-user/end-user.php';
$total = '0';
$error = '';

if (isset($_POST)) {
    $buyId = $_POST['resultId'];
    $resultNum = $_POST['resultNumber'];

    $selectSql = 'SELECT * FROM products2 WHERE status = 1 AND id in ('.(implode(',', $buyId)).') ORDER BY id';
    $selectQuery = pg_query($connect, $selectSql);

    try {
        if ($selectQuery) {
            $dataArray = pg_fetch_all($selectQuery);
        }
		foreach ($dataArray as $data => $val):

			$id = $val['id'];
			$productName = $val['name'];
			$price = $val['price'];
			$image = $val['image'];
			$date = date('Y-m-d H:i:s');
			$number = $resultNum[$data];
			$insertSql = 'INSERT INTO buylist(productid,name,price,image,userid,date,number)VALUES('.$id.','."'$productName'".','.$price.','."'$image'".','.$userId.','."'$date'".','.$number.')';
			$insertQuery = pg_query($connect, $insertSql);

			if (!$insertQuery) {
				throw new Exception('登録処理中にエラーが発生しました');
			}
		endforeach;


    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
} else {
    header('Location:./shoppinglist');
}


try {
    $resultSql = "SELECT * FROM buylist WHERE userid = "."'$userId'"." AND date ="."'$date'"." ORDER BY productid";

    $resultQuery = pg_query($connect, $resultSql);
    $resultArray = pg_fetch_all($resultQuery);
    foreach ($resultArray as $resultdata):

	endforeach;

    if (!$resultQuery) {
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
	<title>購入完了</title>
</head>
<body>
	<h1>購入商品一覧</h1>
	<p>以下の商品を購入しました</p>


		<table border="1" style="margin: auto;">

		<br>
		<br>
			<tr>
				<th>商品ID</th>
				<th>商品名</th>
				<th>価格</th>
				<th>商品画像</th>
				<th>個数</th>

			</tr>
			<?php foreach ($resultArray as $resultdata):?>
			<?php //if ($numberArray):?>

				<tr style="text-align: center;">
					<td><?= $resultdata['productid']; ?></td>
					<td><?= $resultdata['name']; ?></td>
					<td><?= $resultdata['price']; ?>円</td>
					<?php  $total += ($resultdata['price'] * $resultdata['number']); ?>
					<td>
						<img src="data:image/jpg;base64,<?php $img = base64_encode(file_get_contents($resultdata['image'])); echo $img; ?>">
					</td>
					<td><?= $resultdata['number']; ?>個</td>
				</tr>
			<?php //endif;?>
			<?php endforeach; ?>
		</table>
		<p>合計金額：<?= $total; ?>円</p>


			<a href="./shoppinglist">商品一覧に戻る</a>
			<br>
			<a href="./mypage">マイページに戻る</a>
			<br>
			<a href="../logout">ログアウトする</a>
</body>