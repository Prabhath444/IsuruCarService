<?php
require_once("../../database/databaseLogin.php");

session_start();
$rentID = $_POST['rentId'];
$amount = $_POST['totamount'];
$additional_km = $_POST['addmilage'];


if ($rentID === null || $amount === null) {
    die("Rental ID or amount is missing.");
}

try {
    $pdo = new PDO($attr, $user, $pass, $opts);

    $query = "UPDATE `rental` SET `Amount` = :amount, `Rental_status` = 'Completed',`Additional_KM` = :Additional_KM WHERE `Rental_ID` = :rentID;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':rentID', $rentID);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':Additional_KM', $additional_km);

    $stmt->execute();

    echo "Rental record updated successfully";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
