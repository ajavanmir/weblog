<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
    require_once '../functions/helpers.php';
    require_once '../functions/pdo_connection.php';

    $errors = [];
    
    if(isset($_POST['submit'])){
        extract($_POST);
        if(isset($email) && !empty($email) && isset($first_name) && !empty($first_name) && isset($last_name) && !empty($last_name) && isset($password) && !empty($password) && isset($confirm) && !empty($confirm)){
            if($password === $confirm){
                if(strlen($password)>=8){
                    global $pdo;
                    $query = "SELECT `email` FROM `users` WHERE `email` = ?";
                    $statement = $pdo->prepare($query);
                    $statement->execute([$email]);
                    $result = $statement->fetch();
                    if(!$result){
                        $query = "INSERT INTO `users` (`email`,`first_name`,`last_name`,`password`) VALUES (?,?,?,?)";
                        $statement = $pdo->prepare($query);
                        $password = password_hash($password,PASSWORD_DEFAULT);
                        $result = $statement->execute([$email,$first_name,$last_name,$password]);
                        if($result){
                            redirect("auth/login.php");
                        }
                    }else{
                        $errors[] = "user email is exist!";
                    }                    
                }else{
                    $errors[] = "the password not safe please enter 8 character!";
                }
            }else{
                $errors[] = "The password and its repetition are not the same!";
            }
        }else{
            $errors[] = "Error to submit form!";
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
                <form class="pt-3 pb-1 px-2 bg-light rounded-bottom" action="<?= url('auth/register.php') ?>" method="post">
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
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first_name ...">
                    </section>
                    <section class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last_name ...">
                    </section>
                    <section class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password ...">
                    </section>
                    <section class="form-group">
                        <label for="confirm">Confirm</label>
                        <input type="password" class="form-control" name="confirm" id="confirm" placeholder="confirm ...">
                    </section>
                    <section class="mt-4 mb-2 d-flex justify-content-between">
                        <input type="submit" name="submit" class="btn btn-success btn-sm" value="register">
                        <a href="<?=url("auth/login.php");?>">login</a>
                    </section>
                </form>
            </section>
        </section>
    </section>
    <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>