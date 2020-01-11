<?php 

if($_POST){ // ログイン画面から来ていない場合はfalse
    session_start();
    
	// cookieログイン情報を保存するか
	if($_POST['cookie_save']){
        $_SESSION['cookie_save'] = 'on';
	}else{
        $_SESSION['cookie_save'] = '';
	}
    
    if($_POST['user_name'] && $_POST['password']){
        // データベースに接続
        require('require/dbconnect.php');
        
        // ユーザーネームとパスワードが両方入力されている
        // ユーザーネームとパスワードがあっているか確認
        $login = $db->prepare('SELECT * FROM user_table WHERE user_name=? AND password=?');
        $login->execute(array(
            $_POST['user_name'],
            $_POST['password']
        ));
        $user_info = $login->fetch();
        if($user_info){
            // ログイン成功
            // セッションにユーザーネームを保存
            $_SESSION['user_name'] = $_POST['user_name'];
            if($_SESSION['cookie_save']){
                // クッキーにユーザーネームを保存
                setcookie('rantango_user_name', $_POST['user_name'], time()+60*60*24*180);
            }
            header('Location: book-list.php');
            exit();
        }
    }
    // ログイン失敗
    $_SESSION['login_error'] = 'error';
    $_SESSION['login_user_name'] = $_POST['user_name'];
    $_SESSION['login_password'] = $_POST['password'];
}

header('Location: index.php');
exit();