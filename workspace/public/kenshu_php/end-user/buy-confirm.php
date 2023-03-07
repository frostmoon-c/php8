<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/end-user/end-user.php';



$idArray = $_POST['selectId'];
$numberArray = $_POST['selectNumber'];
$buyId = [];//購入されたIDの配列
$total = "0";



for ($i = 0; $i < count($numberArray); ++$i) {
    if ($numberArray[$i] > 0) {
        $buyId[] = $idArray[$i];
		$buyNum[] = $numberArray[$i];
    }
}


//(implode(",", $buyId))//IDの分割
$selectSql = "SELECT * FROM products2 WHERE status = 1 AND id in (" .(implode(",", $buyId)). ") ORDER BY id";

$query = pg_query($connect, $selectSql);

    try {
        if ($query) {
            $dataArray = pg_fetch_all($query);
        }
        foreach ($dataArray as $data):
        endforeach;
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
	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<title>購入確認</title>
</head>
<body>
	<h1>カート内商品一覧</h1>
	<p>以下の商品を購入してよろしいですか？</p>
	<form action="buy" method="post">
		<table border="1" style="margin: auto;">
			<input type="submit" value="購入" >
				<br>
				<br>
			<tr>
				<th>商品ID</th>
				<th>商品名</th>
				<th>単価</th>
				<th>商品画像</th>
				<th>個数</th>
				<th>金額</th>
			</tr>
			<?php foreach ($dataArray as $data=>$val):?>
			<?php //if ($numberArray):?>
				<tr style="text-align: center;">
					<td><?= $val['id']; ?></td>
					<td><?= $val['name']; ?></td>
					<td><?= $val['price']; ?>円</td>
					<td>
						<img src="data:image/jpg;base64,<?php $img = base64_encode(file_get_contents($val['image'])); echo $img; ?>">
					</td>
					<td><?= $buyNum[$data];?>個</td>
					<td><?= $val['price']*$buyNum[$data];?>円</td>

					<?php  $total+=($val['price']*$buyNum[$data]); ?>
				</tr>
				<input type="hidden" name="resultId[]" value=<?= $val['id']; ?>>
				<input type="hidden" name="resultNumber[]" value=<?= $buyNum[$data]; ?>>
			<?php //endif; ?>
			<?php endforeach; ?>
		</table>
		</form>
		<p>合計金額：<?= $total ?>円</p>
			<a href="./shoppinglist">商品一覧に戻る</a>
			<br>
			<a href="./mypage">マイページに戻る</a>
			<br>
			<a href="../logout">ログアウトする</a>
</body>