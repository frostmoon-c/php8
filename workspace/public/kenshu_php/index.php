<?php


if ($_SERVER['REQUEST_URI'] == '/kenshu_php/top') {
	require_once './top.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/login') {
	require_once '/var/www/public/kenshu_php/end-user/login.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/login') {
	require_once '/var/www/public/kenshu_php/admin/login.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/mypage') {
	require_once '/var/www/public/kenshu_php/end-user/mypage.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/contact/contact') {
	require_once '/var/www/public/kenshu_php/end-user/contact/contact.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/contact/confirm') {
	require_once '/var/www/public/kensdhu_php/end-user/contact/confirm.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/logout') {
	require_once '/var/www/public/kenshu_php/logout.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/new-user/regist') {
	require_once '/var/www/public/kenshu_php/end-user/new-user/regist.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/new-user/confirm') {
	require_once '/var/www/public/kenshu_php/end-user/new-user/confirm.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/new-user/save') {
	require_once '/var/www/public/kenshu_php/end-user/new-user/save.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/home') {
	require_once '/var/www/public/kenshu_php/admin/home.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/product/regist') {
	require_once '/var/www/public/kenshu_php/admin/product/regist.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/product/list') {
	require_once '/var/www/public/kenshu_php/admin/product/list.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/product/regist-confirm') {
	require_once '/var/www/public/kenshu_php/admin/product/regist-confirm.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/product/edit') {
	require_once '/var/www/public/kenshu_php/admin/product/edit.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/product/edit-confirm') {
	require_once '/var/www/public/kenshu_php/admin/product/edit-confirm.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/product/delete') {
	require_once '/var/www/public/kenshu_php/admin/product/delete.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/product/delete-confirm') {
	require_once '/var/www/public/kenshu_php/admin/product/delete-confirm.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/shoppinglist') {
	require_once '/var/www/public/kenshu_php/end-user/shoppinglist.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/buy-confirm') {
	require_once '/var/www/public/kenshu_php/end-user/buy-confirm.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/buy') {
	require_once '/var/www/public/kenshu_php/end-user/buy.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/end-user/buylist') {
	require_once '/var/www/public/kenshu_php/end-user/buylist.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/user/list') {
	require_once '/var/www/public/kenshu_php/admin/user/list.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/user/edit') {
	require_once '/var/www/public/kenshu_php/admin/user/edit.php';
}elseif ($_SERVER['REQUEST_URI'] == '/kenshu_php/admin/user/edit-confirm') {
	require_once '/var/www/public/kenshu_php/admin/user/edit-confirm.php';
}else {
	echo "ページがありません。";
}