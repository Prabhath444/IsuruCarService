<?php
require_once("../../database/databaseLogin.php");

session_start();

$vehId = $_POST["vehId"];

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
    $query = "DELETE FROM vehicle WHERE Registration_number = :ID;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ID', $vehId);
    $stmt->execute();
    

} catch (\PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "This customer cannot be deleted due to existing dependencies.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}