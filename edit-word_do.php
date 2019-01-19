<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
require('dbconnect.php');
session_start();
$statement = $db->prepare('UPDATE word_table SET word=?, description=? WHERE id=? AND user_id=?');
$statement->execute(array(
	$_POST['word'],
	$_POST['description'],
	$_POST['word_id'],
	$_COOKIE['rantango_id']
));
header("Location: word.php?id=".$_SESSION['book_id']);
exit();
?>