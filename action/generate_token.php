<?php
    namespace App;

    use \App\Admin;

    session_start();
    
    if (!empty($_SESSION["login"])) {
        $username = $_SESSION["login"];
        require_once("../src/locked/class/admin.php");

        $adm = new Admin();
        $result = $adm->generateToken($username);
        echo $result;
    } else {
        unset($_SESSION["errorMessage"]);
        header("Location: ../index.php");
        exit();
    }

?>