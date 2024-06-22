<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
//config
define("BASE_URL", "http://localhost/php-project/");

//helpers
function redirect($url){
    header('Location: '.trim(BASE_URL,'/ ').'/'.trim($url,'/ '));
    exit;
}

function asset($file){
    return trim(BASE_URL,'/ ').'/'.trim($file,'/ ');
}

function url($url){
    return trim(BASE_URL,'/ ').'/'.trim($url,'/ ');
}

function dd($var){
    echo "<pre>";
    var_dump($var);
    die();
}

function file_upload($file,$allowFile,$status = true){
    $mimeType = pathinfo($file["name"],PATHINFO_EXTENSION);
    if(!empty($allowFile) && in_array($mimeType,$allowFile)){
        $basePath = dirname(__DIR__);
        $image = "/assets/images/posts/".date("Y_m_d_h_i_s").".".$mimeType;
        $moveFile = move_uploaded_file($file['tmp_name'],$basePath.$image);
        if($moveFile){
            if($status)return true;
            return $image;
        }else return false;
    }else return false;
}

function remove_file($path){
    $basePath = dirname(__DIR__);
    if(file_exists($basePath.$path) && unlink($basePath.$path)){
        return true;
    }return false;
}