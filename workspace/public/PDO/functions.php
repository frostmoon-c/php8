<?php
function xss(string $string):string{
	return htmlspecialchars($string,ENT_QUOTES);
}

//データベースに接続し、PDOを返すユーザ定義関数
function getDb() : PDO{
//データベース接続情報
$dns='pgsql:dbname=postgres;host=db;port=5432';
$user = 'laravel_user';
$pass = 'laravel_pass';
$opt = [
	PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_EMULATE_PREPARES=>false,
];
//データベースと接続し、PDOを返す
return new PDO($dns,$user,$pass,$opt);
}