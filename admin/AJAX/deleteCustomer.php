<?php
require_once("../../database/databaseLogin.php");

session_start();

$cusId = $_POST["cusId"];

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
    $query = "DELETE FROM customer WHERE Customer_ID = :ID;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ID', $cusId);
    $stmt->execute();
    

} catch (\PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "This customer cannot be deleted due to existing dependencies.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
