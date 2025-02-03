<?php
require_once("../database/databaseLogin.php");

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


session_start();

if (isset($_SESSION["email"]) && $_SESSION["password"] && $_SESSION['admin_id']) {
    $email = $_SESSION["email"];
    $name = $_SESSION["name"];
} else {
    header("Location: ../login.php");
}
$query = "SELECT * FROM `vehicle`";
$stmt = $pdo->prepare($query);

$stmt->execute();

$vehicle_table = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../dashboard/styles.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>AdminDashboard</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <a class="navbar-brand pt-4 px-2" onclick="location.href='../index.php'">
                    <img src="../images/logo.jpg" alt="Logo" width="80" height="80" class="rounded-circle">
                </a>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="payments.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-wallet me-2"></i>Payments</a>
                <a href="expenses.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-user me-2"></i>Expenses</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i
                        class="fa-solid fa-bell me-2"></i>Manage Vehicles</a>
                <a href="customerManagement.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-users me-2"></i>Manage Customers</a>
                <a href="monthlyReport.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-chart-line me-2"></i>Monthly Report</a>
                <form action="../logout.php" method="POST">
                    <button type="submit" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold" style="border: none; background: none;">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Manage Vehicles</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <!--- updated --->
                                <i class="fas fa-user me-2"></i><?php echo $name  ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> <!--- updated --->
                                <li><a class="dropdown-item text-center fw-bold" href="#">Profile</a></li>
                                <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                                <form action="../logout.php" method="POST">
                                    <button type="submit" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold" style="border: none; background: none;">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                    </button>
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <br>
            <div>
                <button type="button" class="btn btn-warning mx-5" data-bs-toggle="modal" data-bs-target="#addnewvehicle"><span><span>ADD NEW</span></span></button>
            </div>
            <br>
            <!-- vehicle showing -->
            <div class="row g-0 d-flex justify-content-around mx-0">
                <div class="col-11">
                    <div class="container">
                        <div class="scrollable-container vh-70name">
                            <div class="row gy-5 d-flex justify-content-start mx-0 gap-5 mx-0">

                                <?php

                                foreach ($vehicle_table as $vehicle) {

                                    $vehicle_img = $vehicle['image'];
                                    $vehicle_name = $vehicle['Make'] . " " . $vehicle['Model'];
                                    $vehicle_descr = $vehicle['description'];
                                    $vehicle_reg_number = $vehicle['Registration_number'];


                                    echo <<< _END
        
                                <div class="card col-12 col-md-3 px-0" style="width: 15rem;">
                                        <img src="../$vehicle_img" class="card-img-top" alt="...">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-center">$vehicle_name</h5>
                                            <br><br>
                                            <div class="mt-auto">
                                            <button  type="button" class="btn btn-warning col-12" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="vehicleDetails('$vehicle_reg_number');"  ><span><span>View Details</span></span></button>
                                            <br>
                                            <br>
                                            <button  type="button" class="btn btn-danger col-12" data-bs-toggle="modal" data-bs-target="#deleteVeh" data-id='$vehicle_reg_number' data-name='$vehicle_name'><span><span>Remove</span></span></button>
                                            </div>
                                        </div>
                                    </div>
                                _END;
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- view details form -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModal">Vehicle Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" class="form-control" name="model" disabled>

                                </div>
                                <div class="mb-3">
                                    <label for="make" class="form-label">Make</label>
                                    <input type="text" class="form-control" name="make" disabled>

                                </div>
                                <div class="mb-3">
                                    <label for="rnumber" class="form-label">Registraion number</label>
                                    <input type="text" class="form-control" name="rnumber" disabled>

                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <input type="text" class="form-control" name="type" disabled>

                                </div>
                                <div class="mb-3">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="text" class="form-control" name="year" disabled>

                                </div>
                                <div class="mb-3">
                                    <label for="rrate" class="form-label">Rental rate per Kilometer</label>
                                    <input type="text" class="form-control" name="rrate" disabled>
                                </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- ADD NEW VEHICLE FORM -->
            <div class="modal fade" id="addnewvehicle" tabindex="-1" aria-labelledby="addnewvehicle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModal">Vehicle Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addvehicle">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Vehicle model</label>
                                    <input type="text" class="form-control" id="vemodel">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Vehicle make</label>
                                    <input type="text" class="form-control" id="vemake">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Registraion number</label>
                                    <input type="text" class="form-control" id="renumber">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Rental rate per Kilometer</label>
                                    <input type="text" class="form-control" id="rerate">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Type</label>
                                    <input type="text" class="form-control" id="vtype">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Year</label>
                                    <input type="text" class="form-control" id="vyear">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="vdescription">

                                </div>
                                <div>
                                    <label for="exampleInputEmail1" class="form-label">Image</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" id="vimg">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span>Close</span></button>
                            <button class="btn btn-primary" onclick="addVehicle(event)"><span>Save</span></button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- END OF ADD NEW VEHICLE FORM -->

            <!-- /#page-content-wrapper -->
        </div>


        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        New Vehicle added!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Delete vehicle modal -->
        <div class="modal fade" id="deleteVeh" tabindex="-1" aria-labelledby="deleteVehLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="deleteVehLabel">Delete Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <p id="modal-text">Are you sure you want to delete this vehicle?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span>Close</span></button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteVehicle"><span>Delete</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../JS/script.js"></script>
        <script src="script.js"></script>
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };


            document.addEventListener("DOMContentLoaded", function() {
                var toastElement = document.getElementById('successToast');
                var toast = new bootstrap.Toast(toastElement);

                if (localStorage.getItem("showToast") === "true") {
                    toast.show();
                    localStorage.removeItem("showToast");
                }
            });
        </script>
</body>

</html>