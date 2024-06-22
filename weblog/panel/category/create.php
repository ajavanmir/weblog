<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    require_once "../../functions/helpers.php";
    require_once "../../functions/pdo_connection.php";
    require_once "../../functions/check-login.php";

    $name = $_POST['name']??null;
    if(isset($name) && trim($name) != ''){
        global $pdo;
        $query = "INSERT INTO `categories` (`name`, `created_at`, `updated_at`) VALUES (?, NOW(), NOW())";
        $statement = $pdo->prepare($query);
        $result = $statement->execute([$name]);
        if($result)redirect("panel/category");
    }
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
                <form action="<?=url("panel/category/create.php");?>" method="post">
                    <section class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="name ...">
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
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