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

    if(isset($_POST['update'])){
        extract($_POST);
        if(isset($title) && !empty($title) && isset($cat_id) && !empty($cat_id) && isset($body) && !empty($body)){
            $query = "SELECT name FROM `categories` WHERE id = ? ";
            $statement = $pdo->prepare($query);
            $statement->execute([$cat_id]);
            if($result = $statement->fetch()){
                if(!$result)redirect("panel/post");
                extract($_FILES);
                
                if(isset($image) && !empty($image["name"])){
                    if(remove_file($post->image)){
                        $file = file_upload($image,["png","jpg","jpeg","gif"],0);
                        $query = "UPDATE `posts` SET `title` = ?, `body` = ?, `cat_id` = ?, `image` = ? WHERE id = ?";
                        $statement = $pdo->prepare($query);
                        $result = $statement->execute([$title,$body,$cat_id,$file, $_GET['id']]);
                        redirect("panel/post");
                    }
                }else{
                    $query = "UPDATE `posts` SET `title` = ?, `body` = ?, `cat_id` = ? WHERE id = ?";
                    $statement = $pdo->prepare($query);
                    $statement->execute([$title,$body,$cat_id, $_GET['id']]);
                    redirect("panel/post");
                }
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
                    <form action="<?=url('panel/post/edit.php?id=').$_GET['id'];?>" method="post" enctype="multipart/form-data">
                        <section class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="<?=$post->title;?>">
                        </section>
                        <section class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <img src="<?=url($post->image);?>" width="100" />
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
                            <option value="<?= $cat->id;?>" <?php if($post->cat_id == $cat->id)echo "selected";?>><?=$cat->name ;?></option>
                            <?php } ?>
                            </select>
                        </section>
                        <section class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" name="body" id="body" rows="5"><?=$post->body;?></textarea>
                        </section>
                        <section class="form-group">
                            <button name="update" type="submit" class="btn btn-primary">Update</button>
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