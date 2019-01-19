<?php
if(empty($_COOKIE['rantango_user'])){
    header('Location: index.php');
    exit();
}
session_start();
require('dbconnect.php');
$statement = $db->prepare('SELECT * FROM word_table WHERE id=? AND user_id=?');
$statement->execute(array(
    $_GET['id'],
    $_COOKIE['rantango_id']
));
$word = $statement->fetch();
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
    <title>ランタンゴ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap-reboot.min.css">
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
  </head>
<body>
<div id="wrap">
    <!--<button class="top_btn">単語帳を削除</button>-->
    <form action="edit-word_do.php" method="post">
        <div class="row">
            <input type="text" name="word" placeholder=" 単語を入力してください" class="a" maxlength="30" value="<?php 
                echo h($word['word']);
            ?>">
            <button class="b">単語編集</button>
        </div>
        <textarea name="description" rows="4" placeholder=" 単語の説明を入力してください"><?php 
                echo h($word['description']);
            ?></textarea>
        <input type="hidden" name="word_id" value="<?php echo h($_GET['id']); ?>">
    </form>
    <a href="word.php?id=<?php echo h($_SESSION['book_id']); ?>" class="circle">BACK</a>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>