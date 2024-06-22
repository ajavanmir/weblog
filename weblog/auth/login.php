<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    session_start();
    require_once '../functions/helpers.php';
    require_once '../functions/pdo_connection.php';

    if(isset($_SESSION["user"]))unset($_SESSION["user"]);

    $errors = [];
    
    if(isset($_POST['submit'])){
        extract($_POST);
        if(isset($email) && !empty($email) && isset($password) && !empty($password)){
            global $pdo;
            $query = "SELECT `email`,`password` FROM `users` WHERE `email` = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$email]);
            $result = $statement->fetch();
            if($result){
                if(password_verify($password,$result->password)){
                    $_SESSION["user"] = $result->email;
                    redirect("panel");
                }else{
                    $errors[] = "password incorrect!";                        
                }
            }else{
                $errors[] = "user not found!";    
            }
        }else{
            $errors[] = "Error to login!";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP tutorial</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>
<body>
    <section id="app">
        <section style="height: 100vh; background-color: #138496;" class="d-flex justify-content-center align-items-center">
            <section style="width: 20rem;">
                <h1 class="bg-warning rounded-top px-2 mb-0 py-3 h5">PHP Tutorial login</h1>
                <form class="pt-3 pb-1 px-2 bg-light rounded-bottom" action="<?= url('auth/login.php') ?>" method="post">
                    <?php
                    if(!empty($errors)){
                        echo "<p class='alert alert-danger'>";
                        foreach($errors as $val){
                            echo $val."<br>";
                        }
                        echo "</p>";
                    }
                    ?>
                    <section class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="email ...">
                    </section>                    
                    <section class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password ...">
                    </section>
                    <section class="mt-4 mb-2 d-flex justify-content-between">
                        <input type="submit" name="submit" class="btn btn-success btn-sm" value="login">
                        <a href="<?=url("auth/register.php");?>">register</a>
                    </section>
                </form>
            </section>
        </section>
    </section>
    <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>