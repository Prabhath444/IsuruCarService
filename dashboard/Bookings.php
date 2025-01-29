<?php
require_once("../database/databaseLogin.php");

session_start();
if (isset($_SESSION["email"]) && $_SESSION["fname"]) {
    $email = $_SESSION["email"];
    $fname = $_SESSION["fname"];
    $lname = $_SESSION["lname"];

} else {
    header("Location: ../login.php");
}



try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Bootstap 5 Responsive Admin Dashboard</title>
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
                <a href="profile.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-user me-2"></i>Profile</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold  active"><i
                        class="fa-solid fa-circle-check me-2"></i>Bookings</a>
                        <a href="Notification.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-bell me-2"></i><span class="position-relative padding-rgt">Notification <span id="notifications" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $_SESSION['UnreadNotifiCount']; ?>
                        </span></span>
                    </span></a>
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
                    <h2 class="fs-2 m-0">Bookings</h2>
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
                                <i class="fas fa-user me-2"></i><?php echo $fname . " " . $lname  ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item text-center fw-bold" href="profile.php">Profile</a></li>
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
                                            <button onclick="addRegistrationNumber('$vehicle_reg_number')" type="button" class="btn btn-warning col-12 mt-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ><span><span>Select</span></span></button>
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
            <div class="row g-0 d-flex justify-content-around mx-0 form1 px-2">
                <form class="col-11" method="POST">

                    <div class="row">
                        <h2 class="col-4 d-flex align-items-center">Book a Car</h2>
                    </div>

                    <div class="mb-3 ">
                        <label for="rnum" class="form-label">Vehicle ID</label>
                        <input type="text" class="form-control" id="rnumber" name="rnumber" required="required" disabled placeholder="Select from above list" required = "required" >
                    </div>
                    <div class="mb-3">
                        <label for="dateInput" class="form-label">Rental Date</label>
                        <input type="text" class="form-control" id="rentaldate" name="rentaldate" required="required" placeholder="Rental Date" required = "required" value="<?php echo isset($_SESSION['post_rentaldate']) ?  $_SESSION['post_rentaldate'] : "" ?>">
                    </div>
                    <div class="mb-3">
                        <label for="returndate" class="form-label">Return Date</label>
                        <input type="text" class="form-control" id="returndate" name="returndate" required="required" placeholder="Return Date" required = "required" value="<?php echo isset($_SESSION['post_returndate']) ?  $_SESSION['post_returndate'] : "" ?>">
                    </div>

                    <div class="mb-3">
                        <button class="btn mt-3 btn-primary col-12" type="submit" onclick="bookingProcess(event)"><span>Book Now</span></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Updated successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/script.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toastElement = document.getElementById('successToast');
            var toast = new bootstrap.Toast(toastElement);

            if (localStorage.getItem("showToast") === "true") {
                toast.show();
                localStorage.removeItem("showToast"); 
            }
        });


        window.onload = updateNotifications(-1);
    
    </script>
    
</body>

</html>