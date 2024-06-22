<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    require_once "../../functions/helpers.php";
    require_once "../../functions/pdo_connection.php";
    require_once "../../functions/check-login.php";
    $id = trim($_GET['cate_id']);
    if(isset($id) && !empty($id) && is_numeric($id)){
        global $pdo;
        $query = "DELETE FROM `categories` WHERE id = ?";
        $statement = $pdo->prepare($query);
        if($statement->execute([$id])){
            redirect("panel/category");
        }
    }else redirect("panel/category")
?>