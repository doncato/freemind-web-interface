<?php
    namespace App;

    use \App\Admin;

    session_start();

    if (!empty($_SESSION["login"])) {
        $name = $_SESSION["login"];

        require_once("../src/locked/class/admin.php");
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
            <h4>Change Password</h4>
            <form action="../action/change_password.php" method='post' class='needs-validation'>
                <div class="input-group">
                    <input type="text" class="form-control" name="username" value="<?php echo $name;?>" readonly>
                    <input type="password" class="form-control <?php echo $invalid; ?>" placeholder="Old Password" name="old_pass">
                    <input type="password" class="form-control <?php echo $invalid; ?>" placeholder="New Password" name="new_pass">
                    <button class="btn btn-danger" type="submit">Change</button>
                </div>
            </form> 
            <h4>Generate Token</h4>
            <p>
                This will re-generate your personal access token which can be used as
                a login method for third-party applications.<br> Be sure to store it securely,
                as it will only be visible once and grants access to your whole account.<br>
                Your old token will be invalid afterwards.<br>
                (Note: The clear button will only clear the text field and will not unvalidate the token.)
            </p>
            <div class="input-group">
                <input type="text" id="token-field" class="form-control" name="token" value="" placeholder="Your token will be shown here" readonly>
                <button type="button" class="btn btn-outline-secondary" onclick="clear_token()">Clear</button>
                <button type="button" class="btn btn-danger" onclick="generate_token()">Generate</button>
            </div>
        </div>
    </div>
        <script src="../src/settings-script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>