<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (!isset($_POST['upload'])) {
            throw new Exception('画像データがありません');
        }
        $directory_path = './image'; //同じ階層に「image」というフォルダがあるか確認

        if (!file_exists($directory_path)) {
            if (!mkdir($directory_path, 0777)) {
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
      $path = './image/'.$file;
        move_uploaded_file($_FILES['image']['tmp_name'], $path); //imagesディレクトリにファイル保存
        $message = '画像をアップロードしました';
        $connect = pg_connect('host=db port=5432 dbname=postgres user=laravel_user password=laravel_pass');
        $sql = "INSERT INTO images (image) VALUES('$path')";
        $query = pg_query($connect, $sql);
        if (!$query) {
            throw new Exception('画像ファイルではありません');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<h1>画像アップロード</h1>
<!--送信ボタンが押された場合-->
<?php if (isset($_POST['upload'])): ?>
    <p><?php echo $message; ?></p>
    <p><a href="image.php">画像表示へ</a></p>
<?php else: ?>
    <form method="post" enctype="multipart/form-data">
        <p>アップロード画像</p>
        <input type="file" name="image">
        <button><input type="submit" name="upload" value="送信"></button>
    </form>
<?php endif; ?>
