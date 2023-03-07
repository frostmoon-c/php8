<?php
$dsn = $dns = 'pgsql:dbname=postgres;host=db;port=5432';
$username = 'laravel_user';
$password = 'laravel_pass';
$id = rand(1, 5);
try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}
    $sql = "SELECT * FROM images WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $image = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<h1>画像表示</h1>
<img src="images/<?php echo $image['name']; ?>" width="300" height="300">
<a href="upload.php">画像アップロード</a>
</body>
</html>