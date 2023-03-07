<?php

require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';
$userId = $seller['id'];
$selectSql = 'SELECT * FROM endusers ORDER BY id';
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
    $max = 5;
    $dataSum = count($dataArray);
    $max_page = ceil($dataSum / $max);
    if (!isset($_GET['page'])) { // $_GET['page'] はURLに渡された現在のページ数
        $page = 1; // 設定されてない場合は1ページ目にする
    } else {
        $page = $_GET['page'];
    }

    $start = $max * ($page - 1); //スタートするページを取得
  $view_page = array_slice($dataArray, $start, $max, true);
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
	<title>顧客一覧</title>
</head>
<body>
	<h1>顧客一覧</h1>

		<table border="1" style="margin: auto;">
			<tr>
				<th>ID</th>
				<th>名前</th>
				<th>登録日</th>
				<th>電話番号</th>
				<th>メールアドレス</th>
				<th>パスワード</th>
				<th>削除日</th>
				<th>編集・削除</th>
			</tr>
			<?php foreach ($view_page as $data):?>
				<form method="post" id="product_form" name= "product_form">
				<tr style="text-align: center;">
					<td><?= $data['id']; ?></td>
					<td><?= $data['name']; ?></td>
					<td><?= $data['regist_date']; ?></td>
					<td><?= $data['tel'];  ?></td>
					<td><?= $data['mail'];  ?></td>
					<td><?= $data['pass'];  ?></td>
					<td><?= $data['delete_at'];  ?></td>
					<td style="text-align: center;">
						<input type="submit" class="check" id="edit" name="edit" value="編集">
						<br>
						<input type="submit" class="check" name="delete" value="削除">
						<input type="hidden" name="id" value=<?= $data['id']; ?>>
					</td>
				</tr>
				</form>
			<?php endforeach; ?>
		</table>
		<?php  if ($page > 1): ?>
      <a href="list.php?page=<?php echo $page - 1; ?>">前のページへ</a>
    <?php endif; ?>
    <?php  if ($page < $max_page): ?>
      <a href="list.php?page=<?php echo $page + 1; ?>">次のページへ</a>
    <?php endif; ?>
	<!-- <a href="#page_top" class="page_top_btn">トップへ戻る</a> -->
		<a class="pagetop" href="#"><div class="pagetop__arrow"></div></a>

			<br>
			<a href="../home">管理者ページに戻る</a>
			<br>
			<a href="../../logout">ログアウトする</a>
</body>
<script>
		window.onload = function () {
    var inps = document.getElementsByTagName("input");
    for (var i = 0 ; i < inps.length ; ++i) {
        if (inps[i].type == "submit") {
            inps[i].onclick = function () {
                    // ★ submit ボタンと、action に指定する URL の対応です
                    var action_map = {
                        "edit" : "edit",
                        "delete" : "delete-confirm",
                    };
                    this.form.action = action_map[this.name];
                };
        }
    }
};


	function previewImage(obj)
	{
		//fileReaderオブジェクトがファイルを読み込むとonloadイベントが呼び出される
		var fileReader = new FileReader();
		fileReader.onload = (function() {
			//読み込んだ結果はfileReaderオブジェクトのresultプロパティにセットされる
			document.getElementById('preview').src = fileReader.result;
			$('#previewArea').show();//ファイルが読み込まれたら表示
		});
		fileReader.readAsDataURL(obj.files[0]);

	}
</script>
</html>