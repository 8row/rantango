<?php
session_start();
// htmlspecialcharsのショートカット
function h($value){
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="jp">

<head>
	<?php require('require/head.php'); ?>
	<title>ランタンゴ</title>
</head>

<body>
	<div class="container-fluid">
		<h1><img src="img/rantango_logo.png" alt="ランタンゴ" class="img-fluid mt-5"></h1>
		<!--<p>説明</p>-->
		<form action="user_entry.php" method="post" class="mt-5">
			<div class="form-group">
				<h2 class="h4 font-weight-bold">ユーザー作成</h2>
				<p>ユーザーネームを半角英数字で入力してください</p>
				<input type="text" name="user_name" placeholder="ユーザーネーム" maxlength="30" value="<?php
					if ($_SESSION['error']['user_name']) {
						echo h($_SESSION['error']['user_name']);
					}elseif($_SESSION['error']['duplicate']) {
						echo h($_SESSION['error']['duplicate']);
					}elseif($_SESSION['noerror']['user_name']) {
						echo h($_SESSION['noerror']['user_name']);
					}
					?>" class="form-control" required>
				<?php
				if ($_SESSION['error']['user_name']) {
					print('<br><span class="error">【入力が正しくありません】</span>');
				}elseif($_SESSION['error']['duplicate']) {
					print('<br><span class="error">【このユーザー名はすでに存在しているので使えません】</span>');
				}
				?>
			</div>
			<div class="form-group">
				<p>パスワードを4文字以上の半角英数字で入力してください</p>
				<input type="password" name="password" placeholder="パスワード" maxlength="30" value="<?php
					if ($_SESSION['error']['password']) {
						echo h($_SESSION['error']['password']);
					}elseif($_SESSION['noerror']['password']) {
						echo h($_SESSION['noerror']['password']);
					}
					?>" class="form-control" required>
				<?php
				if ($_SESSION['error']['password']) {
					print('<br><span class="error">【入力が正しくありません】</span>');
				}
				?>
			</div>
			<label class="form-check">
				<input type="checkbox" name="cookie_save" value="on" <?php
					if($_SESSION['cookie_save']){ echo 'checked'; }
				?> class="form-check-input">
				クッキーに保存してログイン状態を保持する
			</label>
			<button type="submit" class="btn btn-primary w-50 mx-auto d-block">作成する</button>
		</form>
		<form action="user_login.php" method="post" class="mt-5">
			<h2 class="h4 font-weight-bold">ログイン</h2>
			<div class="form-group">
				<p>ユーザーネームを半角英数字で入力してください</p>
				<input type="text" name="user_name" placeholder="ユーザーネーム" maxlength="30" value="<?php
					if (!empty($_SESSION['login_error']['user_name'])) {
						echo h($_SESSION['login_error']['user_name']);
					}
					?>" class="form-control" required>
				<?php
				if(!empty($_SESSION['error']['user_name'])){
					print('<br><span class="error">【入力が正しくありません】</span>');
				}
			?>
			</div>
			<div class="form-group">
				<p>パスワードを4文字以上の半角英数字で入力してください</p>
				<input type="password" name="password" placeholder="パスワード" maxlength="30" value="<?php
					if (!empty($_SESSION['login_error']['password'])) {
						echo h($_SESSION['login_error']['password']);
					}
					?>" class="form-control" required>
				<?php
				if(!empty($_SESSION['error']['password'])){
					print('<br><span class="error">【入力が正しくありません】</span>');
				}
				?>
			</div>
			<label class="form-check">
				<input type="checkbox" name="cookie_save" value="on" <?php
					if($_SESSION['cookie_save']){ echo 'checked'; }
				?> class="form-check-input">
				クッキーに保存してログイン状態を保持する
			</label>
			<button type="submit" class="btn btn-primary w-50 mx-auto d-block">ログインする</button>
		</form>
		<p class="mt-5">ランタンゴとは、<br>
			簡単に登録した単語をランダムに表示し、もう一回タップして説明を表示できるアプリです。<br>
			スマホとパソコンから利用することができるので、パソコンから単語を登録して、スマホで勉強することができます。<br>
			<br>
			ユーザーを作成するには、1文字以上の半角英数字のユーザーネームと4文字以上の半角英数字のパスワードを入力して作成することが出来ます。<br>
			最後にログインしてから半年経つとログアウトされますので、その際は、再度ログインしてください。</p>
	</div>
</body>

</html>
<?php
unset($_SESSION['error']);
unset($_SESSION['noerror']);
unset($_SESSION['login-error']);
?>