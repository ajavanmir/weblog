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
        $query = "SELECT name FROM `categories` WHERE id = ? ";
        $statement = $pdo->prepare($query);
        if($statement->execute([$id])){
            $result = $statement->fetch();
            if(!$result)redirect("panel/category");
            $cateName = $result->name;
            if(isset($_POST["name"]) && trim($_POST["name"]) != ''){
                $name = $_POST["name"];
                $query = "UPDATE `categories` SET `name` = ?, `updated_at` = NOW() WHERE `id` = ?;";
                $statement = $pdo->prepare($query);
                if($statement->execute([$name,$id]))redirect("panel/category");
            }
        }
    }else redirect("panel/category");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP panel</title>
    <link rel="stylesheet" href="<?=asset("assets/css/bootstrap.min.css");?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?=asset("assets/css/style.css");?>" media="all" type="text/css">
</head>
<body>
<section id="app">
    <?php require_once "../layouts/top-nav.php"; ?>
    <section class="container-fluid">
        <section class="row">
            <section class="col-md-2 p-0">
            <?php require_once "../layouts/sidebar.php"; ?>
            </section>
            <section class="col-md-10 pt-3">
                <form action="<?=url("panel/category/edit.php?cate_id=").$id;?>" method="post">
                    <section class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?=$cateName; ?>">
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
<script src="<?=asset("assets/js/jquery.min.js");?>"></script>
<script src="<?=asset("assets/js/bootstrap.min.js");?>"></script>
</body>
</html>