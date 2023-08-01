<?php

// 接続
// hostはコンテナ名を記載する
$dsn = 'mysql:dbname=test_db;host=run-php-db;';
$user = 'test';
$password = 'test';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    print('Error:'.$e->getMessage());
    exit;
}

date_default_timezone_set('Asia/Tokyo');
$date = date('Y-m-d H.i.m');
//   $pdo->query('drop table if exists test');

//   $pdo->query('create table test(id INT)');

// $pdo->query('insert into memos (memo) values("PHPからのメモです")');
// $message = 'フォームからのメモです';
$stmt = $pdo->prepare('INSERT INTO memos (memo , created) VALUES(? , ?)');
// $stmt->bindParam(1,$message);
if(isset($_POST['post'])){
$memO = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_SPECIAL_CHARS);
$stmt->bindParam(1,$memO);
$stmt->bindParam(2,$date);
$stmt->execute();
};
// $memos = $pdo->query('select * from memos order by id desc limit 0 , 5');
$stmt = $pdo->prepare('select * from memos order by id desc limit ? , 5');
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
if(!$page) {
    $page = 1;
}
$start = ($page - 1) * 5;
$stmt->bindvalue(1, $start , pdo::PARAM_INT);
$stmt->execute();
$counts = $pdo->query('select count(*) as cnt from memos');
$count = $counts->fetch();
$max_page = ceil(($count['cnt'] + 1) / 5);

// $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
// if (!$page) {
//     $page = 1;
// }
// $start = ($page-1) * 5;
// $stmt->bindParam(1,$start);

// $stmt->execute();
// $memo = $stmt->fetch();

//$memo = $_POST['memo'];   




?>


<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="profile">wpprpiqp</div>
    <div><a href="login.php" id="link">チャットアプリ</a></div>
<div>


    <form action="index.php" method="post">
        <textarea name="memo" cols="100" rows="10" 
        placeholder="メモを入力してください" id="textarea"></textarea><br>
        <button type="submit" name="post" id="button">登録する</button>
    </form>

    <form action="search.php" method="post" id="search">
        <input type="text" name="search" placeholder="search..">
        <input type="submit" name="bottom" value="検索">
    </form>

    <h1>メモ帳</h1>
    <?php while ($memo = $stmt->fetch()): ?>
    <div>
        <h2><a href="memo.php?id=<?php echo $memo['id']; ?> "><?php echo htmlspecialchars(mb_substr($memo['memo'], 0 ,50)); ?></a>
    <time><?php echo htmlspecialchars($memo['created']); ?></time></h2>
    </div>
    <?php endwhile; ?>
    <?php if ($page>1) : ?>
    <p><a href="?page=<?php echo $page-1; ?>">前のページ</a></p>
    <?php endif; ?>
    <?php if ($page<$max_page) : ?>
    <p><a href="?page=<?php echo $page+1; ?>">次のページ</a></p>
    <?php endif; ?>
</div>
</body>
</html>




