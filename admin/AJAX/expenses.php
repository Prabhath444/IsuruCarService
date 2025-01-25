<?php
require_once("../../database/databaseLogin.php");

$description = $_POST['Description'];
$date = $_POST['date'];
$amount = $_POST['amount'];
$regNo = $_POST['vehicleReg'];

try {
    $pdo = new PDO($attr, $user, $pass, $opts);

    $query2 = "SELECT * FROM `vehicle` WHERE `Registration_number` = :regNo";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(':regNo', $regNo);

    $stmt2 -> execute();
    $result = $stmt2->fetchAll();

    if (!(count($result) > 0)) {
        die("Invalid Registration Number");
    }

    $query = "INSERT INTO `expenses` (`Expense_type`, `Expense_date`, `Expense_amount`, `vehicle_Registration_number`) VALUES (:descriptions, :dates, :amount, :regNo);";
    $stmt = $pdo->prepare($query);



    $stmt->bindParam(':descriptions', $description);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':regNo', $regNo);
    $stmt->bindParam(':dates', $date);

    $stmt->execute();

    echo "Rental record updated successfully";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}