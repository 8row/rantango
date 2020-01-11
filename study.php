<?php
// ログイン状態か確認
require('require/check_login.php');

// データベースに接続
require('require/dbconnect.php');

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
    <title>ランタンゴ</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
    $(function(){
        var a;
        a = Math.floor( Math.random() * $('.cnt').length );
        $('.cnt').eq(a).css("display", "block");

        $("#next").click(function(){
            if($('.cnt').length<=1){
                  location.reload();
            }
            $('.cnt').eq(a).remove();
            a = Math.floor( Math.random() * $('.cnt').length );
            $('.cnt').eq(a).css("display", "block");
            $("#next").css("display", "none");
            $("#answer").css("display", "block");
        });
       
        $("#answer").click(function(){
            $('.cnt dd').eq(a).css("display", "block");
            $("#next").css("display", "block");
            $("#answer").css("display", "none");
        });
    });
</script>
</head>
<body>
<div class="container-fluid">
    <?php require('require/header.php'); ?>
    
    <div id="frame"></div>
	<dl>
        <?php
            $words = $db->prepare('SELECT * FROM word_table WHERE user_id=? AND book_id=? ORDER BY id DESC');
            $words->execute(array(
                $_SESSION['user_id'],
                $_GET['id']
            ));
            while($word = $words->fetch()):
        ?>
        <div style="display:none;" class="cnt">
            <dt><?php echo h($word['word']); ?></dt>
            <dd style="display: none;"><?php echo h($word['description']); ?></dd>
        </div>
        <?php endwhile; ?>
    </dl>
    <div id="next" style="display:none;" class="btn btn-success rounded-circle study">NEXT</div>
    <div id="answer" class="btn btn-info rounded-circle float-right study">ANSWER</div>
    <a href="book-list.php" class="btn btn-dark rounded-circle mb-3 fixed-bottom">BACK</a>
</div>
</body>
</html>