<?php
$dsn = 'mysql:dbname=test_db;host=run-php-db;';
$user = 'test';
$password = 'test';

$pdo = new PDO($dsn, $user, $password);

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ</title>
</head>
<body>
 <?php $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
 $stmt = $pdo->prepare('select * from memos where id = ?'); 
 $stmt->bindparam(1 ,$id);
 $stmt->execute();
 $memo = $stmt->fetch();
 
 ?>
 <p><?php echo $memo['memo'] ?></p>
 <p><a href="editor.php?id=<?php echo $id ?>">編集する</a></p>
 <p><a href="exit.php?id=<?php echo $id ?>">削除する</a></p>

 <!-- <form action="memo.php" method="post">
     <textarea name="memo" cols="50" rows="10"></textarea>
     <button type="submit">編集する</button>
</form> -->
</body>
</html>