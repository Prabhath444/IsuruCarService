<?php
require_once("../../database/databaseLogin.php");
session_start();

$rentID = $_POST['rentID'];

try {
    
    $pdo = new PDO($attr, $user, $pass, $opts);
    
    
    $query = "SELECT r.*, v.Model, v.Make, v.Rental_rate, v.Rental_rate, c.Email 
              FROM `rental` r 
              JOIN `vehicle` v ON r.`Vehicle_Registration_number` = v.`Registration_number` 
              JOIN `customer` c ON r.`Customer_ID` = c.`Customer_ID` 
              WHERE r.`Rental_ID` = :rent_id;";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":rent_id", $rentID); 
    
    $stmt->execute();
    
    $rental = $stmt->fetch(PDO::FETCH_ASSOC); 

    
    if ($rental) {
        header('Content-Type: application/json');
        echo json_encode($rental);
    
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No rental record found for the given ID.']);
    }
    
} catch (\PDOException $e) {
    error_log($e->getMessage()); // Log the error message
    echo "An error occurred while processing your request. Please try again later.";
}

?>
