<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    session_start();
    require_once "functions/helpers.php";
    require_once "functions/pdo_connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP tutorial</title>
    <link rel="stylesheet" href="<?=asset("assets/css/bootstrap.min.css");?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?=asset("assets/css/style.css");?>" media="all" type="text/css">
</head>
<body>
<section id="app">
    <?php require_once "layout/top-nav.php"?>
    <section class="container my-5">
        <?php
        global $pdo;
        $query = "SELECT posts.*, categories.name AS cat_name FROM posts JOIN categories ON posts.cat_id = categories.id WHERE posts.status = 1 AND posts.id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$_GET['post_id']]);
        $result = $statement->fetch();
        if(!$result)redirect('/');
        ?>
        <section class="row">
            <section class="col-md-12">
                <h1><?=$result->title;?></h1>
                <h5 class="d-flex justify-content-between align-items-center">
                    <a href=""><?=$result->cat_name;?></a>
                    <span class="date-time"><?=$result->created_at;?></span>
                </h5>
                <article class="bg-article p-3"><img class="float-right mb-2 ml-2" style="width: 18rem;" src="" alt=""><?=$result->body;?></article>
            </section>
        </section>
    </section>

</section>
<script src="<?=asset("assets/js/jquery.min.js");?>"></script>
<script src="<?=asset("assets/js/bootstrap.min.js");?>"></script>
</body>
</html>