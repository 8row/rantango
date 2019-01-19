<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
require('dbconnect.php');
session_start();
$statement = $db->prepare('DELETE FROM word_table WHERE id=? AND user_id=?');
$statement->execute(array(
	$_GET['id'],
	$_COOKIE['rantango_id']
));
header("Location: word.php?id=".$_SESSION['book_id']);
exit();
?>