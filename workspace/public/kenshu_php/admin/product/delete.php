
<?php

require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';



if (isset($_POST['id'])) {
    try {
        //物理削除
        // $deleteId = $_POST['id'];
        // $deleteSql = 'DELETE FROM products2 WHERE id ='.$deleteId;
        // $deleteQuery = pg_query($connect, $deleteSql);

        //論理削除
        $deleteId = $_POST['id'];
        $deleteSql = "UPDATE products2 set status = "."0"."WHERE id = "."$deleteId";
        $deleteQuery = pg_query($connect, $deleteSql);

        $productName = $_SESSION['productName'];
        $price = $_SESSION['price'];
        $img = $_SESSION['image'];
        // var_dump($productName);
        // exit;

        if (!$deleteQuery) {
            throw new Exception('データベース処理中にエラーが発生しました');
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
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
		<h2>以下のデータを削除しました</h2>
		<table border="1" style="margin: auto;">
			<tr>
				<th>商品id</th>
				<th>商品名</th>
				<th>価格</th>
				<th>商品画像</th>
				<th>登録者</th>
				<tr>
					<td><?= $deleteId; ?></td>
					<td><?= $productName; ?></td>
					<td><?= $price; ?></td>
					<td><img src="data:image/jpg;base64,<?php echo $img; ?>"></td>
					<td><?=$seller['name']; ?></td>
				</tr>
			</tr>
		</table>
		</form>
		<hr>
		<a href="regist">商品登録画面に戻る</a>
        <br>
        <a href="list">商品一覧へ</a>
        <br>
        <a href="../../logout">ログアウト</a>
</body>
</html>