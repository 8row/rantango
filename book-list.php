<?php 
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

$user_info = $db->prepare('SELECT * FROM user_table WHERE user_name=?');
$user_info->execute(array($_SESSION['user_name']));
$user_info = $user_info->fetch();
$_SESSION['user_id'] = $user_info['id'];
if($_COOKIE['rantango_user_name']){
	setcookie('rantango_user_id', $user_info['id'], time()+60*60*24*180);
}

// htmlspecialcharsのショートカット
function h($value) {
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="jp">
  <head>
	<?php require('require/head.php'); ?>
    <title>単語帳一覧 - ランタンゴ</title>
  </head>
<body>
<div class="container-fluid">
	<?php require('require/header.php'); ?>
	
	<form action="book_create.php" method="post">
		<input type="text" name="book_name" placeholder="単語帳名を入力してください" class="form-control">
		<button class="btn btn-primary col-5 offset-7 mt-3">単語帳作成</button>
	</form>
	<hr>
	<ul class="list-unstyled">
	<?php
		$books = $db->prepare('SELECT * FROM book_table WHERE user_id=? ORDER BY id DESC');
		$books->execute(array($user_info['id']));
		while($book = $books->fetch()):
	?>
		<li class="d-flex flex-wrap align-items-center flex-row-reverse">
			<a href="book.php?id=<?php echo h($book['id']); ?>" class="btn btn-primary col-5">単語帳編集</a>
			<p class="col-7 pl-0"><?php echo h($book['book_name']); ?></p>
			<a href="study.php?id=<?php echo h($book['id']); ?>" class="btn btn-success mt-3 rounded-circle">STUDY</a>
		</li>
		<hr>
		<?php endwhile; ?>
	</ul>
	<p>説明<br>まずは、単語帳名を入力して単語帳を作成してください。<br>
	編集から単語を登録してSTUDYから単語をランダムに表示できます。
	</p>
</div>
</body>
</html>

<?php
unset($_SESSION['error']);
unset($_SESSION['noerror']);
?>