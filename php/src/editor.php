<?php

$dsn = 'mysql:dbname=test_db;host=run-php-db;';
$user = 'test';
$password = 'test';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    print('Error:'.$e->getMessage());
    exit;
}

 $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
 $stmt = $pdo->prepare('select * from memos where id = ?'); 
 $stmt->bindparam(1 ,$id);
 $stmt->execute();
 $memo = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
</head>
<body>
    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <textarea name="memo" cols="50" rows="10" 
        placeholder="メモを入力してください"><?php echo htmlspecialchars($memo['memo']) ?></textarea><br>
        <button type="submit" name="edit">編集する</button>
    </form>
</body>
</html>