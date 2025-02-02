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

$query = "SELECT 
customer.*,
CONCAT(customer.fname, ' ', customer.lname) AS full_name
FROM 
customer";

$stmt = $pdo->prepare($query);
$stmt->execute();

$customer_management = $stmt->fetchAll();



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
                        class="fas fa-solid fa-wallet me-2"></i>Payments</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-solid fa-circle-check me-2"></i>Expenses</a>
                <a href="vehiclemanagement.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-bell me-2"></i>Manage Vehicles</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i
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

            <div class="container-fluid px-4">

                <div class="row my-5">
                    <h3 class="fs-4 mb-3" id="table_name">All Customers</h3>

                    <div class="col">

                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Full name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="table">

                                <?php

                                foreach ($customer_management as $row) {

                                    static $no = 0;
                                    $no++;

                                    $full_name = $row['full_name'];
                                    $email = $row['Email'];
                                    $id = $row['Customer_ID'];


                                    echo <<< _END
                                
                                    <tr>
                                        <th scope="row">$no</th>
                                        <td>$full_name</td>
                                        <td scope="col">$email </td>
                                        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="customerDetails('$id');" ><span>View Details</span></button>
                                        <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteCus" data-id='$id' data-name='$full_name'><span>Delete</span></button></td>
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


    <!-- view details form -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModal ">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" disabled>

                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" disabled>

                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" disabled>

                        </div>
                        <div class="mb-3">
                            <label for="lnumber" class="form-label">License Number</label>
                            <input type="text" class="form-control" name="lnumber" disabled>

                        </div>
                        <div class="mb-3">
                            <label for="rdate" class="form-label">Registration Date</label>
                            <input type="text" class="form-control" name="rdate" disabled>

                        </div>
                        <div class="mb-3">
                            <label for="pnumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="pnumber" disabled>
                        </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Delete customer modal -->
    <div class="modal fade" id="deleteCus" tabindex="-1" aria-labelledby="deleteCusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="deleteCusLabel">Delete Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <p id="modal-text">Are you sure you want to delete this customer?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span>Close</span></button>
                            <button type="button" class="btn btn-danger" id="confirmDelete"><span>Delete</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/script.js"></script>
    <script src="script.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function() {
            el.classList.toggle("toggled");
        };
    </script>
</body>

</html>