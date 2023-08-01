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

$search = trim(htmlspecialchars($_POST['search']) , ENT_QUOTES);

$search = str_replace("　","",$search);

if($search === ""){
    $search = "";
}

$stmt = $pdo->prepare('select * from memos where memo like :search');

$stmt->bindValue(':search' , "%{$search}%" , PDO::PARAM_STR);

$stmt->execute();

$null = false;

?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search</title>
</head>
<body>
    <?php while($list = $stmt->fetch(PDO::FETCH_ASSOC)): if(!$null):?>
    <p><a href="memo.php?id=<?php echo $list['id'] ?>"><?php echo $list['memo'] ?></a><time><?php echo $list['created'] ?></time></p>
    <?php endif; endwhile; if(null):?>
        <p>該当の記事はありません</p>
        <?php endif; ?>
</body>
</html>

