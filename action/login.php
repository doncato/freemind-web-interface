<?php
    namespace App;

    use \App\Admin;

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        session_start();
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        require_once("../src/locked/class/admin.php");

        $auth = new Admin();
        $isLoggedIn = $auth->processLogin($username, $password);
        if (! $isLoggedIn) {
            $_SESSION["errorMessage"] = "Invalid Credentials";
        }
    } else {
        unset($_SESSION["errorMessage"]);
        header("Location: ../index.php");
        exit();
    }

    if (!empty($_SESSION["login"])) {
        header("Location: ../dashboard.php");
    } else {
        header("Location: ../index.php");
    }
?>