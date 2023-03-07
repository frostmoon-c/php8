<?php
//各種関数が読み込まれているファイルを読みこむ
require_once 'functions.php';
//全レコードを取り出すSQL文
const SQL = 'SELECT * FROM products';
//処理中に発生したエラーメッセージを格納する変数の初期化
$error = '';

try {
    $pdo = getDb(); //PDOの取得
    $stm = $pdo->prepare(SQL); //SQLコンテナにSQL文をセット
    $stm->execute(); //SQL文の実行

    //取得した全レコードを配列recordsに一括保存
    $records=$stm->fetchAll(PDO::FETCH_ASSOC);
    //取得したレコードの件数を変数に保存
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
	<title>データ一覧</title>
</head>
<body>
	<?php if ($error !== '') : ?>
		<p><?=$error; ?></p>
	<?php elseif ($count === 0) : ?>
		<p>データが登録されていません</p>
	<?php else : ?>
				<p>登録データ数：<?=$count; ?></p>
				<table border="1">
					<tr><th>商品名</th><th>価格</th></tr>
					<?php foreach ($records as $record): ?>
						<tr>
							<td><?=xss($record['item_name']); ?></td>
							<td><?= $record['price']; ?>円</td>
						</tr>
					<?php endforeach; ?>
				</table>
	<?php endif; ?>
	<hr>
	<a href="top.php">メイン画面に戻る</a>
</body>
</html>