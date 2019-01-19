<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
session_start();
require('dbconnect.php');
$user_info = $db->prepare('SELECT * FROM user_table WHERE id=?');
$user_info->execute(array($_COOKIE['rantango_id']));
$user = $user_info->fetch();
// htmlspecialcharsのショートカット
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="jp">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap-reboot.min.css">
    <title>ランタンゴ</title>
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
    </head>
<body>
<div id="wrap">
    <button class="top_btn">ユーザー削除</button>
	<form class="row" action="alter-user-name_do.php" method="post">
		<input type="text" name="user_name" placeholder=" ユーザー名を入力してください" class="a" maxlength="30" value="<?php 
			echo h($_COOKIE['rantango_user']);
		?>">
		<button class="b">ユーザー名変更</button>
	</form>
    <hr>
    <form action="alter-password_do.php" method="post">
        <div class="row">
            <input type="text" name="password" placeholder=" パスワードを入力してください" class="a" maxlength="30" value="<?php 
                echo h($user['password']);
            ?>">
            <button class="b">パスワード変更</button>
        </div>
    </form>
    <a href="book-list.php" class="circle">BACK</a>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>

</html>