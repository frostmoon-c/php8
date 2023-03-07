<?php
session_start();

$_SESSION['msg']="welcome";

header('Location: sessionOut.php');
?>