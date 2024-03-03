<?php
    namespace App;

    use \App\Admin;

    session_start();
    
    if (!empty($_SESSION["login"])) {
        if (!empty($_POST["new_login"]) && !empty($_POST["new_pass"])) {
            $login = filter_var($_POST["new_login"], FILTER_SANITIZE_STRING);
            $pass = filter_var($_POST["new_pass"], FILTER_SANITIZE_STRING);
            require_once("../src/locked/class/admin.php");

            if ($_SESSION["login"] != ADMIN) {
                header("Location: ../dashboard/settings.php");
            }

            $adm = new Admin();
            $result = $adm->addLogin($login, $pass);
            if ($result) {
                unset($_SESSION["errorMessage"]);
                header("Location: ../dashboard/admin-tools.php");
                exit();
            } else {
                $_SESSION["errorMessage"] = "Something went wrong";
                header("Location: ../dashboard/admin-tools.php");
                exit();
            }
        } else {
            unset($_SESSION["errorMessage"]);
            header("Location: ../dashboard/settings.php");
            exit();
        }
    } else {
        unset($_SESSION["errorMessage"]);
        header("Location: ../index.php");
        exit();
    }

?>