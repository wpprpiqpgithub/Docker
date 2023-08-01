<?php

$J_file = "chatlog.json";
$filesize = filesize($J_file);

if(isset($_GET['ajax']) && $_GET['ajax'] === "ON"){
    if($file = file_get_contents($J_file)){
        $file = json_decode($file);
        $array = $file->chatlog;
        foreach($array as $object){
            if(isset($result)){
                $result = $result.'<div class="'.$object->person.'"><p class="chat">'.str_replace("\r\n","<br>",$object->text).'<span class="chat-time">'.$object->time.'</span></p><img src="'.$object->imgPath.'"></div>';
            }else{
                $result = '<div class="'.$object->person.'"><p class="chat">'.str_replace("\r\n","<br>",$object->text).'<span class="chat-time">'.$object->time.'</span></p><img src="'.$object->imgPath.'"></div>';
            }
        }
    }
    $result = $result .'<input id="preFilesize" type="hidden" value="'.$filesize.'"><input id="aftFilesize" type="hidden" value="'.$filesize.'">';
    echo $result;
    exit;

}elseif(isset($_GET['ajax']) && $_GET['ajax'] === "OFF"){
    echo $filesize;
    exit;

}