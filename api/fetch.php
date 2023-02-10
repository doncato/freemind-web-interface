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
        if (file_exists($file_loc)) {
            http_response_code(200);
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($file_loc));
            header("Content-Disposition: attachment; filename=".$_SESSION["login"].".xml");
            readfile($file_loc);

            exit();
        } else {
            $new_file = fopen($file_loc, "w") or die ("Couldn't open file");
            $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><registry version=\"1.0\"></registry>";
            fwrite($new_file, $content);
            fclose($new_file);

            http_response_code(201);
            header("Content-Type: text/plain");
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($file_loc));
            header("Content-Disposition: attachment; filename=".$_SESSION["login"].".xml");
            readfile($file_loc);

        }
    } else {
        http_response_code(403);
        header("Content-Type: text/plain");
        echo("401 - Unauthorized");

        session_destroy();
        exit();
    }
?>