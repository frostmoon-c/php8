<?php
    require_once 'functions.php';

    if (!isset($_POST['keyword']) || $_POST['keyword'] === '') {
        header('Location: keyword.php');
        exit();
    }
    $keyword = $_POST['keyword'];
    $error = '';

    //データが未定のときはプレースホルダ「？」を利用する
    const SQL = 'SELECT * FROM products WHERE item_name LIKE ?';

    try {
        $pdo = getDb();
        $stm = $pdo->prepare(SQL);
        $stm->bindValue(1, '%'.$keyword.'%');
        $stm->execute();
        $records = $stm->fetchAll(PDO::FETCH_ASSOC);
        $count = $stm->rowCount();
        $pdo = null;
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
	<title>検索</title>
</head>
<body>
	<a href="keyword.php">キーワード検索入力画面に戻る</a>
	<?php if ($error !== ''):?>
		<p><?=$error; ?></p>
		<?php else:?>
			<h1>検索キーワード【<?=$keyword; ?>】</h1>
			<hr>
			<?php if ($count === 0):?>
			<p>該当する商品はありませんでした</p>
			<?php else:?>
				<p><?=$count; ?>件該当する商品が検索されました</p>
				<table border="1">
					<tr>
						<th>商品名</th>
						<th>価格</th>
					</tr>
					<?php foreach ($records as $record):?>
						<tr>
							<td><?= xss($record['item_name']); ?></td>
							<td><?= $record['price']; ?>円</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php endif; ?>
		<?php endif; ?>
</body>
</html>