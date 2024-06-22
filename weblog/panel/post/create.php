<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    require_once "../../functions/helpers.php";
    require_once "../../functions/pdo_connection.php";
    require_once "../../functions/check-login.php";
    
    if(isset($_POST['create'])){
        extract($_POST);
        extract($_FILES);
        if(isset($title) && !empty($title) && isset($cat_id) && !empty($cat_id) && isset($body) && !empty($body) && isset($image) && !empty($image["name"])){
            global $pdo;
            $query = "SELECT name FROM `categories` WHERE id = ? ";
            $statement = $pdo->prepare($query);
            if($statement->execute([$cat_id])){
                $result = $statement->fetch();
                $file = file_upload($image,["png","jpg","jpeg","gif"],0);
                if(!$result || empty($file))redirect("panel/post");
                $query = "INSERT INTO `posts` (`title`,`body`,`cat_id`,`image`) VALUES (?,?,?,?)";
                $statement = $pdo->prepare($query);
                $result = $statement->execute([$title,$body,$cat_id,$file]);
                if($result)redirect("panel/post");
            }
        }else redirect("panel/post");
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
                <form action="<?=url("panel/post/create.php");?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="title ...">
                    </section>
                    <section class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </section>
                    <section class="form-group">
                        <label for="cat_id">Category</label>
                        
                        <select class="form-control" name="cat_id" id="cat_id">
                        <?php
                            global $pdo;
                            $query = "SELECT * FROM `categories`";
                            $statement = $pdo->prepare($query);
                            $statement -> execute();
                            $result = $statement->fetchAll();
                            foreach($result as $cat){
                        ?>
                        <option value="<?= $cat->id;?>"><?=$cat->name ;?></option>
                        <?php } ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."></textarea>
                    </section>
                    <section class="form-group">
                        <button type="submit" name="create" class="btn btn-primary">Create</button>
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