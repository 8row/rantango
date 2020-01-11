<?php
session_start();
if($_COOKIE['rantango_user_id'] || $_SESSION['user_id'] || $_SESSION['user_name']){
	if($_COOKIE['rantango_user_name']){
		$_SESSION['user_id'] = $_COOKIE['rantango_user_id'];
		setcookie('rantango_user_id', $_COOKIE['rantango_user_id'], time()+60*60*24*180);
	}
}else{
	// ログイン状態ではない
	header('Location: index.php');
	exit();
}
?>