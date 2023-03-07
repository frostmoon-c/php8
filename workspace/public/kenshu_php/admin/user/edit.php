<?php
require_once '/var/www/public/kenshu_php/functions.php';
require_once '/var/www/public/kenshu_php/connect.php';
require_once '/var/www/public/kenshu_php/admin/sellers-user.php';


$id = $_POST['id'];//一覧からpostされたid
$sql = "SELECT * FROM endusers WHERE id = '$id';";
$query = pg_query($connect, $sql);
$error = array();

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
            $userName = $data['name'];
			$registDate = $data['regist_date'];
            $tel = $data['tel'];
			$mail = $data['mail'];
            $pass = $data['pass'];
			$delete = $data['delete_at'];
        }
    endforeach;
} catch (PDOException $e) {
    $error = $e->getMessage(); //開発中はエラーの詳細表示させる
//$error="データベース処理中にエラーが発生しました";
}

if (isset($_POST['userName'])) {
    try {
		//if(empty()){}

        $newUserName = xssEscape($_POST['userName']);
        $newRegistDate = xssEscape($_POST['registDate']);
		$newTel = xssEscape($_POST['tel']);
		$newMail = xssEscape($_POST['mail']);
		$newPass = xssEscape($_POST['pass']);
		$newDeleteDate = xssEscape($_POST['delete']);



        $selectSql = "SELECT * FROM endusers WHERE NOT id =".$id;
        $selectQuery = pg_query($connect, $selectSql);





		if (!$selectQuery) {
            throw new Exception('データベース処理エラー');
        }
		$checkArray = pg_fetch_all($selectQuery);

        foreach ($checkArray as $check):
		if ($newTel === $check['tel']) {
			$error['tel'] = '電話番号が登録済みです';
		}
		if ($newMail === $check['mail']) {
			$error['mail'] = 'メールアドレスが登録済みです';
		}
   		endforeach;



		   if (count($error) == 0) {
			if($newDeleteDate === ''){
				$updateSql = "UPDATE endusers SET (name,regist_date,tel,mail,pass,delete_at) = ('$newUserName',TO_DATE('$newRegistDate','YY-MM-DD'),'$newTel','$newMail','$newPass','NULL') WHERE id = '$id';";
			}else{
			$updateSql = "UPDATE endusers SET (name,regist_date,tel,mail,pass,delete_at) = ('$newUserName',TO_DATE('$newRegistDate','YY-MM-DD'),'$newTel','$newMail','$newPass',TO_DATE
			}

            $updateQuery = pg_query($connect, $updateSql);

		$_SESSION['userName'] = $newUserName;
		$_SESSION['registDate'] = $newRegistDate;
		$_SESSION['tel'] = $newTel;
		$_SESSION['mail'] = $newMail;
		$_SESSION['pass'] = $newPass;
		$_SESSION['delete'] = $newDeleteDate;


		header('Location: ./edit-confirm');

		}

		if (!$updateQuery) {
            throw new Exception('データベース処理エラー');
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
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
	<title>顧客データ編集ページ</title>
</head>
<body>
<h1>顧客データ編集</h1>
	<form method="post" id="user_form" name= "user_form">

		<table class="table table-info table-striped table-hover">


			<tr>
				<th class="registration col-md-5" style="text-align: right;">名前</th>
				<td>
					<input type="text" name="userName" id="userName" placeholder="必須" class="col-md-4" value=<?= $userName; ?>>
					<span id="userName-error" style="display: none;"><em>名前を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">登録日</th>
				<td>
					<input type="text" name="registDate" id="registDate" placeholder="必須" class="col-md-4" value=<?= $registDate; ?>>
					<span id="registDate-error" style="display: none;"><em>登録日を入力してください</em></span>
					<span id="registDate-error2" style="display: none;"><em>正しい形式で登録日を入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">電話番号</th>
				<td>
					<input type="text" name="tel" id="tel" placeholder="必須" class="col-md-4" value=<?= $tel; ?>>
					<span id="tel-error" style="display: none;"><em>電話番号を入力してください</em></span>
					<span id="tel-error2" style="display: none;"><em>正しい形式で電話番号を入力してください</em></span>
					<?php if (isset($error['tel'])) { ?>
					<span id="pass-error"><em><?= $error['tel']; ?></em></span>
					<?php } ?>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">メールアドレス</th>
				<td>
					<input type="text" name="mail" id="mail" placeholder="必須" class="col-md-4" value=<?= $mail; ?>>
					<span id="mail-error" style="display: none;"><em>メールアドレスを入力してください</em></span>
					<span id="mail-error2" style="display: none;"><em>正しい形式でメールアドレスを入力してください</em></span>
					<?php if(isset($error['mail'])) { ?>
					<span id="pass-error"><em><?= $error['mail']; ?></em></span>
					<?php } ?>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">パスワード</th>
				<td>
					<input type="text" name="pass" id="pass" placeholder="必須" class="col-md-4" value=<?= $pass; ?>>
					<span id="pass-error" style="display: none;"><em>パスワードを入力してください</em></span>
				</td>
			</tr>

			<tr>
				<th class="registration col-md-4" style="text-align: right;">削除日</th>
				<td>
				<input type="text" name="delete" id="delete" placeholder="" class="col-md-4" value=<?= $delete; ?>>
				<span id="delete-error" style="display: none;"><em>削除日を入力してください</em></span>
				<span id="delete-error2" style="display: none;"><em>正しい形式で削除日を入力してください</em></span>
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
		$('#userName-error').hide();
		$('#registDate-error').hide();
		$('#registDate-error2').hide();
		$('#tel-error').hide();
		$('#tel-error2').hide();
		$('#mail-error').hide();
		$('#mail-error2').hide();
		$('#pass-error').hide();
		$('#delete-error').hide();
		$('#delete-error2').hide();


		var successFlg = true;

		var userName = $('#userName').val();
		if (!userName) {
			$('#userName-error').show();
			successFlg = false;
		}

		var registDate = $('#registDate').val();
		var registDate_pattern = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
		if (!registDate) {
			$('#registDate-error').show();
			successFlg = false;
		} else if (!registDate.match(registDate_pattern)) {
			$('#registDate-error').hide();
			$('#registDate-error2').show();
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


		if (successFlg) {

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
					$('#user_form').submit();
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

C:\Users\admin\Documents\docker-samples\php8\workspace\public\kenshu_php\admin\product\delete-confirm.php