<?php
session_start();

// if(!isset($_POST['userName'])){
// 	header('Location: sessionIn.php');
// 	exit();
// }

$userName=htmlspecialchars($_POST['userName'],ENT_QUOTES);

if($userName===""){
	$userName="ゲスト";
}

$_SESSION['userName']=$userName;
header('Location: session2.php');
?>