<?php 
session_start();
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
    <link href="css/common.css" rel="stylesheet">
  </head>
<body id="top">
<div id="wrap">
	<div>
		<h1><img src="img/rantango_logo.png" alt="ランタンゴ"></h1>
		<!--<p>説明</p>-->
	</div>
	<div id="form-wrap">
		<div id="tab">
			<div id="entry-tab">ユーザー作成</div>
			<div id="login-tab">ログイン</div>
		</div>
		<form action="entry_do.php" method="post" id="entry">
			<div>
				<input type="text" name="name" placeholder="ユーザーネームを半角英数字で入力してください" maxlength="30" value="<?php
					if(!empty($_SESSION['post']['name'])){
						echo h($_SESSION['post']['name']);
					}
				?>" required>
				<?php
					if(!empty($_SESSION['error']['name'])){
						print("<br>【入力が正しくありません】");
					}
					if(!empty($_SESSION['error']['duplicate'])){
						print("<br>【このユーザー名は使えません】");
					}
				?>
			</div>
			<div>
				<input type="password" name="password" placeholder="パスワードを4文字以上の半角英数字で入力してください" maxlength="30" value="<?php
					if(!empty($_SESSION['post']['password'])){
						echo h($_SESSION['post']['password']);
					}
				?>" required>
				<?php
					if(!empty($_SESSION['error']['password'])){
						print("<br>【入力が正しくありません】");
					}
				?>
			</div>
			<button type="submit">作成する</button>
		</form>
		<form action="book-list.php" method="post" id="login">
			<div>
				<input type="text" name="name" placeholder="ユーザーネームを半角英数字で入力してください" maxlength="30" value="<?php
					if(!empty($_SESSION['login_error']['name'])){
						echo h($_SESSION['login_error']['name']);
					}
				?>" required>
				<?php
					//if(!empty($_SESSION['error']['name'])){						print("<br>【入力が正しくありません】");					}
				?>
			</div>
			<div>
				<input type="password" name="password" placeholder="パスワードを4文字以上の半角英数字で入力してください" maxlength="30" value="<?php
					if(!empty($_SESSION['login_error']['password'])){
						echo h($_SESSION['login_error']['password']);
					}
				?>" required>
				<?php
					//if(!empty($_SESSION['error']['password'])){						print("<br>【入力が正しくありません】");					}
				?>
			</div>
			<button type="submit">ログインする</button>
		</form>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>
	$(function(){
		$("#login").css("display", "none");
		$("#entry-tab").click(function(){
			$("#entry").css("display", "block");
			$("#login").css("display", "none");
		});
		$("#login-tab").click(function(){
			$("#login").css("display", "block");
			$("#entry").css("display", "none");
		});
	});
</script>
</body>
</html>