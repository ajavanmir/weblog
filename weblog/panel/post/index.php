<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    require_once "../../functions/helpers.php";
    require_once "../../functions/pdo_connection.php";
    require_once "../../functions/check-login.php";
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
                <section class="mb-2 d-flex justify-content-between align-items-center">
                    <h2 class="h4">Categories</h2>
                    <a href="<?=url("panel/post/create.php");?>" class="btn btn-sm btn-success">Create</a>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>image</th>
                            <th>title</th>
                            <th>cat_id</th>
                            <th>body</th>
                            <th>status</th>
                            <th>setting</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                global $pdo;
                                $query = "SELECT posts.*,categories.name as `cat_name` FROM `posts` LEFT JOIN `categories` ON posts.cat_id = categories.id";
                                $statement = $pdo->prepare($query);
                                $statement->execute();
                                $posts = $statement->fetchAll();
                                foreach($posts as $post){
                            ?>
                            <tr>
                                <td><?= $post->id;?></td>
                                <td><img style="width: 90px;" src="<?=asset($post->image);?>"></td>
                                <td><?= $post->title;?></td>
                                <td><?= isset($post->cat_name)? $post->cat_name: "";?></td>
                                <td><?= substr($post->body,0,100)."...";?></td>
                                <td><?= $post->status?"<span class='text-success'>enable</span>":"<span class='text-danger'>disable</span>";?></td>
                                <td>
                                    <a href="<?= url('panel/post/change-status.php?id='.$post->id); ?>" class="btn btn-warning btn-sm">Change status</a>
                                    <a href="<?= url('panel/post/edit.php?id='.$post->id); ?>" class="btn btn-info btn-sm">Edit</a>
                                    <a href="<?= url('panel/post/delete.php?id='.$post->id); ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
</section>
<script src="<?=asset("assets/js/jquery.min.js");?>"></script>
<script src="<?=asset("assets/js/bootstrap.min.js");?>"></script>
</body>
</html>