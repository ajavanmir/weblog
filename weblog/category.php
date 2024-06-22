<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    session_start();
    require_once "functions/helpers.php";
    require_once "functions/pdo_connection.php";
    if(!isset($_GET['cat_id']))redirect('/');
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
        $query = "SELECT * FROM `categories` WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$_GET['cat_id']]);
        $result = $statement->fetch();
        if(!$result)redirect('/');

        $query = "SELECT * FROM `posts` WHERE `cat_id` = ? AND `status` = 1";
        $statement = $pdo->prepare($query);
        $statement->execute([$_GET['cat_id']]);
        $post = $statement->fetch();
        ?>
        <section class="row">
            <section class="col-12">
                <h1><?=$result->name;?></h1>
                <hr>
            </section>
        </section>
        <section class="row">
            <?php if($post){
            ?>
            <section class="col-12 col-md-4">
                <div class="card">
                    <img class="card-img-top" src="<?=asset($post->image)?>" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?=$post->title?></h5>
                        <p class="card-text"><?=substr($post->body,0,30)?></p>
                        <a href="<?=url('detail.php?post_id=').$post->id;?>" class="btn btn-primary">view</a>
                    </div>
                </div>
            </section>
            <?php
            }else{
                echo "<p class='col-12 alert alert-danger d-block w-100'>Not Found Posts!</p>";
            }
            ?>
        </section>
    </section>
</section>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>