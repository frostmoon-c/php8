<?php
 session_start();
 require_once('functions.php');
 $error="";
 //セッション変数から値を取得
 $itemName=$_SESSION['itemName'];
 $price=$_SESSION['price'];
 //プレースホルダーを利用したSQL文の定義
 const SQL ="INSERT INTO products VALUES(?,?)";
 try{
	$pdo=getDb();
	$stm=$pdo->prepare(SQL);
	//プレーホルダーに実際の値を代入
	$stm->bindValue(1,$itemName);
	$stm->bindValue(2,$price);
	$stm->execute();
	$pdo=null;
 }catch(PDOException $e){
	$error="データ登録中にエラーが発生しました";
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>データ登録（完了）</title>
</head>
<body>
	<?php if($error!==""):?>
		<p><?=$error?></p>
	<?php else :?>
		<p>以下のデータを登録しました</p>
		<table border="1">
			<tr>
				<th>商品名</th>
				<th>価格</th>
				<tr>
					<td><?=$itemName?></td>
					<td><?=$price?></td>
				</tr>
			</tr>
		</table>
		<?php endif; ?>
		<hr>
		<a href="top.php">メイン画面に戻る</a>
</body>
</html>