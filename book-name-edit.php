<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
require('dbconnect.php');
session_start();
if(!empty($_POST['book_name'])){
    $statement = $db->prepare('UPDATE book_table SET book_name=? WHERE id=?');
    $statement->execute(array(
        $_POST['book_name'],
        $_POST['id']
    ));
}
header('Location: book-list.php');
exit();
?>