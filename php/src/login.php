<?php
session_start();
$form = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form['username'] = filter_input(INPUT_POST, 'username' ,FILTER_SANITIZE_SPECIAL_CHARS);

    if ($form['username'] === '') {
    $error['username'] = 'blank';
}

 $image = $_FILES['image'];
 if($image['name'] !== '' && $image['error'] === 0) {
    $finfo = new finfo();
 $type = $finfo -> file($image['tmp_name'], FILEINFO_MIME_TYPE);
 
 }
 if (isset($type)) {
 if($type !== 'image/png' && $type !== 'image/jgpe') {
    $error['image'] = 'type';
 }
 }

 if(empty($error)){
    if (isset($image['name']) == true){
            $img = date('YmdHis') . '_' . $image['name'];
            
            move_uploaded_file($image['tmp_name'], './' . $img);}
            
        if(isset($form) == true){$_SESSION['form'] = $form['username'] ;}
        $_SESSION['image'] = $img; $_SESSION['img'] = $image['name'];
        header('Location: chat.php');
        exit();
    }
    
    

}

?>




<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data" id="form">
        <div id="input"><label for="image">(必須ではない)icon:</label>
        <input type="file" name="image" id="image">
        <?php if (isset($error['image']) && $error['image'] === 'type') { ?> <p id="warning">[.png]または[.jpge]画像指定してください</p> <?php } ?>
        </div>
        <div><label for="username">username:</label> 
        <input type="text" name="username" id="username" placeholder="名前を入力してください"></input>
        <button type="submit" name="signin">login</button>
        <?php if (isset($error['username']) && $error['username'] === 'blank') { ?> <p id="warning">名前を入力してください</p> <?php } ?>
        </div>
        
    </form>
</body>
</html>
