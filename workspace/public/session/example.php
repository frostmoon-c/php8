<?php
session_start();

print('セッションIDは '.$_COOKIE['PHPSESSID'].' です。');

$_SESSION['username'] = 'tanaka';
echo 'ユーザー名は '. $_SESSION['username'].' 。';

unset($_SESSION['username']);

if (!isset($_SESSION['username'])){
    echo 'ユーザー名は削除されました。';
}else{
    echo 'ユーザー名は '. $_SESSION['username'].' 。';
}
?>