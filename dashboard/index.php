<?php
require_once("../database/databaseLogin.php");

session_start();

if (isset($_SESSION["email"]) && $_SESSION["fname"]) {
    $email = $_SESSION["email"];
    $fname = $_SESSION["fname"];
    $lname = $_SESSION["lname"];
    $customer_id = $_SESSION["customer_id"];
} else {
    header("Location: ../login.php");
}

try {
    $pdo = new PDO($attr, $user, $pass, $opts);

    $query = "SELECT r.*, v.* FROM `rental` r JOIN `vehicle` v ON r.`Vehicle_Registration_number` = v.`Registration_number`
    WHERE r.`Customer_ID` = :cus_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindparam(":cus_id", $customer_id);
    $stmt->execute();

    $rental_vehicle = $stmt->fetchAll();
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


$ongoing = 0;
$completed = 0;
foreach ($rental_vehicle as $row) {

    $status = $row['Rental_status'];

    if ($status == 'Ongoing') {
        $ongoing++;
    }
    if ($status == 'Completed') {
        $completed++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="profile.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-user me-2"></i>Profile</a>
                <a href="Bookings.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
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
                                <i class="fas fa-user me-2"></i><?php echo $fname . " " . $lname  ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> <!--- updated --->
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

            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded status" onclick="changeDashboardContent('Ongoing')">
                            <div>
                                <h3 class="fs-2"><?php echo $ongoing  ?></h3>
                                <p class="fs-5 fw-bold">Ongoing</p>
                            </div>
                            <i class="fa-solid fa-car fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded status" onclick="changeDashboardContent('Completed')">
                            <div>
                                <h3 class="fs-2"><?php echo $completed  ?></h3>
                                <p class="fs-5 fw-bold">Completed</p>
                            </div>
                            <i
                                class="fa-solid fa-car-on fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded status" onclick="window.location.href = 'Bookings.php'">
                            <div>
                                <h3 class="fs-2" style="height: 38.3px;"></h3>
                                <p class="fs-5 fw-bold">Book Now</p>
                            </div>
                            <i class="fas fa-taxi fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" onclick="">
                            <div>
                                <h3 class="fs-2">13</h3>
                                <p class="fs-5 fw-bold">Payments</p>
                            </div>
                            <i class="fa-solid fa-coins fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>

                <div class="row my-5">
                    <h3 class="fs-4 mb-3" id="table_name">Ongoing Rentals</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Vehicle</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="table">

                                <?php

                                foreach ($rental_vehicle as $row) {
                                    static $no = 0;
                                    $no++;
                                    $status = $row['Rental_status'];

                                    if ($status != "Ongoing") {
                                        $no--;
                                        continue;
                                    }

                                    $vehicle_name = $row['Make'] . " " . $row['Model'];
                                    $total_KM = $row['Total_KM'];
                                    $rental_date = $row['Rental_date'];
                                    $return_date = $row['Return_date'];
                                    $rental_rate = $row['Rental_rate'];


                                    $rentalDateTime = new DateTime($rental_date);
                                    $returnDateTime = new DateTime($return_date);

                                    $interval = $rentalDateTime->diff($returnDateTime);
                                    $days = $interval->days;

                                    if ($days * 100 - $total_KM > 0) {
                                        $amount = $days * 100 * $rental_rate;
                                    } else {
                                        $amount = $total_KM * $rental_rate;
                                    }

                                    echo <<< _END
                                
                                    <tr class="text-center" >
                                        <th scope="row">$no</th>
                                        <td>$vehicle_name</td>
                                        <td scope="col">$days Days</td>
                                        <td>$status</td>
                                        <td>Pending</td>
                                    </tr>
                                    _END;
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
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

        window.onload = updateNotifications(-1);
    </script>
</body>

</html>