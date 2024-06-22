<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    require_once "../../functions/helpers.php";
    require_once "../../functions/pdo_connection.php";
    require_once "../../functions/check-login.php";

    if(!isset($_GET['id']) || empty($_GET['id']))redirect("panel/post");
    global $pdo;
    $query = "SELECT * FROM `posts` WHERE `id` = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$_GET['id']]);
    $post = $statement->fetch();
    if(!$post){
        redirect("panel/post");   
    }
    $status = $post->status? 0 : 1;
    $query = "UPDATE `posts` SET `status` = ? WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$status, $_GET['id']]);
    if($statement->rowCount()){
        redirect("panel/post");     
    }
?>