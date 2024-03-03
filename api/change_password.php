<?php
    namespace App;

    use \App\Admin;

    session_start();
    
    if (!empty($_SESSION["login"])) {
        if (!empty($_POST["old_pass"]) && !empty($_POST["new_pass"])) {
            
            $username = $_SESSION["login"];
            $old = filter_var($_POST["old_pass"], FILTER_SANITIZE_STRING);
            $new = filter_var($_POST["new_pass"], FILTER_SANITIZE_STRING);
            require_once("../src/locked/class/admin.php");

            $adm = new Admin();
            $result = $adm->changePassword($username, $old, $new);
            if ($result) {
                unset($_SESSION["errorMessage"]);
                header("Location: ../dashboard.php");
                exit();
            } else {
                $_SESSION["errorMessage"] = "Invalid Credentials";
                header("Location: ../dashboard/settings.php");
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