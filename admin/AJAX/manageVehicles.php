<?php
require_once("../../database/databaseLogin.php");

session_start();


try {
    $pdo = new PDO($attr, $user, $pass, $opts);
    $query = "SELECT v.*  FROM `vehicle`;";


    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $rental_vehicle = $stmt->fetchAll();

    

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


