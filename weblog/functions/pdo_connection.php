<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
global $pdo;
try{
    $pdo_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ];
    $pdo = new pdo("mysql:host=localhost;dbname=weblog","root","",$pdo_options);
    return $pdo;
}catch(PDOException $e){
    echo 'error:'.$e->getMessage();
    exit;
}
?>