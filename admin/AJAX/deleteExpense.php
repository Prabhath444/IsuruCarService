<?php
require_once("../../database/databaseLogin.php");

session_start();

$ID = $_POST["ID"];

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
    $query = "DELETE FROM expenses WHERE Expense_ID = :ID;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
