<?php
session_start();
if ( !$_SESSION['userId'] ) {
	header('Location: ./login');
}

// インジェクション対策
$userId = (int)$_SESSION['userId'];

$sql = 'SELECT * FROM sellers WHERE id =' . $userId;
$query = pg_query($connect, $sql);

//if ($query && pg_num_rows($query) > 0 ) {
if ($query && pg_num_rows($query) < 1 ) {
	header('Location: ./login');
}

$seller = pg_fetch_assoc($query);
?>