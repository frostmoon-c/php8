<?php
$max = 5; //コンテンツの最大数

require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';
$userId = $seller['id'];

$sql = 'SELECT * FROM products2 WHERE status = 1 ORDER BY id';
$query = pg_query($connect, $sql);

    try {
        if ($query) {
            $dataArray = pg_fetch_all($query);
        }

        foreach ($dataArray as $data):

        endforeach;
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }

    $dataSum = count($dataArray);
    // var_dump($dataSum);
    // echo "<br><br>";
    // var_dump($data);
    // echo "<br><br>";

    $max_page = ceil($dataSum / $max); // トータルページ数※ceilは小数点を切り捨てる関数

    if (!isset($_GET['page'])) { // $_GET['page_id'] はURLに渡された現在のページ数
        $page = 1; // 設定されてない場合は1ページ目にする
    } else {
        $page = $_GET['page'];
    }

    $start = $max * ($page - 1); //スタートするページを取得
  $view_page = array_slice($dataArray, $start, $max, true);
  //var_dump($view_page); //表示するページを取得

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ページネーション</title>
</head>
<body>
	<h1>ページネーションサンプル</h1>

		<table border="1">
			<tr>
				<th>商品ID</th>
				<th>商品名</th>
				<th>価格</th>
				<th>商品画像</th>
				<th>登録者</th>
				<th>編集・削除</th>
			</tr>
			<?php foreach ($view_page as $data):?>
				<form method="post" id="product_form" name= "product_form">
				<tr style="text-align: center;">
					<td><?= $data['id']; ?></td>
					<td><?= $data['name']; ?></td>
					<td><?= $data['price']; ?>円</td>
					<td>
						<img src="data:image/jpg;base64,<?php $img = base64_encode(file_get_contents($data['image'])); echo $img; ?>">
					</td>
					<td><?= $seller['name']; ?></td>
					<td>
						<input type="submit" class="check" id="edit" name="edit" value="編集">
						<br>
						<input type="submit" class="check" name="delete" value="削除">
						<input type="hidden" name="id" value=<?= $data['id']; ?>>
					</td>
				</tr>
				</form>
			<?php endforeach; ?>
		</table>
              <!-- ページ移動 -->
      <?php  if ($page > 1): ?>
      <a href="pagenation.php?page=<?php echo ($page-1); ?>">前のページへ</a>
    <?php endif; ?>
    <?php  if ($page < $max_page): ?>
      <a href="pagenation.php?page=<?php echo ($page+1); ?>">次のページへ</a>
    <?php endif; ?>


</body>
</html>