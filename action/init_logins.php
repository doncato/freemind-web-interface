<?php
    namespace App;

    use \App\Admin;

    session_start();

    require_once ("../src/locked/class/admin.php");

    $username = "doncato";
    $password = "doncato";

    $auth = new Admin();
    $r = $auth->addLogin($username, $password);

    echo ($r);
    echo "<br>";
    echo "$username - $password";
    echo "<br>";
    echo "Success";
?>
