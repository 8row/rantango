<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
require('dbconnect.php');
session_start();
$statement = $db->prepare('DELETE FROM book_table WHERE id=? AND user_id=?');
$statement->execute(array(
	$_GET['id'],
	$_COOKIE['rantango_id']
));
header("Location: book-list.php");
exit();
?>