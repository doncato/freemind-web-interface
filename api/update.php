<?php
    namespace App;

    use \App\Admin;

    session_start();
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        session_start();
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        require_once("./src/locked/class/admin.php");
    
        $auth = new Admin();
        $isLoggedIn = $auth->processLogin($username, $password);
        if (! $isLoggedIn) {
            $_SESSION["errorMessage"] = "Invalid Credentials";
        }
    }
    
    if (!empty($_SESSION["login"])) {
        $file_loc = "../users/".$_SESSION["login"].".xml";
        $payload = file_get_contents("php://input");
        $file = fopen($file_loc, "w") or die ("Couldn't open file");
        fwrite($file, $payload);
        fclose($file);

        http_response_code(200);

    } else {
        http_response_code(403);
        header("Content-Type: text/plain");
        echo("401 - Unauthorized");

        session_destroy();
        exit();
    }
?>