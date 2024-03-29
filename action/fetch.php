<?php
    namespace App;

    use \App\Admin;

    session_start();
    if (!empty($_SESSION["login"]) && !empty($_SESSION["session-id"])) {
        $url = "http://localhost:8008/v1/xml/fetch";
        $options = array(
            "http" => array(
                "header" => "user: ".$_SESSION["login"]."\r\nsession: ".$_SESSION["session-id"]."\r\n",
                "method" => "POST",
                "content" => "",
            )
        );
        $context = stream_context_create($options);
        $ctx = file_get_contents($url, false, $context);
        if (!$ctx) {
            $ctx = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><registry version=\"1.0\"></registry>";
        }
        echo $ctx;
    } else {
        http_response_code(401);
        header("Content-Type: text/plain");
        echo("401 - Unauthorized".$_SESSION["login"]." ".$_SESSION["session-id"]);

        session_destroy();
        exit();
    }
?>
