<?php 
require('dbconnect.php');
session_start();
if(empty($_COOKIE['rantango_user'])){
	if(empty($_POST['name']) && empty($_POST['password'])){
		header('Location: index.php');
		exit();
	}else{
		$login = $db->prepare('SELECT * FROM user_table WHERE user_name=? AND password=?');
		$login->execute(array(
			$_POST['name'],
			$_POST['password']
			));
		$user_name = $login->fetch();
		if($user_name){
			setcookie('rantango_id', $user_name['id'], time()+60*60*24*180);
			setcookie('rantango_user', $_POST['name'], time()+60*60*24*180);
			setcookie('rantango_password', $_POST['password'], time()+60*60*24*180);
		}else{
			$_SESSION['login_error'] = $_POST;
			header('Location: index.php');
			exit();
		}
	}
}else{
	$user_id = $db->prepare('SELECT * FROM user_table WHERE user_name=?');
	$user_id->execute(array($_COOKIE['rantango_user']));
	$user_id = $user_id->fetch();
	$user_name['id'] = $user_id['id'];
	setcookie('rantango_id', $user_id['id'], time()+60*60*24*180);
}
if(!empty($_COOKIE['rantango_id'])){
	$user_name['id'] = $_COOKIE['rantango_id'];
}
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
    <title>単語帳一覧 - ランタンゴ</title>
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
  </head>
<body>
<div id="wrap">
	<div class="row">
		<div class="a"></div>
		<!--<a href="user.php" class="a button">ユーザーデータ変更</a>-->
		<a href="logout.php" class="b button font90">ログアウト</a>
	</div>
	<hr>
	<form class="row mb40" action="create-book.php" method="post">
		<input type="text" name="book_name" placeholder=" 単語帳名を入力してください" class="a" maxlength="30">
		<button class="b font90">単語帳作成</button>
	</form>
	<ul>
	<?php
		$books = $db->prepare('SELECT * FROM book_table WHERE user_id=? ORDER BY id DESC');
		$books->execute(array($user_name['id']));
		while($book = $books->fetch()):
	?>
		<li class="row">
			<div class="a">
				<?php echo h($book['book_name']); ?>
			</div>
			<div class="b">
				<a class="study" href="rantango.php?id=<?php echo h($book['id']); ?>">STUDY</a>
			</div>
		</li>
		<li class="row">
			<div class="a"></div>
			<a href="word.php?id=<?php echo h($book['id']); ?>" class="b button">編集</a>
		</li>
		<hr>
	<?php endwhile; ?>
</ul>
<p style="text-align: left;">説明<br>まずは、単語帳名を入力して単語帳を作成してください。<br>
編集から単語を登録してSTUDYから単語をランダムに表示できます。
</p>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>