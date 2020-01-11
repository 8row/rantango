<?php
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

if($_POST['book_name']){ // 変更名が空ではない
    $statement = $db->prepare('UPDATE book_table SET book_name=? WHERE id=? AND user_id=?');
    $statement->execute(array(
        $_POST['book_name'],
		$_POST['id'],
		$_SESSION['user_id']
    ));
}
header('Location: book.php?id='. $_POST['id']);
exit();
?>