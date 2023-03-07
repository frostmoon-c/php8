
<?php

require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';

$name = $seller['name'];

if (isset($_POST['productName'])) {
    try {
        if (!isset($_FILES['image'])) {
            throw new Exception('画像データがありません');
        }
        $directoryPath = '/var/www/public/assets/image/products/'; //フォルダがあるか確認

        if (!file_exists($directoryPath)) {
            if (!mkdir($directoryPath, 0777)) {
                throw new Exception('ディレクトリの作成に失敗しました。');
            }
        }

        //ディレクトリが存在or作成に成功したら
        $img_size = getimagesize($_FILES['image']['tmp_name']);
        $regexp = '^image\/(?:gif|png|jpeg)$';
        $mime = $img_size['mime'];

        if (empty($_FILES['image']['tmp_name'])) {
            throw new Exception('画像データがありません');
        }

        if (!preg_match("/$regexp/", $mime)) {
            throw new Exception('画像ファイルではありません');
        }

        //ファイルが選択されていれば$imageにファイル名を代入
        $file = uniqid(mt_rand(), true); //ファイル名をユニーク化
        $file .= '.'.substr(strrchr($_FILES['image']['name'], '.'), 1); //アップロードされたファイルの拡張子を取得
        $path = '/var/www/public/assets/image/products/'.$file;
        move_uploaded_file($_FILES['image']['tmp_name'], $path); //imagesディレクトリにファイル保存

        $productName = xssEscape($_POST['productName']);
        $price = (int) $_POST['price'];
        $userId = $_SESSION['userId'];

        $insertSql = "INSERT INTO products2(name,price,image,userid,status)VALUES('$productName','$price','$path','$userId',1);";
        $insertQuery = pg_query($connect, $insertSql);
        $_SESSION['productName'] = $productName;
        $_SESSION['price'] = $price;
        $_SESSION['image'] = $path;
        header('Location: ./regist-confirm');
        if (!$insertQuery) {
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/style.css">
	<style>
		body{
			font-family: 'Kaisei Opti', serif;
		}
	</style>
	<title>商品新規登録画面</title>

</head>
<body>
	<h1>商品新規登録</h1>
	<h2>ログインユーザー：<?=$name?></h2>
	<form  method="post" id="product_form" name= "product_form" enctype="multipart/form-data">

		<table class="table table-info table-striped table-hover">


			<tr>
				<th class="registration col-md-5" style="text-align: right;">商品名</th>
				<td>
					<input type="text" name="productName" id="productName" placeholder="必須" class="col-md-4" value="">
					<span id="productName-error" style="display: none;"><em>商品名を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">価格</th>
				<td>
					<input type="text" name="price" id="price" placeholder="必須" class="col-md-4" value="">
					<span id="price-error" style="display: none;"><em>価格を入力してください</em></span>
					<span id="price-error2" style="display: none;"><em>正しい形式で価格を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">商品画像</th>
				<td>
					<input type="file" name="image" id="image" class="col-md-4" accept='image/*' onchange="previewImage(this);">
					<span id="image-error" style="display: none;"><em>商品画像を設定してください</em></span>
					<p>プレビュー画像:
						<br>
						<div id="previewArea" style="display:none;">
						<img id="preview" src="" style="max-width:200px;">
						</div>
					</p>
				</td>
			</tr>
		</table>

		<input type="button" name="check" class="check" value="確認">
	</form>
        <a href="list">商品一覧へ</a>
		<a href="../../logout">ログアウト</a>
</body>


</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$('.check').click(function () {
		// エラーメッセージ非表示
		$('#productName-error').hide();
		$('#price-error').hide();
		$('#price-error2').hide();
		$('#image-error').hide();

		var successFlg = true;

		var productName = $('#productName').val();
		if (!productName) {
			$('#productName-error').show();
			successFlg = false;
		}

		var price = $('#price').val();
		var price_pattern = /^(\d{3,6})$/;
		if (!price) {
			$('#price-error').show();
			successFlg = false;
		} else if (!price.match(price_pattern)) {
			$('#price-error').hide();
			$('#price-error2').show();
			successFlg = false;
		}

		var image = $('#image').val();
		if (!image) {
			$('#image-error').show();
			successFlg = false;
		}

		if (successFlg) {
		//var productName=document.getElementById('productName').value;
		//var price=document.getElementById('price').value;
		//var image=document.getElementById('image').value;

			Swal.fire({

				title: '確認',
				text:"送信してよろしいですか？",
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'OK',
				cancelButtonText: '閉じる'
			}).then((result) => {
				if (result.isConfirmed) {
					$('#product_form').submit();
				}
			})
		}

	});

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