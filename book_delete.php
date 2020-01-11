<?php
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

$statement = $db->prepare('DELETE FROM book_table WHERE id=? AND user_id=?');
$statement->execute(array(
    $_POST['id'],
    $_SESSION['user_id']
));
header("Location: book-list.php");
exit();
?>