<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
require('dbconnect.php');
$statement = $db->prepare('UPDATE user_table SET user_name=? WHERE id=?');
$statement->execute(array(
	$_POST['user_name'],
	$_COOKIE['rantango_id']
));
setcookie('rantango_user', $_POST['user_name'], time()+60*60*24*180);
header('Location: user.php');
exit();
?>