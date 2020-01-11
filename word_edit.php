<?php 
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

if($_POST['word'] || $_POST['description']){
	$statement = $db->prepare('UPDATE word_table SET word=?, description=? WHERE id=? AND user_id=?');
	$statement->execute(array(
		$_POST['word'],
		$_POST['description'],
		$_POST['word_id'],
		$_SESSION['user_id']
	));
}else{
	header("Location: word.php?id=". $_POST['word_id']);
	exit();
}

header("Location: book.php?id=". $_SESSION['book_id']);
exit();
?>