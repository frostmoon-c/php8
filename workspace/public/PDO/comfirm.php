<?php
 session_start();//セッション管理の開始（セッション変数の利用）
 //不正な経路によるアクセスのチェック
 if(!isset($_POST['itemName'])|| !isset($_POST['price'])){
	header('Location: insert.php');
	exit();
 }
 //フォームからのデータをそれぞれ取得
 $itemName=$_POST['itemName'];
 $price=$_POST['price'];
 //データが未入力かどうかのチェック
 if($itemName==="" || $price===""){
	header('Location : insert.php');
	exit();
 }
 //セッション変数にデータを登録（他のプログラムとデータを共有）
 $_SESSION['itemName']=$itemName;
 $_SESSION['price']=$price;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>データ登録（確認）</title>
</head>
<body>
	<p>以下のデータを登録しますか？</p>
	<table border="1">
		<tr>
			<th>商品名</th>
			<th>価格</th>
			<tr>
				<td><?=$itemName ?></td>
				<td><?=$price ?></td>
			</tr>
		</tr>
	</table>
 	<br>
	<a href="save.php">登録</a>
	<a href="insert.php">取消</a>
</body>
</html>