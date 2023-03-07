<?php

$connect = pg_connect('host=db port=5432 dbname=postgres user=laravel_user password=laravel_pass');
      $sql = 'SELECT image FROM images';
      $query = pg_query($connect, $sql);
      if ($query) {
          $max = pg_num_rows($query);
          //$dataArray = pg_fetch_array($query);
          $dataArray = pg_fetch_all($query);//エラー
          //var_dump($max);
          var_dump($dataArray);



          foreach ($dataArray as $key => $value) {
            echo "{$key},{$value}";
          }


      }

?>

<h1>画像表示</h1>
<img src="<?php echo $dataArray['image']; ?>" width="300" height="300">
<a href="upload.php">画像アップロード</a>