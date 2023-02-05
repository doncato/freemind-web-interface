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
                <span class="navbar-text">Willkommen im Dashboard, <em><?php echo $name;?></em></span>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <h4>Token Erstellen</h4>
            <form action="../act/add.php" method="post" id="addForm">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="expBool" name="expBool" value="yes" checked>
                    <label class="form-check-label" for="expireSwitch">Verfällt</label>
                </div>
            <div class="row my-3">
                <div class="input-group">
                    <div>
                        <span class="input-group-text">Verfällt nach</span>
                    </div>
                    <div class="col">
                        <input type="number" step="1" min="1" class="form-control" id="expValue" name="expValue" required>
                        <div class="invalid-feedback">Bitte eine natürliche Zahl angeben</div>
                    </div>
                    <div class="col-2">
                        <select class="form-select" id="expUnit" name="expUnit">
                            <option>Minute(n)</option>
                            <option>Stunde(n)</option>
                            <option>Tag(en)</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary">Hinzufügen</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container justify-content-center">
        <h4>Token Verwalten</h4>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Verfällt am</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($tokens ?? array() as $token) {
                        $id = $token["id"];
                        if ($token["expires"] > 0) {
                            $date = date('H:i:s d-m-Y e', $token["expires"]);

                        } else {
                            $date = "Permanent";
                        }
                        echo "
                            <tr>
                                <td>$id</td>
                                <td>$date</td>
                                <td>
                                    <button
                                        type='button'
                                        class='btn btn-sm btn-outline-danger'
                                        onclick='deleteToken($id)'>
                                            Löschen
                                    </button>
                                </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
        <?php
        echo count($tokens??array()) . " Token(s) gefunden";
        ?>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>