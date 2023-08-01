<?php
$dsn = 'mysql:dbname=test_db;host=run-php-db;';
$user = 'test';
$password = 'test';

$pdo = new PDO($dsn, $user, $password);

    $id = filter_input(INPUT_GET, 'id' , FILTER_SANITIZE_NUMBER_INT);
    $delete = $pdo->prepare('delete from memos where id = ?');
    $delete->bindparam(1, $id);
    $delete->execute();
    header('Location: index.php');
    
    
?>


    