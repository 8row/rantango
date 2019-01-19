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
<body id="rantango">
<div id="wrap">
	<dl>
        <?php
            $words = $db->prepare('SELECT * FROM word_table WHERE user_id=? AND book_id=? ORDER BY id DESC');
            $words->execute(array(
                $_COOKIE['rantango_id'],
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
        <div id="next" style="display:none;">NEXT</div>
        <div id="answer">ANSWER</div>
        <a href="book-list.php" class="back">BACK</a>
</div>
</body>
</html>