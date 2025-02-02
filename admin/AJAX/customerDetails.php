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
    $id = $_POST['id'];
}


try {
    $query = "SELECT * FROM `customer` WHERE `Customer_ID`=:id;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        echo json_encode(["error" => "Customer not found."]);
    } else {
        echo json_encode($customer);
    }
} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
} catch (Exception $e) {

    echo "Error: " . $e->getMessage();
}
