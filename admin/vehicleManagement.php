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
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="profile.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-user me-2"></i>Profile</a>
                <a href="payments.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-wallet me-2"></i>Payments</a>
                <a href="Bookings.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-check me-2"></i>Bookings</a>
                <a href="Notification.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-bell me-2"></i>Notification</a>
                <a href="Help.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-question me-2"></i>Help</a>
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
                    <h2 class="fs-2 m-0">Dashboard</h2>
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
                <button type="button" class="btn btn-warning m-5" data-bs-toggle="modal" data-bs-target="#addnewvehicle"><span><span>ADD NEW</span></span></button>
            </div>
            <br>
            <!-- vehicle showing -->
            <div class="row g-0 d-flex justify-content-around mx-0">
                <div class="col-11">
                    <div class="container">
                        <div class="scrollable-container">
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
                                            <button  type="button" class="btn btn-warning col-12 mt-auto" data-bs-toggle="modal" data-bs-target="#exampleModal" ><span><span>View Details</span></span></button>
                                            <br>
                                            <button  type="button" class="btn btn-danger col-12 mt-auto" data-bs-toggle="modal" data-bs-target="#" ><span><span>Remove</span></span></button>

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
                            <h5 class="modal-title" id="exampleModal">Payment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Vehicle name</label>
                                    <input type="text" class="form-control" id="text0">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Registraion number</label>
                                    <input type="text" class="form-control" id="text1">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Type</label>
                                    <input type="text" class="form-control" id="text2">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Year</label>
                                    <input type="text" class="form-control" id="text3">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Rental rate per Kilometer</label>
                                    <input type="text" class="form-control" id="text0">
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span>Close</span></button>
                            <button type="button" class="btn btn-primary"><span>Save</span></button>
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
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Vehicle model</label>
                                    <input type="text" class="form-control" id="text0">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Vehicle make</label>
                                    <input type="text" class="form-control" id="text0">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Registraion number</label>
                                    <input type="text" class="form-control" id="text1">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Rental rate per Kilometer</label>
                                    <input type="text" class="form-control" id="text0">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Type</label>
                                    <input type="text" class="form-control" id="text2">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Year</label>
                                    <input type="text" class="form-control" id="text3">

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="text0">

                                </div>
                            <div>
                            <label for="exampleInputEmail1" class="form-label">Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="inputGroupFile02">
                                    <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span>Close</span></button>
                            <button type="button" class="btn btn-primary"><span>Save</span></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OF ADD NEW VEHICLE FORM -->




            <!-- /#page-content-wrapper -->
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../JS/script.js"></script>
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
</body>

</html>