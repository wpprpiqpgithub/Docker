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

if(isset($_POST['edit'])){
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $edit = $pdo->prepare('update memos set memo = ? where id = ?');
    $memO = filter_input(INPUT_POST,  'memo', FILTER_SANITIZE_SPECIAL_CHARS);
    $edit->bindParam(1 , $memO );
    $edit->bindParam(2 , $id);
    $edit->execute();
   
    header('Location: index.php');
   
    }