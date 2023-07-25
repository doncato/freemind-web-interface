<?php
    namespace App;
    use \App\Admin;
    
    session_start();
    if (!empty($_SESSION["login"])) {
        require_once("../src/locked/class/admin.php");
        $auth = new Admin();
        $auth->deleteSession($_SESSION["id"],$_SESSION["session-id"]);
    }
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
?>