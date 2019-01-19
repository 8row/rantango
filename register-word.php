<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
require('dbconnect.php');
session_start();
if(!empty($_POST['word']) && !empty($_POST['description'])){
	$statement = $db->prepare('INSERT INTO word_table SET user_id=?, book_id=?, word=?, description=?, created=NOW()');
	$statement->execute(array(
		$_COOKIE['rantango_id'],
		$_POST['book_id'],
		$_POST['word'],
		$_POST['description']
	));
}
header("Location: word.php?id=".$_POST['book_id']);
exit();
?>