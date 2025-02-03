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

$customer_id = $_SESSION["customer_id"];

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
    $query = "SELECT n.*,v.`Make`, v.`Model`,v.`Type`,v.`image` FROM `notification` n JOIN `vehicle` v 
ON n.`vehicle_Registration_number` = v.`Registration_number` WHERE n.`customer_ID` = :cusID;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':cusID', $customer_id);
    $stmt->execute();

    $notifications = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
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
    <title>Notification</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text text-uppercase border-bottom">
                <a class="navbar-brand pt-4 px-2" onclick="location.href='../index.php'">
                    <img src="../images/logo.jpg" alt="Logo" width="80" height="80" class="rounded-circle">
                </a>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="profile.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-user me-2"></i>Profile</a>
                <a href="Bookings.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-circle-check me-2"></i>Bookings</a>
                <a href="Notification.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i
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
                    <h2 class="fs-2 m-0">Notification</h2>
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
            <div class="container-fluid px-5">

                <?php

                foreach ($notifications as $notification) {

                    $title = $notification->Title;
                    $class = ($notification->status == 'not-read') ? "notifi" : "notifi-read";
                    $notifi_id= $notification->ID;
                    $vehicle = "$notification->Make $notification->Model";
                    $vehicle_img = $notification->image;

                    echo <<< _END
                                    
                    <div id="$notifi_id" class="container-fluid border border-1 $class border-dark" onclick="updateNotifications($notifi_id);">
                        <h3 class="fw-bold">$title</h3>
                        <div class="container">
                            <div class="row">
                            <div class="col-4 col-lg-2">
                                <img src="../$vehicle_img" height="50px" class="rounded-3" alt="...">
                            </div>
                            <div class="col-8 col-lg-10 d-flex  align-items-center">
                            <p class="">$vehicle booked.</p>
                            </div>
                            </div>
                        </div>
                        
                    </div>
                    _END;
                }
                ?>
            </div>
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