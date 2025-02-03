<?php
require_once("../../database/databaseLogin.php");
session_start();
if (isset($_SESSION["email"]) && $_SESSION["password"] && $_SESSION['admin_id']) {
} else {
    header("Location: ../../login.php");
}

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST["id"])) {
    $rnumber = $_POST['id'];
}


try {
    $query = "SELECT * FROM `vehicle` WHERE `Registration_number`=:rnumber;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':rnumber', $rnumber);

    $stmt->execute();
    $vehicle = $stmt->fetchAll();


    header('Content-Type: application/json');
    echo json_encode($vehicle);
} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
} catch (Exception $e) {

    echo "Error: " . $e->getMessage();
}
