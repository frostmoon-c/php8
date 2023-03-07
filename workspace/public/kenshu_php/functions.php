<?php
//エスケープ処理
function xssEscape(string $string):string{
	return htmlspecialchars($string, ENT_QUOTES);
}
?>
<?php
//エスケープ処理(こっち使う)
// function xssEscape2(string $string):string{
// 	return pg_escape_string($string);
// }
?>