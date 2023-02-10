<?php
    namespace App;

    use \App\Admin;

    session_start();

    if (!empty($_SESSION["login"])) {
        $name = $_SESSION["login"];
        header("Location: ./dashboard.php");
        exit();
    }

    $invalid = "";
    if (!empty($_SESSION["errorMessage"])) {
        $invalid = "is-invalid";
    }
    $message = $_SESSION["errorMessage"] ?? "";
    session_unset();
?>
<!DOCTYPE html">
<html>
    <?php
        include("./src/locked/head.html");
    ?>
    <body>
        <div class="container my-5">
            <h1>Freemind</h1>
            <p>
                To proceed please enter your credentials:
            </p>
        </div>
        <div class="container">
            <form action="./action/login.php" method='post' class='needs-validation'>
                <div class='input-group'>
                    <input type="text" class="form-control <?php echo $invalid; ?>" id="username" placeholder="Username" name="username">
                    <span class='invalid-feedback'><?php echo $message; ?></span>
                    <input type="password" class="form-control <?php echo $invalid; ?>", id="password" placeholder="Password" name="password">
                    <span class='invalid-feedback'><?php echo $message; ?></span>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
