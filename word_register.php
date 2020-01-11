<?php
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

if($_POST['word'] || $_POST['description']){
	$statement = $db->prepare('INSERT INTO word_table SET user_id=?, book_id=?, word=?, description=?, created=NOW()');
	$statement->execute(array(
		$_SESSION['user_id'],
		$_POST['book_id'],
		$_POST['word'],
		$_POST['description']
	));
}
header("Location: book.php?id=".$_POST['book_id']);
exit();
?>