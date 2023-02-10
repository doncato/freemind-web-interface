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
                        <th>Delete</th>
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
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNewPrompt">Add New</button>
        </div>
        
        <!-- START ADD NEW MODAL -->
        <div class="modal fade" id="addNewPrompt">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Event</h4>
                        <button type="button" class="btn-close" onclick="addNewClear()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addNewForm" class='needs-validation'>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Type</span>
                                <select class="form-select addNewEle" id="type">
                                    <option>Event</option>
                                    <option>ToDo</option>
                                    <option>Appointment</option>
                                </select>
                            </div>
                            <input type="text" class="form-control addNewEle mb-3" id="title" placeholder="Title">
                            <textarea rows="5" class="form-control addNewEle mb-3" id="description" placeholder="Description"></textarea>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Due</span>
                                <span class="mx-3"></span>
                                <input type="number" id="dueDate-1" class="form-control addNewEle" placeholder="00" min="0" max="23" oninput="adjustVal(this)">
                                <span class="input-group-text">:</span>
                                <input type="number" id="dueDate-2" class="form-control addNewEle" placeholder="00" min="0" max="59" oninput="adjustVal(this)">
                                <span class="mx-3"></span>
                                <input type="number" id="dueDate-3" class="form-control addNewEle" placeholder="00" min="1" max="31" oninput="adjustVal(this)">
                                <span class="input-group-text">/</span>
                                <input type="number" id="dueDate-4" class="form-control addNewEle" placeholder="00" min="1" max="12" oninput="adjustVal(this)">
                                <span class="input-group-text">/ 20</span>
                                <input type="number" id="dueDate-5" class="form-control addNewEle" placeholder="00" min="20" max="38" oninput="adjustVal(this)">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" onclick="addNewClear()">Cancel</button>
                        <button type="button" class="btn btn-outline-primary" onclick="addNew()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ADD NEW MODAL -->

        <script src="./src/dashboard-script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>