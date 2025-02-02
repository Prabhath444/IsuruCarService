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
function getCompletedRentalsByMonth($pdo, $year, $month) {
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
function getExpensesByMonth($pdo, $year, $month) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Monthly Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../dashboard/styles.css">
    <link rel="stylesheet" href="../css/style.css">
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
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        h1, h3 {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4">
        <h1>Report for <?php echo htmlspecialchars($monthName . " " . $year); ?></h1>

        <div class="navigation">
            <a href="?year=<?php echo $prevYear; ?>&month=<?php echo $prevMonth; ?>">Previous Month</a>
            <a href="?year=<?php echo $nextYear; ?>&month=<?php echo $nextMonth; ?>">Next Month</a>
        </div>

        <!-- Income (Completed Rentals) Table -->
        <h3>Completed Rentals (Income)</h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
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
                        <tr>
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
                    <tr><td colspan="8">No completed rentals found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Expenses Table -->
        <h3>Expenses</h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
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
                        <tr>
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
                    <tr><td colspan="5">No expenses found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Monthly Summary Table -->
        <h3>Monthly Summary</h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
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
</body>
</html>

<?php unset($pdo); ?>
