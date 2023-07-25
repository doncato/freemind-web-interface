<?php
    namespace App;

    use \App\Admin;

    session_start();

    if (!empty($_SESSION["login"])) {
        $name = $_SESSION["login"];

        require_once("../src/locked/class/admin.php");
        if ($_SESSION["login"] != ADMIN) {
            header("Location: ../dashboard.php");
        }
        $auth = new Admin();
        $auth->extendSession($_SESSION["id"], $_SESSION["session-id"]);
    } else {
        header("Location: ../index.php");
        exit();
    }

    $invalid = "";
    if (!empty($_SESSION["errorMessage"])) {
        $invalid = "is-invalid";
    }
    $message = $_SESSION["errorMessage"] ?? "";
?>

<!DOCTYPE html">
<html>
    <?php
        include "../src/locked/head.html";
    ?>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-right mb-3 px-3">
            <div class="container">
                <span class="navbar-text">Logged in as: <em><?php echo $name;?></em></span>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard.php">Home</a>
                </li>
                <?php
                if ($_SESSION["login"] == ADMIN) {
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"./admin-tools.php\">Admin Tools</a></li>";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="./settings.php">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../action/logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <h4>Create User</h4>
            <form action="../action/create_user.php" method='post' class='needs-validation'>
                <div class="input-group">
                    <input type="text" class="form-control <?php echo $invalid; ?>" name="new_login" placeholder="Username">
                    <input type="password" class="form-control <?php echo $invalid; ?>" placeholder="Password" name="new_pass">
                    <button class="btn btn-danger" type="submit">Create</button>
                </div>
            </form> 
        </div>
        <div class="container">
            <h4>Delete User</h4>
            <form action="../action/delete_user.php" method='post' class='needs-validation'>
                <div class="input-group">
                    <input type="text" class="form-control" name="login" placeholder="Username">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form> 
        </div>
    </div>
        <script src="../src/settings-script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>