<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
session_start();
if(!isset($_SESSION["user"])){
    redirect("auth/login.php");    
}
?>