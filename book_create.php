<?php
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

if($_POST['book_name']){
	$statement = $db->prepare('INSERT INTO book_table SET user_id=?, book_name=?, created=NOW()');
	$statement->execute(array(
		$_SESSION['user_id'],
		$_POST['book_name']
	));
}
header('Location: book-list.php');
exit();
?>