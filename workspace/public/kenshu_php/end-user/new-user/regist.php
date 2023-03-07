<?php

require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';
session_start();
$error = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = xssEscape($_POST['user_name']);
    $tel = xssEscape($_POST['tel']);
    $mail = xssEscape($_POST['mail']);
    $pass = xssEscape($_POST['pass']);

    try {
        $selectSql = 'SELECT * FROM endusers';
        $selectQuery = pg_query($connect, $selectSql);

        if (!$selectQuery) {
            throw new Exception('データベース処理エラー');
        }

        $dataArray = pg_fetch_all($selectQuery);

        foreach ($dataArray as $data):
			if ($tel === $data['tel']) {
				$error['tel'] = '電話番号が登録済みです';
			}
			if ($mail === $data['mail']) {
				$error['mail'] = 'メールアドレスが登録済みです';
			}
   		endforeach;

        if (count($error) == 0) {
            $_SESSION['user_name'] = $user_name;
            $_SESSION['tel'] = $tel;
            $_SESSION['mail'] = $mail;
            $_SESSION['pass'] = $pass;

            header('Location: confirm');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
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
	<title>新規登録画面</title>
</head>
<body>
	<h1>新規登録</h1>
	<form method="post" id="registrationForm">

		<table class="table table-info table-striped table-hover">


			<tr>
				<th class="registration col-md-5" style="text-align: right;">氏名</th>
				<td>
					<input type="text" name="user_name" id="user_name" placeholder="必須" class="col-md-4" value="">
					<span id="name-error" style="display: none;"><em>名前を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-5" style="text-align: right;">電話番号</th>
				<td>
					<input type="text" name="tel" id="tel" placeholder="必須" class="col-md-4" value="">
					<span id="tel-error" style="display: none;"><em>電話番号を入力してください</em></span>
					<span id="tel-error2" style="display: none;"><em>正しい形式で電話番号を入力してください</em></span>
					<?php if (isset($error['tel'])) { ?>
					<span id="pass-error"><em><?= $error['tel']; ?></em></span>
					<?php } ?>

				</td>
			</tr>

			<tr>
				<th class="registration col-md-5" style="text-align: right;">メールアドレス</th>
				<td>
					<input type="text" name="mail" id="mail" placeholder="必須" class="col-md-4" value="">
					<span id="mail-error" style="display: none;"><em>メールアドレスを入力してください</em></span>
					<span id="mail-error2" style="display: none;"><em>正しい形式でメールアドレスを入力してください</em></span>
					<?php if(isset($error['mail'])) { ?>
					<span id="pass-error"><em><?= $error['mail']; ?></em></span>
					<?php } ?>
				</td>
			</tr>

			<tr>
				<th class="col-md-5" style="text-align: right;">パスワード</th>
				<td>
					<input type="text" name="pass" id="pass" placeholder="必須" class="col-md-4" value="">
					<span id="pass-error" style="display: none;"><em>パスワードを入力してください</em></span>
				</td>
			</tr>

		</table>
		<input type="button" class="check" value="確認">
	</form>


</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$('.check').click(function () {
		// エラーメッセージ非表示
		$('#name-error').hide();
		$('#tel-error').hide();
		$('#tel-error2').hide();
		$('#mail-error').hide();
		$('#mail-error2').hide();
		$('#id-error').hide();
		$('#pass-error').hide();

		var successFlg = true;

		var name = $('#user_name').val();
		if (!user_name) {
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

		var pass = $('#pass').val();
		if (!pass) {
			$('#pass-error').show();
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
					$('#registrationForm').submit();
				}
			})
		}

	});

</script>



</html>