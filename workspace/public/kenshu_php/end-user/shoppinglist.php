<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/end-user/end-user.php';

$selectSql = 'SELECT * FROM products2 WHERE status = 1 ORDER BY id';
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
	<title>商品購入ページ</title>
</head>
<body>
<div id="page_top">
	<h1>商品一覧</h1>
	<p>購入商品を選択してカートへを押してください。</p>
	<br>
	<br>
	<form action="buy-confirm" method="post">
		<table border="1" style="margin: auto;">
		<input type="submit" value="カートへ" >
		<br>
		<br>
			<tr>
				<th>商品ID</th>
				<th>商品名</th>
				<th>価格</th>
				<th>商品画像</th>
				<th>購入</th>
			</tr>
			<?php foreach ($dataArray as $key=>$data):?>
				<tr>
					<td style="text-align: center;"><?= $data['id']; ?></td>
					<td style="text-align: center;"><?= $data['name']; ?></td>
					<td style="text-align: center;"><?= $data['price']; ?>円</td>
					<td style="text-align: center;">
						<img src="data:image/jpg;base64,<?php $img = base64_encode(file_get_contents($data['image'])); echo $img; ?>">
					</td>
					<td style="text-align: center;">
					<select name="selectNumber[]">
							<option value="0">-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
						<input type="hidden" name="selectId[]" value=<?= $data['id']; ?>>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		</form>
		<a href="#page_top" class="page_top_btn">トップへ戻る</a>
		<br>
		<a class="pagetop" href="#"><div class="pagetop__arrow"></div></a>
		<br>
		<a href="./mypage">マイページに戻る</a>
		<br>
		<a href="../logout">ログアウトする</a>
</body>