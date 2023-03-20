<?php
    namespace App;

    use \App\Admin;
    
    session_start();
    if (!empty($_SESSION["login"]) && !empty($_SESSION["session-id"])) {
        $url = "http://localhost:8008/v1/xml/update";
        $payload = file_get_contents("php://input");
        $options = array(
            "http" => array(
                "header" => "Content-type: application/xml\r\nuser: ".$_SESSION["login"]."\r\nsession: ".$_SESSION["session-id"]."\r\n",
                "method" => "POST",
                "content" => $payload,
            )
        );
        $context = stream_context_create($options);
        echo file_get_contents($url, false, $context);
    } else {
        http_response_code(401);
        header("Content-Type: text/plain");
        echo("401 - Unauthorized");

        session_destroy();
        exit();
    }
?>