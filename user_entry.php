<?php
if($_POST){ // ログイン画面から来ていない場合はfalse
	session_start();

	// cookieログイン情報を保存するか
	if($_POST['cookie_save']){
		$_SESSION['cookie_save'] = 'on';
	}else{
		$_SESSION['cookie_save'] = '';
	}

	// ユーザーネームが半角英数字か確認
	if(preg_match("/^[a-zA-Z0-9]+$/", $_POST['user_name'])){
		// エラーなし
		$_SESSION['error']['user_name'] = '';
		$_SESSION['noerror']['user_name'] = $_POST['user_name'];
	}else{
		// エラーあり
		$_SESSION['error']['user_name'] = $_POST['user_name'];
	}

	// パスワードが4文字以上の半角英数字か確認
	if(strlen($_POST['password']) >= 4 && preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])){
		// エラーなし
		$_SESSION['error']['password'] = '';
		$_SESSION['noerror']['password'] = $_POST['password'];
	}else{
		// エラーあり
		$_SESSION['error']['password'] = $_POST['password'];
	}

	// ユーザーネームまたはパスワードに問題があればログインページ戻る
	if($_SESSION['error']['user_name'] || $_SESSION['error']['password']){
		header('Location: index.php');
		exit();
	}

	// データベースに接続
	require('require/dbconnect.php');

	// 同じユーザーネームがすでに存在しているか確認
	$already_exists = $db->prepare('SELECT COUNT(*) AS cnt FROM user_table WHERE user_name=?');
	$already_exists->execute(array($_POST['user_name']));
	$record = $already_exists->fetch();
	if($record['cnt'] > 0){
		$_SESSION['error']['duplicate'] = $_POST['user_name'];
		header('Location: index.php');
		exit();
	}

	// ユーザー登録してログイン
	$statement = $db->prepare('INSERT INTO user_table SET user_name=?, password=?, created=NOW()');
	$statement->execute(array(
		$_POST['user_name'],
		$_POST['password']
	));

	// セッションにユーザーネームを保存
	$_SESSION['user_name'] = $_POST['user_name'];
	if($_SESSION['cookie_save']){
		// クッキーにユーザーネームを保存
		setcookie('rantango_user_name', $_POST['user_name'], time()+60*60*24*180);
	}
	header('Location: book-list.php');
	exit();
}

header('Location: index.php');
exit();
?>