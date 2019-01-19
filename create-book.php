<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
require('dbconnect.php');
session_start();
if(!empty($_POST['book_name'])){
	$statement = $db->prepare('INSERT INTO book_table SET user_id=?, book_name=?, created=NOW()');
	$statement->execute(array(
		$_COOKIE['rantango_id'],
		$_POST['book_name']
	));
}
header('Location: book-list.php');
exit();
?>