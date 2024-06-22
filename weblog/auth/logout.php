<?php
/*
Copyright amir javanmir
Released on: June 22, 2024
*/
session_start();
require_once "../functions/helpers.php";
session_destroy();
redirect("auth/login.php");
?>