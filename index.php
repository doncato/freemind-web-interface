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
            <form action="./login.php" method='post' class='needs-validation'>
                <div class='row'>
                    <div class='col-5'>
                        <input type="text" class="form-control <?php echo $invalid; ?>" id="username" placeholder="Username" name="username">
                        <div class='invalid-feedback'><?php echo $message; ?></div>
                    </div>
                    <div class='col-5'>
                        <input type="password" class="form-control <?php echo $invalid; ?>", id="password" placeholder="Password" name="password">
                        <div class='invalid-feedback'><?php echo $message; ?></div>
                    </div>
                    <div class='col-2'>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
