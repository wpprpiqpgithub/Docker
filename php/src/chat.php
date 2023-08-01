<?php  
$J_file = "chatlog.json"; // ファイルパス格納
date_default_timezone_set('Asia/Tokyo'); // タイムゾーンを日本にセット

session_start();
$username = $_SESSION['form']; $image = $_SESSION['image']; $img = $_SESSION['img'];

if(isset($_GET['person'])){
  $_SESSION['person'] = $_GET['person'];
}else{
  if(empty($_GET['change']) && empty($_SESSION['person'])){
    $_SESSION['person'] = 'person1'; 
  }elseif ( $_SESSION['person'] === "person2"){
    $_SESSION['person'] = 'person1';
  }elseif ( $_SESSION['person'] === 'person1'){
    $_SESSION['person'] = 'person2';
  }
}
    
if(isset($_POST['submit']) && $_POST['submit'] === "送信"){ 
    
    if($_SESSION['person'] === 'person1'){

    $chat = [];
    $chat["person"] = "person1";
    if(!empty($img) == true){$chat["imgPath"] = "$image";}else{$chat["imgPath"] = "HIRO_20141011-P1050014_TP_V4.jpg";} 
    $chat["time"] = date("H:i");
    $chat["text"] = htmlspecialchars($_POST['text'],ENT_QUOTES);

    }elseif($_SESSION['person'] === 'person2'){

    $chat = [];
    $chat["person"] = "person2";
    $chat["imgPath"] = "ftdrdftgy_TP_V4.jpg"; 
    $chat["time"] = date("H:i");
    $chat["text"] = htmlspecialchars($_POST['text'],ENT_QUOTES);

    }

    if($file = file_get_contents($J_file)){ 
      $file = str_replace(array(" ","\n","\r"),"",$file);
      $file = mb_substr($file,0,mb_strlen($file)-2);
      $json = json_encode($chat);
      $json = $file.','.$json.']}';
      file_put_contents($J_file,$json,LOCK_EX);
    }else{ 
      $json = json_encode($chat);
      $json = '{"chatlog":['.$json.']}';
      file_put_contents($J_file,$json,FILE_APPEND | LOCK_EX);
    } 

    // header('Location:https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/chat.php');
    header('Location:./chat.php');
    exit;   

  } 

if($file = file_get_contents($J_file)){
  $file = json_decode($file);
  $array = $file->chatlog;
  foreach($array as $object){
        if(isset($result)){
            $result =  $result.'<div class="'.$object->person.'"><p class="chat">'.str_replace("\r\n","<br>",$object->text).'<span class="chat-time">'.$object->time.'</span></p><img src="'.$object->imgPath.'"></div>';
        }else{
            $result = '<div class="'.$object->person.'"><p class="chat">'.str_replace("\r\n","<br>",$object->text).'<span class="chat-time">'.$object->time.'</span></p><img src="'.$object->imgPath.'"></div>';
        }
} 


if(isset($filesize)){
$result = $result .'<input id="preFilesize" type="hidden" value="'.$_SESSION['filesize'].'"><input id="aftFilesize" type="hidden" value="'.$filesize.'">';

$result = '<input id="preFilesize" type="hidden" value="'.$_SESSION['filesize'].'"><input id="aftFilesize" type="hidden" value="'.$filesize.'">'; 

};

}

if( isset($_GET['reset'])){
  file_put_contents($J_file,'');
  header("Location:./chat.php");
  exit;
}

if( isset($_GET['back'] )){

  $_session = [];
  if(isset($_COOKIE[session_name()])){
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"],$params["domain"],$params["secure"],$params['httponly']);
  }
  session_destroy();
  header("Location:../index.php");
  exit;
  
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
  <title>チャット</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="main.js"></script>
</head>
<body class="<?php if($_SESSION['person'] === 'person2'){echo "second";}?>">
  <main class="main">
  <div class="chat-system">
  
    <h2 class="text-center"></h2>
    <p class="text-center">1対1のチャット機能です。下のユーザーを切り替えることで会話が楽しめます。</p>
    <form method="get" action="chat.php">
      <div class="change-person flex-box">
        <input type="submit" id="person2" name="person" value="person2"><label for="person2"><img class="<?php if($_SESSION['person'] === 'person2'){echo "on";}?>" src=<?php if(!empty($img)){echo $image;}else{echo "HIRO_20141011-P1050014_TP_V4.jpg";} ?>></label>
        <input type="submit" id="change" name="change" value="change"><label for="change"><img src="2093.png"></label>
        <input type="submit" id="person1" name="person" value="person1"><label for="person1"><img class="<?php if($_SESSION['person'] === 'person1'){echo "on";}?>" src="ftdrdftgy_TP_V4.jpg"></label>
      </div>
    </form>
  

    <div class="chat-box">
      <div class="chat-area" id="chat-area">
        <?php if(isset($result)){
         echo $result; 
        } ?>
      </div>
      <form class="send-box flex-box" action="chat.php#chat-area" method="post">
      <textarea id="textarea" type="text" name="text" rows="1" required placeholder="message.."></textarea>
        <input type="submit" name="submit" value="送信" id="search">
        </form>
    </div>
  </div>
<dt><dd style="position: absolute ; top: 5% ; right:10% ; font-size:2rem ; font-weight:600;"><?php echo($username) ?></dd></dt>
<?php if(!empty($img)){ ?><form action="chat.php" method="$_GET"><input type="submit" value="アイコンを削除する" name="unlink" style="color: red"></input></from> <?php if(isset($_GET['unlink'])){  if(isset($img)){if(!empty($img)){unlink($image);}} } } ?>

  <form action="chat.php" method="$_GET">
    <input class="bth back-bth" type="submit" name="back" value="Topページに戻る">
    <input class="bth back-bth" type="submit" name="reset" value="チャット履歴をリセット">
  </form>

  </main>
</body>
</html>