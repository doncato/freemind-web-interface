<?php
    namespace App;

    use \App\Admin;

    session_start();

    if (!empty($_SESSION["login"])) {
        $name = $_SESSION["login"];
    } else {
        header("Location: ./index.php");
        exit();
    }
?>

<!DOCTYPE html">
<html>
    <?php
        include "./src/locked/head.html";
    ?>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-right mb-3 px-3">
            <div class="container">
                <span class="navbar-text">Logged in as: <em><?php echo $name;?></em></span>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./dashboard/settings.php">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="container justify-content-center">
            <h4>Your Events</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody id="table">
                    <tr>
                        <td><div class="spinner-border text-muted"></div></td>
                        <td><div class="spinner-border text-muted"></div></td>
                        <td><div class="spinner-border text-muted"></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <script src="./src/dashboard-script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>