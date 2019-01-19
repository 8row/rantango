<?php
	session_start();
	session_destroy();
	setcookie('rantango_id', '', 0);
	setcookie('rantango_user', '', 0);
	setcookie('rantango_password', '', 0);
	header('Location: index.php');
	exit();
?>