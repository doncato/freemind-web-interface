<?php
    namespace App;

    use \App\Admin;

    session_start();
    
    if (!empty($_SESSION["login"])) {
        if (!empty($_POST["login"])) {
            $login = filter_var($_POST["login"], FILTER_SANITIZE_STRING);
            require_once("../src/locked/class/admin.php");

            if ($_SESSION["login"] != ADMIN) {
                header("Location: ../dashboard/settings.php");
            }

            $adm = new Admin();
            $result = $adm->removeLogin($login);
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
            header("Location: ../dashboard/admin-tools.php");
            exit();
        }
    } else {
        unset($_SESSION["errorMessage"]);
        header("Location: ../index.php");
        exit();
    }

?>