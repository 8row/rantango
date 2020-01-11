<?php
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

$_SESSION['book_id'] = $_GET['id'];
$book = $db->prepare('SELECT * FROM book_table WHERE id=? AND user_id=?');
$book->bindParam(1, $_GET['id'], PDO::PARAM_INT);
$book->bindParam(2, $_SESSION['user_id'], PDO::PARAM_STR);
$book->execute();
$book = $book->fetch();
if(!$book){
    // 単語帳が見つからないので、単語帳一覧に戻る
    header('Location: book-list.php');
    exit();
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
    <title>単語一覧ランタンゴ</title>
</head>

<body>
<div class="container-fluid">
    <?php require('require/header.php'); ?>
    
    <form action="book_delete.php" method="post">
        <button class="btn btn-primary col-12">単語帳削除</button>
        <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
    </form>
    <hr>

	<form action="book-name_edit.php" method="post">
		<input type="text" name="book_name" placeholder="単語帳名を入力してください" value="<?php 
			echo h($book['book_name']);
		?>" class="form-control">
		<input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
		<button class="btn btn-primary col-5 offset-7 mt-3">名前変更</button>
	</form>
    <hr>
    
    <form action="word_register.php" method="post">
        <input type="text" name="word" placeholder="単語を入力してください" class="form-control">
        <textarea name="description" rows="4" placeholder="単語の説明を入力してください" class="form-control mt-3"></textarea>
        <button class="btn btn-primary col-5 offset-7 mt-3">単語登録</button>
        <input type="hidden" name="book_id" value="<?php echo h($_GET['id']); ?>">
    </form>
    <hr>

    <a href="book-list.php" class="btn btn-dark rounded-circle float-right mb-3">BACK</a>
    <hr>

	<ul class="list-unstyled">
        <?php
            $words = $db->prepare('SELECT * FROM word_table WHERE user_id=? AND book_id=? ORDER BY id DESC');
            $words->execute(array(
                $_SESSION['user_id'],
                $_GET['id']
            ));
            while($word = $words->fetch()):
        ?>
        <li class="d-flex flex-wrap align-items-center">
            <p class="col-7 pl-0"><?php echo h($word['word']); ?></p>
            <a href="word.php?id=<?php echo h($word['id']); ?>" class="btn btn-primary col-5">編集</a>
            <p class="col-12 pl-0 mt-3"><?php echo h($word['description']); ?></p>
        </li>
        <hr>
    <?php endwhile; ?>
    </ul>
    <p style="text-align: left;">説明<br>名前変更で単語帳名を変更することができます。<br>
単語とその説明をセットで登録してください。<br>
登録した内容は、編集から変更することができます。</p>
</div>
</body>
</html>