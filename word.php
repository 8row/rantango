<?php
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

$word = $db->prepare('SELECT * FROM word_table WHERE id=? AND user_id=?');
$word->bindParam(1, $_GET['id'], PDO::PARAM_INT);
$word->bindParam(2, $_SESSION['user_id'], PDO::PARAM_STR);
$word->execute();
$word = $word->fetch();
if(!$word){
    // 単語が見つからないので、単語一覧に戻る
    header("Location: book.php?id=".$_SESSION['book_id']);
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
    <title>ランタンゴ</title>
  </head>
<body>
<div class="container-fluid">
    <?php require('require/header.php'); ?>

    <form action="word_edit.php" method="post" class="clearfix">
        <input type="text" name="word" placeholder="単語を入力してください" class="form-control" maxlength="30" value="<?php 
            echo h($word['word']);
        ?>">
        <textarea name="description" rows="4" placeholder="単語の説明を入力してください" class="form-control mt-3"><?php 
                echo h($word['description']);
                ?></textarea>
        <button class="btn btn-primary float-right mt-3 col-5">単語編集</button>
        <input type="hidden" name="word_id" value="<?php echo h($_GET['id']); ?>">
    </form>
    <form action="word_delete.php" method="post" class="clearfix">
        <input type="hidden" name="word_id" value="<?php echo h($_GET['id']); ?>">
        <button class="btn btn-danger float-right mt-3 col-5">単語削除</button>
    </form>
    <a href="book.php?id=<?php echo h($_SESSION['book_id']); ?>" class="btn btn-dark rounded-circle float-right mt-3">BACK</a>
</div>
</body>
</html>