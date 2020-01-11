<?php
session_start();

if($_COOKIE['rantango_user_id'] || $_SESSION['user_id']){
	if($_COOKIE['rantango_user_name']){
		$_SESSION['user_id'] = $_COOKIE['rantango_user_id'];
		setcookie('rantango_user_id', $_COOKIE['rantango_user_id'], time()+60*60*24*180);
	}
}else{
	// ログイン状態ではない
	header('Location: index.php');
	exit();
}

// データベースに接続
require('require/dbconnect.php');

$statement = $db->prepare('DELETE FROM word_table WHERE id=? AND user_id=?');
$statement->execute(array(
    $_POST['word_id'],
    $_SESSION['user_id']
));
header("Location: book.php?id=". $_SESSION['book_id']);
exit();
?>