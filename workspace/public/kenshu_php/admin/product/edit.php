<?php
require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';

$id = $_POST['id'];//一覧からpostされたid
$sql = "SELECT * FROM products2 WHERE id = '$id';";
$query = pg_query($connect, $sql);
$error = '';

try {
    if ($query) {
        $max = pg_num_rows($query);
        $dataArray = pg_fetch_all($query);
        if ($max < 1) {
            $error = 'エラーが発生しました';
        }
    }

    foreach ($dataArray as $data):

        if ($id === $data['id']) {
            $productName = $data['name'];
            $price = $data['price'];
            //$image = $data['image'];;
            $img = base64_encode(file_get_contents($data['image']));
        }
    endforeach;
} catch (PDOException $e) {
    $error = $e->getMessage(); //開発中はエラーの詳細表示させる
//$error="データベース処理中にエラーが発生しました";
}

if (isset($_POST['productName'])) {
    try {
        if (empty($_FILES['image']['tmp_name'])) {
            $path =$data['image'];
        } else {
            $img_size = getimagesize($_FILES['image']['tmp_name']);
            $regexp = '^image\/(?:gif|png|jpeg)$';
            $mime = $img_size['mime'];
			 //ファイルが選択されていれば$imageにファイル名を代入
			 $file = uniqid(mt_rand(), true); //ファイル名をユニーク化
			 $file .= '.'.substr(strrchr($_FILES['image']['name'], '.'), 1); //アップロードされたファイルの拡張子を取得
			 $path = '/var/www/public/assets/image/products/'.$file;
			 move_uploaded_file($_FILES['image']['tmp_name'], $path); //imagesディレクトリにファイル保存
        }

        if (!preg_match("/$regexp/", $mime)) {
            throw new Exception('画像ファイルではありません');
        }

        $newProductName = xssEscape($_POST['productName']);
        $newPrice = (int) $_POST['price'];

        $selectSql = "SELECT * FROM products2 WHERE name = '$productName';";
        $selectQuery = pg_query($connect, $selectSql);

        // if ($selectQuery) {
        //     $dataArray = pg_fetch_all($query);
        //     foreach ($checkArray as $check):

		// 		if (!$check['id'] === $data['id']) {
		// 			$alert = "<script type='text/javascript'>alert('同一商品名が登録されています');</script>";
        //         echo $alert;
		// 		header('Location: ./error');
		// 		}else{
		// 			$name = $data['name'];
		// 		}
		// 	endforeach;

            $updateSql = "UPDATE products2 SET (name,price,image,userid) = ('$newProductName','$newPrice','$path','$userId') WHERE id = '$id';";
            // var_dump($updateSql);
            // exit;
            $updateQuery = pg_query($connect, $updateSql);
            $_SESSION['productName'] = $newProductName;
            $_SESSION['price'] = $newPrice;
            $_SESSION['image'] = $path;
            header('Location: ./edit-confirm');
            if (!$updateQuery) {
                throw new Exception('データベース処理中にエラーが発生しました');
            }
        //}
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
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
	<title>商品編集ページ</title>
</head>
<body>
<h1>商品編集</h1>
	<form method="post" id="product_form" name= "product_form" enctype="multipart/form-data">

		<table class="table table-info table-striped table-hover">


			<tr>
				<th class="registration col-md-5" style="text-align: right;">商品名</th>
				<td>
					<input type="text" name="productName" id="productName" placeholder="必須" class="col-md-4" value=<?= $productName; ?>>
					<span id="productName-error" style="display: none;"><em>商品名を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">価格</th>
				<td>
					<input type="text" name="price" id="price" placeholder="必須" class="col-md-4" value=<?= $price; ?>>
					<span id="price-error" style="display: none;"><em>価格を入力してください</em></span>
					<span id="price-error2" style="display: none;"><em>正しい形式で価格を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">商品画像</th>
				<td>
					<p>現在の画像</p>
				<img src="data:image/jpg;base64,<?php echo $img; ?>">
				<br>
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
		<input type="hidden" name="id" value=<?= $_POST['id']; ?>>
	</form>


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