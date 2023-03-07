<?php
session_start();
require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = array();
	if (!$_POST['userId']) {
		$error['userId'] = 'ユーザーIDを入力してください';
	}
	if (!$_POST['pass']) {
		$error['pass'] = 'パスワードを入力してください';
	}
	if (count($error) == 0) {
		try {
			$userId =(int)xssEscape($_POST['userId']);
			$password = xssEscape($_POST['pass']);
			$_SESSION['userId'] = $userId;
			$sql = "SELECT * FROM endusers WHERE id = ".$userId ." AND pass = "."'$password'"." LIMIT 1";
			$query = pg_query($connect, $sql);

			// $data = pg_fetch_assoc($query);

			// if ($query) {
			//     $dataArray = pg_fetch_all($query);
			//     foreach ($dataArray as $data):

			//     if ($data['id'] === $userId && $data['pass'] === $password) {
			//         header('Location: ./mypage');
			//     } else {
			//         header('Location: ./login');
			//         $alert = "<script type='text/javascript'>alert('ユーザーIDとパスワードに誤りがあります。');</script>";
			//         echo $alert;
			//     }

			//     endforeach;
			// }

			if ($query) {
				$max = pg_num_rows($query);
				// var_dump($max);
				// exit;
				if ($max > 0) {
					header('Location: ./mypage');
				} else {
					$error['missMatch'] = 'ユーザーIDとパスワードに誤りがあります。';
				}
			}
		} catch (PDOException $e) {
			$error['exception'] = $e->getMessage(); //開発中はエラーの詳細表示させる
		//$error="データベース処理中にエラーが発生しました";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/style.css">
	<title>購入者ログイン</title>
</head>
<body>
	<h1>ログイン情報を入力してください</h1>
	<form method="post" id="loginForm">
		<label for="userId" style="margin-left: 11px;">ユーザID：</label>
		<input type="text" name="userId" id="userId">
		<?php if(isset($error['userId'])) { ?>
			<span id="userId-error"><em><?= $error['userId']; ?></em></span>
		<?php } ?>
		<br>
		<label for="pass">パスワード：</label>
		<input type="password" name="pass" id="pass">
		<?php if(isset($error['pass'])) { ?>
		<span id="pass-error"><em><?= $error['pass']; ?></em></span>
		<?php } ?>
		<br>
		<?php if(isset($error['missMatch'])) { ?>
			<span id="error"><em><?= $error['missMatch']; ?></em></span><br>
		<?php } ?>
		<br>
		<input type="submit" name="check" class="check" value="ログイン">
	</form>
	<br>
	<a href="./new-user/regist">新規登録はこちら</a>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	//$('.check').click(function () {
		function clickBtn1(){
		// エラーメッセージ非表示
		// $('#userId-error').hide();
		// $('#pass-error').hide();


		// var successFlg = true;

		// var userId = $('#userId').val();
		// if (!userId) {
		// 	$('#userId-error').show();
		// 	successFlg = false;
		// }

		// var pass = $('#pass').val();
		// if (!pass) {
		// 	$('#pass-error').show();
		// 	successFlg = false;
		// }

		// if (successFlg) {

		// $('#loginForm').submit();

		// }

	};
</script>
</html>