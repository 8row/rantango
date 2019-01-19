<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
session_start();
$_SESSION['book_id'] = $_GET['id'];
require('dbconnect.php');
$books = $db->prepare('SELECT * FROM book_table WHERE id=?');
$books->execute(array($_GET['id']));
$book = $books->fetch();
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
    <form action="delete-book_do.php" method="post">
        <button class="top_btn">単語帳を削除</button>
        <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
    </form>
	<form class="row" action="book-name-edit.php" method="post">
		<input type="text" name="book_name" placeholder=" 単語帳名を入力してください" class="a" maxlength="30" value="<?php 
			echo h($book['book_name']);
		?>">
		<input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
		<button class="b">名前変更</button>
	</form>
    <hr>
    <form action="register-word.php" method="post">
        <div class="row">
            <input type="text" name="word" placeholder=" 単語を入力してください" class="a" maxlength="30" value="<?php 
                //echo h($book['book_name']);
            ?>">
            <button class="b">単語登録</button>
        </div>
        <textarea name="description" rows="4" placeholder=" 単語の説明を入力してください"></textarea>
        <input type="hidden" name="book_id" value="<?php echo h($_GET['id']); ?>">
    </form>
    <a href="book-list.php" class="circle">BACK</a>
	<ul>
        <?php
            $words = $db->prepare('SELECT * FROM word_table WHERE user_id=? AND book_id=? ORDER BY id DESC');
            $words->execute(array(
                $_COOKIE['rantango_id'],
                $_GET['id']
            ));
            while($word = $words->fetch()):
        ?>
        <li>
            <div class="row clear_b">
                <div class="a"><?php echo h($word['word']); ?></div>
                <a href="edit-word.php?id=<?php echo h($word['id']); ?>" class="b button">編集</a>
            </div>
            <div class="row f_del">
                <div class="a"><?php echo h($word['description']); ?></div>
                <a href="delete-word.php?id=<?php echo h($word['id']); ?>" class="b button">削除</a>
            </div>
        </li>
        <hr>
    <?php endwhile; ?>
    </ul>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>