<?php
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/end-user/end-user.php';
if (empty($_SESSION['userId'])) {
    header('Location: ./login');
}

$error = '';
$name = $endUser['name'];
$tel = $endUser['tel'];
$mail = $endUser['mail'];

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
	<title>お問い合わせ</title>
</head>

<html>

<body>
	<h1>お問い合わせ</h1>
	<h2>ようこそ、<?=$name; ?>さん</h2>
	<br>
	<form action="confirm" method="post" id="contactForm">

		<table class="table table-info table-striped table-hover">
			<tr>
				<th class="col-md-4" style="text-align: right;">氏名</th>
				<td>
					<input type="text" name="name" id="name" placeholder="必須" class="col-md-4" value="<?=$name; ?>">
					<span id="name-error" style="display: none;"><em>名前を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="col-md-4"style="text-align: right;">電話番号</th>
				<td>
					<input type="text" name="tel" id="tel" placeholder="必須" class="col-md-4" value="<?=$tel; ?>">
					<span id="tel-error" style="display: none;"><em>電話番号を入力してください</em></span>
					<span id="tel-error2" style="display: none;"><em>正しい形式で電話番号を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="col-md-4"style="text-align: right;">メールアドレス</th>
				<td>
					<input type="text" name="mail" id="mail" placeholder="必須" class="col-md-4" value="<?=$mail; ?>">
					<span id="mail-error" style="display: none;"><em>メールアドレスを入力してください</em></span>
					<span id="mail-error2" style="display: none;"><em>正しい形式でメールアドレスを入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="col-md-4"style="text-align: right;">ご住所</th>
				<td>

						&#12306;<input type="text" name="zip1" id="zip1" class="col-md-2"> - <input type="text"
							name="zip2" class="col-md-2" id="zip2">
						<em class="form_notice1">郵便番号を入力すると、自動で都道府県と市町村郡が表示されます。</em><br>
						<label>都道府県<input type="text" name="pref" id="pref"></label><br>
						<label>市区町村<input type="text" name="city" id="city"></label><br>
						<label class="flex">番地<input type="text" name="add" id="add"class="add flex"></label>
						<span id="zip1-error" style="display: none;"><em>郵便番号1を入力してください</em></span>
						<br>
						<span id="zip2-error" style="display: none;"><em>郵便番号2を入力してください</em></span>
				</td>
			<tr>


			<tr>
				<th class="col-md-4"style="text-align: right;">問い合わせ内容</th>
				<td>
					<textarea type="text" name="msg" id="msg" placeholder="必須" rows="4" cols="50" class="col-md-8"
						value=""></textarea>
					<br>
					<span id="msg-error" style="display: none;"><em>問い合わせ内容を入力してください</em></span>
				</td>
			</tr>

		</table>

		<input type="button" class="check" value="確認">
		<br>
		<a href="../mypage.php">ユーザーマイページに戻る</a>
		<br>
		<a href="../../logout">ログアウト</a>

	</form>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$('.check').click(function () {
		// エラーメッセージ非表示
		$('#name-error').hide();
		$('#tel-error').hide();
		$('#tel-error2').hide();
		$('#mail-error').hide();
		$('#mail-error2').hide();
		$('#msg-error').hide();

		var successFlg = true;

		var name = $('#name').val();
		if (!name) {
			$('#name-error').show();
			successFlg = false;
		}

		var tel = $('#tel').val();
		var tel_pattern = /^(0{1}\d{9,10})$/;
		if (!tel) {
			$('#tel-error').show();
			successFlg = false;
		} else if (!tel.match(tel_pattern)) {
			$('#tel-error').hide();
			$('#tel-error2').show();
			successFlg = false;
		}

		var mail = $('#mail').val();
		var mail_pattern = /^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
		if (!mail) {
			$('#mail-error').show();
			successFlg = false;
		}
		else if (!mail.match(mail_pattern)) {
			$('#mail-error').hide();
			$('#mail-error2').show();
			successFlg = false;
		}

		var zip1 = $('#zip1').val();
		if (!zip1) {
			$('#zip1-error').show();
			successFlg = false;
		}

		var zip2 = $('#zip2').val();
		if (!zip2) {
			$('#zip2-error').show();
			successFlg = false;
		}


		var msg = $('#msg').val();
		if (!msg) {
			$('#msg-error').show();
			successFlg = false;
		}

		if (successFlg) {
			Swal.fire({
				title: '確認',
				text: "送信してよろしいですか？",
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'OK',
				cancelButtonText: '閉じる'
			}).then((result) => {
				if (result.isConfirmed) {
					$('#contactForm').submit();
				}
			})
		}

	});
</script>

<script>
	$(function () {
		$('#zip1').jpostal({
			postcode: [
				'#zip1',
				'#zip2'
			],
			address: {
				'#pref': '%3',
				'#city': '%4',
				'#add': '%5'
			}
		});
	});
</script>


</html>