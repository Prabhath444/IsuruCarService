<?php
require_once("../database/databaseLogin.php");

session_start();

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}

if (!isset($_SESSION["email"]) || !isset($_SESSION["password"]) || !isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

$email = $_SESSION["email"];
$name  = $_SESSION["name"];

// Get the current year and month (with fallback to URL parameters)
$year  = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');

// Define a fixed rate per kilometer (adjust as needed)
$fixedRate = 10; // For example, 10 units per kilometer

// --- Function to Retrieve Completed Rentals (Income) ---
// Note: Removed Rental_rate column since it does not exist.
function getCompletedRentalsByMonth($pdo, $year, $month)
{
    $sql = "SELECT Rental_ID, Rental_date, Return_date, Total_KM, Additional_KM, Customer_ID, vehicle_Registration_number
            FROM rental 
            WHERE Rental_status = 'Completed' 
            AND YEAR(Return_date) = ? AND MONTH(Return_date) = ?
            ORDER BY Return_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$year, $month]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// --- Function to Retrieve Expenses ---
function getExpensesByMonth($pdo, $year, $month)
{
    $sql = "SELECT Expense_ID, Expense_date, Expense_type, Expense_amount, vehicle_Registration_number 
            FROM expenses 
            WHERE YEAR(Expense_date) = ? AND MONTH(Expense_date) = ?
            ORDER BY Expense_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$year, $month]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetching data
$completedRentals = getCompletedRentalsByMonth($pdo, $year, $month);

// Calculate rental income for each rental based on Total_KM * fixed rate
$totalRentalIncome = 0;
foreach ($completedRentals as &$rental) {
    // Calculate income for this rental
    $rental['Rental_Income'] = $rental['Total_KM'] * $fixedRate;
    $totalRentalIncome += $rental['Rental_Income'];
}
unset($rental); // remove reference

$expenses = getExpensesByMonth($pdo, $year, $month);
$totalExpenses = array_sum(array_column($expenses, 'Expense_amount'));

// Calculate net profit (total income - total expenses)
$netProfit = $totalRentalIncome - $totalExpenses;

// Calculate previous and next month for navigation
$prevMonth = ($month == 1) ? 12 : $month - 1;
$prevYear  = ($month == 1) ? $year - 1 : $year;
$nextMonth = ($month == 12) ? 1 : $month + 1;
$nextYear  = ($month == 12) ? $year + 1 : $year;

// Format month name
$monthName = DateTime::createFromFormat('!m', $month)->format('F');
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
    <style>
        /* Basic styling for the table and navigation links */
        body {
            font-family: Arial, sans-serif;
        }

        .navigation {
            text-align: center;
            margin: 20px 0;
        }

        .navigation a {
            margin: 0 15px;
            text-decoration: none;
            background-color: #4287f5;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

        h1,
        h3 {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
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
                <a href="expenses.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-solid fa-circle-check me-2"></i>Expenses</a>
                <a href="vehiclemanagement.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-bell me-2"></i>Manage Vehicles</a>
                <a href="customerManagement.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-users me-2"></i>Manage Customers</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i
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
                    <h2 class="fs-2 m-0">Monthly Report</h2>
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

            <div class="container-fluid px-4 total-row">
                <h1>Report for <?php echo htmlspecialchars($monthName . " " . $year); ?></h1>

                <div class="navigation">
                    <a href="?year=<?php echo $prevYear; ?>&month=<?php echo $prevMonth; ?>">Previous Month</a>
                    <a href="?year=<?php echo $nextYear; ?>&month=<?php echo $nextMonth; ?>">Next Month</a>
                </div>

                <!-- Income (Completed Rentals) Table -->
                <h3 class="total-row">Completed Rentals (Income)</h3>
                <table class="table table-bordered text-center total-row">
                    <thead>
                        <tr class="total-row">
                            <th>ID</th>
                            <th>Rental Date</th>
                            <th>Return Date</th>
                            <th>Total KM</th>
                            <th>Additional KM</th>
                            <th>Customer ID</th>
                            <th>Vehicle Registration</th>
                            <th>Rental Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($completedRentals): ?>
                            <?php foreach ($completedRentals as $rental): ?>
                                <tr class="total-row">
                                    <td><?php echo htmlspecialchars($rental['Rental_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['Rental_date']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['Return_date']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['Total_KM']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['Additional_KM']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['Customer_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['vehicle_Registration_number']); ?></td>
                                    <td><?php echo number_format(floatval($rental['Rental_Income']), 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="total-row">
                                <td colspan="7" class="text-end">Total Rental Income:</td>
                                <td><?php echo number_format($totalRentalIncome, 2); ?></td>
                            </tr>
                        <?php else: ?>
                            <tr class="total-row">
                                <td colspan="8">No completed rentals found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Expenses Table -->
                <h3 class="total-row">Expenses</h3>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="total-row">
                            <th>ID</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Vehicle Registration</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($expenses): ?>
                            <?php foreach ($expenses as $expense): ?>
                                <tr class="total-row">
                                    <td><?php echo htmlspecialchars($expense['Expense_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($expense['Expense_date']); ?></td>
                                    <td><?php echo htmlspecialchars($expense['Expense_type']); ?></td>
                                    <td><?php echo htmlspecialchars($expense['vehicle_Registration_number']); ?></td>
                                    <td><?php echo number_format(floatval($expense['Expense_amount']), 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="total-row">
                                <td colspan="4" class="text-end">Total Expenses:</td>
                                <td><?php echo number_format($totalExpenses, 2); ?></td>
                            </tr>
                        <?php else: ?>
                            <tr class="total-row">
                                <td colspan="5">No expenses found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Monthly Summary Table -->
                <h3 class="total-row">Monthly Summary</h3>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="total-row">
                            <th>Total Income</th>
                            <th>Total Expenses</th>
                            <th>Net Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="total-row">
                            <td><?php echo number_format($totalRentalIncome, 2); ?></td>
                            <td><?php echo number_format($totalExpenses, 2); ?></td>
                            <td><?php echo number_format($netProfit, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
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