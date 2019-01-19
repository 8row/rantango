<?php
require('dbconnect.php');
session_start();
if(!empty($_POST)){
	if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['name'])){
		$_SESSION['error']['name'] = 'error';
	}else{
		$_SESSION['error']['name'] = '';
	}
	if(strlen($_POST['password']) < 4 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])){
		$_SESSION['error']['password'] = 'error';
	}else{
		$_SESSION['error']['password'] = '';
	}
	$already_exists = $db->prepare('SELECT COUNT(*) AS cnt FROM user_table WHERE user_name=?');
	$already_exists->execute(array($_POST['name']));
	$record = $already_exists->fetch();
	if($record['cnt'] > 0){
		$_SESSION['error']['duplicate'] = 'error';
		header('Location: index.php');
		exit();
	}
	if(empty($_SESSION['error']['name']) && empty($_SESSION['error']['password'])){
		$statement = $db->prepare('INSERT INTO user_table SET user_name=?, password=?, created=NOW()');
		$statement->execute(array(
			$_POST['name'],
			$_POST['password']
		));
		setcookie('rantango_user', $_POST['name'], time()+60*60*24*180);
		setcookie('rantango_password', $_POST['passsword'], time()+60*60*24*180);
		unset($_SESSION['post']);
		unset($_SESSION['error']);
		header('Location: book-list.php');
		exit();
	}else{
		$_SESSION['post']['name'] = $_POST['name'];
		$_SESSION['post']['password'] = $_POST['password'];
		header('Location: index.php');
		exit();
	}
}
header('Location: index.php');
exit();
?>