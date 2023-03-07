<?php

//tmp_name(一時保存ファイル名)
//if($_FILES['image']['tmp_name']){
	//var_dump — 変数に関する情報をダンプ（出力）する
	//getimagesize —画像のサイズ・形式を配列で取得する
	var_dump(getimagesize($_FILES['image']['tmp_name']));

	exit();
	//}
