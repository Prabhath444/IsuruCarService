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

$query = "SELECT * FROM expenses ORDER BY `Expense_date` DESC;";
$stmt = $pdo->prepare($query);
$stmt->execute();

$expences_data = $stmt->fetchAll();

$expensesCount = 0;
foreach ($expences_data as $row) {
    $expensesCount++;
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
    <link rel="stylesheet" href="../dashboard/styles.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Expenses</title>
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
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i
                        class="fas fa-solid fa-circle-check me-2"></i>Expenses</a>
                <a href="vehiclemanagement.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
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
                    <h2 class="fs-2 m-0">Expenses</h2>
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
                <div class="row g-3 my-2">

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded status" onclick="window.location.href = '#'">
                            <div>
                                <h3 class="fs-2"><?php echo $expensesCount  ?></h3>
                                <p class="fs-5 fw-bold">Expenses</p>
                            </div>
                            <i class="fas fa-taxi fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded status" onclick="window.location.href = 'monthlyReport.php'">
                            <div>
                                <h3 class="fs-2" hidden>_</h3>
                                <p class="fs-5 fw-bold pdding">Monthly Report</p>
                            </div>
                            <i class="fa-solid fa-coins fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <h3 class="fs-4 mb-3" id="table_name">Expenses</h3>
                    <div class="col text-start">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <span>ADD NEW</span>
                        </button>
                    </div>
                </div>
                <div class="row my-5">

                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Description</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount (Rs.)</th>
                                    <th scope="col">Vehicle Reg.No</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="table">

                                <?php

                                foreach ($expences_data as $row) {

                                    $id = $row['Expense_ID'];
                                    $date = $row['Expense_date'];
                                    $type = $row['Expense_type'];
                                    $amount = round($row['Expense_amount'], 2);
                                    $vrn = $row['vehicle_Registration_number'];
                                    echo <<< _END
                                
                                    <tr class="text-center">
                                        <td>$type</td>
                                        <td >$date</td>
                                        <td>$amount</td>
                                        <td>$vrn </td>
                                        <td><button type="button" class="btn btn-danger" onclick="deleteExpense($id)"><span>Delete</span></button></td>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Expense Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="expensesForm">
                        <div class="mb-3">
                            <label for="Description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="Description" name="Description" required>

                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>

                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" required>

                        </div>
                        <div class="mb-3">
                            <label for="Vehicle" class="form-label">Vehicle Registration Number</label>
                            <input type="text" class="form-control" id="Vehicle" name="vehicleReg" required>
                        </div>
                        <div class="modal-footer">
                            <p id="errormsg" style="display: none;" class="text-danger text-start"></p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span>Close</span></button>
                            <button class="btn btn-primary" onclick="addExpenses()"><span>Add</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        New Expense Added!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../JS/script.js"></script>

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